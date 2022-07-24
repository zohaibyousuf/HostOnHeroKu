@extends('layout.main')
@section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Group Permission')}}</h4>
                    </div>
                    {!! Form::open(['route' => 'role.setPermission', 'method' => 'post']) !!}
                    <div class="card-body">
                    	<input type="hidden" name="role_id" value="{{$lsms_role_data->id}}" />
						<div class="table-responsive">
						    <table class="table table-bordered table-hover table-striped reports-table">
						        <thead>
						        <tr>
						            <th colspan="5" class="text-center">{{$lsms_role_data->name}} {{trans('file.Group Permission')}}</th>
						        </tr>
						        <tr>
						            <th rowspan="2" class="text-center">Module Name 
						            </th>
						            <th colspan="4" class="text-center">{{trans('file.Permissions')}}&nbsp;&nbsp; <input type="checkbox" id="select_all" class="checkbox"></th>
						        </tr>
						        <tr>
						            <th class="text-center">{{trans('file.View')}}</th>
						            <th class="text-center">{{trans('file.Add')}}</th>
						            <th class="text-center">{{trans('file.Edit')}}</th>
						            <th class="text-center">{{trans('file.Delete')}}</th>
						        </tr>
						        </thead>
						        <tbody>
						        <tr>
						            <td>{{trans('file.Product')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("products-index", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="products-index" checked />
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="products-index" />
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("products-add", $all_permission))
						               	<input type="checkbox" value="1" class="checkbox" name="products-add" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="products-add">
						                @endif
						                </div>

						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("products-edit", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="products-edit" checked />
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="products-edit" />
						                @endif
						                </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("products-delete", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="products-delete" checked />
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="products-delete" />
						                @endif
						                </div>
						            </td>
						        </tr>

						        <tr>
						            <td>{{trans('file.Purchase')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("purchases-index", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="purchases-index" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="purchases-index">
						                @endif
						                </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("purchases-add", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="purchases-add" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="purchases-add">
						                @endif
						                </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("purchases-edit", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="purchases-edit" checked />
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="purchases-edit">
						                @endif
						                </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("purchases-delete", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="purchases-delete" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="purchases-delete">
						                @endif
						            	</div>
						            </td>
						        </tr>

						        <tr>
						            <td>{{trans('file.Sale')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("sales-index", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="sales-index" checked />
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="sales-index">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("sales-add", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="sales-add" checked />
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="sales-add">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("sales-edit", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="sales-edit" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="sales-edit">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("sales-delete", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="sales-delete" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="sales-delete">
						                @endif
						            	</div>
						            </td>
						        </tr>

						        <tr>
						            <td>{{trans('file.Return')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("returns-index", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="returns-index" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="returns-index">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("returns-add", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="returns-add" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="returns-add">
						                @endif
						                </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("returns-edit", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="returns-edit" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="returns-edit">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("returns-delete", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="returns-delete" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="returns-delete">
						                @endif
						            	</div>
						            </td>
						        </tr>
						        <tr>
						            <td>{{trans('file.User')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("users-index", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="users-index" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="users-index">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("users-add", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="users-add" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="users-add">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("users-edit", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="users-edit" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="users-edit">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("users-delete", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="users-delete" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="users-delete">
						                @endif
						            	</div>
						            </td>
						        </tr>
						        <tr>
						            <td>{{trans('file.Customer')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("customers-index", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="customers-index" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="customers-index">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("customers-add", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="customers-add" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="customers-add">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("customers-edit", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="customers-edit" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="customers-edit">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("customers-delete", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="customers-delete" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="customers-delete">
						                @endif
						            	</div>
						            </td>
						        </tr>
						        <tr>
						            <td>{{trans('file.Report')}}s</td>
						            <td colspan="5">
						            	<span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("profit-loss", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="profit-loss" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="profit-loss">
					                    	@endif
						                    </div>
						                    <label for="profit-loss" class="padding05">{{trans('file.profit')}}/{{trans('file.Loss')}} &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("best-seller", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="best-seller" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="best-seller">
					                    	@endif
						                    </div>
						                    <label for="best-seller" class="padding05">{{trans('file.Best Seller')}} &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("product-report", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="product-report" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="product-report">
					                    	@endif
						                    </div>
						                    <label for="product-report" class="padding05">{{trans('file.Product')}} {{trans('file.Report')}} &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("purchase-report", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="purchase-report" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="purchase-report">
					                    	@endif
						                    </div>
						                    <label for="purchase-report" class="padding05"> {{trans('file.Purchase')}} {{trans('file.Report')}} &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("sale-report", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="sale-report" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="sale-report">
					                    	@endif
						                    </div>
						                    <label for="sale-report" class="padding05">{{trans('file.Sale')}} {{trans('file.Report')}} &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("product-qty-alert", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="product-qty-alert" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="product-qty-alert">
					                    	@endif
						                    </div>
						                    <label for="product-qty-alert" class="padding05">{{trans('file.Product')}} {{trans('file.Quantity')}} {{trans('file.Alert')}} &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("customer-report", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="customer-report" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="customer-report">
					                    	@endif
						                    </div>
						                    <label for="customer-report" class="padding05">{{trans('file.Customer')}} {{trans('file.Report')}} &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("due-report", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="due-report" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="due-report">
					                    	@endif
						                    </div>
						                    <label for="due-report" class="padding05">{{trans('file.Due')}} {{trans('file.Report')}} &nbsp;&nbsp;</label>
						                </span>
						            </td>
						        </tr>
						        </tbody>
						    </table>
						</div>
						<div class="form-group">
	                        <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
	                    </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

	$("#select_all").on( "change", function() {
	    if ($(this).is(':checked')) {
	        $("tbody input[type='checkbox']").prop('checked', true);
	    } 
	    else {
	        $("tbody input[type='checkbox']").prop('checked', false);
	    }
	});
</script>
@endsection