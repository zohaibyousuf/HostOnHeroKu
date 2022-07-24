@extends('layout.main') @section('content')

<section>
	<h4 class="text-center">{{trans('file.Product')}} {{trans('file.Quantity')}} {{trans('file.Alert')}}</h4>
	<div class="table-responsive">
        <table id="report-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Image')}}</th>
                    <th>{{trans('file.Product')}} {{trans('file.Name')}}</th>
                    <th>{{trans('file.Product')}} {{trans('file.Code')}}</th>
                    <th>{{trans('file.Quantity')}}</th>
                    <th>{{trans('file.Alert')}} {{trans('file.Quantity')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lsms_product_data as $key=>$product)
                <tr>
                    <td>{{$key}}</td>
                    <td>
                    @if($product->image) 
                        <img src="{{url('public/product/images',$product->image)}}" height="80" width="80">
                    @else
                        No Image
                    @endif
                    </td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->model_no}}</td>
                    <td>{{number_format((float)($product->qty), 2, '.', '')}}</td>
                    <td>{{number_format((float)($product->alert_qty), 2, '.', '')}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<script type="text/javascript">

    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(3).addClass("active");

    $('#report-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 1]
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

</script>
@endsection