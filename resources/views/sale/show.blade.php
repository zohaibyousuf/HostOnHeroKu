@if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<!DOCTYPE html>
<html>
<head>
	<title>{{trans('file.Invoice')}}-{{$settings->site_title}}</title>
<style type="text/css">
	h1 {
		color: #7c5cc4;
	}
	#print-btn {
        font-weight: 400;
        border: 1px solid transparent;
        padding: 0.55rem 0.75rem;
        font-size: 0.9rem;
        line-height: 1.5;
        border-radius: 0;
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: #fff;
	}
	#sale-list {
        font-weight: 400;
        border: 1px solid transparent;
        padding: 0.55rem 0.75rem;
        font-size: 0.9rem;
        line-height: 1.5;
        border-radius: 0;
        background-color: #7c5cc4;
        border-color: #7c5cc4;
        color: #fff;
        text-decoration: none;
	}
	@media print {
    #print-btn { display: none }
    #sale-list { display: none }
    .printarea { -webkit-print-color-adjust: exact }
    table.listthead { page-break-inside:auto }
    table.listthead tr { page-break-inside:avoid; page-break-after:auto }
    table.listthead thead { display:table-header-group }
    table.listthead tfoot { display:table-footer-group }
}
</style>
</head>
<body>
	<button type="button" id="print-btn">{{trans('file.Print')}}</button>&nbsp;&nbsp;
	<a id="sale-list" href="{{route('sales.index')}}">{{trans('file.Go To')}} {{trans('file.Sale')}} {{trans('file.List')}}</a>
<div style="margin: 75px 50px; font-family: arial">
	<table style="width: 100%" cellpadding="5px">
		<tr>
			<td style="width: 50%">
				<h2>{{$lsms_user_data->company_name}}</h2>
				<span>{{$lsms_user_data->address}}</span><br>
				<span>{{$lsms_user_data->phone}}</span><br>
			</td>
			<td style="width: 50%">
				<h1>{{trans('file.Invoice')}}</h1>
				<table style="width: 100%" cellpadding="5px" cellspacing="0">
					<tr style="background-color: #8cc98d">
						<td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">{{trans('file.Invoice')}} No.</td>
						<td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">{{trans('file.Date')}}</td>
						<td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">{{trans('file.Payment')}} {{trans('file.Mode')}}</td>
					</tr>
					<tr>
						<td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">{{$lsms_sale_data->reference_no}}</td>
						<td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">{{ date_format($lsms_sale_data->created_at,"d-m-Y") }}</td>
						<td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">{{$lsms_sale_data->payment_status}}</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr style="height: 30px"><td></td><td></td></tr>
		<tr>
			<td style="background-color: #8cc98d; width: 50%">
				<strong>{{trans('file.Bill')}} {{trans('file.To')}}</strong>
			</td>
			<td style="width: 50%"></td>
		</tr>
		<tr>			
			<td style="width: 50%">
				<span>{{$lsms_customer_data->name}}</span><br>
				<span>{{$lsms_customer_data->company_name}}</span><br>
				<span>{{$lsms_customer_data->address}}</span><br>
				<span>{{$lsms_customer_data->phone}}</span><br>
			</td>
			<td style="width: 50%"></td>
		</tr>
		<tr style="height: 30px"><td></td><td></td></tr>
	</table>
	<table style="width: 100%" cellpadding="5px" cellspacing="0">
		<tr style="background-color: #8cc98d;">
			<td style="width: 10%; border: 1px solid rgba(0,0,0,0.3)"><strong>Sl No</strong></td>
			<td style="width: 50%; border: 1px solid rgba(0,0,0,0.3)"><strong>{{trans('file.Product')}} {{trans('file.Name')}}</strong></td>
			<td style="width: 10%; text-align: center; border: 1px solid rgba(0,0,0,0.3)"><strong>{{trans('file.Quantity')}}</strong></td>
			<td style="width: 15%; text-align: center; border: 1px solid rgba(0,0,0,0.3)"><strong>{{trans('file.Unit')}} {{trans('file.Price')}}</strong></td>
			<td style="width: 15%; text-align: center; border: 1px solid rgba(0,0,0,0.3)"><strong>{{trans('file.Total')}}</strong></td>
		</tr>
		
		<!-- LOOP START -->
		@foreach($lsms_product_sale_data as $key=>$product_sale_data)
		<tr>
			<td style="width: 10%; border: 1px solid rgba(0,0,0,0.3)">{{$key + 1}}</td>
			<?php 
				$product = DB::table('products')->find($product_sale_data->product_id);
			?>
			<td style="width: 50%; border: 1px solid rgba(0,0,0,0.3)">{{$product->name}}</td>
			@if($product_sale_data->unit)
				<td style="width: 10%; text-align: center; border: 1px solid rgba(0,0,0,0.3)">{{$product_sale_data->qty}} {{$product_sale_data->unit}}</td>
			@else
			<td style="width: 10%; text-align: center; border: 1px solid rgba(0,0,0,0.3)">{{$product_sale_data->qty}}</td>
			@endif
			<td style="width: 15%; text-align: center; border: 1px solid rgba(0,0,0,0.3)">{{$product_sale_data->product_price}}</td>
			<td style="width: 15%; text-align: center; border: 1px solid rgba(0,0,0,0.3)">{{$product_sale_data->total}}</td>
		</tr>
		@endforeach
		<!-- LOOP END -->
		
		<tr>
			<td colspan="2" style="width: 60%; border: 1px solid rgba(0,0,0,0.3)"><strong>{{trans('file.Grand Total')}}</strong></td>
			<td style="width: 10%; text-align: center; border: 1px solid rgba(0,0,0,0.3)"><strong>{{$lsms_sale_data->total_qty}}</strong></td>
			<td colspan="2" style="width: 30%; text-align: center; border: 1px solid rgba(0,0,0,0.3)"><strong>{{$lsms_sale_data->grand_total}}</strong></td>
		</tr>
		<tr>
			<td colspan="5" style="width: 100%; text-align: center; border: 1px solid rgba(0,0,0,0.3)"><strong>{{trans('file.In Words')}}: <span style="text-transform: uppercase">{{$settings->currency}}</span> <span style="text-transform: capitalize">{{str_replace("-"," ",$numberInWords)}}</span></strong></td>
		</tr>
		<tr style="height: 30px"><td colspan="5"></td></tr>
		<tr><td colspan="5"><strong>{{trans('file.Note')}}:</strong> {{$lsms_sale_data->note}}</td></tr>
	</table>
	<table style="width: 100%;">
		<tr style="height: 75px"><td></td><td></td></tr>
		<td>
			<tr>			
				<td style="width: 30%; text-align: center; border-top: 1px solid rgba(0,0,0,0.7)">
					{{trans('file.Stamp')}} & {{trans('file.Signature')}}
				</td>
				<td style="width: 70%"></td>
			</tr>
		</td>
		<tr style="height: 30px"><td></td><td></td></tr>
		<tr>
			<td colspan="2"style="width: 100%; text-align: center; border-top: 1px solid rgba(0,0,0,0.3); font-size: 12px;padding-top:15px">
				{{trans('file.Invoice')}} {{trans('file.Generate')}} {{trans('file.By')}} <strong>{{$settings->site_title}}</strong>.
				Powered by <a style="text-decoration: none; color: #60bf62;" href="http://lion-coders.com"><strong>LionCoders</strong></a>
			</td>
		</tr>
	</table>
</div>
<script type="text/javascript" src="<?php echo asset('public/vendor/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript">

	$('#print-btn').on('click', function(){
		window.print();
	});
</script>
</body>
</html>
