<?php

namespace App\Http\Controllers;
use App\User;
use Hash;
use Keygen;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('users-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            $lsms_user_list = User::where('is_active', true)->get();
            return view('user.index', compact('lsms_user_list', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('users-add')){
            $lsms_role_list = Role::where('is_active', true)->get();
            return view('user.create', compact('lsms_role_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function generatePassword()
    {
        $id = Keygen::numeric(6)->generate();
        return $id;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => [
                'max:255',
                    Rule::unique('users')->where(function ($query) {
                    return $query->where('is_active', true);
                }),
            ],
            'email' => [
                'email',
                'max:255',
                    Rule::unique('users')->where(function ($query) {
                    return $query->where('is_active', true);
                }),
            ],
        ]);

        $data = $request->all();
        if(env('MAIL_FROM_ADDRESS') != ''){
            Mail::send( 'mail.user_details', $data, function( $message ) use ($data)
            {
                $message->to( $data['email'] )->subject( 'User Account Details' );
            });
        }
        $data['is_active'] = true;
        $data['password'] = bcrypt($data['password']);
        User::create($data);
        return redirect('users')->with('message1', 'User created successfullly'); 
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role);
        if($role->hasPermissionTo('users-edit')){
            $lsms_user_data = User::find($id);
            $lsms_role_list = Role::where('is_active', true)->get();
            return view('user.edit', compact('lsms_user_data', 'lsms_role_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    
    public function update(Request $request, $id)
    {
        //return redirect()->back()->with('not_permitted', 'This feature is disable for demo!'); 
        $this->validate($request, [
            'username' => [
                'max:255',
                Rule::unique('users')->ignore($id)->where(function ($query) {
                    return $query->where('is_active', true);
                }),
            ],
            'email' => [
                'email',
                'max:255',
                    Rule::unique('users')->ignore($id)->where(function ($query) {
                    return $query->where('is_active', true);
                }),
            ],
        ]);

        $input = $request->except('password');
        if(!empty($request['password']))
            $input['password'] = bcrypt($request['password']);
        $lims_user_data = User::find($id);
        $lims_user_data->update($input);
        return redirect('users')->with('message1', 'Data updated successfullly');
    }

    public function profile($id)
    {
        $lsms_user_data = User::find($id);
        return view('user.profile', compact('lsms_user_data'));
    }

    public function profileUpdate(Request $request, $id)
    {
        //return redirect()->back()->with('not_permitted', 'This feature is disable for demo!'); 
        $input = $request->all();
        $lsms_user_data = User::find($id);
        $lsms_user_data->update($input);
        return redirect()->back()->with('message1', 'Profile updated successfully');
    }

    public function changePassword(Request $request, $id)
    {
        //return redirect()->back()->with('not_permitted', 'This feature is disable for demo!'); 
        $input = $request->all();
        $lsms_user_data = User::find($id);
        if($input['new_pass'] != $input['confirm_pass'])
            return redirect()->back()->with('message2', "Please Confirm your new password");

        if (Hash::check($input['current_pass'], $lsms_user_data->password)) {
            $lsms_user_data->password = bcrypt($input['new_pass']);
            $lsms_user_data->save();
        }
        else {
            return redirect()->back()->with('message2', "Current Password doesn't match");
        }
        auth()->logout();
        return redirect('/');
    }

    public function destroy($id)
    {
        //return redirect()->back()->with('not_permitted', 'This feature is disable for demo!'); 
        $lsms_user_data = User::find($id);
        $lsms_user_data->is_active = false;
        $lsms_user_data->save();
        return redirect('users')->with('message2', 'User deleted successfully');
    }
}
