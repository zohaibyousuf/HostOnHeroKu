<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Auth;
use Keygen;
use DNS1D;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProductController extends Controller
{

    public function index()
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('products-index')){
            $lsms_product_all = Product::where('is_active', true)->get();
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            return view('product.index', compact('lsms_product_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::firstOrCreate(['id' => Auth::user()->role]);
        if ($role->hasPermissionTo('products-add')){
            $lsms_category_list = Category::where('is_active', true)->get();
            return view('product.create',compact('lsms_category_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model_no' => [
                'max:255',
                Rule::unique('products')->where(function ($query) {
                            return $query->where('is_active', 1);
                        }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:50000',
        ]);

        $data = $request->except('image');
        $image = $request->image;
        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $data['model_no']);
            $imageName = $imageName . '.' . $ext;
            $image->move('public/product/images', $imageName);
            $data['image'] = $imageName;
        }
        $data['is_active'] = true;
        Product::create($data);
        return redirect('products')->with('message', 'Data inserted successfully'); 
    }

    public function generateCode()
    {
        $id = Keygen::numeric(8)->generate();
        return $id;
    }

    public function edit($id)
    {
        $role = Role::firstOrCreate(['id' => Auth::user()->role]);
        if ($role->hasPermissionTo('products-edit')){
            $lsms_category_list = Category::where('is_active', true)->get();
            $lsms_product_data = Product::where('id', $id)->first();
            return view('product.edit',compact('lsms_category_list', 'lsms_product_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'model_no' => [
                'max:255',
                Rule::unique('products')->ignore($id)->where(function ($query) {
                            return $query->where('is_active', 1);
                        }),
            ],

            'image' => 'image|mimes:jpg,jpeg,png,gif|max:50000',
        ]);

        $lsms_product_data = Product::findOrFail($id);
        $data = $request->except('image');
        $image = $request->image;
        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $data['model_no']);
            $imageName = $imageName . '.' . $ext;
            $image->move('public/product/images', $imageName);
            $data['image'] = $imageName;
        }
        $lsms_product_data->update($data);
        return Redirect::to('products')->with('message', 'Data updated successfully');
    }

    public function printBarcode()
    {
        $lsms_product_list = Product::where('is_active', true)->get();
        return view('product.print_barcode', compact('lsms_product_list'));
    }

    public function lsmsProductSearch(Request $request)
    {
        $product_code = explode(":", $request['data']);
        $lsms_product_data = Product::where('model_no', $product_code[1])->first();
        $product[] = $lsms_product_data->name;
        $product[] = $lsms_product_data->model_no;
        $product[] = $lsms_product_data->price;
        $product[] = DNS1D::getBarcodePNG($lsms_product_data->model_no, $lsms_product_data->barcode_symbology);
        return $product;
    }

    public function importProduct(Request $request)
    {   
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
           $category = Category::firstOrNew(['name'=> $data['category']], ['is_active' => true] );
           $category->save();
           $product = Product::firstOrNew(['model_no'=> $data['code']], ['is_active' => true] );
           $product->name = $data['name'];
           $product->image = $data['image'];
           $product->brand = $data['brand'];
           $product->category_id = $category->id;
           $product->alert_qty = $data['alertqty'];
           $product->price = $data['price'];
           $product->unit = $data['unit'];
           $product->product_details = $data['productdetails'];
           //return $product->model_no;
           if(strtolower($data['barcodesymbology']) == 'code 128')
                $product->barcode_symbology = 'C128';
           elseif(strtolower($data['barcodesymbology']) == 'code 39')
                $product->barcode_symbology = 'C39';
           elseif(strtolower($data['barcodesymbology']) == 'upc-a')
                $product->barcode_symbology = 'UPCA';
           elseif(strtolower($data['barcodesymbology']) == 'upc-e')
                $product->barcode_symbology = 'UPCE';
           elseif(strtolower($data['barcodesymbology']) == 'ean-8')
                $product->barcode_symbology = 'EAN8';
           elseif(strtolower($data['barcodesymbology']) == 'ean-13')
                $product->barcode_symbology = 'EAN13';

           $product->is_active = true;
           $product->qty = 0;
           $product->save();
         }
         return redirect('products')->with('message1', 'Data imported successfully');
        
    }

    public function destroy($id)
    {
        $lsms_product_data = Product::findOrFail($id);
        $lsms_product_data->is_active = false;
        $lsms_product_data->save();
        return redirect('products')->with('not_permitted', 'Data deleted successfully'); ;
    }
}
