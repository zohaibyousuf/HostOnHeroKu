<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use App\Product;
use App\Purchase;
use App\ProductPurchase;
use App\Category;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PurchaseController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('purchases-index')){
            $lsms_purchase_all = Purchase::orderBy('id', 'desc')->get();
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            return view('purchase.index', compact('lsms_purchase_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('purchases-add')){
            $lsms_product_list = Product::where('is_active', true)->get();
            if($lsms_product_list->isEmpty())
                return redirect('purchases')->with('message','Your Product Table is empty');
            return view('purchase.create', compact('lsms_product_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
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
        return $product;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['reference_no'] = 'pr-' . date("Ymd") . '-'. date("his");
        $data['user_id'] = Auth::id();
        Purchase::create($data);

        $lsms_purchase_data = Purchase::latest()->first();
        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $product_cost = $data['product_cost'];;
        $total = $data['subtotal'];
        $product_purchase = [];

        foreach ($product_id as $key => $id) {
            //add quantity to product table
            $lsms_product_data = Product::find($id);
            $lsms_product_data->qty = $lsms_product_data->qty + $qty[$key];
            $lsms_product_data->save();

            $product_purchase['purchase_id'] = $lsms_purchase_data->id ;
            $product_purchase['product_id'] = $id;
            $product_purchase['qty'] = $qty[$key];
            $product_purchase['unit'] = $lsms_product_data->unit;
            $product_purchase['product_cost'] = $product_cost[$key];
            $product_purchase['total'] = $total[$key];
            ProductPurchase::create($product_purchase);
        }
        return redirect('purchases')->with('message3','Purchase Created Successfully');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('purchases-edit')){
            $lsms_product_list = Product::where('is_active', true)->get();
            $lsms_purchase_data = Purchase::find($id);
            $lsms_product_purchase_data = ProductPurchase::where('purchase_id', $id)->get();

            return view('purchase.edit', compact('lsms_product_list', 'lsms_purchase_data', 'lsms_product_purchase_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $lsms_purchase_data = Purchase::find($id);
        $lsms_product_purchase_data = ProductPurchase::where('purchase_id', $id)->get();

        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $product_cost = $data['product_cost'];
        $total = $data['subtotal'];
        $product_purchase = [];

        foreach ($lsms_product_purchase_data as $key => $product_purchase_data) {
            $old_recieved_value = $product_purchase_data->qty;
            $old_product_id[] = $product_purchase_data->product_id;
            $lsms_product_data = Product::find($product_purchase_data->product_id);

            $lsms_product_data->qty -= $old_recieved_value;
            $lsms_product_data->save();
            if( !(in_array($old_product_id[$key], $product_id)) )
                $product_purchase_data->delete();
        }

        foreach ($product_id as $key => $pro_id) {

            $lsms_product_data = Product::find($pro_id);
            $lsms_product_data->qty += $qty[$key];
            $lsms_product_data->save();

            $product_purchase['purchase_id'] = $id ;
            $product_purchase['product_id'] = $pro_id;
            $product_purchase['qty'] = $qty[$key];
            $product_purchase['product_cost'] = $product_cost[$key];
            $product_purchase['total'] = $total[$key];

            if(in_array($pro_id, $old_product_id))
                ProductPurchase::where([
                    ['purchase_id', $id],
                    ['product_id', $pro_id]
                    ])->update($product_purchase);
            else{
                $product_purchase['unit'] = $lsms_product_data->unit;
                ProductPurchase::create($product_purchase);
            }
        }

        $lsms_purchase_data->update($data);
        return redirect('purchases')->with('message4','Purchase Updated Successfully');
    }

    public function productPurchaseData($id)
    {
        $lims_product_purchase_data = ProductPurchase::where('purchase_id', $id)->get();
        foreach ($lims_product_purchase_data as $key => $product_purchase_data) {
            $product = Product::find($product_purchase_data->product_id);

            $product_purchase[0][$key] = $product->name . ':' . $product->model_no;
            $product_purchase[1][$key] = $product_purchase_data->qty;
            $product_purchase[2][$key] = $product_purchase_data->product_cost;
            $product_purchase[3][$key] = $product_purchase_data->total;
            $product_purchase[4][$key] = $product_purchase_data->unit;
        }
        return $product_purchase;
    }

    public function purchaseByCsv()
    {
        return view('purchase.import');
    }

    public function importPurchase(Request $request)
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
        $product_cost = 0;
        $grand_total = $data['shipping_cost'];
        $data['reference_no'] = 'pr-'.date("Ymd").'-'.date("his");
        $data['item'] = $data['total_qty'] = $data['total_cost'] = $data['grand_total'] = 0;
        $data['user_id'] = Auth::id();
        Purchase::create($data);
        $lsms_purchase_data = Purchase::latest()->first();

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
           $product->qty += $data['quantity'];
           $product->save();
           
           $product_purchase = new ProductPurchase();
           $product_purchase->purchase_id = $lsms_purchase_data->id;
           $product_purchase->product_id = $product->id;
           $product_purchase->qty = $data['quantity'];
           $product_purchase->product_cost = $data['productcost'];
           $product_purchase->total = $data['quantity'] * $data['productcost'];
           $product_purchase->save();
           $quantity += $data['quantity'];
           $product_cost += $data['productcost'];
           $grand_total +=  $product_purchase->total;
           $item++;
         }
         $lsms_purchase_data->item = $item;
         $lsms_purchase_data->total_qty = $quantity;
         $lsms_purchase_data->total_cost = $product_cost;
         $lsms_purchase_data->grand_total = $grand_total;
         $lsms_purchase_data->save();
         return redirect('purchases')->with('message4','Purchase imported successfully');  
    }

    public function destroy($id)
    {
        $lsms_purchase_data = Purchase::find($id);
        $lsms_product_purchase_data = ProductPurchase::where('purchase_id', $id)->get();
        foreach ($lsms_product_purchase_data as $product_purchase_data) {
            $lsms_product_data = Product::find($product_purchase_data->product_id);
            $lsms_product_data->qty -= $product_purchase_data->qty;
            $lsms_product_data->save();
            $product_purchase_data->delete();
        }
        $lsms_purchase_data->delete();
        return redirect('purchases')->with('message','Purchase deleted successfully');
    }
}
