<?php

namespace App\Http\Controllers;
use App\ProductPurchase;
use App\Product;
use App\Sale;
use App\ProductSale;
use App\Purchase;
use App\Returns;
use App\Payment;
use App\Language;
use Auth;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     
        $this->middleware('auth');
    }


    public function report()
    {
        if(!Auth::user()->is_active){
            auth()->logout();
            return redirect('/');
        }
        
        $start_date = date("Y").'-'.date("m").'-'.'01';
        $end_date = date("Y").'-'.date("m").'-'.'31';
        $sale = Sale::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
        $return = Returns::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
        $revenue = $sale - $return;
        $purchase = Purchase::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
        $profit = $revenue - $purchase;
        $sold_qty = Sale::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('total_qty');

        $recent_sale = Sale::orderBy('id', 'desc')->take(5)->get();
        $recent_purchase = Purchase::orderBy('id', 'desc')->take(5)->get();
        $recent_return = Returns::orderBy('id', 'desc')->take(5)->get();
        $recent_payment = Payment::orderBy('id', 'desc')->take(5)->get();

        $best_selling_qty = ProductSale::select(DB::raw('product_id, sum(qty) as sold_qty'))->whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->groupBy('product_id')->orderBy('sold_qty', 'desc')->take(5)->get();

        $yearly_best_selling_qty = ProductSale::select(DB::raw('product_id, sum(qty) as sold_qty'))->whereDate('created_at', '>=' , date("Y").'-01-01')->whereDate('created_at', '<=' , date("Y").'-12-31')->groupBy('product_id')->orderBy('sold_qty', 'desc')->take(5)->get();

        $yearly_best_selling_price = ProductSale::select(DB::raw('product_id, sum(total) as total_price'))->whereDate('created_at', '>=' , date("Y").'-01-01')->whereDate('created_at', '<=' , date("Y").'-12-31')->groupBy('product_id')->orderBy('total_price', 'desc')->take(5)->get();

        $start = strtotime(date("Y") .'-01-01');
        $end = strtotime(date("Y") .'-12-31');
        while($start < $end)
        {
            $start_date = date("Y").'-'.date('m', $start).'-'.'01';
            $end_date = date("Y").'-'.date('m', $start).'-'.'31';
            $sale_amount = Sale::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
            $purchase_amount = Purchase::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');

             $yearly_sale_amount[] = number_format((float)$sale_amount, 2, '.', '');
             $yearly_purchase_amount[] = number_format((float)$purchase_amount, 2, '.', '');
             $start = strtotime("+1 month", $start);
        }

        return view('index', compact('sale', 'return', 'revenue', 'purchase', 'sold_qty', 'profit', 'recent_sale', 'recent_purchase', 'recent_return', 'recent_payment', 'best_selling_qty', 'yearly_best_selling_qty', 'yearly_best_selling_price', 'yearly_sale_amount', 'yearly_purchase_amount'));
    }

    public function switchLanguage($locale)
    {
        $language = Language::firstOrNew(['id' => 1]);
        $language->code = $locale;
        $language->save();
        return redirect()->back();
    }

    public function logoutIfAuthenticated()
    {
        return redirect('/dashboard');
    }
}
