<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Customer;
use App\Returns;
use App\ProductReturn;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ReturnController extends Controller
{

    public function index()
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('returns-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            $lsms_return_all = Returns::orderBy('id', 'desc')->get();
            return view('return.index',compact('lsms_return_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
       
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('returns-add')){
            $lsms_product_list = Product::where('is_active', true)->get();
            if($lsms_product_list->isEmpty())
                return redirect('/returns')->with('message1','Your Product Table is empty');
            $lsms_customer_list = Customer::where('is_active', true)->get();
            
            return view('return.create', compact('lsms_product_list', 'lsms_customer_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function lsmsProductSearch(Request $request)
    {
        $data = explode(":",$request['data']);
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

    public function store(Request $request)
    {
        $data = $request->all();
        $data['reference_no'] = 'rr-' . date("Ymd") . '-'. date("his");
        $data['user_id'] = Auth::id();
        Returns::create($data);
        $lsms_return_data = Returns::latest()->first();

        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $product_price = $data['product_price'];;
        $total = $data['subtotal'];
        $product_return = [];

        foreach ($product_id as $key => $id) {
            //add quantity to product table
            $lsms_product_data = Product::find($id);
            $lsms_product_data->qty = $lsms_product_data->qty + $qty[$key];
            $lsms_product_data->save();

            $product_return['return_id'] = $lsms_return_data->id ;
            $product_return['product_id'] = $id;
            $product_return['qty'] = $qty[$key];
            $product_return['product_price'] = $product_price[$key];
            $product_return['total'] = $total[$key];
            $product_return['unit'] = $lsms_product_data->unit;
            ProductReturn::create($product_return);
        }

        return redirect('returns')->with('message','Return Created Successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('returns-edit')){
            $lsms_product_list = Product::where('is_active', true)->get();
            $lsms_customer_list = Customer::where('is_active', true)->get();
            $lsms_return_data = Returns::find($id);
            $lsms_product_return_data = ProductReturn::where('return_id', $id)->get();
            return view('return.edit', compact('lsms_product_list', 'lsms_return_data', 'lsms_product_return_data', 'lsms_customer_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $lsms_return_data = Returns::find($id);
        $lsms_product_return_data = ProductReturn::where('return_id', $id)->get();
        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $product_price = $data['product_price'];
        $total = $data['subtotal'];
        $product_return = [];

        foreach ($lsms_product_return_data as $key => $product_return_data) {
            $old_recieved_value = $product_return_data->qty;
            $old_product_id[] = $product_return_data->product_id;
            $lsms_product_data = Product::find($product_return_data->product_id);

            $lsms_product_data->qty -= $old_recieved_value;
            $lsms_product_data->save();
            if( !(in_array($old_product_id[$key], $product_id)) )
                $product_return_data->delete();
        }

        foreach ($product_id as $key => $pro_id) {

            $lsms_product_data = Product::find($pro_id);
            $lsms_product_data->qty += $qty[$key];
            $lsms_product_data->save();

            $product_return['return_id'] = $id ;
            $product_return['product_id'] = $pro_id;
            $product_return['qty'] = $qty[$key];
            $product_return['product_price'] = $product_price[$key];
            $product_return['total'] = $total[$key];

            if(in_array($pro_id, $old_product_id))
                ProductReturn::where([
                    ['return_id', $id],
                    ['product_id', $pro_id]
                    ])->update($product_return);
            else{
                $product_return['unit'] = $lsms_product_data->unit;
                ProductReturn::create($product_return);
            }
        }

        $lsms_return_data->update($data);
        return redirect('returns')->with('message','Return Updated Successfully');
    }

    public function productreturnData($id)
    {
        $lims_product_return_data = ProductReturn::where('return_id', $id)->get();
        foreach ($lims_product_return_data as $key => $product_return_data) {
            $product = Product::find($product_return_data->product_id);

            $product_return[0][$key] = $product->name . ':' . $product->model_no;
            $product_return[1][$key] = $product_return_data->qty;
            $product_return[2][$key] = $product_return_data->product_price;
            $product_return[3][$key] = $product_return_data->total;
            $product_return[4][$key] = $product_return_data->unit;
        }
        return $product_return;
    }

    public function destroy($id)
    {
        $lsms_return_data = Returns::find($id);
        $lsms_product_return_data = ProductReturn::where('return_id', $id)->get();
        foreach ($lsms_product_return_data as $product_return_data) {
            $lsms_product_data = Product::find($product_return_data->product_id);
            $lsms_product_data->qty -= $product_return_data->qty;
            $lsms_product_data->save();
            $product_return_data->delete();
        }
        $lsms_return_data->delete();
        return redirect('returns')->with('message','Data Deleted Successfully');
    }
}
