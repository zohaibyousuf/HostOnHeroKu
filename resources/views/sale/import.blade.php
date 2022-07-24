@extends('layout.main') @section('content')
@if(session()->has('message1'))
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message1') }}</div> 
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Import')}} {{trans('file.Sale')}} {{trans('file.By')}} CSV</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic">{{trans('file.The field labels marked with * are required input fields')}}.</p>
                        {!! Form::open(['route' => 'sale.import', 'method' => 'post', 'files' => true, 'id' => 'purchase-form']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Invoice')}} No</strong></label>
                                            <p><strong>{{'sr-' . date("Ymd") . '-'. date("his")}}</strong> </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Customer')}} *</strong></label>
                                            <select name="customer_id" class="selectpicker form-control" required data-live-search="true" id="customer-id" data-live-search-style="begins" title="Select customer...">
                                                @foreach($lsms_customer_list as $customer)
                                                <option value="{{$customer->id}}">{{$customer->name . ' (' . $customer->phone. ')'}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Payment')}} {{trans('file.Status')}}</strong></label>
                                            <select class="form-control" name="payment_status">
                                                <option value="Due">Due</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Payment')}} {{trans('file.Method')}}</strong></label>
                                            <select class="form-control" name="payment_method">
                                                <option value="Cheque">Cheque</option>
                                                <option value="Cash">Cash</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Paid')}} {{trans('file.Amount')}}</strong></label>
                                            <input type="number" name="paid_amount" class="form-control" value="0" required />
                                        </div>
                                    </div>
                                </div>
                                <div id="cheque-element" class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Cheque')}} No</strong></label>
                                            <input type="text" name="cheque_no" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Cheque')}} Date</strong></label>
                                            <input id="cheque-date" type="text" name="cheque_date" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Upload CSV File')}} *</strong></label>
                                            <input type="file" name="file" class="form-control" required />
                                            <p>{{trans('file.The correct column order is')}} (product_code, quantity, product_price) {{trans('file.and you must follow this')}}. {{trans('file.All columns are required')}} </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong></strong></label><br>
                                            <a href="../public/sample_file/sample_sale_products.csv" class="btn btn-primary btn-block btn-lg"><i class="fa fa-download"></i> {{trans('file.Download Sample File')}}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Note')}}</strong></label>
                                            <textarea rows="5" class="form-control" name="note"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary" id="submit-button">
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

$('.selectpicker').selectpicker({
    style: 'btn-link',
});

$('select[name="payment_method"]').on('change', function(){
    if($('select[name="payment_method"]').val() == 'Cheque')
        $('#cheque-element').show();
    else
        $('#cheque-element').hide();
});

    var cheque_date = $('#cheque-date');
    cheque_date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
     });
    
</script>
@endsection