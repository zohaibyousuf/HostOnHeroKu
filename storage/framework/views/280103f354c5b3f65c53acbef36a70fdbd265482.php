 <?php $__env->startSection('content'); ?>
<?php if(session()->has('message')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message3')): ?>
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message3')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message4')): ?>
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message4')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<section>
    <div class="container-fluid">
        <?php if(in_array("purchases-add", $all_permission)): ?>
        <a href="<?php echo e(route('purchases.create')); ?>" class="btn btn-info"><i class="fa fa-plus"></i> <?php echo e(trans('file.Add')); ?> <?php echo e(trans('file.Purchase')); ?></a>
        &nbsp;
        <a href="<?php echo e(url('purchases/purchase_by_csv')); ?>" class="btn btn-primary"><i class="fa fa-file"></i> <?php echo e(trans('file.Import')); ?> <?php echo e(trans('file.Purchase')); ?></a>
        <?php endif; ?>
    </div>
    <table id="purchase-table" class="table table-hover purchase-list">
        <thead>
            <tr>
                <th class="not-exported"></th>
                <th><?php echo e(trans('file.Date')); ?></th>
                <th><?php echo e(trans('file.Reference')); ?> No</th>
                <th><?php echo e(trans('file.Supplier')); ?></th>
                <th><?php echo e(trans('file.Items')); ?></th>
                <th><?php echo e(trans('file.Quantity')); ?> </th>
                <th><?php echo e(trans('file.Product')); ?> <?php echo e(trans('file.Cost')); ?></th>
                <th><?php echo e(trans('file.Shipping Cost')); ?></th>
                <th><?php echo e(trans('file.Grand Total')); ?></th>
                <th class="not-exported"><?php echo e(trans('file.Action')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $lsms_purchase_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php 
                $user = DB::table('users')->find($purchase->user_id);
                $replace = Array(
                        '\\' => '',
                        '"' => '\"'
                    );

                $purchase->note = str_replace(array_keys($replace), $replace, $purchase->note);

                $purchase->note = preg_replace('/\r\n+/', "<br>", $purchase->note);
            ?>
            <tr class="purchase-link" data-purchase='["<?php echo e($purchase->created_at->toDateString()); ?>", "<?php echo e($purchase->reference_no); ?>", "<?php echo e($purchase->id); ?>", "<?php echo e($purchase->supplier); ?>", "<?php echo e($purchase->total_cost); ?>", "<?php echo e($purchase->shipping_cost); ?>", "<?php echo e($purchase->grand_total); ?>", "<?php echo e($purchase->note); ?>", "<?php echo e($user->name); ?>", "<?php echo e($user->email); ?>", "<?php echo e($purchase->total_qty); ?>"]'>
                <td><?php echo e($key); ?></td>
                <td><?php echo e($purchase->created_at->toDateString() . ' '. $purchase->created_at->toTimeString()); ?></td>
                <td><?php echo e($purchase->reference_no); ?></td>
                <?php if($purchase->supplier): ?>
                <td><?php echo e($purchase->supplier); ?></td>
                <?php else: ?>
                <td>N/A</td>
                <?php endif; ?>
                <td><?php echo e($purchase->item); ?></td>
                <td><?php echo e($purchase->total_qty); ?></td>
                <td class="product-cost"><?php echo e($purchase->total_cost); ?></td>
                <?php if($purchase->shipping_cost): ?>
                <td class="shipping-cost"><?php echo e($purchase->shipping_cost); ?></td>
                <?php else: ?>
                <td class="shipping-cost">0.00</td>
                <?php endif; ?>
                <td class="grand-total"><?php echo e($purchase->grand_total); ?></td>
                <td>
                    <div class="btn-group">
                        <a class="btn btn-success view" href="#" title="<?php echo e(trans('file.View')); ?>"><i class="fa fa-eye"></i></a>
                        <?php if(in_array("purchases-edit", $all_permission)): ?>
                        <a class="btn btn-primary" href="<?php echo e(route('purchases.edit', ['id' => $purchase->id])); ?>" title="<?php echo e(trans('file.Edit')); ?>"><i class="fa fa-edit"></i></a>
                        <?php endif; ?>
                        <?php if(in_array("purchases-delete", $all_permission)): ?>
                        <?php echo e(Form::open(['route' => ['purchases.destroy', $purchase->id], 'method' => 'DELETE'] )); ?>

                        <button type="submit" class="btn btn-danger" onclick="return confirmDelete()" title="<?php echo e(trans('file.Delete')); ?>">  <i class="fa fa-times"></i></button>
                        <?php echo e(Form::close()); ?>

                        <?php endif; ?>
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
            <th>0.00</th>
            <th>0.00</th>
            <th>0.00</th>
            <th></th>
        </tfoot>
    </table>

    <div id="purchase-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Purchase')); ?> <?php echo e(trans('file.Details')); ?> &nbsp;&nbsp;</h5>
              <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="fa fa-print"></i> <?php echo e(trans('file.Print')); ?></button>
              <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
                <div id="purchase-content" class="modal-body"></div>
                <br>
                <table class="table table-bordered product-purchase-list">
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
                <div id="purchase-footer" class="modal-body"></div>
          </div>
        </div>
    </div>

</section>

<script type="text/javascript">

    $("ul#purchase").siblings('a').attr('aria-expanded','true');
    $("ul#purchase").addClass("show");
    $("ul#purchase li").eq(0).addClass("active");

    $("tr.purchase-link td:not(:first-child, :last-child)").on("click", function(){
        var purchase = $(this).parent().data('purchase');
        purchaseDetails(purchase);
    });

    $(".view").on("click", function(){
        var purchase = $(this).parent().parent().parent().data('purchase');
        purchaseDetails(purchase);
    });

    $("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('purchase-details');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<style type="text/css">@media  print { #print-btn { display: none } #close-btn { display: none } }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

    function purchaseDetails(purchase){
        var htmltext = '<strong><?php echo e(trans("file.Date")); ?>: </strong>'+purchase[0]+'<br><strong><?php echo e(trans("file.Reference")); ?>: </strong>'+purchase[1]+'<br><strong><?php echo e(trans("file.Supplier")); ?>: </strong>'+purchase[3];
        $.get('purchases/product_purchase/' + purchase[2], function(data){
            $(".product-purchase-list tbody").remove();
            var name_code = data[0];
            var qty = data[1];
            var cost = data[2];
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
                cols += '<td>' + cost[index] + '</td>';
                cols += '<td>' + subtotal[index] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);
            });

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=2><strong><?php echo e(trans("file.Total")); ?>:</strong></td>';
            cols += '<td>' + purchase[10] + '</td>';
            cols += '<td></td>';
            cols += '<td>' + purchase[4] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong><?php echo e(trans("file.Shipping Cost")); ?>:</strong></td>';
            cols += '<td>' + purchase[5] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong><?php echo e(trans("file.Grand Total")); ?>:</strong></td>';
            cols += '<td>' + purchase[6] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

             $("table.product-purchase-list").append(newBody);
        });

        var htmlfooter = '<p><strong><?php echo e(trans("file.Note")); ?>:</strong> '+purchase[7]+'</p><strong><?php echo e(trans("file.Created By")); ?>:</strong><br>'+purchase[8]+'<br>'+purchase[9];

        $('#purchase-content').html(htmltext);
        $('#purchase-footer').html(htmlfooter);
        $('#purchase-details').modal('show');
    }

    $('#purchase-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 9]
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
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.column( 6, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.column( 7, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 8 ).footer() ).html(dt_selector.cells( rows, 8, { page: 'current' } ).data().sum().toFixed(2));
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