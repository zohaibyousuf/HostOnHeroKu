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

                        <h4><?php echo e(trans('file.Settings')); ?></h4>

                    </div>

                    <div class="card-body">

                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>

                        <?php echo Form::open(['route' => 'settings.store', 'files' => true, 'method' => 'post']); ?>


                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label><strong><?php echo e(trans('file.Site Title')); ?> *</strong></label>

                                        <input type="text" name="site_title" class="form-control" value="<?php if($lsms_setting_data): ?><?php echo e($lsms_setting_data->site_title); ?><?php endif; ?>" required />

                                    </div>

                                    <div class="form-group">

                                        <label><strong><?php echo e(trans('file.Mail Host')); ?></strong></label>

                                        <input type="text" name="mail_host" class="form-control" value="<?php echo e(env('MAIL_HOST')); ?>" />

                                    </div>

                                    <div class="form-group">

                                        <label><strong><?php echo e(trans('file.Mail Address')); ?></strong></label>

                                        <input type="text" name="mail_address" class="form-control" value="<?php echo e(env('MAIL_FROM_ADDRESS')); ?>" />

                                    </div>

                                    <div class="form-group">

                                        <label><strong><?php echo e(trans('file.Mail Name')); ?></strong></label>

                                        <input type="text" name="mail_name" class="form-control" value="<?php echo e(env('MAIL_FROM_NAME')); ?>" />

                                    </div>

                                    <div class="form-group">

                                        <label><strong><?php echo e(trans('file.Currency')); ?> *</strong></label>

                                        <input type="text" name="currency" class="form-control" value="<?php if($lsms_setting_data): ?><?php echo e($lsms_setting_data->currency); ?><?php endif; ?>" required />

                                    </div>

                                    <div class="form-group">

                                        <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label><strong><?php echo e(trans('file.Site Logo')); ?></strong></label>

                                        <input type="file" name="site_logo" class="form-control" value=""/>

                                    </div>

                                    <?php if($errors->has('site_logo')): ?>

                                   <span>

                                       <strong><?php echo e($errors->first('site_logo')); ?></strong>

                                    </span>

                                    <?php endif; ?>

                                    <div class="form-group">

                                        <label><strong><?php echo e(trans('file.Mail Port')); ?></strong></label>

                                        <input type="text" name="port" class="form-control" value="<?php echo e(env('MAIL_PORT')); ?>" />

                                    </div>

                                    <div class="form-group">

                                        <label><strong><?php echo e(trans('file.Password')); ?></strong></label>

                                        <input type="password" name="password" class="form-control" value="<?php echo e(env('MAIL_PASSWORD')); ?>" />

                                    </div>

                                    <div class="form-group">

                                        <label><strong><?php echo e(trans('file.Encryption')); ?></strong></label>

                                        <input type="text" name="encryption" class="form-control" value="<?php echo e(env('MAIL_ENCRYPTION')); ?>" />

                                    </div>

                                    <div class="form-group">

                                        <label><strong><?php echo e(trans('file.Time Zone')); ?></strong></label>

                                        <?php if($lsms_setting_data): ?>

                                        <input type="hidden" name="timezone_hidden" value="<?php echo e(env('APP_TIMEZONE')); ?>">

                                        <?php endif; ?>

                                        <select name="timezone" class="selectpicker form-control" data-live-search="true" title="Select TimeZone...">

                                            <?php $__currentLoopData = $zones_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <option value="<?php echo e($zone['zone']); ?>"><?php echo e($zone['diff_from_GMT'] . ' - ' . $zone['zone']); ?></option>

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



    $("ul#settings").siblings('a').attr('aria-expanded','true');

    $("ul#settings").addClass("show");

    $("ul#settings li").eq(1).addClass("active");



    if($("input[name='timezone_hidden']").val()){

        $('select[name=timezone]').val($("input[name='timezone_hidden']").val());

        $('.selectpicker').selectpicker('refresh');

    }



    $('.selectpicker').selectpicker({

      style: 'btn-link',

    });



</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>