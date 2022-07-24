@extends('layout.main')
@section('content')
@if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
@if(session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif

<!-- Counts Section -->
<section class="dashboard-counts">
	<div class="container-fluid">
	  <div class="row">
	    <!-- Count item widget-->
	    <div class="col-md-4 form-group">
	      <div class="wrapper count-title d-flex">
	        <div class="icon"><i class="ion-cash"></i></div>
	        <div class="name">{{ trans('file.revenue') }}
	          <div class="count-number revenue-data">{{number_format((float)$revenue, 2, '.', '')}}</div>
	          <span>{{date('F Y')}}</span>
	        </div>
	      </div>
	    </div>
	    <!-- Count item widget-->
	    <div class="col-md-4 form-group">
	      <div class="wrapper count-title d-flex">
	        <div class="icon"><i class="ion-bag"></i></div>
	        <div class="name">{{trans('file.Purchase')}}
	          <div class="count-number purchase-data">{{number_format((float)$purchase, 2, '.', '')}}</div>
	          <span>{{date('F Y')}}</span>
	        </div>
	      </div>
	    </div>
	    <!-- Count item widget-->
	    <div class="col-md-4 form-group">
	      <div class="wrapper count-title d-flex">
	        <div class="icon"><i class="ion-connection-bars"></i></div>
	        <div class="name">{{trans('file.profit')}}
	          <div class="count-number profit-data">{{number_format((float)$profit, 2, '.', '')}}</div>
	          <span>{{date('F Y')}}</span>
	        </div>
	      </div>
	    </div>
	    <!-- Count item widget-->
	    <div class="col-md-4 form-group">
	      <div class="wrapper count-title d-flex">
	        <div class="icon"><i class="ion-cube"></i></div>
	        <div class="name">{{trans('file.Sale')}}
	          <div class="count-number sale-data">{{number_format((float)$sale, 2, '.', '')}}</div>
	          <span>{{date('F Y')}}</span>
	        </div>
	      </div>
	    </div>
	    <!-- Count item widget-->
	    <div class="col-md-4 form-group">
	      <div class="wrapper count-title d-flex">
	        <div class="icon"><i class="ion-arrow-return-left"></i></div>
	        <div class="name">{{trans('file.Return')}}
	          <div class="count-number return-data">{{number_format((float)$return, 2, '.', '')}}</div>
	          <span>{{date('F Y')}}</span>
	        </div>
	      </div>
	    </div>
	    <!-- Count item widget-->
	    <div class="col-md-4 form-group">
	      <div class="wrapper count-title d-flex">
	        <div class="icon"><i class="fa fa-shopping-cart"></i></div>
	        <div class="name">{{trans('file.Sale')}} Qty
	          <div class="count-number sale-data">{{$sold_qty}}</div>
	          <span>{{date('F Y')}}</span>
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
	          <h4>{{trans('file.yearly report')}}</h4>
	        </div>
	        <div class="card-body">
	          <canvas id="saleChart" data-sale_chart_value = "{{json_encode($yearly_sale_amount)}}" data-purchase_chart_value = "{{json_encode($yearly_purchase_amount)}}"></canvas>
	        </div>
	      </div>
	    </div>
	    <div class="col-md-7">
	      <div class="card">
	        <div class="card-header d-flex justify-content-between align-items-center">
	          <h4>{{trans('file.Recent Transaction')}}</h4>
	          <div class="right-column">
	            <div class="badge badge-primary">{{trans('file.latest')}} 5</div>
	          </div>
	        </div>
	        <ul class="nav nav-tabs" role="tablist">
	          <li class="nav-item">
	            <a class="nav-link active" href="#sale-latest" role="tab" data-toggle="tab">{{trans('file.Sale')}}</a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link" href="#purchase-latest" role="tab" data-toggle="tab">{{trans('file.Purchase')}}</a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link" href="#return-latest" role="tab" data-toggle="tab">{{trans('file.Return')}}</a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link" href="#payment-latest" role="tab" data-toggle="tab">{{trans('file.Payment')}}</a>
	          </li>
	        </ul>

	        <div class="tab-content">
	          <div role="tabpanel" class="tab-pane fade show active" id="sale-latest">
	              <div class="table-responsive">
	                <table class="table table-striped">
	                  <thead>
	                    <tr>
	                      <th>{{trans('file.Date')}}</th>
	                      <th>{{trans('file.Reference')}}</th>
	                      <th>{{trans('file.Customer')}}</th>
	                      <th>{{trans('file.Payment')}} {{trans('file.Status')}}</th>
	                      <th>{{trans('file.Grand Total')}}</th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                    @foreach($recent_sale as $sale)
	                    <?php $customer = DB::table('customers')->find($sale->customer_id); ?>
	                    <tr>
	                      <td>{{ date('d-m-Y', strtotime($sale->created_at->toDateString())) }}</td>
	                      <td>{{$sale->reference_no}}</td>
	                      <td>{{$customer->name}}</td>
	                      @if($sale->payment_status == 'Paid')
	                      <td><div class="badge badge-success">Paid</div></td>
	                      @else
	                      <td><div class="badge badge-danger">Due</div></td>
	                      @endif
	                      <td>{{$sale->grand_total}}</td>
	                    </tr>
	                    @endforeach
	                  </tbody>
	                </table>
	              </div>
	          </div>
	          <div role="tabpanel" class="tab-pane fade" id="purchase-latest">
	              <div class="table-responsive">
	                <table class="table table-striped">
	                  <thead>
	                    <tr>
	                      <th>{{trans('file.Date')}}</th>
	                      <th>{{trans('file.Reference')}}</th>
	                      <th>{{trans('file.Supplier')}}</th>
	                      <th>{{trans('file.Grand Total')}}</th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                    @foreach($recent_purchase as $purchase)
	                    <tr>
	                      <td>{{date('d-m-Y', strtotime($purchase->created_at->toDateString())) }}</td>
	                      <td>{{$purchase->reference_no}}</td>
	                      @if($purchase->supplier)
	                        <td>{{$purchase->supplier}}</td>
	                      @else
	                        <td>N/A</td>
	                      @endif
	                      <td>{{$purchase->grand_total}}</td>
	                    </tr>
	                    @endforeach
	                  </tbody>
	                </table>
	              </div>
	          </div>
	          <div role="tabpanel" class="tab-pane fade" id="return-latest">
	              <div class="table-responsive">
	                <table class="table table-striped">
	                  <thead>
	                    <tr>
	                      <th>{{trans('file.Date')}}</th>
	                      <th>{{trans('file.Reference')}}</th>
	                      <th>{{trans('file.Customer')}}</th>
	                      <th>{{trans('file.Grand Total')}}</th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                    @foreach($recent_return as $return)
	                    <?php $customer = DB::table('customers')->find($return->customer_id); ?>
	                    <tr>
	                      <td>{{date('d-m-Y', strtotime($return->created_at->toDateString())) }}</td>
	                      <td>{{$return->reference_no}}</td>
	                      <td>{{$customer->name}}</td>
	                      <td>{{$return->grand_total}}</td>
	                    </tr>
	                    @endforeach
	                  </tbody>
	                </table>
	              </div>
	          </div>
	          <div role="tabpanel" class="tab-pane fade" id="payment-latest">
	              <div class="table-responsive">
	                <table class="table table-striped">
	                  <thead>
	                    <tr>
	                      <th>{{trans('file.Date')}}</th>
	                      <th>{{trans('file.Reference')}}</th>
	                      <th>{{trans('file.Amount')}}</th>
	                      <th>{{trans('file.Paid')}} {{trans('file.By')}}</th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                    @foreach($recent_payment as $payment)
	                    <tr>
	                      <td>{{date('d-m-Y', strtotime($payment->created_at->toDateString())) }}</td>
	                      <td>{{$payment->reference_no}}</td>
	                      <td>{{$payment->amount}}</td>
	                      <td>{{$payment->payment_method}}</td>
	                    </tr>
	                    @endforeach
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
	          <h4>{{trans('file.Best Seller').' '.date('F')}}</h4>
	          <div class="right-column">
	            <div class="badge badge-primary">{{trans('file.top')}} 5</div>
	          </div>
	        </div>
	        <div class="table-responsive">
	            <table class="table table-striped">
	              <thead>
	                <tr>
	                  <th>SL No</th>
	                  <th>{{trans('file.Product Details')}}</th>
	                  <th>{{trans('file.Qty')}}</th>
	                </tr>
	              </thead>
	              <tbody>
	                @foreach($best_selling_qty as $key=>$sale)
	                <?php $product = DB::table('products')->find($sale->product_id); ?>
	                <tr>
	                  <td>{{$key + 1}}</td>
	                  <td>{{$product->name}}<br>[{{$product->model_no}}]</td>
	                  <td>{{$sale->sold_qty}}</td>
	                </tr>
	                @endforeach
	              </tbody>
	            </table>
	          </div>
	      </div>
	    </div>
	    <div class="col-md-6">
	      <div class="card">
	        <div class="card-header d-flex justify-content-between align-items-center">
	          <h4>{{trans('file.Best Seller').' '.date('Y'). '('.trans('file.Qty').')'}}</h4>
	          <div class="right-column">
	            <div class="badge badge-primary">Top 5</div>
	          </div>
	        </div>
	        <div class="table-responsive">
	            <table class="table table-striped">
	              <thead>
	                <tr>
	                  <th>SL No</th>
	                  <th>{{trans('file.Product Details')}}</th>
	                  <th>{{trans('file.Qty')}}</th>
	                </tr>
	              </thead>
	              <tbody>
	                @foreach($yearly_best_selling_qty as $key => $sale)
	                <?php $product = DB::table('products')->find($sale->product_id); ?>
	                <tr>
	                  <td>{{$key + 1}}</td>
	                  <td>{{$product->name}}<br>[{{$product->model_no}}]</td>
	                  <td>{{$sale->sold_qty}}</td>
	                </tr>
	                @endforeach
	              </tbody>
	            </table>
	          </div>
	      </div>
	    </div>
	    <div class="col-md-6">
	      <div class="card">
	        <div class="card-header d-flex justify-content-between align-items-center">
	          <h4>{{trans('file.Best Seller').' '.date('Y') . '('.trans('file.Price').')'}}</h4>
	          <div class="right-column">
	            <div class="badge badge-primary">Top 5</div>
	          </div>
	        </div>
	        <div class="table-responsive">
	            <table class="table table-striped">
	              <thead>
	                <tr>
	                  <th>SL No</th>
	                  <th>{{trans('file.Product Details')}}</th>
	                  <th>{{trans('file.Grand Total')}}</th>
	                </tr>
	              </thead>
	              <tbody>
	                @foreach($yearly_best_selling_price as $key => $sale)
	                <?php $product = DB::table('products')->find($sale->product_id); ?>
	                <tr>
	                  <td>{{$key + 1}}</td>
	                  <td>{{$product->name}}<br>[{{$product->model_no}}]</td>
	                  <td>{{number_format((float)$sale->total_price, 2, '.', '')}}</td>
	                </tr>
	                @endforeach
	              </tbody>
	            </table>
	          </div>
	      </div>
	    </div>
	  </div>
	</div>
</section>
@endsection
