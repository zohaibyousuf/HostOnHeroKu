 <?php $__env->startSection('content'); ?>
<?php if(session()->has('message')): ?>
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message1')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message1')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<section>
    <div class="container-fluid">
        <div class="input-group">
            <br>
          <?php if(in_array("returns-add", $all_permission)): ?>
          <div class="input-group-prepend">
                <a href="<?php echo e(route('returns.create')); ?>" class="btn btn-info"><i class="fa fa-plus"></i> <?php echo e(trans('file.Add')); ?> <?php echo e(trans('file.Return')); ?></a>
          </div>
          <?php endif; ?>  
        </div>
    </div>
    <table id="return-table" class="table table-hover return-list">
        <thead>
            <tr>
                <th class="not-exported"></th>
                <th><?php echo e(trans('file.Date')); ?></th>
                <th><?php echo e(trans('file.Reference')); ?> No</th>
                <th><?php echo e(trans('file.Customer')); ?></th>
                <th><?php echo e(trans('file.Items')); ?></th>
                <th><?php echo e(trans('file.Total')); ?> Qty</th>
                <th><?php echo e(trans('file.Grand Total')); ?></th>
                <th class="not-exported">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $lsms_return_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
            <tr class="return-link" data-return='["<?php echo e($return->created_at->toDateString()); ?>", "<?php echo e($return->reference_no); ?>", "<?php echo e($user->name); ?>", "<?php echo e(@$user->company_name); ?>", "<?php echo e($user->email); ?>", "<?php echo e($user->phone); ?>", "<?php echo e($customer->name); ?>", "<?php echo e($customer->phone); ?>", "<?php echo e($return->id); ?>", "<?php echo e($return->total_qty); ?>", "<?php echo e($return->total_price); ?>", "<?php echo e($return->grand_total); ?>", "<?php echo e($return->note); ?>"]'>
                <td><?php echo e($key); ?></td>
                <td><?php echo e($return->created_at->toDateString() . ' '. $return->created_at->toTimeString()); ?></td>
                <td><?php echo e($return->reference_no); ?></td>
                <?php $customer = DB::table('customers')->find($return->customer_id); ?>
                <td><?php echo e($customer->name); ?></td>
                <td><?php echo e($return->item); ?></td>
                <td><?php echo e($return->total_qty); ?></td>
                <td><?php echo e($return->grand_total); ?></td>
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
                            <?php if(in_array("returns-edit", $all_permission)): ?>
                            <li>
                                <a class="btn btn-link" href="<?php echo e(route('returns.edit', ['id' => $return->id])); ?>"><i class="fa fa-edit"></i> <?php echo e(trans('file.Edit')); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array("returns-delete", $all_permission)): ?>
                            <li>
                            <?php echo e(Form::open(['route' => ['returns.destroy', $return->id], 'method' => 'DELETE'] )); ?>

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
            <th></th>
            <th></th>
        </tfoot>
    </table>

    <div id="return-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Return')); ?> <?php echo e(trans('file.Details')); ?> &nbsp;&nbsp;</h5>
              <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="fa fa-print"></i> <?php echo e(trans('file.Print')); ?></button>
              <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
                <div id="return-content" class="modal-body"></div>
                <br>
                <table class="table table-bordered product-return-list">
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
          newWin.document.write('<style type="text/css">@media  print { #print-btn { display: none } #close-btn { display: none } }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

    function returnDetails(returns){
        var htmltext = '<strong><?php echo e(trans("file.Date")); ?>: </strong>'+returns[0]+'<br><strong><?php echo e(trans("file.Reference")); ?>: </strong>'+returns[1]+'<br><br><div class="row"><div class="col-md-6"><strong><?php echo e(trans("file.From")); ?>:</strong><br>'+returns[2]+'<br>'+returns[3]+'<br>'+returns[4]+'<br>'+returns[5]+'</div><div class="col-md-6"><strong><?php echo e(trans("file.To")); ?>:</strong><br>'+returns[6]+'<br>'+returns[7]+'</div></div>';
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
            cols += '<td colspan=2><strong><?php echo e(trans("file.Total")); ?>:</strong></td>';
            cols += '<td>' + returns[9] + '</td>';
            cols += '<td></td>';
            cols += '<td>' + returns[10] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong><?php echo e(trans("file.Grand Total")); ?>:</strong></td>';
            cols += '<td>' + returns[11] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

             $("table.product-return-list").append(newBody);
        });

        var htmlfooter = '<p><strong><?php echo e(trans("file.Note")); ?>:</strong> '+returns[12]+'</p><strong><?php echo e(trans("file.Created By")); ?>:</strong><br>'+returns[2]+'<br>'+returns[4];

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>