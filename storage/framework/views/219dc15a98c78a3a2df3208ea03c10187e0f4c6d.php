<?php $__env->startSection('content'); ?>
<?php if(session()->has('not_permitted')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message')): ?>
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>

<!-- Counts Section -->
<section class="dashboard-counts">
	<div class="container-fluid">
	  <div class="row">
	    <!-- Count item widget-->
	    <div class="col-md-4 form-group">
	      <div class="wrapper count-title d-flex">
	        <div class="icon"><i class="ion-cash"></i></div>
	        <div class="name"><?php echo e(trans('file.revenue')); ?>

	          <div class="count-number revenue-data"><?php echo e(number_format((float)$revenue, 2, '.', '')); ?></div>
	          <span><?php echo e(date('F Y')); ?></span>
	        </div>
	      </div>
	    </div>
	    <!-- Count item widget-->
	    <div class="col-md-4 form-group">
	      <div class="wrapper count-title d-flex">
	        <div class="icon"><i class="ion-bag"></i></div>
	        <div class="name"><?php echo e(trans('file.Purchase')); ?>

	          <div class="count-number purchase-data"><?php echo e(number_format((float)$purchase, 2, '.', '')); ?></div>
	          <span><?php echo e(date('F Y')); ?></span>
	        </div>
	      </div>
	    </div>
	    <!-- Count item widget-->
	    <div class="col-md-4 form-group">
	      <div class="wrapper count-title d-flex">
	        <div class="icon"><i class="ion-connection-bars"></i></div>
	        <div class="name"><?php echo e(trans('file.profit')); ?>

	          <div class="count-number profit-data"><?php echo e(number_format((float)$profit, 2, '.', '')); ?></div>
	          <span><?php echo e(date('F Y')); ?></span>
	        </div>
	      </div>
	    </div>
	    <!-- Count item widget-->
	    <div class="col-md-4 form-group">
	      <div class="wrapper count-title d-flex">
	        <div class="icon"><i class="ion-cube"></i></div>
	        <div class="name"><?php echo e(trans('file.Sale')); ?>

	          <div class="count-number sale-data"><?php echo e(number_format((float)$sale, 2, '.', '')); ?></div>
	          <span><?php echo e(date('F Y')); ?></span>
	        </div>
	      </div>
	    </div>
	    <!-- Count item widget-->
	    <div class="col-md-4 form-group">
	      <div class="wrapper count-title d-flex">
	        <div class="icon"><i class="ion-arrow-return-left"></i></div>
	        <div class="name"><?php echo e(trans('file.Return')); ?>

	          <div class="count-number return-data"><?php echo e(number_format((float)$return, 2, '.', '')); ?></div>
	          <span><?php echo e(date('F Y')); ?></span>
	        </div>
	      </div>
	    </div>
	    <!-- Count item widget-->
	    <div class="col-md-4 form-group">
	      <div class="wrapper count-title d-flex">
	        <div class="icon"><i class="fa fa-shopping-cart"></i></div>
	        <div class="name"><?php echo e(trans('file.Sale')); ?> Qty
	          <div class="count-number sale-data"><?php echo e($sold_qty); ?></div>
	          <span><?php echo e(date('F Y')); ?></span>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</section>
<section class="mb-30px">
	<div class="container-fluid">
	  <div class="row">
	    <div class="col-md-12">
	      <div class="card">
	        <div class="card-header d-flex align-items-center">
	          <h4><?php echo e(trans('file.yearly report')); ?></h4>
	        </div>
	        <div class="card-body">
	          <canvas id="saleChart" data-sale_chart_value = "<?php echo e(json_encode($yearly_sale_amount)); ?>" data-purchase_chart_value = "<?php echo e(json_encode($yearly_purchase_amount)); ?>"></canvas>
	        </div>
	      </div>
	    </div>
	    <div class="col-md-7">
	      <div class="card">
	        <div class="card-header d-flex justify-content-between align-items-center">
	          <h4><?php echo e(trans('file.Recent Transaction')); ?></h4>
	          <div class="right-column">
	            <div class="badge badge-primary"><?php echo e(trans('file.latest')); ?> 5</div>
	          </div>
	        </div>
	        <ul class="nav nav-tabs" role="tablist">
	          <li class="nav-item">
	            <a class="nav-link active" href="#sale-latest" role="tab" data-toggle="tab"><?php echo e(trans('file.Sale')); ?></a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link" href="#purchase-latest" role="tab" data-toggle="tab"><?php echo e(trans('file.Purchase')); ?></a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link" href="#return-latest" role="tab" data-toggle="tab"><?php echo e(trans('file.Return')); ?></a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link" href="#payment-latest" role="tab" data-toggle="tab"><?php echo e(trans('file.Payment')); ?></a>
	          </li>
	        </ul>

	        <div class="tab-content">
	          <div role="tabpanel" class="tab-pane fade show active" id="sale-latest">
	              <div class="table-responsive">
	                <table class="table table-striped">
	                  <thead>
	                    <tr>
	                      <th><?php echo e(trans('file.Date')); ?></th>
	                      <th><?php echo e(trans('file.Reference')); ?></th>
	                      <th><?php echo e(trans('file.Customer')); ?></th>
	                      <th><?php echo e(trans('file.Payment')); ?> <?php echo e(trans('file.Status')); ?></th>
	                      <th><?php echo e(trans('file.Grand Total')); ?></th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                    <?php $__currentLoopData = $recent_sale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                    <?php $customer = DB::table('customers')->find($sale->customer_id); ?>
	                    <tr>
	                      <td><?php echo e(date('d-m-Y', strtotime($sale->created_at->toDateString()))); ?></td>
	                      <td><?php echo e($sale->reference_no); ?></td>
	                      <td><?php echo e($customer->name); ?></td>
	                      <?php if($sale->payment_status == 'Paid'): ?>
	                      <td><div class="badge badge-success">Paid</div></td>
	                      <?php else: ?>
	                      <td><div class="badge badge-danger">Due</div></td>
	                      <?php endif; ?>
	                      <td><?php echo e($sale->grand_total); ?></td>
	                    </tr>
	                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                  </tbody>
	                </table>
	              </div>
	          </div>
	          <div role="tabpanel" class="tab-pane fade" id="purchase-latest">
	              <div class="table-responsive">
	                <table class="table table-striped">
	                  <thead>
	                    <tr>
	                      <th><?php echo e(trans('file.Date')); ?></th>
	                      <th><?php echo e(trans('file.Reference')); ?></th>
	                      <th><?php echo e(trans('file.Supplier')); ?></th>
	                      <th><?php echo e(trans('file.Grand Total')); ?></th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                    <?php $__currentLoopData = $recent_purchase; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                    <tr>
	                      <td><?php echo e(date('d-m-Y', strtotime($purchase->created_at->toDateString()))); ?></td>
	                      <td><?php echo e($purchase->reference_no); ?></td>
	                      <?php if($purchase->supplier): ?>
	                        <td><?php echo e($purchase->supplier); ?></td>
	                      <?php else: ?>
	                        <td>N/A</td>
	                      <?php endif; ?>
	                      <td><?php echo e($purchase->grand_total); ?></td>
	                    </tr>
	                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                  </tbody>
	                </table>
	              </div>
	          </div>
	          <div role="tabpanel" class="tab-pane fade" id="return-latest">
	              <div class="table-responsive">
	                <table class="table table-striped">
	                  <thead>
	                    <tr>
	                      <th><?php echo e(trans('file.Date')); ?></th>
	                      <th><?php echo e(trans('file.Reference')); ?></th>
	                      <th><?php echo e(trans('file.Customer')); ?></th>
	                      <th><?php echo e(trans('file.Grand Total')); ?></th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                    <?php $__currentLoopData = $recent_return; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                    <?php $customer = DB::table('customers')->find($return->customer_id); ?>
	                    <tr>
	                      <td><?php echo e(date('d-m-Y', strtotime($return->created_at->toDateString()))); ?></td>
	                      <td><?php echo e($return->reference_no); ?></td>
	                      <td><?php echo e($customer->name); ?></td>
	                      <td><?php echo e($return->grand_total); ?></td>
	                    </tr>
	                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                  </tbody>
	                </table>
	              </div>
	          </div>
	          <div role="tabpanel" class="tab-pane fade" id="payment-latest">
	              <div class="table-responsive">
	                <table class="table table-striped">
	                  <thead>
	                    <tr>
	                      <th><?php echo e(trans('file.Date')); ?></th>
	                      <th><?php echo e(trans('file.Reference')); ?></th>
	                      <th><?php echo e(trans('file.Amount')); ?></th>
	                      <th><?php echo e(trans('file.Paid')); ?> <?php echo e(trans('file.By')); ?></th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                    <?php $__currentLoopData = $recent_payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                    <tr>
	                      <td><?php echo e(date('d-m-Y', strtotime($payment->created_at->toDateString()))); ?></td>
	                      <td><?php echo e($payment->reference_no); ?></td>
	                      <td><?php echo e($payment->amount); ?></td>
	                      <td><?php echo e($payment->payment_method); ?></td>
	                    </tr>
	                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                  </tbody>
	                </table>
	              </div>
	          </div>
	        </div>
	      </div>
	    </div>
	    <div class="col-md-5">
	      <div class="card">
	        <div class="card-header d-flex justify-content-between align-items-center">
	          <h4><?php echo e(trans('file.Best Seller').' '.date('F')); ?></h4>
	          <div class="right-column">
	            <div class="badge badge-primary"><?php echo e(trans('file.top')); ?> 5</div>
	          </div>
	        </div>
	        <div class="table-responsive">
	            <table class="table table-striped">
	              <thead>
	                <tr>
	                  <th>SL No</th>
	                  <th><?php echo e(trans('file.Product Details')); ?></th>
	                  <th><?php echo e(trans('file.Qty')); ?></th>
	                </tr>
	              </thead>
	              <tbody>
	                <?php $__currentLoopData = $best_selling_qty; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                <?php $product = DB::table('products')->find($sale->product_id); ?>
	                <tr>
	                  <td><?php echo e($key + 1); ?></td>
	                  <td><?php echo e($product->name); ?><br>[<?php echo e($product->model_no); ?>]</td>
	                  <td><?php echo e($sale->sold_qty); ?></td>
	                </tr>
	                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	              </tbody>
	            </table>
	          </div>
	      </div>
	    </div>
	    <div class="col-md-6">
	      <div class="card">
	        <div class="card-header d-flex justify-content-between align-items-center">
	          <h4><?php echo e(trans('file.Best Seller').' '.date('Y'). '('.trans('file.Qty').')'); ?></h4>
	          <div class="right-column">
	            <div class="badge badge-primary">Top 5</div>
	          </div>
	        </div>
	        <div class="table-responsive">
	            <table class="table table-striped">
	              <thead>
	                <tr>
	                  <th>SL No</th>
	                  <th><?php echo e(trans('file.Product Details')); ?></th>
	                  <th><?php echo e(trans('file.Qty')); ?></th>
	                </tr>
	              </thead>
	              <tbody>
	                <?php $__currentLoopData = $yearly_best_selling_qty; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                <?php $product = DB::table('products')->find($sale->product_id); ?>
	                <tr>
	                  <td><?php echo e($key + 1); ?></td>
	                  <td><?php echo e($product->name); ?><br>[<?php echo e($product->model_no); ?>]</td>
	                  <td><?php echo e($sale->sold_qty); ?></td>
	                </tr>
	                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	              </tbody>
	            </table>
	          </div>
	      </div>
	    </div>
	    <div class="col-md-6">
	      <div class="card">
	        <div class="card-header d-flex justify-content-between align-items-center">
	          <h4><?php echo e(trans('file.Best Seller').' '.date('Y') . '('.trans('file.Price').')'); ?></h4>
	          <div class="right-column">
	            <div class="badge badge-primary">Top 5</div>
	          </div>
	        </div>
	        <div class="table-responsive">
	            <table class="table table-striped">
	              <thead>
	                <tr>
	                  <th>SL No</th>
	                  <th><?php echo e(trans('file.Product Details')); ?></th>
	                  <th><?php echo e(trans('file.Grand Total')); ?></th>
	                </tr>
	              </thead>
	              <tbody>
	                <?php $__currentLoopData = $yearly_best_selling_price; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                <?php $product = DB::table('products')->find($sale->product_id); ?>
	                <tr>
	                  <td><?php echo e($key + 1); ?></td>
	                  <td><?php echo e($product->name); ?><br>[<?php echo e($product->model_no); ?>]</td>
	                  <td><?php echo e(number_format((float)$sale->total_price, 2, '.', '')); ?></td>
	                </tr>
	                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	              </tbody>
	            </table>
	          </div>
	      </div>
	    </div>
	  </div>
	</div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>