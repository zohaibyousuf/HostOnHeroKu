 <?php $__env->startSection('content'); ?>
<?php if(session()->has('message1')): ?>
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message1')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message2')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message2')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>

<section>
    <div class="container-fluid">
        <?php if(in_array("users-add", $all_permission)): ?>
            <a href="<?php echo e(route('users.create')); ?>" class="btn btn-info"><i class="fa fa-plus"></i> <?php echo e(trans('file.Add')); ?> <?php echo e(trans('file.User')); ?></a>
        <?php endif; ?>
    </div>
    <div class="table-responsive">
        <table id="user-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.UserName')); ?></th>
                    <th><?php echo e(trans('file.Email')); ?></th>
                    <th><?php echo e(trans('file.Company Name')); ?></th>
                    <th><?php echo e(trans('file.Phone Number')); ?></th>
                    <th><?php echo e(trans('file.Role')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.Action')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $lsms_user_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key); ?></td>
                    <td><?php echo e($user->username); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td><?php echo e($user->company_name); ?></td>
                    <td><?php echo e($user->phone); ?></td>
                    <?php $role = DB::table('roles')->find($user->role)?>
                    <td><?php echo e($role->name); ?></td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(trans('file.Action')); ?>

                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <?php if(in_array("users-edit", $all_permission)): ?>
                                <li>
                                	<a href="<?php echo e(route('users.edit', ['id' => $user->id])); ?>" class="btn btn-link"><i class="fa fa-edit"></i> <?php echo e(trans('file.Edit')); ?></a>
                                </li>
                                <?php endif; ?>
                                <?php if(in_array("users-delete", $all_permission)): ?>
                                <?php echo e(Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE'] )); ?>

                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> <?php echo e(trans('file.Delete')); ?></button>
                                </li>
                                <?php echo e(Form::close()); ?>

                                <?php endif; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</section>

<script type="text/javascript">

    $("ul#user").siblings('a').attr('aria-expanded','true');
    $("ul#user").addClass("show");
    $("ul#user li").eq(0).addClass("active");

	function confirmDelete() {
	    if (confirm("Are you sure want to delete?")) {
	        return true;
	    }
	    return false;
	}

    $('#user-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 6]
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
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>