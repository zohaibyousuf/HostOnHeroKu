
<?php $__env->startSection('content'); ?>
<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.Group Permission')); ?></h4>
                    </div>
                    <?php echo Form::open(['route' => 'role.setPermission', 'method' => 'post']); ?>

                    <div class="card-body">
                    	<input type="hidden" name="role_id" value="<?php echo e($lsms_role_data->id); ?>" />
						<div class="table-responsive">
						    <table class="table table-bordered table-hover table-striped reports-table">
						        <thead>
						        <tr>
						            <th colspan="5" class="text-center"><?php echo e($lsms_role_data->name); ?> <?php echo e(trans('file.Group Permission')); ?></th>
						        </tr>
						        <tr>
						            <th rowspan="2" class="text-center">Module Name 
						            </th>
						            <th colspan="4" class="text-center"><?php echo e(trans('file.Permissions')); ?>&nbsp;&nbsp; <input type="checkbox" id="select_all" class="checkbox"></th>
						        </tr>
						        <tr>
						            <th class="text-center"><?php echo e(trans('file.View')); ?></th>
						            <th class="text-center"><?php echo e(trans('file.Add')); ?></th>
						            <th class="text-center"><?php echo e(trans('file.Edit')); ?></th>
						            <th class="text-center"><?php echo e(trans('file.Delete')); ?></th>
						        </tr>
						        </thead>
						        <tbody>
						        <tr>
						            <td><?php echo e(trans('file.Product')); ?></td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("products-index", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="products-index" checked />
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="products-index" />
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("products-add", $all_permission)): ?>
						               	<input type="checkbox" value="1" class="checkbox" name="products-add" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="products-add">
						                <?php endif; ?>
						                </div>

						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("products-edit", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="products-edit" checked />
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="products-edit" />
						                <?php endif; ?>
						                </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("products-delete", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="products-delete" checked />
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="products-delete" />
						                <?php endif; ?>
						                </div>
						            </td>
						        </tr>

						        <tr>
						            <td><?php echo e(trans('file.Purchase')); ?></td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("purchases-index", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="purchases-index" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="purchases-index">
						                <?php endif; ?>
						                </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("purchases-add", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="purchases-add" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="purchases-add">
						                <?php endif; ?>
						                </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("purchases-edit", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="purchases-edit" checked />
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="purchases-edit">
						                <?php endif; ?>
						                </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("purchases-delete", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="purchases-delete" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="purchases-delete">
						                <?php endif; ?>
						            	</div>
						            </td>
						        </tr>

						        <tr>
						            <td><?php echo e(trans('file.Sale')); ?></td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("sales-index", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-index" checked />
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-index">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("sales-add", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-add" checked />
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-add">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("sales-edit", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-edit" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-edit">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("sales-delete", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-delete" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-delete">
						                <?php endif; ?>
						            	</div>
						            </td>
						        </tr>

						        <tr>
						            <td><?php echo e(trans('file.Return')); ?></td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("returns-index", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="returns-index" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="returns-index">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("returns-add", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="returns-add" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="returns-add">
						                <?php endif; ?>
						                </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("returns-edit", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="returns-edit" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="returns-edit">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("returns-delete", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="returns-delete" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="returns-delete">
						                <?php endif; ?>
						            	</div>
						            </td>
						        </tr>
						        <tr>
						            <td><?php echo e(trans('file.User')); ?></td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("users-index", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-index" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-index">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("users-add", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-add" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-add">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("users-edit", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-edit" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-edit">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("users-delete", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-delete" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-delete">
						                <?php endif; ?>
						            	</div>
						            </td>
						        </tr>
						        <tr>
						            <td><?php echo e(trans('file.Customer')); ?></td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("customers-index", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="customers-index" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="customers-index">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("customers-add", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="customers-add" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="customers-add">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("customers-edit", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="customers-edit" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="customers-edit">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("customers-delete", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="customers-delete" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="customers-delete">
						                <?php endif; ?>
						            	</div>
						            </td>
						        </tr>
						        <tr>
						            <td><?php echo e(trans('file.Report')); ?>s</td>
						            <td colspan="5">
						            	<span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("profit-loss", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="profit-loss" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="profit-loss">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="profit-loss" class="padding05"><?php echo e(trans('file.profit')); ?>/<?php echo e(trans('file.Loss')); ?> &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("best-seller", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="best-seller" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="best-seller">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="best-seller" class="padding05"><?php echo e(trans('file.Best Seller')); ?> &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("product-report", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="product-report" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="product-report">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="product-report" class="padding05"><?php echo e(trans('file.Product')); ?> <?php echo e(trans('file.Report')); ?> &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("purchase-report", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="purchase-report" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="purchase-report">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="purchase-report" class="padding05"> <?php echo e(trans('file.Purchase')); ?> <?php echo e(trans('file.Report')); ?> &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("sale-report", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="sale-report" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="sale-report">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="sale-report" class="padding05"><?php echo e(trans('file.Sale')); ?> <?php echo e(trans('file.Report')); ?> &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("product-qty-alert", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="product-qty-alert" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="product-qty-alert">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="product-qty-alert" class="padding05"><?php echo e(trans('file.Product')); ?> <?php echo e(trans('file.Quantity')); ?> <?php echo e(trans('file.Alert')); ?> &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("customer-report", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="customer-report" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="customer-report">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="customer-report" class="padding05"><?php echo e(trans('file.Customer')); ?> <?php echo e(trans('file.Report')); ?> &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("due-report", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="due-report" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="due-report">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="due-report" class="padding05"><?php echo e(trans('file.Due')); ?> <?php echo e(trans('file.Report')); ?> &nbsp;&nbsp;</label>
						                </span>
						            </td>
						        </tr>
						        </tbody>
						    </table>
						</div>
						<div class="form-group">
	                        <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
	                    </div>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

	$("#select_all").on( "change", function() {
	    if ($(this).is(':checked')) {
	        $("tbody input[type='checkbox']").prop('checked', true);
	    } 
	    else {
	        $("tbody input[type='checkbox']").prop('checked', false);
	    }
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>