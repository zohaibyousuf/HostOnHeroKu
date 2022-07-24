
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
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>Update User Profile</h4>
                    </div>
                    <div class="card-body">
                        <p>The field labels marked with * are required input fields.</p>
                        <?php echo Form::open(['route' => ['user.profileUpdate', Auth::id()], 'method' => 'post']); ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><strong>Name *</strong> </label>
                                    <input type="text" name="name" value="<?php echo e($lsms_user_data->name); ?>" required class="form-control" />
                                    <?php if($errors->has('name')): ?>
                                    <span>
                                       <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label><strong>Username *</strong> </label>
                                    <input type="text" name="username" value="<?php echo e($lsms_user_data->username); ?>" required class="form-control" />
                                    <?php if($errors->has('username')): ?>
                                    <span>
                                       <strong><?php echo e($errors->first('username')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label><strong>Company Name *</strong> </label>
                                    <input type="text" name="company_name" value="<?php echo e($lsms_user_data->company_name); ?>" required class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label><strong>Email *</strong> </label>
                                    <input type="email" name="email" value="<?php echo e($lsms_user_data->email); ?>" required class="form-control">
                                    <?php if($errors->has('email')): ?>
                                    <span>
                                       <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label><strong>Address *</strong> </label>
                                    <input type="text" name="address" value="<?php echo e($lsms_user_data->address); ?>" required class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label><strong>Phone *</strong> </label>
                                    <input type="text" name="phone" value="<?php echo e($lsms_user_data->phone); ?>" required class="form-control" />
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>Change Password</h4>
                    </div>
                    <div class="card-body">
                        <?php echo Form::open(['route' => ['user.password', Auth::id()], 'method' => 'put']); ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><strong>Current Password *</strong> </label>
                                    <input type="password" name="current_pass" required class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label><strong>New Password *</strong> </label>
                                    <input type="password" name="new_pass" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <label><strong>Confirm Password *</strong> </label>
                                    <input type="password" name="confirm_pass" id="confirm_pass" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <div class="registrationFormAlert" id="divCheckPasswordMatch">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $('select[name="role"]').val($('input[name="role_hidden"]').val());
    $('#confirm_pass').on('input', function(){

        if($('input[name="new_pass"]').val() != $('input[name="confirm_pass"]').val())
            $("#divCheckPasswordMatch").html("Password doesn't match!");
        else
            $("#divCheckPasswordMatch").html("Password matches!");
         
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>