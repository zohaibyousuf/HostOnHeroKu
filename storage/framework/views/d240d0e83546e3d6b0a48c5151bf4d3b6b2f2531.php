 <?php $__env->startSection('content'); ?>
<?php if(session()->has('message1')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message1')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message2')): ?>
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message2')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message3')): ?>
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message3')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message4')): ?>
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message4')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message5')): ?>
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message5')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<section>
    <div class="container-fluid">
        <?php if(in_array("sales-add", $all_permission)): ?>
        <a href="<?php echo e(route('sales.create')); ?>" class="btn btn-info"><i class="fa fa-plus"></i> <?php echo e(trans('file.Add')); ?> <?php echo e(trans('file.Sale')); ?></a>
        &nbsp;
        <a href="<?php echo e(url('sales/sale_by_csv')); ?>" class="btn btn-primary"><i class="fa fa-file"></i> <?php echo e(trans('file.Import')); ?> <?php echo e(trans('file.Sale')); ?></a>
        <?php endif; ?>
    </div>
    <table id="sale-table" class="table table-hover sale-list">
        <thead>
            <tr>
                <th class="not-exported"></th>
                <th><?php echo e(trans('file.Date')); ?></th>
                <th><?php echo e(trans('file.Invoice')); ?> No</th>
                <th><?php echo e(trans('file.Customer')); ?></th>
                <th><?php echo e(trans('file.Items')); ?></th>
                <th><?php echo e(trans('file.Quantity')); ?></th>
                <th><?php echo e(trans('file.Grand Total')); ?></th>
                <th><?php echo e(trans('file.Paid')); ?> <?php echo e(trans('file.Amount')); ?></th>
                <th><?php echo e(trans('file.Due')); ?> <?php echo e(trans('file.Amount')); ?></th>
                <th><?php echo e(trans('file.Payment')); ?> <?php echo e(trans('file.Status')); ?></th>
                <th class="not-exported"><?php echo e(trans('file.Action')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $lsms_sale_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
            <tr class="sale-link" data-sale='["<?php echo e($sale->created_at->toDateString()); ?>", "<?php echo e($sale->reference_no); ?>", "<?php echo e($sale->payment_status); ?>", "<?php echo e($user->name); ?>", "<?php echo e(@$user->company_name); ?>", "<?php echo e($user->email); ?>", "<?php echo e($user->phone); ?>", "<?php echo e($customer->name); ?>", "<?php echo e($customer->phone); ?>", "<?php echo e($sale->id); ?>", "<?php echo e($sale->total_qty); ?>", "<?php echo e($sale->total_price); ?>", "<?php echo e($sale->grand_total); ?>", "<?php echo e($sale->paid_amount); ?>", "<?php echo e($sale->note); ?>"]'>
                <td><?php echo e($key); ?></td>
                <td><?php echo e($sale->created_at->toDateString() . ' '. $sale->created_at->toTimeString()); ?></td>
                <td><?php echo e($sale->reference_no); ?></td>
                <?php if($sale->customer_id): ?>
                <?php $customer = DB::table('customers')->find($sale->customer_id); ?>
                <td><?php echo e($customer->name); ?></td>
                <?php else: ?>
                <td>N/A</td>
                <?php endif; ?>
                <td><?php echo e($sale->item); ?></td>
                <td><?php echo e($sale->total_qty); ?></td>
                <td class="grand-total"><?php echo e($sale->grand_total); ?></td>
                <?php if($sale->paid_amount): ?>
                <td class="paid-amount"><?php echo e($sale->paid_amount); ?></td>
                <?php else: ?>
                <td class="paid-amount">0</td>
                <?php endif; ?>
                <td class="due-amount"><?php echo e($sale->grand_total - $sale->paid_amount); ?></td>
                <?php if($sale->payment_status == 'Due'): ?>
                <td><div class="badge badge-danger"><?php echo e($sale->payment_status); ?></div></td>
                <?php else: ?>
                <td><div class="badge badge-success"><?php echo e($sale->payment_status); ?></div></td>
                <?php endif; ?>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(trans('file.Action')); ?> 
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                            <li>
                                <a class="btn btn-link view" href="#"><i class="fa fa-eye"></i> <?php echo e(trans('file.View')); ?></a>
                            </li>
                            <?php if(in_array("sales-edit", $all_permission)): ?>
                            <li>
                                <a class="btn btn-link" href="<?php echo e(route('sales.edit', ['id' => $sale->id])); ?>"><i class="fa fa-edit"></i>  <?php echo e(trans('file.Edit')); ?></a>
                            </li>
                            <?php endif; ?>
                            <li>
                                <a class="btn btn-link" href="<?php echo e(route('sales.show', ['id' => $sale->id])); ?>"><i class="fa fa-copy"></i>  <?php echo e(trans('file.Generate')); ?> <?php echo e(trans('file.Invoice')); ?></a>
                            </li>
                            <li>
                                <button type="button" class="get-payment btn btn-link" data-id = "<?php echo e($sale->id); ?>"><i class="fa fa-money"></i> <?php echo e(trans('file.View')); ?> <?php echo e(trans('file.Payment')); ?></button>
                            </li>
                            <li>
                                <button type="button" class="add-payment btn btn-link" data-id = "<?php echo e($sale->id); ?>" data-toggle="modal" data-target="#add-payment"><i class="fa fa-plus"></i> <?php echo e(trans('file.Add')); ?> <?php echo e(trans('file.Payment')); ?></button>
                            </li>
                            <?php if(in_array("sales-delete", $all_permission)): ?>
                            <li>
                            <?php echo e(Form::open(['route' => ['sales.destroy', $sale->id], 'method' => 'DELETE'] )); ?>

                                <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> <?php echo e(trans('file.Delete')); ?></button>
                            <?php echo e(Form::close()); ?>

                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot class="tfoot active">
            <th></th>
            <th><?php echo e(trans('file.Total')); ?>:</th>
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
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.All')); ?> <?php echo e(trans('file.Payment')); ?></h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover payment-list">
                        <thead>
                            <tr>
                                <th><?php echo e(trans('file.Date')); ?></th>
                                <th><?php echo e(trans('file.Reference')); ?> No</th>
                                <th><?php echo e(trans('file.Amount')); ?></th>
                                <th><?php echo e(trans('file.Payment')); ?> <?php echo e(trans('file.Method')); ?></th>
                                <th><?php echo e(trans('file.Action')); ?></th>
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
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Add')); ?> <?php echo e(trans('file.Payment')); ?></h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <?php echo Form::open(['route' => 'sale.add-payment', 'method' => 'post', 'files' => true, 'class' => 'payment-form' ]); ?>


                        <div class="form-group">
                            <label><strong><?php echo e(trans('file.Amount')); ?></strong></label>
                            <input type="number" name="amount" class="form-control" required />
                        </div>

                        <div class="form-group">
                            <label><strong><?php echo e(trans('file.Payment')); ?> <?php echo e(trans('file.Method')); ?></strong></label>
                            <select name="paid_by_id" class="form-control">
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>

                        <div id="cheque">
                            <div class="form-group">
                                <label><strong><?php echo e(trans('file.Cheque')); ?> No</strong></label>
                                <input type="text" name="cheque_no" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label><strong><?php echo e(trans('file.Cheque')); ?> <?php echo e(trans('file.Date')); ?></strong></label>
                                <input type="text" name="cheque_date" class="form-control" id="cheque-date" />
                            </div>
                        </div>

                        <input type="hidden" name="sale_id">

                        <button type="submit" class="btn btn-primary"><?php echo e(trans('file.Submit')); ?></button>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>

    <div id="edit-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Update')); ?> <?php echo e(trans('file.Payment')); ?></h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <?php echo Form::open(['route' => 'sale.update-payment', 'method' => 'post', 'class' => 'payment-form' ]); ?>


                        <div class="form-group">
                            <label><strong><?php echo e(trans('file.Amount')); ?></strong></label>
                            <input type="number" name="edit_amount" class="form-control" required />
                        </div>

                        <div class="form-group">
                            <label><strong><?php echo e(trans('file.Payment')); ?> <?php echo e(trans('file.Method')); ?></strong></label>
                            <select name="edit_paid_by_id" class="form-control">
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>
                        <div id="edit-cheque">
                            <div class="form-group">
                                <label><strong><?php echo e(trans('file.Cheque')); ?> No</strong></label>
                                <input type="text" name="edit_cheque_no" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label><strong><?php echo e(trans('file.Cheque')); ?> <?php echo e(trans('file.Date')); ?></strong></label>
                                <input type="text" name="edit_cheque_date" class="form-control" id="edit-cheque-date" />
                            </div>
                        </div>

                        <input type="hidden" name="payment_id">

                        <button type="submit" class="btn btn-primary"><?php echo e(trans('file.Update')); ?></button>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>

    <div id="sale-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Sale')); ?> <?php echo e(trans('file.Details')); ?> &nbsp;&nbsp;</h5>
              <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="fa fa-print"></i> <?php echo e(trans('file.Print')); ?></button>
              <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
                <div id="sale-content" class="modal-body"></div>
                <br>
                <table class="table table-bordered product-sale-list">
                    <thead>
                        <th>#</th>
                        <th><?php echo e(trans('file.Product')); ?></th>
                        <th>Qty</th>
                        <th><?php echo e(trans('file.Cost')); ?></th>
                        <th><?php echo e(trans('file.SubTotal')); ?></th>
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
          newWin.document.write('<style type="text/css">@media  print { #print-btn { display: none } #close-btn { display: none } }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

    function saleDetails(sale){
        var htmltext = '<strong><?php echo e(trans("file.Date")); ?>: </strong>'+sale[0]+'<br><strong><?php echo e(trans("file.Reference")); ?>: </strong>'+sale[1]+'<br><strong><?php echo e(trans("file.Payment")); ?> <?php echo e(trans("file.Status")); ?>: </strong>'+sale[2]+'<br><br><div class="row"><div class="col-md-6"><strong><?php echo e(trans("file.From")); ?>:</strong><br>'+sale[3]+'<br>'+sale[4]+'<br>'+sale[5]+'<br>'+sale[6]+'</div><div class="col-md-6"><strong><?php echo e(trans("file.To")); ?>:</strong><br>'+sale[7]+'<br>'+sale[8]+'</div></div>';
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
            cols += '<td colspan=2><strong><?php echo e(trans("file.Total")); ?>:</strong></td>';
            cols += '<td>' + sale[10] + '</td>';
            cols += '<td></td>';
            cols += '<td>' + sale[11] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong><?php echo e(trans("file.Grand Total")); ?>:</strong></td>';
            cols += '<td>' + sale[12] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong><?php echo e(trans("file.Paid")); ?>:</strong></td>';
            cols += '<td>' + sale[13] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong><?php echo e(trans("file.Balance")); ?>:</strong></td>';
            cols += '<td>' + (sale[12] - sale[13]) + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

             $("table.product-sale-list").append(newBody);
        });

        var htmlfooter = '<p><strong><?php echo e(trans("file.Note")); ?>:</strong> '+sale[14]+'</p><strong><?php echo e(trans("file.Created By")); ?>:</strong><br>'+sale[3]+'<br>'+sale[5];

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
                cols += '<td><div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu edit-options dropdown-default pull-right" user="menu"><li><button type="button" class="btn btn-link edit-btn" data-id="' + payment_id[index] +'" data-clicked=false data-toggle="modal" data-target="#edit-payment"><i class="fa fa-edit"></i> Edit</button></li><li class="divider"></li><?php echo e(Form::open(['route' => 'sale.delete-payment', 'method' => 'post'] )); ?><li><input type="hidden" name="id" value="' + payment_id[index] + '" /> <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> Delete</button></li><?php echo e(Form::close()); ?></ul></div></td>'
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>