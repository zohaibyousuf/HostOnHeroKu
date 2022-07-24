@extends('layout.main') @section('content')

@if(empty($product_name))
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{'No Data exist between this date range!'}}</div>
@endif

<section>
    {!! Form::open(['route' => 'report.byDate', 'method' => 'post']) !!}
    <div class="col-md-6 offset-md-3">
        <div class="form-group row">
            <label><strong>{{trans('file.Choose Your Date')}}</strong></label>
            <div class="input-group">
                <input type="text" class="daterangepicker-field form-control" value="{{$start_date}} to {{$end_date}}" required />
                <input type="hidden" name="start_date" value="{{$start_date}}" />
                <input type="hidden" name="end_date" value="{{$end_date}}"/>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">{{trans('file.Submit')}}</button>
                </div>
            </div>
        </div>  
    </div>
    {!! Form::close() !!}
    <table id="report-table" class="table table-hover">
        <thead>
            <tr>
                <th class="not-exported"></th>
                <th>{{trans('file.Product')}}</th>
                <th>{{trans('file.Purchased')}} {{trans('file.Amount')}}</th>
                <th>{{trans('file.Purchased')}} Qty</th>
                <th>{{trans('file.Sold')}} {{trans('file.Amount')}}</th>
                <th>{{trans('file.Sold')}} Qty</th>
                <th>{{trans('file.profit')}}</th>
                <th>{{trans('file.In Stock')}}</th>
            </tr>
        </thead>
        <tbody>
        	<?php 
        		$total_cost = 0;
        		$total_purchased_qty = 0;
        		$total_price = 0;
        		$total_sold_qty = 0;
                $total_profit = 0;
        	?>
            @if(!empty($product_name))
            @foreach($product_id as $key => $pro_id)
            <tr>
                <td>{{$key}}</td>
                <td>{{$product_name[$key].':'.$product_code[$key]}}</td>
                <?php
                    $purchased_cost = DB::table('product_purchases')->where('product_id', $pro_id)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $end_date)->sum('total');

                	$total_cost += $purchased_cost;
                    
                    $purchased_qty = DB::table('product_purchases')->where('product_id', $pro_id)
                    ->whereDate('created_at','>=', $start_date)->whereDate('created_at','<=', $end_date)->sum('qty');

                	$total_purchased_qty += $purchased_qty;

                    $sold_price = DB::table('product_sales')->where('product_id', $pro_id)
                    ->whereDate('created_at','>=', $start_date)->whereDate('created_at','<=', $end_date)->sum('total');
                	$total_price += $sold_price;

                    $sold_qty = DB::table('product_sales')->where('product_id', $pro_id)
                    ->whereDate('created_at','>=', $start_date)->whereDate('created_at','<=', $end_date)->sum('qty');
                	$total_sold_qty += $sold_qty;
                    if($purchased_qty > 0)
                        $profit = $sold_price - (($purchased_cost / $purchased_qty) * $sold_qty);
                    else
                       $profit =  $sold_price;
                    $total_profit += $profit;
                ?>
                <td>{{$purchased_cost}}</td>
                <td>{{$purchased_qty}}</td>
                <td>{{$sold_price}}</td>
                <td>{{$sold_qty}}</td>
                <td>{{number_format((float)$profit, 2, '.', '')}}</td>
                <td>{{$product_qty[$key]}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
        <tfoot>
            <th></th>
        	<th>Total</th>
        	<th>0.00</th>
            <th>0.00</th>
        	<th>0.00</th>
            <th>0.00</th>
        	<th>0.00</th>
        	<th>0.00</th>
        </tfoot>
    </table>
</section>

<script type="text/javascript">

    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(2).addClass("active");

    $('#report-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': 0
            },
            {
                'checkboxes': {
                   'selectRow': true
                },
                'targets': 0
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            }
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 2 ).footer() ).html(dt_selector.cells( rows, 2, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 3 ).footer() ).html(dt_selector.cells( rows, 3, { page: 'current' } ).data().sum());
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum());
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum());
        }
        else {
            $( dt_selector.column( 2 ).footer() ).html(dt_selector.column( 2, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 3 ).footer() ).html(dt_selector.column( 3, {page:'current'} ).data().sum());
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.column( 4, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.column( 5, {page:'current'} ).data().sum());
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.column( 6, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.column( 7, {page:'current'} ).data().sum());
        }
    }

$(".daterangepicker-field").daterangepicker({
  callback: function(startDate, endDate, period){
    var start_date = startDate.format('YYYY-MM-DD');
    var end_date = endDate.format('YYYY-MM-DD');
    var title = start_date + ' to ' + end_date;
    $(this).val(title);
    $('input[name="start_date"]').val(start_date);
    $('input[name="end_date"]').val(end_date);
  }
});

</script>
@endsection