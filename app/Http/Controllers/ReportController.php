<?php

namespace App\Http\Controllers;
use App\Product;
use App\ProductPurchase;
use App\Sale;
use App\ProductSale;
use App\Purchase;
use App\Returns;
use App\Payment;
use App\Customer;
use DB;
use Illuminate\Http\Request;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ReportController extends Controller
{
    
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function bestSeller()
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('best-seller')){
            $start = strtotime(date("Y-m", strtotime("-2 months")).'-01');
            $end = strtotime(date("Y").'-'.date("m").'-31');
            while($start <= $end)
            {
                $start_date = date("Y").'-'.date('m', $start).'-'.'01';
                $end_date = date("Y").'-'.date('m', $start).'-'.'31';

                $best_selling_qty = ProductSale::select(DB::raw('product_id, sum(qty) as sold_qty'))->whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->groupBy('product_id')->orderBy('sold_qty', 'desc')->take(1)->get();

                if(!count($best_selling_qty)){
                    $product[] = date('F', $start);
                    $sold_qty[] = 0;
                }
                foreach ($best_selling_qty as $best_seller) {
                    $product_data = Product::find($best_seller->product_id);
                    $product[] = date('F', $start) .': ' .$product_data->name.'('.$product_data->model_no.')';
                    $sold_qty[] = $best_seller->sold_qty;
                }
                $start = strtotime("+1 month", $start);
            }

            $start_month = date("F Y", strtotime('-2 month'));
            return view('report.best_seller', compact('product', 'sold_qty', 'start_month'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function profitLoss(Request $request)
    {
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        $query1 = array(
            'SUM(grand_total) AS grand_total'
        );
        $query2 = array(
            'SUM(grand_total) AS grand_total',
            'SUM(paid_amount) AS paid_amount'
        );
        $purchase = Purchase::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->selectRaw(implode(',', $query1))->get();
        $total_purchase = Purchase::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->count();
        $sale = Sale::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->selectRaw(implode(',', $query2))->get();
        $total_sale = Sale::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->count();
        $return = Returns::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->selectRaw(implode(',', $query1))->get();
        $total_return = Returns::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->count();
        $payment_recieved = DB::table('payments')->whereDate('payments.created_at', '>=' , $start_date)->whereDate('payments.created_at', '<=' , $end_date)->count();
        $total_payment = Payment::whereDate('payments.created_at', '>=' , $start_date)->whereDate('payments.created_at', '<=' , $end_date)->sum('amount');
        $cheque_payment_sale = DB::table('payments')
                                ->whereDate('payments.created_at', '>=' , $start_date)
                                ->whereDate('payments.created_at', '<=' , $end_date)
                                ->where('payment_method','Cheque')
                                ->sum('amount');
        $cash_payment_sale =  $total_payment - $cheque_payment_sale;

        return view('report.profit_loss', compact('purchase', 'total_purchase', 'sale', 'total_sale', 'return', 'total_return', 'total_payment', 'payment_recieved', 'cash_payment_sale', 'cheque_payment_sale', 'start_date', 'end_date'));
    }

    public function productReportByDate(Request $request)
    {
        $data = $request->all();
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        $lsms_product_all = Product::all();
        foreach ($lsms_product_all as $product) {
            $lsms_product_purchase_data = ProductPurchase::where('product_id', $product->id)->whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->first();
            if($lsms_product_purchase_data){
                $product_name[] = $product->name;
                $product_code[] = $product->model_no;
                $product_id[] = $product->id;
                $product_qty[] = $product->qty;
            }
            else{
                $lsms_product_sale_data = ProductSale::where('product_id', $product->id)->whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->first();
                if($lsms_product_sale_data){
                    $product_name[] = $product->name;
                    $product_code[] = $product->model_no;
                    $product_id[] = $product->id;
                    $product_qty[] = $product->qty;
                }
            }
        }
    
        return view('report.product_report',compact('product_id', 'product_name', 'product_code', 'product_qty', 'start_date', 'end_date'));
    }

    public function productQuantityAlert()
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('product-qty-alert')){            
            $lsms_product_data = Product::where('is_active', true)->whereColumn('alert_qty', '>', 'qty')->get();
            return view('report.qty_alert_report', compact('lsms_product_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function purchaseReportByDate(Request $request)
    {
        $data = $request->all();
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        $lsms_product_all = Product::where('is_active', true)->get();

        foreach ($lsms_product_all as $product) {
            $lsms_product_purchase_data = ProductPurchase::where('product_id', $product->id)->whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->first();

            if($lsms_product_purchase_data){
                $product_name[] = $product->name;
                $product_code[] = $product->model_no;
                $product_id[] = $product->id;
                $product_qty[] = $product->qty;
            }
        }
        return view('report.purchase_report',compact('product_id', 'product_name', 'product_code', 'product_qty', 'start_date', 'end_date'));
    }

    public function saleReportByDate(Request $request)
    {
        $data = $request->all();
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        $lsms_product_all = Product::where('is_active', true)->get();

        foreach ($lsms_product_all as $product) {
            $lsms_product_sale_data = ProductSale::where('product_id', $product->id)->whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->first();
            
            if($lsms_product_sale_data){
                $product_name[] = $product->name;
                $product_code[] = $product->model_no;
                $product_id[] = $product->id;
                $product_qty[] = $product->qty;
            }
        }
        return view('report.sale_report',compact('product_id', 'product_name', 'product_code', 'product_qty', 'start_date', 'end_date'));
    }

    public function customerReportByDate(Request $request)
    {
        $data = $request->all();
        $customer_id = $data['customer_id'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        $lsms_sale_data = Sale::where('customer_id', $customer_id)->whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->get();
        $lsms_payment_data = DB::table('sales')
                        ->join('payments', 'sales.id', '=', 'payments.sale_id')
                        ->where('sales.customer_id', $data['customer_id'])
                        ->whereDate('payments.created_at', '>=' , $start_date)
                        ->whereDate('payments.created_at', '<=' , $end_date)->select('payments.*', 'sales.reference_no as sale_reference')->get();
                        
        foreach ($lsms_sale_data as $key => $sale) {
            $lsms_product_sale_data[$key] = ProductSale::where('sale_id', $sale->id)->get();
        }
        $lsms_customer_list = Customer::where('is_active', true)->get();
        return view('report.customer_report', compact('lsms_sale_data', 'lsms_payment_data', 'lsms_product_sale_data', 'customer_id', 'lsms_customer_list', 'start_date', 'end_date'));
    }

    public function dueReportByDate(Request $request)
    {
        $data = $request->all();
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        $lsms_sale_data = Sale::where('payment_status','Due')->whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->get();

        return view('report.due_report', compact('lsms_sale_data'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
