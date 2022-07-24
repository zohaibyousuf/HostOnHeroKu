 <?php $__env->startSection('content'); ?>
<?php if(session()->has('not_permitted')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.Add')); ?> <?php echo e(trans('file.Customer')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</p>
                        <?php echo Form::open(['route' => 'customer.store', 'method' => 'post']); ?>

                            <div class="form-group">
                                <label><strong><?php echo e(trans('file.Name')); ?> *</strong> </label>
                                <input type="text" name="name" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong><?php echo e(trans('file.Company Name')); ?> </strong></label>
                                <input type="text" name="company_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong><?php echo e(trans('file.Address')); ?></strong></label>
                                <input type="text" name="address" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><strong><?php echo e(trans('file.Phone Number')); ?> *</strong></label>
                                <input type="text" name="phone" required class="form-control" />
                                <?php if($errors->has('phone')): ?>
                                <span>
                                   <strong><?php echo e($errors->first('phone')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="is_active" required class="form-control" value="1">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
                            </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $("ul#customer").siblings('a').attr('aria-expanded','true');
    $("ul#customer").addClass("show");
    $("ul#customer li").eq(1).addClass("active");
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>