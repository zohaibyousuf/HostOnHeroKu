@extends('layout.main')
@section('content')
@if(session()->has('message1'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message1') }}</div> 
@endif
@if(session()->has('message2'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message2') }}</div> 
@endif
@if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>Update User Profile</h4>
                    </div>
                    <div class="card-body">
                        <p>The field labels marked with * are required input fields.</p>
                        {!! Form::open(['route' => ['user.profileUpdate', Auth::id()], 'method' => 'post']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><strong>Name *</strong> </label>
                                    <input type="text" name="name" value="{{$lsms_user_data->name}}" required class="form-control" />
                                    @if($errors->has('name'))
                                    <span>
                                       <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label><strong>Username *</strong> </label>
                                    <input type="text" name="username" value="{{$lsms_user_data->username}}" required class="form-control" />
                                    @if($errors->has('username'))
                                    <span>
                                       <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label><strong>Company Name *</strong> </label>
                                    <input type="text" name="company_name" value="{{$lsms_user_data->company_name}}" required class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label><strong>Email *</strong> </label>
                                    <input type="email" name="email" value="{{$lsms_user_data->email}}" required class="form-control">
                                    @if($errors->has('email'))
                                    <span>
                                       <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label><strong>Address *</strong> </label>
                                    <input type="text" name="address" value="{{$lsms_user_data->address}}" required class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label><strong>Phone *</strong> </label>
                                    <input type="text" name="phone" value="{{$lsms_user_data->phone}}" required class="form-control" />
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>Change Password</h4>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['route' => ['user.password', Auth::id()], 'method' => 'put']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><strong>Current Password *</strong> </label>
                                    <input type="password" name="current_pass" required class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label><strong>New Password *</strong> </label>
                                    <input type="password" name="new_pass" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <label><strong>Confirm Password *</strong> </label>
                                    <input type="password" name="confirm_pass" id="confirm_pass" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <div class="registrationFormAlert" id="divCheckPasswordMatch">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $('select[name="role"]').val($('input[name="role_hidden"]').val());
    $('#confirm_pass').on('input', function(){

        if($('input[name="new_pass"]').val() != $('input[name="confirm_pass"]').val())
            $("#divCheckPasswordMatch").html("Password doesn't match!");
        else
            $("#divCheckPasswordMatch").html("Password matches!");
         
    });
</script>
@endsection
