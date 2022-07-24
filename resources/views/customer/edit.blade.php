@extends('layout.main') @section('content')
@if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Update')}} {{trans('file.Customer')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic">{{trans('file.The field labels marked with * are required input fields')}}.</p>
                        {!! Form::open(['route' => ['customer.update',$lsms_customer_data->id], 'method' => 'put']) !!}
                            <div class="form-group">
                                <label><strong>{{trans('file.Name')}} *</strong> </label>
                                <input type="text" name="name" value="{{$lsms_customer_data->name}}" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong>{{trans('file.Company Name')}} </strong></label>
                                <input type="text" name="company_name" value="{{$lsms_customer_data->company_name}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong>{{trans('file.Address')}}</strong></label>
                                <input type="text" name="address" value="{{$lsms_customer_data->address}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong>{{trans('file.Phone Number')}} *</strong></label>
                                <input type="text" name="phone" required value="{{$lsms_customer_data->phone}}" class="form-control">
                                @if($errors->has('phone'))
                                <span>
                                   <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $("ul#customer").siblings('a').attr('aria-expanded','true');
    $("ul#customer").addClass("show");
</script>
@endsection