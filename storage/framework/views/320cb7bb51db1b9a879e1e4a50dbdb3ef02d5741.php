 <?php $__env->startSection('content'); ?>
<?php if(session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<section>
    <div class="container-fluid">
    	<div class="input-group">
          <div class="input-group-prepend">
                <?php if(in_array("products-add", $all_permission)): ?>
                <a href="<?php echo e(route('products.create')); ?>" class="btn btn-info"><i class="fa fa-plus"></i> <?php echo e(trans('file.Add')); ?> <?php echo e(trans('file.Product')); ?></a>
                &nbsp;&nbsp;
                <a href="#" data-toggle="modal" data-target="#importProduct" class="btn btn-primary"><i class="fa fa-file"></i> <?php echo e(trans('file.Import')); ?> <?php echo e(trans('file.Product')); ?></a>
                <?php endif; ?>
          </div>    
        </div>
    </div>

    <table id="product-table" class="table table-striped">
        <thead>
            <tr>
                <th class="not-exported"></th>
                <th><?php echo e(trans('file.Image')); ?></th>
                <th><?php echo e(trans('file.Name')); ?></th>
                <th><?php echo e(trans('file.Brand')); ?></th>
                <th><?php echo e(trans('file.Category')); ?></th>
                <th><?php echo e(trans('file.Code')); ?></th>
                <th><?php echo e(trans('file.Price')); ?></th>
                <th><?php echo e(trans('file.Quantity')); ?></th>
                <th><?php echo e(trans('file.Alert')); ?> <?php echo e(trans('file.Quantity')); ?></th>
                <th class="not-exported"><?php echo e(trans('file.Action')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $lsms_product_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php 
                $category = DB::table('categories')->where('id', $product->category_id)->first();
                    $replace = Array(
                        '\\' => '',
                        '"' => '\"'
                    );

                    $product_name = str_replace(array_keys($replace), $replace, $product->name);

                    $product->product_details = str_replace(array_keys($replace), $replace, $product->product_details);

                    $product->product_details = preg_replace('/\r\n+/', "<br>", $product->product_details);
            ?>
            <tr class="product-link" data-product='[ "<?php echo e($product_name); ?>", "<?php echo e($product->model_no); ?>", "<?php echo e($product->brand); ?>", "<?php echo e($category->name); ?>", "<?php echo e($product->price); ?>", "<?php echo e($product->qty); ?>", "<?php echo e($product->alert_qty); ?>","<?php echo e($product->product_details); ?>", "<?php echo e($product->unit); ?>"]' data-imagedata ="<?php echo e(DNS1D::getBarcodePNG($product->model_no, $product->barcode_symbology)); ?>">
                <td><?php echo e($key); ?></td>
                <?php if($product->image): ?>
                <td> <img src="<?php echo e(url('public/product/images',$product->image)); ?>" height="80" width="80">
                </td>
                <?php else: ?>
                <td>No Image</td>
                <?php endif; ?>
                <td><?php echo e($product->name); ?></td>
                <?php if($product->brand): ?>
                <td><?php echo e($product->brand); ?></td>
                <?php else: ?>
                <td>N/A</td>
                <?php endif; ?>
                <td><?php echo e($category->name); ?></td>
                <?php if($product->model_no): ?>
                <td><?php echo e($product->model_no); ?></td>
                <?php else: ?>
                <td>N/A</td>
                <?php endif; ?>
                <td><?php echo e($product->price); ?></td>
                <td><?php echo e($product->qty); ?></td>
                <?php if($product->alert_qty): ?>
                <td><?php echo e($product->alert_qty); ?></td>
                <?php else: ?>
                <td>N/A</td>
                <?php endif; ?>
                <td>
                    <div class="btn-group">
                        <?php if(in_array("products-edit", $all_permission)): ?>
                        <a class="btn btn-primary" href="<?php echo e(route('products.edit', ['id' => $product->id])); ?>" title="<?php echo e(trans('file.Edit')); ?>"><i class="fa fa-edit"></i></a>
                        <?php endif; ?>
                        <?php if(in_array("products-delete", $all_permission)): ?>
                        <?php echo e(Form::open(['route' => ['products.destroy', $product->id], 'method' => 'DELETE'] )); ?>

                            <button type="submit" class="btn btn-danger" onclick="return confirmDelete()" title="<?php echo e(trans('file.Delete')); ?>"> <i class="fa fa-times"></i></button>
                        <?php echo e(Form::close()); ?>

                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div id="importProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <?php echo Form::open(['route' => 'product.import', 'method' => 'post', 'files' => true]); ?>

            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Import')); ?> <?php echo e(trans('file.Product')); ?></h5>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <p class="italic"><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</p>
               <p><?php echo e(trans('file.The correct column order is')); ?> [name *, image (file name with extension like example.jpg), code *, barcode_symbology *, brand, category *, price *, unit, alert_qty, product_details] <?php echo e(trans('file.and you must follow this')); ?>. <?php echo e(trans('file.Every Product Code must be unique. To show Image you must put the image in the')); ?> public/product/image directory</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong><?php echo e(trans('file.Upload CSV File')); ?> *</strong></label>
                            <?php echo e(Form::file('file', array('class' => 'form-control','required'))); ?>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong></strong></label><br>
                            <a href="public/sample_file/sample_products.csv" class="btn btn-primary btn-block"><i class="fa fa-download"></i> <?php echo e(trans('file.Download Sample File')); ?></a>
                        </div>
                    </div>
                </div>
                
                <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
            </div>
            <?php echo Form::close(); ?>

          </div>
        </div>
    </div>

    <div id="product-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Product Details')); ?> &nbsp;&nbsp;</h5>
              <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="fa fa-print"></i> <?php echo e(trans('file.Print')); ?></button>
              <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
                <div id="product-content" class="modal-body">
                </div>
          </div>
        </div>
    </div>

</section>
<script type="text/javascript">

    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");
    $("ul#product li").eq(1).addClass("active");

    $("tr.product-link td:not(:first-child, :last-child)").on("click", function(){
        var product = $(this).parent().data('product');
        var imagedata = $(this).parent().data('imagedata');
        htmltext = '';
        htmltext = '</p><p><strong><?php echo e(trans("file.Name")); ?>: </strong>'+product[0]+'</p><p><strong><?php echo e(trans("file.Code")); ?>: </strong>'+product[1]+ '</p><strong><?php echo e(trans("file.Barcode")); ?>: </strong> <img src="data:image/png;base64,'+imagedata+'" alt="barcode" /></p><p><strong><?php echo e(trans("file.Brand")); ?>: </strong>'+product[2]+'</p><p><strong><?php echo e(trans("file.Category")); ?>: </strong>'+product[3]+
            '</p><p><strong><?php echo e(trans("file.Unit")); ?>: </strong>'+product[8]+
            '</p><p><strong><?php echo e(trans("file.Price")); ?>: </strong>'+product[4]+
            '</p><p><strong><?php echo e(trans("file.Quantity")); ?>: </strong>'+product[5]+
            '</p><p><strong><?php echo e(trans("file.Alert")); ?> <?php echo e(trans("file.Quantity")); ?>: </strong>'+product[6]+'</p><p><strong><?php echo e(trans("file.Product Details")); ?>: </strong></p>'+product[7];

        $('#product-content').html(htmltext);
        $('#product-details').modal('show');
    });

    $('#product-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 1, 9]
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
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                },
                customize: function(doc) {
                    for (var i = 1; i < doc.content[1].table.body.length; i++) {
                        if (doc.content[1].table.body[i][0].text.indexOf('<img src=') !== -1) {
                            var imagehtml = doc.content[1].table.body[i][0].text;
                            var regex = /<img.*?src=['"](.*?)['"]/;
                            var src = regex.exec(imagehtml)[1];
                            var tempImage = new Image();
                            tempImage.src = src;
                            var canvas = document.createElement("canvas");
                            canvas.width = tempImage.width;
                            canvas.height = tempImage.height;
                            var ctx = canvas.getContext("2d");
                            ctx.drawImage(tempImage, 0, 0);
                            var imagedata = canvas.toDataURL("image/png");
                            delete doc.content[1].table.body[i][0].text;
                            doc.content[1].table.body[i][0].image = imagedata;
                            doc.content[1].table.body[i][0].fit = [30, 30];
                        }
                    }
                },
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible',
                    format: {
                        body: function ( data, row, column, node ) {
                            if (column === 0 && (data.indexOf('<img src=') !== -1)) {
                                var regex = /<img.*?src=['"](.*?)['"]/;
                                data = regex.exec(data)[1];                 
                            }
                            return data;
                        }
                    }
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                }
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