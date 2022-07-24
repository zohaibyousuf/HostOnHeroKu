@extends('layout.main') @section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section class="forms">
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Print') .' '.trans('file.Barcode')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                    	<label><strong>{{trans('file.Add Product')}} *</strong></label>
                                        <div class="search-box input-group">
                                        	
                                            <button type="button" class="btn btn-secondary btn-lg"><i class="fa fa-barcode"></i></button>
                                            <input type="text" name="product_code_name" id="lsms_productcodeSearch" placeholder="Please type product code and select..." class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table id="myTable" class="table table-hover order-list">
                                                <thead>
                                                    <tr>
                                                        <th>{{trans('file.Name')}}</th>
                                                        <th>{{trans('file.Code')}}</th>
                                                        <th>{{trans('file.Quantity')}}</th>
                                                        <th><i class="fa fa-trash"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary" id="submit-button">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="print-barcode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
	    <div role="document" class="modal-dialog">
	        <div class="modal-content">
		        <div class="modal-header">
		          <h5 id="modal_header" class="modal-title">{{trans('file.Barcode')}}</h5>&nbsp;&nbsp;
		          <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="fa fa-print"></i> {{trans('file.Print')}}</button>
		          <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
		        </div>
		        <div class="modal-body">
	        		<div id="label-content">
	        		</div>
		        </div>
	        </div>
	    </div>
    </div>
</section>

<script type="text/javascript">

    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");
    $("ul#product li").eq(3).addClass("active");
	
	var lsms_product_code = [ @foreach($lsms_product_list as $product)
        <?php
            $productArray[] = $product->name.':'.$product->model_no;
        ?>
         @endforeach
            <?php
            echo  '"'.implode('","', $productArray).'"';
            ?> ];

    var lsms_productcodeSearch = $('#lsms_productcodeSearch');

    lsms_productcodeSearch.autocomplete({
    source: function(request, response) {
        var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
        response($.grep(lsms_product_code, function(item) {
            return matcher.test(item);
        }));
    },
    select: function(event, ui) {
        var data = ui.item.value;
        $.ajax({
            type: 'GET',
            url: 'lsms_product_search',
            data: {
                data: data
            },
            success: function(data) {
                //alert(data);
                var flag = 1;
                $(".product-code").each(function() {
                    if ($(this).text() == data[1]) {
                        alert('Duplicate input is not allowed!')
                        flag = 0;
                    }
                });
                $("input[name='product_code_name']").val('');
                if(flag){
                    var newRow = $('<tr data-imagedata="'+data[3]+'" data-price="'+data[2]+'">');
                    var cols = '';
                    cols += '<td>' + data[0] + '</td>';
                    cols += '<td class="product-code">' + data[1] + '</td>';
                    cols += '<td><input type="number" class="form-control qty" name="qty[]" value="1" /></td>';
                    cols += '<td><button type="button" class="ibtnDel btn btn-md btn-danger">Delete</button></td>';
                    newRow.append(cols);
                    $("table.order-list tbody").append(newRow);
                }
            }
        });
    }
});

	//Delete product
	$("table.order-list tbody").on("click", ".ibtnDel", function(event) {
	    rowindex = $(this).closest('tr').index();
	    $(this).closest("tr").remove();
	});

	$("#submit-button").on("click", function(event){
		var product_name = [];
		var code = [];
		var price = [];
		var qty = [];
		var barcode_image = [];
		var rownumber = $('table.order-list tbody tr:last').index();
		for(i = 0; i <= rownumber; i++){
			product_name.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('td:nth-child(1)').text());
			code.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('td:nth-child(2)').text());
			price.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').data('price'));
			qty.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.qty').val());
			barcode_image.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').data('imagedata'));
		}
		var htmltext = '<table class="barcodelist" style="width: 100%" cellpadding="5px" cellspacing="10px">';
		$.each(qty, function(index){
			i = 0;
			while(i < qty[index]){
                if(i % 2 == 0)
                    htmltext +='<tr>';
				htmltext +='<td>';
				htmltext += product_name[index] + '<br>';
				htmltext += '<img src="data:image/png;base64,'+barcode_image[index]+'" alt="barcode" /><br>';
				htmltext += '<strong>'+code[index]+'</strong><br>';
				htmltext += 'price: '+price[index];
				htmltext +='</td>';
                if(i % 2 != 0)
                    htmltext +='</tr>';
				i++;
			}
		});
        htmltext += '</table">';
		$('#label-content').html(htmltext);
		$('#print-barcode').modal('show');
	});

	$("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('print-barcode');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<style type="text/css">@media print { #modal_header { display: none } #print-btn { display: none } #close-btn { display: none } } table.barcodelist { page-break-inside:auto } table.barcodelist tr { page-break-inside:avoid; page-break-after:auto }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

</script>
@endsection