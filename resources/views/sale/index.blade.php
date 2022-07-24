@extends('layout.main') @section('content')
@if(session()->has('message1'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message1') }}</div> 
@endif
@if(session()->has('message2'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message2') }}</div> 
@endif
@if(session()->has('message3'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message3') }}</div> 
@endif
@if(session()->has('message4'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message4') }}</div> 
@endif
@if(session()->has('message5'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message5') }}</div> 
@endif
@if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section>
    <div class="container-fluid">
        @if(in_array("sales-add", $all_permission))
        <a href="{{route('sales.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> {{trans('file.Add')}} {{trans('file.Sale')}}</a>
        &nbsp;
        <a href="{{url('sales/sale_by_csv')}}" class="btn btn-primary"><i class="fa fa-file"></i> {{trans('file.Import')}} {{trans('file.Sale')}}</a>
        @endif
    </div>
    <table id="sale-table" class="table table-hover sale-list">
        <thead>
            <tr>
                <th class="not-exported"></th>
                <th>{{trans('file.Date')}}</th>
                <th>{{trans('file.Invoice')}} No</th>
                <th>{{trans('file.Customer')}}</th>
                <th>{{trans('file.Items')}}</th>
                <th>{{trans('file.Quantity')}}</th>
                <th>{{trans('file.Grand Total')}}</th>
                <th>{{trans('file.Paid')}} {{trans('file.Amount')}}</th>
                <th>{{trans('file.Due')}} {{trans('file.Amount')}}</th>
                <th>{{trans('file.Payment')}} {{trans('file.Status')}}</th>
                <th class="not-exported">{{trans('file.Action')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lsms_sale_all as $key=>$sale)
            <?php 
                $user = DB::table('users')->find($sale->user_id);
                $customer = DB::table('customers')->find($sale->customer_id);
                $replace = Array(
                        '\\' => '',
                        '"' => '\"'
                    );

                $sale->note = str_replace(array_keys($replace), $replace, $sale->note);

                $sale->note = preg_replace('/\r\n+/', "<br>", $sale->note);
            ?>
            <tr class="sale-link" data-sale='["{{$sale->created_at->toDateString()}}", "{{$sale->reference_no}}", "{{$sale->payment_status}}", "{{$user->name}}", "{{@$user->company_name}}", "{{$user->email}}", "{{$user->phone}}", "{{$customer->name}}", "{{$customer->phone}}", "{{$sale->id}}", "{{$sale->total_qty}}", "{{$sale->total_price}}", "{{$sale->grand_total}}", "{{$sale->paid_amount}}", "{{$sale->note}}"]'>
                <td>{{$key}}</td>
                <td>{{ $sale->created_at->toDateString() . ' '. $sale->created_at->toTimeString() }}</td>
                <td>{{ $sale->reference_no }}</td>
                @if($sale->customer_id)
                <?php $customer = DB::table('customers')->find($sale->customer_id); ?>
                <td>{{ $customer->name }}</td>
                @else
                <td>N/A</td>
                @endif
                <td>{{$sale->item}}</td>
                <td>{{$sale->total_qty}}</td>
                <td class="grand-total">{{ $sale->grand_total }}</td>
                @if($sale->paid_amount)
                <td class="paid-amount">{{$sale->paid_amount}}</td>
                @else
                <td class="paid-amount">0</td>
                @endif
                <td class="due-amount">{{$sale->grand_total - $sale->paid_amount}}</td>
                @if($sale->payment_status == 'Due')
                <td><div class="badge badge-danger">{{ $sale->payment_status }}</div></td>
                @else
                <td><div class="badge badge-success">{{ $sale->payment_status }}</div></td>
                @endif
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
                            @if(in_array("sales-edit", $all_permission))
                            <li>
                                <a class="btn btn-link" href="{{ route('sales.edit', ['id' => $sale->id]) }}"><i class="fa fa-edit"></i>  {{trans('file.Edit')}}</a>
                            </li>
                            @endif
                            <li>
                                <a class="btn btn-link" href="{{ route('sales.show', ['id' => $sale->id]) }}"><i class="fa fa-copy"></i>  {{trans('file.Generate')}} {{trans('file.Invoice')}}</a>
                            </li>
                            <li>
                                <button type="button" class="get-payment btn btn-link" data-id = "{{$sale->id}}"><i class="fa fa-money"></i> {{trans('file.View')}} {{trans('file.Payment')}}</button>
                            </li>
                            <li>
                                <button type="button" class="add-payment btn btn-link" data-id = "{{$sale->id}}" data-toggle="modal" data-target="#add-payment"><i class="fa fa-plus"></i> {{trans('file.Add')}} {{trans('file.Payment')}}</button>
                            </li>
                            @if(in_array("sales-delete", $all_permission))
                            <li>
                            {{ Form::open(['route' => ['sales.destroy', $sale->id], 'method' => 'DELETE'] ) }}
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
            <th id="grand-total">0.00</th>
            <th id="paid-amount">0.00</th>
            <th id="due-amount">0.00</th>
            <th></th>
            <th></th>
        </tfoot>
    </table>

    <div id="view-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{trans('file.All')}} {{trans('file.Payment')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover payment-list">
                        <thead>
                            <tr>
                                <th>{{trans('file.Date')}}</th>
                                <th>{{trans('file.Reference')}} No</th>
                                <th>{{trans('file.Amount')}}</th>
                                <th>{{trans('file.Payment')}} {{trans('file.Method')}}</th>
                                <th>{{trans('file.Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="add-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Add')}} {{trans('file.Payment')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'sale.add-payment', 'method' => 'post', 'files' => true, 'class' => 'payment-form' ]) !!}

                        <div class="form-group">
                            <label><strong>{{trans('file.Amount')}}</strong></label>
                            <input type="number" name="amount" class="form-control" required />
                        </div>

                        <div class="form-group">
                            <label><strong>{{trans('file.Payment')}} {{trans('file.Method')}}</strong></label>
                            <select name="paid_by_id" class="form-control">
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>

                        <div id="cheque">
                            <div class="form-group">
                                <label><strong>{{trans('file.Cheque')}} No</strong></label>
                                <input type="text" name="cheque_no" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label><strong>{{trans('file.Cheque')}} {{trans('file.Date')}}</strong></label>
                                <input type="text" name="cheque_date" class="form-control" id="cheque-date" />
                            </div>
                        </div>

                        <input type="hidden" name="sale_id">

                        <button type="submit" class="btn btn-primary">{{trans('file.Submit')}}</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div id="edit-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Update')}} {{trans('file.Payment')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'sale.update-payment', 'method' => 'post', 'class' => 'payment-form' ]) !!}

                        <div class="form-group">
                            <label><strong>{{trans('file.Amount')}}</strong></label>
                            <input type="number" name="edit_amount" class="form-control" required />
                        </div>

                        <div class="form-group">
                            <label><strong>{{trans('file.Payment')}} {{trans('file.Method')}}</strong></label>
                            <select name="edit_paid_by_id" class="form-control">
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>
                        <div id="edit-cheque">
                            <div class="form-group">
                                <label><strong>{{trans('file.Cheque')}} No</strong></label>
                                <input type="text" name="edit_cheque_no" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label><strong>{{trans('file.Cheque')}} {{trans('file.Date')}}</strong></label>
                                <input type="text" name="edit_cheque_date" class="form-control" id="edit-cheque-date" />
                            </div>
                        </div>

                        <input type="hidden" name="payment_id">

                        <button type="submit" class="btn btn-primary">{{trans('file.Update')}}</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div id="sale-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Sale')}} {{trans('file.Details')}} &nbsp;&nbsp;</h5>
              <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="fa fa-print"></i> {{trans('file.Print')}}</button>
              <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
                <div id="sale-content" class="modal-body"></div>
                <br>
                <table class="table table-bordered product-sale-list">
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
                <div id="sale-footer" class="modal-body"></div>
          </div>
        </div>
    </div>

</section>
<script type="text/javascript">

    $("ul#sale").siblings('a').attr('aria-expanded','true');
    $("ul#sale").addClass("show");
    $("ul#sale li").eq(0).addClass("active");

    $("tr.sale-link td:not(:first-child, :last-child)").on("click", function(){
        var sale = $(this).parent().data('sale');
        saleDetails(sale);
    });

    $(".view").on("click", function(){
        var sale = $(this).parent().parent().parent().parent().parent().data('sale');
        saleDetails(sale);
    });

    $("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('sale-details');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<style type="text/css">@media print { #print-btn { display: none } #close-btn { display: none } }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

    function saleDetails(sale){
        var htmltext = '<strong>{{trans("file.Date")}}: </strong>'+sale[0]+'<br><strong>{{trans("file.Reference")}}: </strong>'+sale[1]+'<br><strong>{{trans("file.Payment")}} {{trans("file.Status")}}: </strong>'+sale[2]+'<br><br><div class="row"><div class="col-md-6"><strong>{{trans("file.From")}}:</strong><br>'+sale[3]+'<br>'+sale[4]+'<br>'+sale[5]+'<br>'+sale[6]+'</div><div class="col-md-6"><strong>{{trans("file.To")}}:</strong><br>'+sale[7]+'<br>'+sale[8]+'</div></div>';
        $.get('sales/product_sale/' + sale[9], function(data){
            $(".product-sale-list tbody").remove();
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
            cols += '<td>' + sale[10] + '</td>';
            cols += '<td></td>';
            cols += '<td>' + sale[11] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Grand Total")}}:</strong></td>';
            cols += '<td>' + sale[12] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Paid")}}:</strong></td>';
            cols += '<td>' + sale[13] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Balance")}}:</strong></td>';
            cols += '<td>' + (sale[12] - sale[13]) + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

             $("table.product-sale-list").append(newBody);
        });

        var htmlfooter = '<p><strong>{{trans("file.Note")}}:</strong> '+sale[14]+'</p><strong>{{trans("file.Created By")}}:</strong><br>'+sale[3]+'<br>'+sale[5];

        $('#sale-content').html(htmltext);
        $('#sale-footer').html(htmlfooter);
        $('#sale-details').modal('show');
    }

    $('#sale-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 10]
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

            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 8 ).footer() ).html(dt_selector.cells( rows, 8, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 8 ).footer() ).html(dt_selector.cells( rows, 8, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

    $("#cheque").hide();
    $('#view-payment').modal('hide');

    var cheque_date = $('#cheque-date');
    cheque_date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
     });

    var edit_cheque_date = $('#edit-cheque-date');
    edit_cheque_date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
     });

    $("table.sale-list tbody").on("click", ".get-payment", function(event) {
        var id = $(this).data('id').toString();
        $.get('sales/getpayment/' + id, function(data) {
            $(".payment-list tbody").remove();
            var newBody = $("<tbody>");
            payment_date  = data[0];
            payment_reference = data[1];
            paid_amount = data[2];
            payment_method = data[3];
            payment_id = data[4];
            cheque_no = data[5];
            cheque_date = data[6];

            $.each(payment_date, function(index){
                var newRow = $("<tr>");
                var cols = '';

                cols += '<td>' + payment_date[index] + '</td>';
                cols += '<td>' + payment_reference[index] + '</td>';
                cols += '<td>' + paid_amount[index] + '</td>';
                cols += '<td>' + payment_method[index] + '</td>';
                cols += '<td><div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu edit-options dropdown-default pull-right" user="menu"><li><button type="button" class="btn btn-link edit-btn" data-id="' + payment_id[index] +'" data-clicked=false data-toggle="modal" data-target="#edit-payment"><i class="fa fa-edit"></i> Edit</button></li><li class="divider"></li>{{ Form::open(['route' => 'sale.delete-payment', 'method' => 'post'] ) }}<li><input type="hidden" name="id" value="' + payment_id[index] + '" /> <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> Delete</button></li>{{ Form::close() }}</ul></div></td>'
                newRow.append(cols);
                newBody.append(newRow);
                $("table.payment-list").append(newBody);
            });
            $('#view-payment').modal('show');
        });
    });

    $("table.sale-list tbody").on("click", ".add-payment", function(event) {
        $("#cheque").hide();
        $('select[name="paid_by_id"]').val('Cash');
        rowindex = $(this).closest('tr').index();
        var sale_id = $(this).data('id').toString();
        var balance = $('table.sale-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(8)').text();
        $('input[name="amount"]').val(balance);
        $('input[name="sale_id"]').val(sale_id);
    });

    $("table.payment-list").on("click", ".edit-btn", function(event) {
        $(".edit-btn").attr('data-clicked', true);        
        $("#edit-cheque").hide();
        var id = $(this).data('id').toString();
        $.each(payment_id, function(index){
            if(payment_id[index] == parseFloat(id)){
                $('input[name="payment_id"]').val(payment_id[index]);
                if(payment_method[index] == 'Cash')
                    $('select[name="edit_paid_by_id"]').val('Cash');
                else{
                    $('select[name="edit_paid_by_id"]').val('Cheque');
                    $("#edit-cheque").show();
                    $('input[name="edit_cheque_no"]').val(cheque_no[index]);
                    $('input[name="edit_cheque_date"]').val(cheque_date[index]);
                }
                $('input[name="edit_date"]').val(payment_date[index]);
                $('input[name="edit_payment_reference"]').val(payment_reference[index]);
                $('input[name="edit_amount"]').val(paid_amount[index]);
                return false;
            }
        });
        $('#view-payment').modal('hide');
    });

    $('select[name="paid_by_id"]').on("change", function() {        
        var payment_method = $('select[name="paid_by_id"]').val();
        if (payment_method == 'Cheque') {
            $("#cheque").show();
        } else {
            $("#cheque").hide();
        }
    });

    $('select[name="edit_paid_by_id"]').on("change", function() {        
        var payment_method = $('select[name="edit_paid_by_id"]').val();

        if (payment_method == 'Cheque') {
            $("#edit-cheque").show();
            $(".card-element").hide();
        } else {
            $(".card-element").hide();
            $("#edit-cheque").hide();
        }
    });

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }
</script>
@endsection