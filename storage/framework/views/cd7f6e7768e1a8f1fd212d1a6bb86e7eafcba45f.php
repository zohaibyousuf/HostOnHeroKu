 <?php $__env->startSection('content'); ?>

<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.Add')); ?> <?php echo e(trans('file.User')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                        <?php echo Form::open(['route' => 'users.store', 'method' => 'post', 'files' => true]); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Name')); ?> *</strong> </label>
                                        <input type="text" name="name" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.UserName')); ?> *</strong> </label>
                                        <input type="text" name="username" required class="form-control">
                                        <?php if($errors->has('username')): ?>
                                       <span>
                                           <strong><?php echo e($errors->first('username')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Password')); ?> *</strong> </label>
                                        <div class="input-group">
                                            <input type="password" name="password" required class="form-control">
                                            <div class="input-group-append">
                                                <button id="genbutton" type="button" class="btn btn-default"><?php echo e(trans('file.Generate')); ?></button>
                                            </div>
                                            <?php if($errors->has('password')): ?>
                                            <span>
                                               <strong><?php echo e($errors->first('password')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Address')); ?> *</strong></label>
                                        <textarea name="address" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Email')); ?> *</strong></label>
                                        <input type="email" name="email" placeholder="example@example.com" required class="form-control">
                                        <?php if($errors->has('email')): ?>
                                       <span>
                                           <strong><?php echo e($errors->first('email')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Phone Number')); ?> *</strong></label>
                                        <input type="text" name="phone" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Company Name')); ?> *</strong></label>
                                        <input type="text" name="company_name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Role')); ?> *</strong></label>
                                        <select name="role" required class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Role...">
                                          <?php $__currentLoopData = $lsms_role_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
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

    $("ul#user").siblings('a').attr('aria-expanded','true');
    $("ul#user").addClass("show");
    $("ul#user li").eq(1).addClass("active");

    $('.selectpicker').selectpicker({
      style: 'btn-link',
    });
    
    $('#genbutton').on("click", function(){
      $.get('genpass', function(data){
        $("input[name='password']").val(data);
      });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>