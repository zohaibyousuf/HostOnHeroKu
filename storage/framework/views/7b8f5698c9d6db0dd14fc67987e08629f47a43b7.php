 <?php $__env->startSection('content'); ?>
<?php if(session()->has('message1')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message1')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message2')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message2')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message3')): ?>
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message3')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message4')): ?>
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message4')); ?></div> 
<?php endif; ?>
<?php if(session()->has('import_message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('import_message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<section>
    <div class="container-fluid">
        <div class="input-group">
            <div class="input-group-prepend">
                <?php if(in_array("customers-add", $all_permission)): ?>
                <a href="<?php echo e(route('customer.create')); ?>" class="btn btn-info"><i class="fa fa-plus"></i> <?php echo e(trans('file.Add')); ?> <?php echo e(trans('file.Customer')); ?></a>
                &nbsp;&nbsp;
                <a href="#" data-toggle="modal" data-target="#import-customer" class="btn btn-primary"> <i class="fa fa-file"></i> <?php echo e(trans('file.Import')); ?> <?php echo e(trans('file.Customer')); ?></a>
                <?php endif; ?>
            </div>    
        </div>
    </div>


    <table id="customer-table" class="table table-hover">
        <thead>
            <tr>
                <th class="not-exported"></th>
                <th><?php echo e(trans('file.Name')); ?></th>
                <th><?php echo e(trans('file.Company Name')); ?></th>
                <th><?php echo e(trans('file.Address')); ?></th>
                <th><?php echo e(trans('file.Phone Number')); ?></th>
                <th class="not-exported"><?php echo e(trans('file.Action')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $lsms_customer_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key); ?></td>
                <td><?php echo e($customer->name); ?></td>
                <?php if($customer->company_name): ?>
                <td><?php echo e($customer->company_name); ?></td>
                <?php else: ?>
                <td>N/A</td>
                <?php endif; ?>
                <?php if($customer->address): ?>
                <td><?php echo e($customer->address); ?></td>
                <?php else: ?>
                <td>N/A</td>
                <?php endif; ?>
                <td><?php echo e($customer->phone); ?></td>
                <td>
                    <div class="btn-group">
                        <?php if(in_array("customers-edit", $all_permission)): ?>
                        <a class="btn btn-primary" href="<?php echo e(route('customer.edit', ['id' => $customer->id])); ?>" title="<?php echo e(trans('file.Edit')); ?>"><i class="fa fa-edit"></i></a>
                        <?php endif; ?>
                        <?php if(in_array("customers-delete", $all_permission)): ?>
                        <?php echo e(Form::open(['route' => ['customer.destroy', $customer->id], 'method' => 'DELETE'] )); ?>

                        <button type="submit" class="btn btn-danger" onclick="return confirmDelete()" title="<?php echo e(trans('file.Delete')); ?>"> <i class="fa fa-times"></i></button>
                        <?php echo e(Form::close()); ?>

                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e(Form::close()); ?>

    <div id="import-customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <?php echo Form::open(['route' => 'customer.import', 'method' => 'post', 'files' => true]); ?>

            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Import')); ?> <?php echo e(trans('file.Customer')); ?></h5>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
               <p><?php echo e(trans('file.The correct column order is')); ?> (name, company, address, phone) <?php echo e(trans('file.and you must follow this')); ?>. <?php echo e(trans('file.All columns are required')); ?>.</p>
                <label><strong><?php echo e(trans('file.Upload CSV File')); ?> *</strong></label>
                <div class="form-group">
                    <?php echo e(Form::file('file', array('class' => 'form-control','required'))); ?>

                </div>
                <div class="form-group" id="operation_value"></div>
                <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
            </div>
            <?php echo Form::close(); ?>

          </div>
        </div>
    </div>
</section>
<script type="text/javascript">

    $("ul#customer").siblings('a').attr('aria-expanded','true');
    $("ul#customer").addClass("show");
    $("ul#customer li").eq(0).addClass("active");

    $('#customer-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 5]
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
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
    } );

    function confirmDelete() {
      if (confirm("Are you sure want to delete?")) {
          return true;
      }
      return false;
  }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>