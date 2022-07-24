<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $lsms_category_all = Category::where('is_active', 1)->get();
        return view('category.create',compact( 'lsms_category_all'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $request->name = preg_replace('/\s+/', ' ', $request->name);
        $this->validate($request, [
            'name' => [
                'max:255',
                    Rule::unique('categories')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);
        $lsms_category_data['name'] = $request->name;
        $lsms_category_data['is_active'] = true;
        Category::create($lsms_category_data);
        return redirect('category')->with('message', 'Category created successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $lsms_category_data = Category::findOrFail($id);
        return $lsms_category_data;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => [
                'max:255',
                Rule::unique('categories')->ignore($request->category_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $input = $request->all();
        $lsms_category_data = Category::findOrFail($request->category_id);
        $lsms_category_data->update($input);
        return redirect('category')->with('message', 'Category updated successfully');
    }

    public function importCategory(Request $request)
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

           $category = Category::firstOrNew(['name'=>$data['name']]);
           $category->name = $data['name'];
           $category->is_active = true;
           $category->save();
        }
        return redirect('category')->with('message', 'Category imported successfully');
    }

    public function destroy($id)
    {
        $lsms_category_data = Category::findOrFail($id);
        $lsms_product_data = Product::where('category_id', $id)->get();
        foreach ($lsms_product_data as $product_data) {
            $product_data->is_active = false;
            $product_data->save();
        }
        $lsms_category_data->is_active = false;
        $lsms_category_data->save();
        return redirect('category')->with('not_permitted','Category deleted successfully');
    }
}
