 <?php $__env->startSection('content'); ?>
<?php if(session()->has('message1')): ?>
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message1')); ?></div> 
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.Import')); ?> <?php echo e(trans('file.Purchase')); ?> <?php echo e(trans('file.By')); ?> CSV</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</p>
                        <?php echo Form::open(['route' => 'purchase.import', 'method' => 'post', 'files' => true, 'id' => 'purchase-form']); ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Reference')); ?> No</strong></label>
                                            <p><strong><?php echo e('pr-' . date("Ymd") . '-'. date("his")); ?></strong> </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Supplier')); ?></strong></label>
                                            <input type="text" name="supplier" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <strong><?php echo e(trans('file.Shipping Cost')); ?></strong>
                                            </label>
                                            <input type="number" name="shipping_cost" class="form-control" step="any" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Upload CSV File')); ?>*</strong></label>
                                            <input type="file" name="file" class="form-control" required />
                                            <p><?php echo e(trans('file.The correct column order is')); ?> (product_code, quantity, product_cost) <?php echo e(trans('file.and you must follow this')); ?>. <?php echo e(trans('file.All columns are required')); ?>.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong></strong></label><br>
                                            <a href="../public/sample_file/sample_purchase_products.csv" class="btn btn-primary btn-block btn-lg"><i class="fa fa-download"></i> <?php echo e(trans('file.Download Sample File')); ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Note')); ?></strong></label>
                                            <textarea rows="5" class="form-control" name="note"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary" id="submit-button">
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
    $("ul#purchase").siblings('a').attr('aria-expanded','true');
    $("ul#purchase").addClass("show");
    $("ul#purchase li").eq(2).addClass("active");
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>