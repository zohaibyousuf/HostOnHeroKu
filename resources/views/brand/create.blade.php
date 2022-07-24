@extends('layout.main') @section('content')
<!-- Trigger the modal with a button -->


@if($errors->has('title'))
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('title') }}</div>
@endif 
@if($errors->has('image'))
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('image') }}</div>
@endif
@if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif

<div class="row">  
        <div class="col-md-4">
            <form action="{{ route('brand.search') }}" id="lims_brand_search"  method="get" name="lims_brand_search">
                @csrf          
                <div class="search-box input-group">
                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                <input class="form-control" type="text" name="lims_brandNameSearch" id="lims_brandNameSearch" placeholder="Type Brand name and click...">
                </div>
            </form>      
        </div>

        <div class="col-md-3" >
        <strong>Brand Options</strong>
        <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu dropdown-default pull-right" user="menu">
            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#createModal">Add Brand</button>
            <li class="divider"></li>
            <li>
                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#importBrand"> Import Brand</button>
            </li>
            <form action="{{ route('brand.export') }}" method="post">
                @csrf
                 
                <li>
                    <button type="submit" id="export" class="btn btn-link" data-toggle="modal"> Export Brand</button>
                </li>
        </ul>
        </div>
        <div class="col-md-4">
            <div class="btn-toolbar pull-right">
              <div class="btn-group">{{ $lims_brand_all->links() }}</div>
              
            </div>
        </div>
</div>
<!-- Modal -->
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select_all" value="-1">Export</th>
                    <th>Brand</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_brand_all as $brand)
                <tr>
                    <td>
                        <input type="checkbox" name="brand[]" value="{{$brand->id}}">
                    </td>
                    <td>{{ $brand->title }}</td>
                    @if($brand->image)
                    <td> <img src="{{url('images',$brand->image)}}" height="80" width="80">
                    </td>
                    @else
                    <td>No Image</td>
                    @endif
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default">Action</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-default pull-right" user="menu">
                                <button type="button" data-id="{{$brand->id}}" class="open-EditbrandDialog btn btn-link" data-toggle="modal" data-target="#editModal">Edit brand
                                </button>
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['brand.destroy', $brand->id], 'method' => 'DELETE'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"> Delete</button>
                                </li>
                                {{ Form::close() }}
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</form>
<div id="createModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            {!! Form::open(['route' => 'brand.store', 'method' => 'post', 'files' => true]) !!}
            <div class="row">
                <div class="col-md-12 panel">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h4>Add Brand</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="card-body">
                                <p>Please fill in the information below. The field labels marked with * are required input fields.</p>
                                <div class="form-group">
                                    <label><strong>Brand Title *</strong></label>
                                    {{Form::text('title',null,array('required' => 'required', 'class' => 'form-control'))}}
                                </div>
                                <div class="form-group">
                                    <label><strong>Brand Image</strong></label>
                                    {{Form::file('image', array('class' => 'form-control'))}}
                                </div>
                                <div class="form-group" id="operation_value"></div>
                                {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div id="importBrand" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => 'brand.import', 'method' => 'post', 'files' => true]) !!}
            <div class="row">
                <div class="col-md-12 panel">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h4>Import Brand</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="card-body">
                                <p>The field labels marked with * are required input fields.</p>
                                <p>The correct column order is (name*, image) & you must follow this. Please make sure the csv file is UTF-8 encoded and not saved with byte order mark (BOM).</p>
                                <p>To display Image it must be stored in the image folder under public directory</p>
                                <label><strong>Upload File *</strong></label>
                                <div class="form-group">
                                    {{Form::file('file', array('class' => 'form-control', 'required'))}}
                                </div>
                                <div class="form-group" id="operation_value"></div>
                                {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['route' => ['brand.update', 1], 'method' => 'PUT', 'files' => true] ) }}
            <div class="row">
                <div class="col-md-12 panel">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h4>Update Brand</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="card-body">
                                <p>Please fill in the information below. The field labels marked with * are required input fields.</p>
                                <div class="form-group">
                                    <label><strong>Brand Title *</strong></label>
                                    {{Form::text('title',null, array('required' => 'required', 'class' => 'form-control'))}}
                                </div>
                                <input type="hidden" name="brand_id">
                                <div class="form-group">
                                    {{Form::file('image', array('class' => 'form-control'))}}
                                </div>
                                {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script type="text/javascript">
function confirmDelete() {
    if (confirm("Are you sure want to delete?")) {
        return true;
    }
    return false;
}

var lims_brand_title = [ @foreach($lims_brand_list as $brand)
        <?php
            $brandNameArray[] = $brand->title;
        ?>
         @endforeach
            <?php
            echo  '"'.implode('","', $brandNameArray).'"';
            ?> ];
var lims_brandNameSearch = $('#lims_brandNameSearch');

    lims_brandNameSearch.autocomplete({
      source: function( request, response ) {
              var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
              response( $.grep( lims_brand_title, function( item ){
                  return matcher.test( item );
              }) );
          },
      select: function(event,ui){
        lims_brandNameSearch.val(ui.item.value);
        var lims_brand_search = $("#lims_brand_search");
        $("#lims_brand_search").submit();
        }
    });

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$( "#select_all" ).on( "change", function() {
    if ($(this).is(':checked')) {
        $("tbody input[type='checkbox']").prop('checked', true);
    } 
    else {
        $("tbody input[type='checkbox']").prop('checked', false);
    }
});

$("#export").on("click", function(e){
    e.preventDefault();
    var brand = [];
    $(':checkbox:checked').each(function(i){
      brand[i] = $(this).val();
    });
    $.ajax({
       type:'POST',
       url:'/exportbrand',
       data:{

            brandArray: brand
        },
       success:function(data){
        alert('Exported to CSV file successfully! Click Ok to download file');
        window.location.href = data;
       }
    });
});

$(document).ready(function() {
    $('.open-EditbrandDialog').on('click', function() {
        var url = "brand/"
        var id = $(this).data('id').toString();
        url = url.concat(id).concat("/edit");

        $.get(url, function(data) {
            //alert(data['id']);
            $("input[name='title']").val(data['title']);
            $("input[name='brand_id']").val(data['id']);

        });
    });
})
</script>
@endsection