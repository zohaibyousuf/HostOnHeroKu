<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use App\Product;
use App\Customer;
use App\Sale;
use App\ProductSale;
use App\User;
use App\Payment;
use App\PaymentWithCheque;
use App;
use PDF;
use DB;
use Auth;
use NumberToWords\NumberToWords;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SaleController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('sales-index')){
            $lsms_sale_all = Sale::orderBy('id', 'desc')->get();
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            return view('sale.index',compact('lsms_sale_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('sales-add')){
            $lsms_product_list = Product::where([
                                ['is_active', true],
                                ['qty', '>' , 0]
                            ])->get();
            if($lsms_product_list->isEmpty())
                return redirect('sales')->with('message1','Emplty Stock!');
            $lsms_customer_list = Customer::where('is_active', true)->get();
            return view('sale.create', compact('lsms_product_list', 'lsms_customer_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['reference_no'] = 'sr-' . date("Ymd") . '-'. date("his");
        $data['user_id'] = Auth::id();
        Sale::create($data);

        $lsms_sale_data = Sale::latest()->first();
        if($data['paid_amount'] > 0){
            $lsms_payment_data = new Payment();
            $lsms_payment_data->sale_id = $lsms_sale_data->id;
            $lsms_payment_data->reference_no = 'par-' . date("Ymd") . ' '. date("his");
            $lsms_payment_data->amount = $data['paid_amount'];
            $lsms_payment_data->payment_method = $data['payment_method'];
            $lsms_payment_data->save();

            if($lsms_payment_data->payment_method == 'Cheque' ) {
                $lsms_payment_data = Payment::latest()->first();
                $data['payment_id'] = $lsms_payment_data->id;
                $data['cheque_date'] = date('Y-m-d', strtotime($data['cheque_date']));
                PaymentWithCheque::create($data);
            }
        }

        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $product_price = $data['product_price'];;
        $total = $data['subtotal'];
        $product_sale = [];

        foreach ($product_id as $key => $id) {
            //deduct quantity to product table
            $lsms_product_data = Product::find($id);
            $lsms_product_data->qty = $lsms_product_data->qty - $qty[$key];
            $lsms_product_data->save();

            $product_sale['sale_id'] = $lsms_sale_data->id ;
            $product_sale['product_id'] = $id;
            $product_sale['qty'] = $qty[$key];
            $product_sale['unit'] = $lsms_product_data->unit;
            $product_sale['product_price'] = $product_price[$key];
            $product_sale['total'] = $total[$key];
            ProductSale::create($product_sale);
        }

        return redirect('sales')->with('message2','Sale Created Successfully');
    }

    public function lsmsProductSearch(Request $request)
    {
        $data = explode("-",$request['data']);
        $lsms_product_data = Product::where([
            ['model_no', $data[1]],
            ['is_active', true],
        ])->first();

        $product[] = $lsms_product_data->name;
        $product[] = $lsms_product_data->id;
        $product[] = $lsms_product_data->model_no;
        $product[] = $lsms_product_data->price;
        return $product;
    }

    public function show($id)
    {
        $lsms_user_data = User::find(Auth::user()->id);
        $lsms_sale_data = Sale::find($id);
        $lsms_product_sale_data = ProductSale::where('sale_id', $id)->get();
        $lsms_customer_data = Customer::find($lsms_sale_data->customer_id);
        //convert grand total in words
        $numberToWords = new NumberToWords();
        if(App::getLocale() != 'ar')
            $numberTransformer = $numberToWords->getNumberTransformer(App::getLocale());
        else
            $numberTransformer = $numberToWords->getNumberTransformer('en');
        $numberInWords = $numberTransformer->toWords($lsms_sale_data->grand_total);
        
        return view('sale.show', compact('lsms_user_data', 'lsms_sale_data', 'lsms_product_sale_data', 'lsms_customer_data', 'numberInWords'));
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('sales-edit')){
            $lsms_product_list = Product::where('is_active', true)->get();
            $lsms_customer_list = Customer::where('is_active', true)->get();
            $lsms_sale_data = Sale::find($id);
            $lsms_product_sale_data = ProductSale::where('sale_id', $id)->get();

            return view('sale.edit', compact('lsms_product_list', 'lsms_sale_data', 'lsms_product_sale_data', 'lsms_customer_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $url = $request['url'];
        $data = $request->all();
        $lsms_sale_data = Sale::find($id);
        $lsms_product_sale_data = ProductSale::where('sale_id', $id)->get();

        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $product_price = $data['product_price'];
        $total = $data['subtotal'];
        $product_sale = [];

        foreach ($lsms_product_sale_data as $key => $product_sale_data) {
            $old_recieved_value = $product_sale_data->qty;
            $old_product_id[] = $product_sale_data->product_id;
            $lsms_product_data = Product::find($product_sale_data->product_id);

            $lsms_product_data->qty += $old_recieved_value;
            $lsms_product_data->save();
            if( !(in_array($old_product_id[$key], $product_id)) )
                $product_sale_data->delete();
        }

        foreach ($product_id as $key => $pro_id) {

            $lsms_product_data = Product::find($pro_id);
            $lsms_product_data->qty -= $qty[$key];
            $lsms_product_data->save();

            $product_sale['sale_id'] = $id ;
            $product_sale['product_id'] = $pro_id;
            $product_sale['qty'] = $qty[$key];
            $product_sale['product_price'] = $product_price[$key];
            $product_sale['total'] = $total[$key];

            if(in_array($pro_id, $old_product_id))
                ProductSale::where([
                    ['sale_id', $id],
                    ['product_id', $pro_id]
                    ])->update($product_sale);
            else{
                $product_sale['unit'] = $lsms_product_data->unit;
                ProductSale::create($product_sale);
            }
        }
        $balance = $data['grand_total'] - $lsms_sale_data->paid_amount;
        if($balance > 0 || $balance < 0)
            $data['payment_status'] = 'Due';
        else
            $data['payment_status'] = 'Paid';
        $lsms_sale_data->update($data);
        return Redirect::to($url)->with('message3','Sale Updated Successfully');
    }

    public function productSaleData($id)
    {
        $lims_product_sale_data = ProductSale::where('sale_id', $id)->get();
        foreach ($lims_product_sale_data as $key => $product_sale_data) {
            $product = Product::find($product_sale_data->product_id);

            $product_sale[0][$key] = $product->name . ':' . $product->model_no;
            $product_sale[1][$key] = $product_sale_data->qty;
            $product_sale[2][$key] = $product_sale_data->product_price;
            $product_sale[3][$key] = $product_sale_data->total;
            $product_sale[4][$key] = $product_sale_data->unit;
        }
        return $product_sale;
    }

    public function saleByCsv()
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('sales-add')){
            $lsms_customer_list = Customer::where('is_active', true)->get();
            return view('sale.import', compact('lsms_customer_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function importSale(Request $request)
    {
        //get the file
        $upload=$request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        //checking if this is a CSV file
        if($ext != 'csv')
            return redirect()->back()->with('message2', 'Please upload a CSV file');
        
        $filePath=$upload->getRealPath();
        $file_handle = fopen($filePath, 'r');
        //checking any column is empty
        while (!feof($file_handle) ) {
            $current_line = fgetcsv($file_handle, 1024);
            if($current_line){
                if(in_array('', $current_line)) {
                    return redirect()->back()->with('message1', 'Any Column of your CSV file is empty! Please Check your CSV file!!!');
                }
            }
        }

        $data = $request->except('file');
        $item = 0;
        $quantity = 0;
        $product_price = 0;
        $grand_total = 0;
        $data['reference_no'] = 'sr-' . date("Ymd") . '-'. date("his");
        $data['item'] = $data['total_qty'] = $data['total_price'] = $data['grand_total'] = 0;
        $data['user_id'] = Auth::id();
        Sale::create($data);
        $lsms_sale_data = Sale::latest()->first();
        if($data['paid_amount'] > 0){
            $lsms_payment_data = new Payment();
            $lsms_payment_data->sale_id = $lsms_sale_data->id;
            $lsms_payment_data->reference_no = 'spr-' . date("Ymd") . ' '. date("his");
            $lsms_payment_data->amount = $data['paid_amount'];
            $lsms_payment_data->payment_method = $data['payment_method'];
            $lsms_payment_data->save();

            if($lsms_payment_data->payment_method == 'Cheque') {
                $lsms_payment_data = Payment::latest()->first();
                $data['payment_id'] = $lsms_payment_data->id;
                $data['cheque_date'] = date('Y-m-d', strtotime($data['cheque_date']));
                PaymentWithCheque::create($data);
            }
        }
        //get file
        $filename =  $request->file->getClientOriginalName();
        $upload=$request->file('file');
        $filePath=$upload->getRealPath();
        //open and read
        $file=fopen($filePath, 'r');
        $header= fgetcsv($file);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        //looping through othe columns
        while($columns=fgetcsv($file))
        {
            if($columns[0]=="")
                continue;
            foreach ($columns as $key => $value) {
                $value=preg_replace('/\D/','',$value);
            }
           $data= array_combine($escapedHeader, $columns);
           $product = Product::firstOrNew(['model_no'=>$data['productcode']], ['is_active' => true] );
           $product->qty -= $data['quantity'];
           $product->save();
           $product_sale = new ProductSale();
           $product_sale->sale_id = $lsms_sale_data->id;
           $product_sale->product_id = $product->id;
           $product_sale->qty = $data['quantity'];
           $product_sale->product_price = $data['productprice'];
           $product_sale->total = $data['quantity'] * $data['productprice'];
           $product_sale->save();
           $quantity += $data['quantity'];
           $grand_total += $product_sale->total;
           $item++;
         }
         $lsms_sale_data->item = $item;
         $lsms_sale_data->total_qty = $quantity;
         $lsms_sale_data->total_price = $grand_total;
         $lsms_sale_data->grand_total = $grand_total;
         $lsms_sale_data->save();
         return redirect('sales')->with('message2', 'Sale imported successfully');  
    }

    public function getPayment($id)
    {
        $lsms_payment_list = Payment::where('sale_id', $id)->get();
        $date = [];
        $payment_reference = [];
        $paid_amount = [];
        $payment_method = [];
        $payment_id = [];
        $cheque_no = [];
        $cheque_date = [];

        foreach ($lsms_payment_list as $payment) {
            $date[] = $payment->created_at->toDateString() . ' '. $payment->created_at->toTimeString();
            $payment_reference[] = $payment->reference_no;
            $paid_amount[] = $payment->amount;
            $payment_method[] = $payment->payment_method;
            if($payment->payment_method == 'Cheque'){
                $lsms_payment_cheque_data = PaymentWithCheque::where('payment_id',$payment->id)->first();
                $cheque_no[] = $lsms_payment_cheque_data->cheque_no;
                $cheque_date[] = $lsms_payment_cheque_data->cheque_date;
            }
            else{
                $cheque_no[] = null;
                $cheque_date[] = null;
            }
            $payment_id[] = $payment->id;
        }
        $payments[] = $date;
        $payments[] = $payment_reference;
        $payments[] = $paid_amount;
        $payments[] = $payment_method;
        $payments[] = $payment_id;
        $payments[] = $cheque_no;
        $payments[] = $cheque_date;

        return $payments;
    }
    
    public function addPayment(Request $request)
    {
        $data = $request->all();
        if(!$data['amount'])
            $data['amount'] = 0.00;
        
        $lsms_sale_data = Sale::find($data['sale_id']);
        $lsms_sale_data->paid_amount += $data['amount'];
        $balance = $lsms_sale_data->grand_total - $lsms_sale_data->paid_amount;
        if($balance > 0 || $balance < 0)
            $lsms_sale_data->payment_status = 'Due';
        elseif ($balance == 0)
            $lsms_sale_data->payment_status = 'Paid';
        $lsms_sale_data->save();

        if($data['paid_by_id'] == 'Cash')
            $payment_method = 'Cash';
        else
            $payment_method = 'Cheque';

        $lsms_payment_data = new Payment();
        $payment_no = Payment::where('sale_id', $lsms_sale_data->id)->count();
        $lsms_payment_data->sale_id = $lsms_sale_data->id;
        $lsms_payment_data->reference_no = 'par-' . date("Ymd") . ' '. date("his");
        $lsms_payment_data->amount = $data['amount'];
        $lsms_payment_data->payment_method = $payment_method;
        $lsms_payment_data->save();

        if ($payment_method == 'Cheque') {
            $lsms_payment_data = Payment::latest()->first();
            $data['payment_id'] = $lsms_payment_data->id;
            $data['cheque_date'] = date('Y-m-d', strtotime($data['cheque_date']));
            PaymentWithCheque::create($data);
        }

        return redirect('sales')->with('message4', 'Payment added successfully');
    }

    public function updatePayment(Request $request)
    {
        $data = $request->all();
        $lsms_payment_data = Payment::find($data['payment_id']);
        $lsms_sale_data = Sale::find($lsms_payment_data->sale_id);
        //updating sale table
        $amount_dif = $data['edit_amount'] - $lsms_payment_data->amount;
        $lsms_sale_data->paid_amount = $lsms_sale_data->paid_amount + $amount_dif;
        $balance = $lsms_sale_data->grand_total - $lsms_sale_data->paid_amount;
        if($balance > 0 || $balance < 0)
            $lsms_sale_data->payment_status = 'Due';
        elseif ($balance == 0)
            $lsms_sale_data->payment_status = 'Paid';
        $lsms_sale_data->save();

        //updating payment data
        $lsms_payment_data->amount = $data['edit_amount'];
        if($data['edit_paid_by_id'] == 'Cash'){
            if($lsms_payment_data->payment_method == 'Cheque'){
                $lsms_payment_cheque_data = PaymentWithCheque::where('payment_id', $data['payment_id'])->first();
                $lsms_payment_cheque_data->delete();
            }
            $lsms_payment_data->payment_method = 'Cash';
        }
        
        else{
            if($lsms_payment_data->payment_method == 'Cheque'){
                $lsms_payment_data->payment_method = 'Cheque';
                $lsms_payment_cheque_data = PaymentWithCheque::where('payment_id', $data['payment_id'])->first();
                $lsms_payment_cheque_data->cheque_no = $data['edit_cheque_no'];
                $lsms_payment_cheque_data->cheque_date = date('Y-m-d', strtotime($data['edit_cheque_date']));
                $lsms_payment_cheque_data->save(); 
            }
            else{
                $lsms_payment_data->payment_method = 'Cheque';
                $data['cheque_no'] = $data['edit_cheque_no'];
                $data['cheque_date'] = date('Y-m-d', strtotime($data['edit_cheque_date']));
                PaymentWithCheque::create($data);
            }
        }
        $lsms_payment_data->save();
        return redirect('sales')->with('message5', 'Payment updated successfully');
    }

    public function deletePayment(Request $request)
    {
        $lims_payment_data = Payment::find($request['id']);
        $lims_sale_data = Sale::where('id', $lims_payment_data->sale_id)->first();
        $lims_sale_data->paid_amount -= $lims_payment_data->amount;
        $balance = $lims_sale_data->grand_total - $lims_sale_data->paid_amount;
        if($balance > 0 || $balance < 0)
            $lims_sale_data->payment_status = 'Due';
        elseif ($balance == 0)
            $lims_sale_data->payment_status = 'Paid';
        $lims_sale_data->save();

        if ($lims_payment_data->payment_method == 'Cheque') {
            $lims_payment_cheque_data = PaymentWithCheque::where('payment_id', $request['id'])->first();
            $lims_payment_cheque_data->delete();
        }
        $lims_payment_data->delete();
        return redirect('sales');
    }

    public function destroy($id)
    {
        $lsms_sale_data = Sale::find($id);
        $lsms_product_sale_data = ProductSale::where('sale_id', $id)->get();
        $lsms_payment_data = Payment::where('sale_id', $id)->get();
        foreach ($lsms_product_sale_data as $product_sale_data) {
            $lsms_product_data = Product::find($product_sale_data->product_id);
            $lsms_product_data->qty += $product_sale_data->qty;
            $lsms_product_data->save();
            $product_sale_data->delete();
        }

        foreach ($lsms_payment_data as $payment_data) {
            $lsms_payment_with_cheque_data = PaymentWithCheque::where('payment_id', $payment_data->id)->first();
            if($lsms_payment_with_cheque_data)
                $lsms_payment_with_cheque_data->delete();

            $payment_data->delete();
        }
        $lsms_sale_data->delete();
        return redirect('sales');
    }
}
