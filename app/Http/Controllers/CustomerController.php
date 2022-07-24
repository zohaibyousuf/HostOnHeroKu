<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerGroup;
use App\Customer;
use Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CustomerController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('customers-index')){
            $lsms_customer_all = Customer::where('is_active', true)->get();
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            return view('customer.index', compact('lsms_customer_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('customers-add')){
            return view('customer.create');
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'phone' => [
                'max:255',
                Rule::unique('customers')->where(function ($query) {
                        return $query->where('is_active', 1);
                    }),
            ],
        ]);

        $lsms_customer_data = $request->all();
        Customer::create($lsms_customer_data);
        return redirect('customer')->with('message1', 'Data inserted Successfully');
    }

    public function lsmsCustomerSearch()
    {
        $lsms_customer_title = $_GET['lsms_customerTitleSearch'];
        $lsms_customer_all = Customer::where('name', 'LIKE',"%{$lsms_customer_title}%")->paginate(10);
        $lsms_customer_list = Customer::all();
        return view('customer.index', compact('lsms_customer_all', 'lsms_customer_list'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('customers-edit')){
            $lsms_customer_data = Customer::find($id);
            return view('customer.edit', compact('lsms_customer_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'phone' => [
                'max:255',
            Rule::unique('customers')->ignore($id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $input = $request->all();
        $lsms_customer_data = Customer::find($id);
        $lsms_customer_data->update($input);
        return redirect('customer')->with('message2', 'Data updated Successfully');
    }

    public function importCustomer(Request $request)
    {
        //get the file
        $upload=$request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        //checking if this is a CSV file
        if($ext != 'csv')
            return redirect()->back()->with('message3', 'Please upload a CSV file');
        
        $filePath=$upload->getRealPath();
        $file_handle = fopen($filePath, 'r');
        //checking any column is empty
        while (!feof($file_handle) ) {
            $current_line = fgetcsv($file_handle, 1024);
            if($current_line){
                if(in_array('', $current_line)) {
                    return redirect()->back()->with('message4', 'Any Column of your CSV file is empty! Please Check your CSV file!!!');
                }
            }
        }

        $filename =  $request->file->getClientOriginalName();
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
           $customer = Customer::firstOrNew(['phone'=>$data['phone']]);

           $customer->name = $data['name'];
           $customer->company_name = $data['company'];
           $customer->phone = $data['phone'];
           $customer->address = $data['address'];
           $customer->is_active = true;
           $customer->save();
        }
        return redirect('customer')->with('import_message','Data Imported Successfully');
        
    }

    public function exportCustomer(Request $request)
    {
        $lsms_customer_data = $request['customerArray'];
        $csvData=array('customer_group, name, company_name, email, phone_number, address, city, state, postal_code, country');
        foreach ($lsms_customer_data as $customer) {
            if($customer > 0) {
                $data = Customer::where('id', $customer)->first();
                $lsms_customer_group_data = CustomerGroup::where('id', $data->customer_group_id)->first();
                $csvData[]=$lsms_customer_group_data->name . ',' . $data->name .','. $data->company_name . ',' . $data->email . ',' . $data->phone_number . ',' . $data->address . ',' . $data->city . ',' . $data->state . ',' . $data->postal_code . ',' . $data->country;
            }   
        }        
        $filename="customer- " .date('d-m-Y').".csv";
        $file_path=public_path().'/downloads/'.$filename;
        $file_url=url('/').'/downloads/'.$filename;   
        $file = fopen($file_path,"w+");
        foreach ($csvData as $exp_data){
          fputcsv($file,explode(',',$exp_data));
        }   
        fclose($file);
        return $file_url;
    }

    public function destroy($id)
    {
        $lsms_customer_data = Customer::find($id);
        $lsms_customer_data->is_active = false;
        $lsms_customer_data->save();
        return redirect('customer');
    }
}
