@extends('layout.main') @section('content')

<section>
    {!! Form::open(['route' => 'report.dueByDate', 'method' => 'post']) !!}
    <div class="col-md-6 offset-md-3">
        <div class="form-group row">
            <label><strong>{{trans('file.Choose Your Date')}}</strong></label>
            <div class="input-group">
                <input type="text" class="daterangepicker-field form-control" />
                <input type="hidden" name="start_date" />
                <input type="hidden" name="end_date" />
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
                <th>{{trans('file.Invoice')}} No</th>
                <th>{{trans('file.Date')}}</th>
                <th>{{trans('file.Customer')}} {{trans('file.Details')}}</th>
                <th>{{trans('file.Paid')}}</th>
                <th>{{trans('file.Due')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lsms_sale_data as $key=>$sale_data)
            <tr>
                <td>{{$key}}</td>
                <td>{{$sale_data->reference_no}}</td>
                <td>{{$sale_data->created_at->toDateString() . ' '. $sale_data->created_at->toTimeString()}}</td>
                <?php
                    $customer = DB::table('customers')->find($sale_data->customer_id);
                ?>
                <td>{{$customer->name .' (' .$customer->phone . ')'}}</td>
                <td>{{$sale_data->paid_amount}}</td>
                <td>{{$sale_data->grand_total - $sale_data->paid_amount}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="tfoot active">
            <th></th>
            <th>{{trans('file.Total')}}:</th>
            <th></th>
            <th></th>
            <th>0.00</th>
            <th>0.00</th>
        </tfoot>
    </table>
</section>

<script type="text/javascript">

    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(7).addClass("active");

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
                    columns: ':visible:Not(.not-exported)',
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
                    columns: ':visible:Not(.not-exported)',
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
                    columns: ':visible:Not(.not-exported)',
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

            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.column( 4, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.column( 5, {page:'current'} ).data().sum().toFixed(2));
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