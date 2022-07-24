<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index()
    {
        $lims_supplier_all = Supplier::paginate(10);
        $lims_supplier_list = Supplier::all();
        return view('supplier.index',compact('lims_supplier_all', 'lims_supplier_list'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'company_name' => 'string|max:255|unique:suppliers',
            'email' => 'email|max:255|unique:suppliers',
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);
        
        $input = $request->except('image');
        $image = $request->image;
        if ($image) {
            $imageName = $image->getClientOriginalName();
            $image->move('images', $imageName);
            $input['image'] = $imageName;
        }

        Supplier::create($input);
        return redirect('supplier');
    }

    public function limsSupplierSearch()
    {
        $lims_supplier_title = $_GET['lims_supplierTitleSearch'];
        $lims_supplier_all = Supplier::where('company_name', $lims_supplier_title)->paginate(5);
        $lims_supplier_list = Supplier::all();
        return view('supplier.index', compact('lims_supplier_all', 'lims_supplier_list'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $lims_supplier_data = Supplier::where('id',$id)->first();
        return view('supplier.edit',compact('lims_supplier_data'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'company_name' => [
                'max:255',
                Rule::unique('suppliers')->ignore($id),
            ],

            'email' => [
                'max:255',
                Rule::unique('suppliers')->ignore($id),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);

        $input = $request->except('image');
        $image = $request->image;
        if ($image) {
            $imageName = $image->getClientOriginalName();
            $image->move('images', $imageName);
            $input['image'] = $imageName;
        }

        $lims_supplier_data = Supplier::findOrFail($id);
        $lims_supplier_data->update($input);
        return redirect('supplier');
    }

    public function destroy($id)
    {
        $lims_supplier_data = Supplier::findOrFail($id);
        $lims_supplier_data->delete();
        return redirect('supplier');
    }

    public function importSupplier(Request $request)
    {
        $header = null;
        $delimiter = ',' ;
        $data = array();
        $filename = $request->file->getClientOriginalName();
        if (($handle = fopen($filename, "r")) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        for ($i = 0; $i < count($data); $i ++)
        {
            Supplier::Create($data[$i]);
        }
        return redirect('supplier');
    }

    public function exportSupplier(Request $request)
    {
        $lims_supplier_data = $request['supplierArray'];
        $csvData=array('name, image, company_name, vat_number, email, phone_number, address, city, state, postal_code, country');
        foreach ($lims_supplier_data as $supplier) {
            if($supplier > 0) {
                $data = supplier::where('id', $supplier)->first();
                $csvData[]=$data->name .','. $data->image . ',' .$data->company_name . ',' . $data->vat_number . ',' . $data->email . ',' . $data->phone_number . ',' . $data->address . ',' . $data->city . ',' . $data->state . ',' . $data->postal_code . ',' . $data->country;
            }   
        }        
        $filename=date('Y-m-d').".csv";
        $file_path=public_path().'/downloads/'.$filename;
        $file_url=url('/').'/downloads/'.$filename;   
        $file = fopen($file_path,"w+");
        foreach ($csvData as $exp_data){
          fputcsv($file,explode(',',$exp_data));
        }   
        fclose($file);
        return $file_url;
    }
}
