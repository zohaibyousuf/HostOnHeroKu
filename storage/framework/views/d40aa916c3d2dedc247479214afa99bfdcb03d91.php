 <?php $__env->startSection('content'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
            <h4 class="text-center mt-3"><?php echo e(trans('file.Best Seller')); ?> <?php echo e(trans('file.From')); ?> <?php echo e($start_month.' - '.date("F Y")); ?></h4>
            <div class="card-body">
              <canvas id="bestSeller" data-product = "<?php echo e(json_encode($product)); ?>" data-sold_qty="<?php echo e(json_encode($sold_qty)); ?>" ></canvas>
            </div>
        </div>
	</div>
</div>

<script type="text/javascript">
	$("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(1).addClass("active");
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>