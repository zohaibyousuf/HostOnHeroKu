@extends('layout.main') @section('content')
@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section>
    <div class="container-fluid">
    	<div class="input-group">
          <div class="input-group-prepend">
                @if(in_array("products-add", $all_permission))
                <a href="{{route('products.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> {{trans('file.Add')}} {{trans('file.Product')}}</a>
                &nbsp;&nbsp;
                <a href="#" data-toggle="modal" data-target="#importProduct" class="btn btn-primary"><i class="fa fa-file"></i> {{trans('file.Import')}} {{trans('file.Product')}}</a>
                @endif
          </div>    
        </div>
    </div>

    <table id="product-table" class="table table-striped">
        <thead>
            <tr>
                <th class="not-exported"></th>
                <th>{{trans('file.Image')}}</th>
                <th>{{trans('file.Name')}}</th>
                <th>{{trans('file.Brand')}}</th>
                <th>{{trans('file.Category')}}</th>
                <th>{{trans('file.Code')}}</th>
                <th>{{trans('file.Price')}}</th>
                <th>{{trans('file.Quantity')}}</th>
                <th>{{trans('file.Alert')}} {{trans('file.Quantity')}}</th>
                <th class="not-exported">{{trans('file.Action')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lsms_product_all as $key => $product)
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
            <tr class="product-link" data-product='[ "{{$product_name}}", "{{$product->model_no}}", "{{$product->brand}}", "{{$category->name}}", "{{$product->price}}", "{{$product->qty}}", "{{$product->alert_qty}}","{{$product->product_details}}", "{{$product->unit}}"]' data-imagedata ="{{DNS1D::getBarcodePNG($product->model_no, $product->barcode_symbology)}}">
                <td>{{$key}}</td>
                @if($product->image)
                <td> <img src="{{url('public/product/images',$product->image)}}" height="80" width="80">
                </td>
                @else
                <td>No Image</td>
                @endif
                <td>{{ $product->name }}</td>
                @if($product->brand)
                <td>{{ $product->brand }}</td>
                @else
                <td>N/A</td>
                @endif
                <td>{{ $category->name }}</td>
                @if($product->model_no)
                <td>{{ $product->model_no }}</td>
                @else
                <td>N/A</td>
                @endif
                <td>{{ $product->price}}</td>
                <td>{{ $product->qty}}</td>
                @if($product->alert_qty)
                <td>{{ $product->alert_qty}}</td>
                @else
                <td>N/A</td>
                @endif
                <td>
                    <div class="btn-group">
                        @if(in_array("products-edit", $all_permission))
                        <a class="btn btn-primary" href="{{ route('products.edit', ['id' => $product->id]) }}" title="{{trans('file.Edit')}}"><i class="fa fa-edit"></i></a>
                        @endif
                        @if(in_array("products-delete", $all_permission))
                        {{ Form::open(['route' => ['products.destroy', $product->id], 'method' => 'DELETE'] ) }}
                            <button type="submit" class="btn btn-danger" onclick="return confirmDelete()" title="{{trans('file.Delete')}}"> <i class="fa fa-times"></i></button>
                        {{ Form::close() }}
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div id="importProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            {!! Form::open(['route' => 'product.import', 'method' => 'post', 'files' => true]) !!}
            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Import')}} {{trans('file.Product')}}</h5>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <p class="italic">{{trans('file.The field labels marked with * are required input fields')}}.</p>
               <p>{{trans('file.The correct column order is')}} [name *, image (file name with extension like example.jpg), code *, barcode_symbology *, brand, category *, price *, unit, alert_qty, product_details] {{trans('file.and you must follow this')}}. {{trans('file.Every Product Code must be unique. To show Image you must put the image in the')}} public/product/image directory</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>{{trans('file.Upload CSV File')}} *</strong></label>
                            {{Form::file('file', array('class' => 'form-control','required'))}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong></strong></label><br>
                            <a href="public/sample_file/sample_products.csv" class="btn btn-primary btn-block"><i class="fa fa-download"></i> {{trans('file.Download Sample File')}}</a>
                        </div>
                    </div>
                </div>
                
                <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
            </div>
            {!! Form::close() !!}
          </div>
        </div>
    </div>

    <div id="product-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Product Details')}} &nbsp;&nbsp;</h5>
              <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="fa fa-print"></i> {{trans('file.Print')}}</button>
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
        htmltext = '</p><p><strong>{{trans("file.Name")}}: </strong>'+product[0]+'</p><p><strong>{{trans("file.Code")}}: </strong>'+product[1]+ '</p><strong>{{trans("file.Barcode")}}: </strong> <img src="data:image/png;base64,'+imagedata+'" alt="barcode" /></p><p><strong>{{trans("file.Brand")}}: </strong>'+product[2]+'</p><p><strong>{{trans("file.Category")}}: </strong>'+product[3]+
            '</p><p><strong>{{trans("file.Unit")}}: </strong>'+product[8]+
            '</p><p><strong>{{trans("file.Price")}}: </strong>'+product[4]+
            '</p><p><strong>{{trans("file.Quantity")}}: </strong>'+product[5]+
            '</p><p><strong>{{trans("file.Alert")}} {{trans("file.Quantity")}}: </strong>'+product[6]+'</p><p><strong>{{trans("file.Product Details")}}: </strong></p>'+product[7];

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
@endsection