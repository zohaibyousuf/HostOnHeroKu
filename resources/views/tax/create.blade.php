@extends('layout.main') @section('content')

@if($errors->has('name'))
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('name') }}</div>
@endif

@if($errors->has('rate'))
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('rate') }}</div>
@endif

<div class="row">
    <div class="col-md-4">
        <form action="{{ route('tax.search') }}" id="lims_tax_search" method="get" name="lims_tax_search">
            @csrf
            <div class="search-box input-group">
                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                <input class="form-control" type="text" name="lims_taxNameSearch" id="lims_taxNameSearch" placeholder="Type tax name and click...">
            </div>
        </form>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <div class="input-group-prepend">
                <input type="text" disabled="" placeholder="Select Your Options..." class="form-control">
                <button data-toggle="dropdown" type="button" class="btn btn-outline-secondary dropdown-toggle"><span class="caret"></span></button>
                <div class="dropdown-menu">
                    <a href="" data-toggle="modal" data-target="#createModal" class="dropdown-item open-CreatetaxDialog">Add Tax</a>
                    <a href="#" data-toggle="modal" data-target="#importTax" class="dropdown-item">Import tax</a> {{ Form::open(['route' => 'tax.export', 'method' => 'post'] ) }}
                    <a href="" id="export" class="dropdown-item">Export To CSV File</a> {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="btn-toolbar pull-right">
          <div class="btn-group">{{ $lims_tax_all->links() }}</div>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select_all" value="-1"> Export</th>
                    <th>Name</th>
                    <th>Rate(%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_tax_all as $tax)
                <tr>
                    <td>
                        <input type="checkbox" name="tax[]" value="{{$tax->id}}">
                    </td>
                    <td>{{ $tax->name }}</td>
                    <td>{{ $tax->rate }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default">Action</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-default pull-right" user="menu">
                                <li>
                                    <button type="button" data-id="{{$tax->id}}" class="open-EdittaxDialog btn btn-link" data-toggle="modal" data-target="#editModal">Edit
                                </button>
                                </li>
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['tax.destroy', $tax->id], 'method' => 'DELETE'] ) }}
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

<div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => 'tax.store', 'method' => 'post']) !!}
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">Add Tax</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <p>The field labels marked with * are required input fields.</p>
                <form>
                    <div class="form-group">
                    <label><strong>Tax Name *</strong></label>
                    {{Form::text('name',null,array('required' => 'required', 'class' => 'form-control'))}}
                    </div>
                    <div class="form-group">
                        <label><strong>Rate(%) *</strong></label>
                        {{Form::text('rate',null,array('required' => 'required', 'class' => 'form-control'))}}
                    </div>
                    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
            	</form>
        	</div>
        {{ Form::close() }}
    	</div>
	</div>
</div>

<div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
	<div role="document" class="modal-dialog">
		  <div class="modal-content">
		    {!! Form::open(['route' => ['tax.update',1], 'method' => 'put']) !!}
		    <div class="modal-header">
		      <h5 id="exampleModalLabel" class="modal-title">Update Tax</h5>
		      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
		    </div>
		    <div class="modal-body">
		      <p>The field labels marked with * are required input fields.</p>
		        <form>
		            <input type="hidden" name="tax_id">
		            <div class="form-group">
		                <label><strong>Tax Name *</strong></label>
		                {{Form::text('name',null,array('required' => 'required', 'class' => 'form-control'))}}
		            </div>
		            <div class="form-group">
		                <label><strong>Rate(%) *</strong></label>
		                {{Form::text('rate',null,array('required' => 'required', 'class' => 'form-control'))}}
		            </div>
		            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
		        </form>
		    </div>
		    {{ Form::close() }}
		  </div>
	</div>
</div>

<div id="importTax" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
<div role="document" class="modal-dialog">
  <div class="modal-content">
    {!! Form::open(['route' => 'tax.import', 'method' => 'post', 'files' => true]) !!}
    <div class="modal-header">
      <h5 id="exampleModalLabel" class="modal-title">Import Tax</h5>
      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <p>The field labels marked with * are required input fields.</p>
       <p>The correct column order is (name*, rate*) & you must follow this. Please make sure the CSV file is UTF-8 encoded and not saved with byte order mark (BOM).</p>

        <label><strong>Upload File *</strong></label>
        <div class="form-group">
            {{Form::file('file', array('class' => 'form-control', 'required'))}}
        </div>
        <div class="form-group" id="operation_value"></div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    </div>
    {{ Form::close() }}
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

    $(document).ready(function() {
    $('.open-EdittaxDialog').on('click', function() {
        var url = "tax/"
        var id = $(this).data('id').toString();
        url = url.concat(id).concat("/edit");

        $.get(url, function(data) {
            $("input[name='name']").val(data['name']);
            $("input[name='rate']").val(data['rate']);
            $("input[name='tax_id']").val(data['id']);
        });
    });

    var lims_tax_title = [ @foreach($lims_tax_list as $tax)
    <?php
        $taxNameArray[] = $tax->name;
    ?>
     @endforeach
        <?php
        echo  '"'.implode('","', $taxNameArray).'"';
        ?> ];
    var lims_taxNameSearch = $('#lims_taxNameSearch');

    lims_taxNameSearch.autocomplete({
      source: function( request, response ) {
              var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
              response( $.grep( lims_tax_title, function( item ){
                  return matcher.test( item );
              }) );
          },
      select: function(event,ui){
        lims_taxNameSearch.val(ui.item.value);
        var lims_tax_search = $("#lims_tax_search");
        $("#lims_tax_search").submit();
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
        var tax = [];
        $(':checkbox:checked').each(function(i){
          tax[i] = $(this).val();
        });
        $.ajax({
           type:'POST',
           url:'/exporttax',
           data:{

                taxArray: tax
            },
           success:function(data){
            alert('Exported to CSV file successfully! Click Ok to download file');
            window.location.href = data;
           }
        });
    });
});
</script>

@endsection