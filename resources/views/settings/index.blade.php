@extends('layout.main') @section('content')



@if(session()->has('message'))

  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 

@endif

@if(session()->has('not_permitted'))

  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 

@endif

<section class="forms">

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header d-flex align-items-center">

                        <h4>{{trans('file.Settings')}}</h4>

                    </div>

                    <div class="card-body">

                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>

                        {!! Form::open(['route' => 'settings.store', 'files' => true, 'method' => 'post']) !!}

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label><strong>{{trans('file.Site Title')}} *</strong></label>

                                        <input type="text" name="site_title" class="form-control" value="@if($lsms_setting_data){{$lsms_setting_data->site_title}}@endif" required />

                                    </div>

                                    <div class="form-group">

                                        <label><strong>{{trans('file.Mail Host')}}</strong></label>

                                        <input type="text" name="mail_host" class="form-control" value="{{env('MAIL_HOST')}}" />

                                    </div>

                                    <div class="form-group">

                                        <label><strong>{{trans('file.Mail Address')}}</strong></label>

                                        <input type="text" name="mail_address" class="form-control" value="{{env('MAIL_FROM_ADDRESS')}}" />

                                    </div>

                                    <div class="form-group">

                                        <label><strong>{{trans('file.Mail Name')}}</strong></label>

                                        <input type="text" name="mail_name" class="form-control" value="{{env('MAIL_FROM_NAME')}}" />

                                    </div>

                                    <div class="form-group">

                                        <label><strong>{{trans('file.Currency')}} *</strong></label>

                                        <input type="text" name="currency" class="form-control" value="@if($lsms_setting_data){{$lsms_setting_data->currency}}@endif" required />

                                    </div>

                                    <div class="form-group">

                                        <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label><strong>{{trans('file.Site Logo')}}</strong></label>

                                        <input type="file" name="site_logo" class="form-control" value=""/>

                                    </div>

                                    @if($errors->has('site_logo'))

                                   <span>

                                       <strong>{{ $errors->first('site_logo') }}</strong>

                                    </span>

                                    @endif

                                    <div class="form-group">

                                        <label><strong>{{trans('file.Mail Port')}}</strong></label>

                                        <input type="text" name="port" class="form-control" value="{{env('MAIL_PORT')}}" />

                                    </div>

                                    <div class="form-group">

                                        <label><strong>{{trans('file.Password')}}</strong></label>

                                        <input type="password" name="password" class="form-control" value="{{env('MAIL_PASSWORD')}}" />

                                    </div>

                                    <div class="form-group">

                                        <label><strong>{{trans('file.Encryption')}}</strong></label>

                                        <input type="text" name="encryption" class="form-control" value="{{env('MAIL_ENCRYPTION')}}" />

                                    </div>

                                    <div class="form-group">

                                        <label><strong>{{trans('file.Time Zone')}}</strong></label>

                                        @if($lsms_setting_data)

                                        <input type="hidden" name="timezone_hidden" value="{{env('APP_TIMEZONE')}}">

                                        @endif

                                        <select name="timezone" class="selectpicker form-control" data-live-search="true" title="Select TimeZone...">

                                            @foreach($zones_array as $zone)

                                            <option value="{{$zone['zone']}}">{{$zone['diff_from_GMT'] . ' - ' . $zone['zone']}}</option>

                                            @endforeach

                                        </select>

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



    $("ul#settings").siblings('a').attr('aria-expanded','true');

    $("ul#settings").addClass("show");

    $("ul#settings li").eq(1).addClass("active");



    if($("input[name='timezone_hidden']").val()){

        $('select[name=timezone]').val($("input[name='timezone_hidden']").val());

        $('.selectpicker').selectpicker('refresh');

    }



    $('.selectpicker').selectpicker({

      style: 'btn-link',

    });



</script>

@endsection