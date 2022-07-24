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
                        <h4>{{trans('file.Add')}} {{trans('file.Customer')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic">{{trans('file.The field labels marked with * are required input fields')}}.</p>
                        {!! Form::open(['route' => 'customer.store', 'method' => 'post']) !!}
                            <div class="form-group">
                                <label><strong>{{trans('file.Name')}} *</strong> </label>
                                <input type="text" name="name" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong>{{trans('file.Company Name')}} </strong></label>
                                <input type="text" name="company_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong>{{trans('file.Address')}}</strong></label>
                                <input type="text" name="address" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong>{{trans('file.Phone Number')}} *</strong></label>
                                <input type="text" name="phone" required class="form-control" />
                                @if($errors->has('phone'))
                                <span>
                                   <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="is_active" required class="form-control" value="1">
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
    $("ul#customer li").eq(1).addClass("active");
</script>
@endsection