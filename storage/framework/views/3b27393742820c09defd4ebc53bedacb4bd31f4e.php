 <?php $__env->startSection('content'); ?>
<section>
    <h3 class="text-center"><?php echo e(trans('file.Customer')); ?> <?php echo e(trans('file.Report')); ?></h3>
    <?php echo Form::open(['route' => 'report.customerByDate', 'method' => 'post']); ?>

    <div class="row">
        <div class="col-md-4 offset-md-2 mt-4">
            <div class="form-group row">
                <label class="d-tc mt-2"><strong><?php echo e(trans('file.Choose Your Date')); ?></strong> &nbsp;</label>
                <div class="d-tc">
                    <div class="input-group">
                        <input type="text" class="daterangepicker-field form-control" value="<?php echo e($start_date); ?> to <?php echo e($end_date); ?>" required />
                        <input type="hidden" name="start_date" value="<?php echo e($start_date); ?>" />
                        <input type="hidden" name="end_date" value="<?php echo e($end_date); ?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="form-group row">
                <label class="d-tc mt-2"><strong><?php echo e(trans('file.Customer')); ?></strong> &nbsp;</label>
                <div class="d-tc">
                    <input type="hidden" name="customer_id_hidden" value="<?php echo e($customer_id); ?>" />
                    <select id="customer_id" name="customer_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                        <?php $__currentLoopData = $lsms_customer_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customer->id); ?>"><?php echo e($customer->name); ?> (<?php echo e($customer->phone); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-2 mt-4">
            <div class="form-group">
                <button class="btn btn-primary" type="submit"><?php echo e(trans('file.Submit')); ?></button>
            </div>
        </div>
    </div>
    <input type="hidden" name="customer_id_hidden" value="<?php echo e($customer_id); ?>" />
    <?php echo Form::close(); ?>


    <ul class="nav nav-tabs ml-4" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" href="#customer-sale" role="tab" data-toggle="tab"><?php echo e(trans('file.Sale')); ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#customer-payments" role="tab" data-toggle="tab"><?php echo e(trans('file.Payment')); ?></a>
      </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade show active" id="customer-sale">
            <div class="table-responsive">
                <table id="sale-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th class="not-exported-sale"></th>
                            <th><?php echo e(trans('file.Date')); ?></th>
                            <th><?php echo e(trans('file.Reference')); ?> No</th>
                            <th><?php echo e(trans('file.Product')); ?> (<?php echo e(trans('file.Qty')); ?>)</th>
                            <th><?php echo e(trans('file.Grand Total')); ?></th>
                            <th><?php echo e(trans('file.Paid')); ?></th>
                            <th><?php echo e(trans('file.Due')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $lsms_sale_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key); ?></td>
                            <td><?php echo e($sale->created_at->toDateString() . ' '. $sale->created_at->toTimeString()); ?></td>
                            <td><?php echo e($sale->reference_no); ?></td>
                            <td>
                                <?php $__currentLoopData = $lsms_product_sale_data[$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_sale_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $product = App\Product::find($product_sale_data->product_id);
                                ?>
                                <?php if($product_sale_data->unit): ?>
                                    <?php echo e($product->name.' ('.$product_sale_data->qty.' '.$product_sale_data->unit.')'); ?>

                                <?php else: ?>
                                    <?php echo e($product->name.' ('.$product_sale_data->qty.')'); ?>

                                <?php endif; ?>
                                <br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td><?php echo e($sale->grand_total); ?></td>
                            <td><?php echo e($sale->paid_amount); ?></td>
                            <td><?php echo e(number_format((float)($sale->grand_total - $sale->paid_amount), 2, '.', '')); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="tfoot active">
                        <tr>
                            <th></th>
                            <th>Total:</th>
                            <th></th>
                            <th></th>
                            <th>0.00</th>
                            <th>0.00</th>
                            <th>0.00</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane fade" id="customer-payments">
            <div class="table-responsive">
                <table id="payment-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th class="not-exported-payment"></th>
                            <th><?php echo e(trans('file.Date')); ?></th>
                            <th><?php echo e(trans('file.Payment')); ?> <?php echo e(trans('file.Reference')); ?></th>
                            <th><?php echo e(trans('file.Sale')); ?> <?php echo e(trans('file.Reference')); ?></th>
                            <th><?php echo e(trans('file.Amount')); ?></th>
                            <th><?php echo e(trans('file.Paid')); ?> <?php echo e(trans('file.Method')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $lsms_payment_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key); ?></td>
                            <td><?php echo e($payment->created_at); ?></td>
                            <td><?php echo e($payment->reference_no); ?></td>
                            <td><?php echo e($payment->sale_reference); ?></td>
                            <td><?php echo e($payment->amount); ?></td>
                            <td><?php echo e($payment->payment_method); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="tfoot active">
                        <tr>
                            <th></th>
                            <th>Total:</th>
                            <th></th>
                            <th></th>
                            <th>0.00</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
</section>

<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(6).addClass("active");

    $('#customer_id').val($('input[name="customer_id_hidden"]').val());
    $('.selectpicker').selectpicker('refresh');

    $('#sale-table').DataTable( {
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
                    columns: ':visible:Not(.not-exported-sale)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_sale(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_sale(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-sale)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_sale(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_sale(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-sale)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_sale(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum_sale(dt, false);
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
            datatable_sum_sale(api, false);
        }
    } );

    function datatable_sum_sale(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.column( 5, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.column( 6, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

    $('#payment-table').DataTable( {
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
                    columns: ':visible:Not(.not-exported-payment)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_payment(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_payment(dt, false);
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
                    datatable_sum_payment(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_payment(dt, false);
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
                    datatable_sum_payment(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum_payment(dt, false);
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
            datatable_sum_payment(api, false);
        }
    } );

    function datatable_sum_payment(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.column( 4, {page:'current'} ).data().sum().toFixed(2));
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>