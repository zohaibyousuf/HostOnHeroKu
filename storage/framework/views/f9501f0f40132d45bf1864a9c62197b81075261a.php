
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
                        <h4><?php echo e(trans('file.Update')); ?> <?php echo e(trans('file.Product')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</p>
                        <?php echo Form::open(['route' => ['products.update', $lsms_product_data->id], 'method' => 'put', 'files' => true, 'id' => 'product-form']); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Product')); ?> <?php echo e(trans('file.Name')); ?> *</strong> </label>
                                    <input type="text" name="name" required class="form-control" value="<?php echo e($lsms_product_data->name); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Product')); ?> <?php echo e(trans('file.Image')); ?></strong> </label>
                                    <input type="file" name="image" class="form-control">
                                    <?php if($errors->has('image')): ?>
                                        <span>
                                           <strong><?php echo e($errors->first('image')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Code')); ?> *</strong> </label>
                                    <div class="input-group">
                                        <input type="text" name="model_no" class="form-control" value="<?php echo e($lsms_product_data->model_no); ?>" required />
                                        <div class="input-group-append">
                                            <button id="genbutton" type="button" class="btn btn-default"><?php echo e(trans('file.Generate')); ?></button>
                                        </div>
                                    </div>
                                    <?php if($errors->has('model_no')): ?>
                                    <span>
                                       <strong><?php echo e($errors->first('model_no')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="barcode_symbology_hidden" value="<?php echo e($lsms_product_data->barcode_symbology); ?>">
                                    <label><strong><?php echo e(trans('file.Barcode Symbology')); ?> *</strong> </label>
                                    <div class="input-group">
                                        <select name="barcode_symbology" required class="form-control selectpicker">
                                            <option value="C128">Code 128</option>
                                            <option value="C39">Code 39</option>
                                            <option value="UPCA">UPC-A</option>
                                            <option value="UPCE">UPC-E</option>
                                            <option value="EAN8">EAN-8</option>
                                            <option value="EAN13">EAN-13</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Brand')); ?></strong> </label>
                                    <input type="text" name="brand" class="form-control" value="<?php echo e($lsms_product_data->brand); ?>"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Category')); ?> *</strong> </label>
                                    <input type="hidden" name="category" value="<?php echo e($lsms_product_data->category_id); ?>">
                                    <select name="category_id" required class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Category...">
                                        <?php $__currentLoopData = $lsms_category_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Product')); ?> <?php echo e(trans('file.Price')); ?> *</strong> </label>
                                    <input type="number" name="price" class="form-control" step="any" value="<?php echo e($lsms_product_data->price); ?>" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Product')); ?> <?php echo e(trans('file.Unit')); ?></strong> </label>
                                    <input type="text" name="unit" class="form-control" value="<?php echo e($lsms_product_data->unit); ?>"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Alert')); ?> <?php echo e(trans('file.Quantity')); ?></strong> </label>
                                    <input type="number" name="alert_qty" class="form-control" step="any" value="<?php echo e($lsms_product_data->alert_qty); ?>"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Product')); ?> <?php echo e(trans('file.Details')); ?></strong></label>
                                    <textarea name="product_details" class="form-control" rows="5"><?php echo e($lsms_product_data->product_details); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
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

    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");

    $('.selectpicker').selectpicker({
      style: 'btn-link',
    });

    $('#genbutton').on("click", function(){
      $.get('../gencode', function(data){
        $("input[name='model_no']").val(data);
      });
    });

    var cat = $("input[name='category']").val();
    $('select[name="barcode_symbology"]').val($("input[name='barcode_symbology_hidden']").val());
    $('select[name="category_id"]').val(cat);
    $('.selectpicker').selectpicker('refresh');

    $('#product-form').on('submit',function(e){
        var product_code = $("input[name='model_no']").val();
        var barcode_symbology = $('select[name="barcode_symbology"]').val();
        var exp = /^\d+$/;

        if(!(product_code.match(exp)) && (barcode_symbology == 'UPCA' || barcode_symbology == 'UPCE' || barcode_symbology == 'EAN8' || barcode_symbology == 'EAN13') ) {
            alert('Product code must be numeric value.');
            e.preventDefault();
        }
        else if(product_code.match(exp)) {
            if(barcode_symbology == 'UPCA' && product_code.length > 11){
                alert('Product code length must be less than 12');
                e.preventDefault();
            }
            else if(barcode_symbology == 'EAN8' && product_code.length > 7){
                alert('Product code length must be less than 8');
                e.preventDefault();
            }
            else if(barcode_symbology == 'EAN13' && product_code.length > 12){
                alert('Product code length must be less than 13');
                e.preventDefault();
            }
        }
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>