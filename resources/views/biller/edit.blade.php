@extends('layout.main') @section('content')
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>Update Biller</h4>
                    </div>
                    <div class="card-body">
                        <p>The field labels marked with * are required input fields.</p>
                        {!! Form::open(['route' => ['biller.update', $lims_biller_data->id], 'method' => 'put', 'files' => true]) !!}

                            <div class="form-group">
                                <label><strong>Name *</strong> </label>
                                <input type="text" name="name" value="{{$lims_biller_data->name}}" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong>Image</strong></label>
                                <input type="file" name="image" class="form-control">
                                @if($errors->has('image'))
                               <span>
                                   <strong>{{ $errors->first('image') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label><strong>Company Name *</strong></label>
                                <input type="text" name="company_name" value="{{$lims_biller_data->company_name}}" required class="form-control">
                                @if($errors->has('company_name'))
                               <span>
                                   <strong>{{ $errors->first('company_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label><strong>VAT Number</strong></label>
                                <input type="text" name="vat_number" value="{{$lims_biller_data->vat_number}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong>E-mail *</strong></label>
                                <input type="email" name="email" value="{{$lims_biller_data->email}}" required class="form-control">
                                @if($errors->has('email'))
                               <span>
                                   <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label><strong>Phone Number *</strong></label>
                                <input type="text" name="phone_number" value="{{$lims_biller_data->phone_number}}" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong>Address *</strong></label>
                                <input type="text" name="address" value="{{$lims_biller_data->address}}" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong>City *</strong></label>
                                <input type="text" name="city"  value="{{$lims_biller_data->city}}" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong>State</strong></label>
                                <input type="text" name="state" value="{{$lims_biller_data->state}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong>Postal Code</strong></label>
                                <input type="text" name="postal_code" value="{{$lims_biller_data->postal_code}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong>Country</strong></label>
                                <input type="text" name="country" value="{{$lims_biller_data->country}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Submit" class="btn btn-primary">
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
