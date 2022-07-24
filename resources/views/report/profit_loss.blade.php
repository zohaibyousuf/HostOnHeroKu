@extends('layout.main')
@section('content')
<section>
	<h3 class="text-center">{{trans('file.profit')}} {{trans('file.Or')}} {{trans('file.Loss')}}</h3>
	{!! Form::open(['route' => 'report.profitLoss', 'method' => 'post']) !!}
	<div class="col-md-6 offset-md-3 mt-4">
        <div class="form-group row">
            <label class="d-tc mt-2"><strong>{{trans('file.Choose Your Date')}}</strong> &nbsp;</label>
            <div class="d-tc">
                <div class="input-group">
                    <input type="text" class="daterangepicker-field form-control" placeholder="{{$start_date}} To {{$end_date}}" required/>
                    <input type="hidden" name="start_date" />
                    <input type="hidden" name="end_date" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">{{trans('file.Submit')}}</button>
                    </div>
                </div>
            </div>
        </div> 
    </div>
	{{Form::close()}}
	<div class="container-fluid">
		<div class="row mt-4">
			<div class="col-md-4">
				<div class="colored-box purple-bg">
					<i class="fa fa-heart"></i>
					<p>{{trans('file.Purchase')}}s</p>
					<h3 class="text-center">{{number_format((float)$purchase[0]->grand_total, 2, '.', '') }}</h3>
					<p class="text-center">
						{{$total_purchase}} {{trans('file.Purchase')}}s<br>
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="colored-box orange-bg">
					<i class="fa fa-shopping-cart"></i>
					<p>{{trans('file.Sale')}}s</p>
					<h3 class="text-center">{{number_format((float)$sale[0]->grand_total, 2, '.', '') }}</h3>
					<p class="text-center">
						{{$total_sale}} {{trans('file.Sale')}}s<br>
						{{trans('file.Paid')}} {{number_format((float)$sale[0]->paid_amount, 2, '.', '')}}<br>
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="colored-box green-bg">
					<i class="fa fa-random "></i>
					<p>{{trans('file.Return')}}s</p>
					<h3 class="text-center">{{number_format((float)$return[0]->grand_total, 2, '.', '') }}</h3>
					<p class="text-center">
						{{$total_return}} {{trans('file.Return')}}s<br>
					</p>
				</div>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-12">
				<div class="colored-box blue-bg">
					<i class="fa fa-dollar"></i>
					<p>{{trans('file.Payment')}} {{trans('file.Recieved')}}</p>
					<h3 class="text-center">{{number_format((float)$total_payment, 2, '.', '') }}</h3>
					<p class="text-center">
						{{$payment_recieved}} {{trans('file.Recieved')}}<br>
						Cash: {{number_format((float)$cash_payment_sale, 2, '.', '')}}, Cheque: {{number_format((float)$cheque_payment_sale, 2, '.', '')}}
					</p>
				</div>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-6">
				<div class="colored-box orange-bg">
					<i class="fa fa-money"></i>
					<p>{{trans('file.profit')}} / {{trans('file.Loss')}}</p>
					<h3 class="text-center">{{number_format((float)($sale[0]->grand_total - $purchase[0]->grand_total), 2, '.', '') }}</h3>
					<p class="text-center">
						{{number_format((float)$sale[0]->grand_total, 2, '.', '') }} {{trans('file.Sale')}}s - {{number_format((float)$purchase[0]->grand_total, 2, '.', '') }} {{trans('file.Purchase')}}s
					</p>
				</div>
			</div>
			<div class="col-md-6">
				<div class="colored-box light-blue-bg">
					<i class="fa fa-money"></i>
					<p>{{trans('file.profit')}} / {{trans('file.Loss')}}</p>
					<h3 class="text-center">{{number_format((float)($sale[0]->grand_total - $purchase[0]->grand_total - $return[0]->grand_total), 2, '.', '') }}</h3>
					<p class="text-center">
						{{number_format((float)$sale[0]->grand_total, 2, '.', '') }} {{trans('file.Sale')}}s - {{number_format((float)$purchase[0]->grand_total, 2, '.', '') }} {{trans('file.Purchase')}}s - {{number_format((float)$return[0]->grand_total, 2, '.', '') }} {{trans('file.Return')}}s
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	$("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(0).addClass("active");

	$(".daterangepicker-field").daterangepicker({
	  callback: function(startDate, endDate, period){
	    var start_date = startDate.format('YYYY-MM-DD');
	    var end_date = endDate.format('YYYY-MM-DD');
	    var title = start_date + ' to ' + end_date;
	    $(this).val(title);
	    $('input[name="start_date"]').val(start_date);
	    $('input[name="end_date"]').val(end_date);
	  }
	});
</script>
@endsection