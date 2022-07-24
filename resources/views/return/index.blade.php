@extends('layout.main') @section('content')
@if(session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('message1'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message1') }}</div> 
@endif
@if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section>
    <div class="container-fluid">
        <div class="input-group">
            <br>
          @if(in_array("returns-add", $all_permission))
          <div class="input-group-prepend">
                <a href="{{route('returns.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> {{trans('file.Add')}} {{trans('file.Return')}}</a>
          </div>
          @endif  
        </div>
    </div>
    <table id="return-table" class="table table-hover return-list">
        <thead>
            <tr>
                <th class="not-exported"></th>
                <th>{{trans('file.Date')}}</th>
                <th>{{trans('file.Reference')}} No</th>
                <th>{{trans('file.Customer')}}</th>
                <th>{{trans('file.Items')}}</th>
                <th>{{trans('file.Total')}} Qty</th>
                <th>{{trans('file.Grand Total')}}</th>
                <th class="not-exported">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lsms_return_all as $key=>$return)
            <?php 
                $user = DB::table('users')->find($return->user_id);
                $customer = DB::table('customers')->find($return->customer_id);
                $replace = Array(
                        '\\' => '',
                        '"' => '\"'
                    );

                $return->note = str_replace(array_keys($replace), $replace, $return->note);

                $return->note = preg_replace('/\r\n+/', "<br>", $return->note);
            ?>
            <tr class="return-link" data-return='["{{$return->created_at->toDateString()}}", "{{$return->reference_no}}", "{{$user->name}}", "{{@$user->company_name}}", "{{$user->email}}", "{{$user->phone}}", "{{$customer->name}}", "{{$customer->phone}}", "{{$return->id}}", "{{$return->total_qty}}", "{{$return->total_price}}", "{{$return->grand_total}}", "{{$return->note}}"]'>
                <td>{{$key}}</td>
                <td>{{ $return->created_at->toDateString() . ' '. $return->created_at->toTimeString() }}</td>
                <td>{{ $return->reference_no }}</td>
                <?php $customer = DB::table('customers')->find($return->customer_id); ?>
                <td>{{ $customer->name }}</td>
                <td>{{$return->item}}</td>
                <td>{{$return->total_qty}}</td>
                <td>{{$return->grand_total}}</td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.Action')}} 
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                            <li>
                                <a class="btn btn-link view" href="#"><i class="fa fa-eye"></i> {{trans('file.View')}}</a>
                            </li>
                            @if(in_array("returns-edit", $all_permission))
                            <li>
                                <a class="btn btn-link" href="{{ route('returns.edit', ['id' => $return->id]) }}"><i class="fa fa-edit"></i> {{trans('file.Edit')}}</a>
                            </li>
                            @endif
                            @if(in_array("returns-delete", $all_permission))
                            <li>
                            {{ Form::open(['route' => ['returns.destroy', $return->id], 'method' => 'DELETE'] ) }}
                                <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> {{trans('file.Delete')}}</button>
                            {{ Form::close() }}
                            </li>
                            @endif
                        </ul>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="tfoot active">
            <th></th>
            <th>{{trans('file.Total')}}:</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tfoot>
    </table>

    <div id="return-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Return')}} {{trans('file.Details')}} &nbsp;&nbsp;</h5>
              <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="fa fa-print"></i> {{trans('file.Print')}}</button>
              <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
                <div id="return-content" class="modal-body"></div>
                <br>
                <table class="table table-bordered product-return-list">
                    <thead>
                        <th>#</th>
                        <th>{{trans('file.Product')}}</th>
                        <th>Qty</th>
                        <th>{{trans('file.Cost')}}</th>
                        <th>{{trans('file.SubTotal')}}</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div id="return-footer" class="modal-body"></div>
          </div>
        </div>
    </div>
</section>
<script type="text/javascript">

    $("ul#return").siblings('a').attr('aria-expanded','true');
    $("ul#return").addClass("show");
    $("ul#return li").eq(0).addClass("active");

    $("tr.return-link td:not(:first-child, :last-child)").on("click", function(){
        var returns = $(this).parent().data('return');
        returnDetails(returns);
    });

    $(".view").on("click", function(){
        var returns = $(this).parent().parent().parent().parent().parent().data('return');
        returnDetails(returns);
    });

    $("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('return-details');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<style type="text/css">@media print { #print-btn { display: none } #close-btn { display: none } }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

    function returnDetails(returns){
        var htmltext = '<strong>{{trans("file.Date")}}: </strong>'+returns[0]+'<br><strong>{{trans("file.Reference")}}: </strong>'+returns[1]+'<br><br><div class="row"><div class="col-md-6"><strong>{{trans("file.From")}}:</strong><br>'+returns[2]+'<br>'+returns[3]+'<br>'+returns[4]+'<br>'+returns[5]+'</div><div class="col-md-6"><strong>{{trans("file.To")}}:</strong><br>'+returns[6]+'<br>'+returns[7]+'</div></div>';
        $.get('returns/product_return/' + returns[8], function(data){
            $(".product-return-list tbody").remove();
            var name_code = data[0];
            var qty = data[1];
            var price = data[2];
            var subtotal = data[3];
            var unit = data[4];

            var newBody = $("<tbody>");
            $.each(name_code, function(index){
                var newRow = $("<tr>");
                var cols = '';
                cols += '<td><strong>' + (index+1) + '</strong></td>';
                cols += '<td>' + name_code[index] + '</td>';
                if(unit[index])
                    cols += '<td>' + qty[index] + ' ' + unit[index] + '</td>';
                else
                    cols += '<td>' + qty[index] + '</td>';
                cols += '<td>' + price[index] + '</td>';
                cols += '<td>' + subtotal[index] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);
            });

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=2><strong>{{trans("file.Total")}}:</strong></td>';
            cols += '<td>' + returns[9] + '</td>';
            cols += '<td></td>';
            cols += '<td>' + returns[10] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Grand Total")}}:</strong></td>';
            cols += '<td>' + returns[11] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

             $("table.product-return-list").append(newBody);
        });

        var htmlfooter = '<p><strong>{{trans("file.Note")}}:</strong> '+returns[12]+'</p><strong>{{trans("file.Created By")}}:</strong><br>'+returns[2]+'<br>'+returns[4];

        $('#return-content').html(htmltext);
        $('#return-footer').html(htmlfooter);
        $('#return-details').modal('show');
    }

    $('#return-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 7]
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
            },
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
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }
</script>
@endsection