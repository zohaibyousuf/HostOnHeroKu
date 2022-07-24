@extends('layout.main') @section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
            <h4 class="text-center mt-3">{{trans('file.Best Seller')}} {{trans('file.From')}} {{$start_month.' - '.date("F Y")}}</h4>
            <div class="card-body">
              <canvas id="bestSeller" data-product = "{{json_encode($product)}}" data-sold_qty="{{json_encode($sold_qty)}}" ></canvas>
            </div>
        </div>
	</div>
</div>

<script type="text/javascript">
	$("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(1).addClass("active");
</script>
@endsection