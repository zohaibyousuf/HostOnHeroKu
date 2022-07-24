@extends('layout.main')
<title>Customer Group</title>
@section('content')
@if($errors->has('name'))
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('name') }}</div>
@endif 
<div class="row">  
    <div class="col-md-4">
        <form action="{{ route('customer_group.search') }}" id="lims_customer_group_search"  method="get" name="lims_customer_group_search">
            @csrf          
            <div class="search-box input-group">
            	<button class="btn btn-primary"><i class="fa fa-search"></i></button>       
            <input class="form-control" type="text" name="lims_customer_groupNameSearch" id="lims_customer_groupNameSearch" placeholder="Type CustomerGroup and click...">
            </div>
        </form>      
    </div>
    <div class="col-md-3">
    	<div class="input-group">
          <div class="input-group-prepend">
          	<input type="text" disabled="" placeholder="Select Your Options..." class="form-control">
            <button data-toggle="dropdown" type="button" class="btn btn-outline-secondary dropdown-toggle"><span class="caret"></span></button>
            <div class="dropdown-menu">
            	<a href="" data-toggle="modal" data-target="#createModal" class="dropdown-item">Add Customer Group</a>
            	<a href="#" data-toggle="modal" data-target="#importcustomer_group" class="dropdown-item">Import Customer Group</a>
            	{{ Form::open(['route' => 'customer_group.export', 'method' => 'post'] ) }}
            	<a href="" id="export" class="dropdown-item">Export To CSV File</a>
            	{{Form::close()}}
            </div>
          </div>    
        </div>
    </div>
    <div class="col-md-3">
        <div class="btn-toolbar pull-right">
          <div class="btn-group">{{$lims_customer_group_all->links()}}</div>
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
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_customer_group_all as $customer_group)
                <tr>
                    <td>
                        <input type="checkbox" name="customer_group[]" value="{{$customer_group->id}}">
                    </td>
                    <td>{{ $customer_group->name }}</td>
                    <td>{{ $customer_group->percentage}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default">Action</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-default pull-right" user="menu">
                                <li>
                                    <button type="button" data-id="{{$customer_group->id}}" class="open-EditCustomerGroupDialog btn btn-link" data-toggle="modal" data-target="#editModal">Edit
                                    </button>
                                </li>
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['customer_group.destroy', $customer_group->id], 'method' => 'DELETE'] ) }}
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
    {!! Form::open(['route' => 'customer_group.store', 'method' => 'post']) !!}
    <div class="modal-header">
      <h5 id="exampleModalLabel" class="modal-title">Add Customer Group</h5>
      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
      <p>The field labels marked with * are required input fields.</p>
      <form>
        <div class="form-group">
          <label><strong>Name *</strong></label>
          <input type="text" name="name" required="required" class="form-control">
        </div>
        <div class="form-group">       
          <label><strong>Percentage(%) *</strong></label>
          <input type="text" name="percentage" required="required" class="form-control">
        </div>                
        <div class="form-group">       
          <input type="submit" value="Submit" class="btn btn-primary">
        </div>
      </form>
    </div>

    {{ Form::close() }}
  </div>
</div>
</div>

<div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
<div role="document" class="modal-dialog">
  <div class="modal-content">
    {!! Form::open(['route' => ['customer_group.update',1], 'method' => 'put']) !!}
    <div class="modal-header">
      <h5 id="exampleModalLabel" class="modal-title">Update Customer Group</h5>
      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
      <p>The field labels marked with * are required input fields.</p>
        <div class="form-group">
            <input type="hidden" name="customer_group_id">
          <label><strong>Name *</strong></label>
          <input type="text" name="name" required="required" class="form-control">
        </div>
        <div class="form-group">       
          <label><strong>Percentage(%) *</strong></label>
          <input type="text" name="percentage" required="required" class="form-control">
        </div>                
        <div class="form-group">       
          <input type="submit" value="Submit" class="btn btn-primary">
        </div>
    </div>
    {{ Form::close() }}
  </div>
</div>
</div>

<div id="importcustomer_group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
<div role="document" class="modal-dialog">
  <div class="modal-content">
    {!! Form::open(['route' => 'customer_group.import', 'method' => 'post', 'files' => true]) !!}
    <div class="modal-header">
      <h5 id="exampleModalLabel" class="modal-title">Import Customer Group</h5>
      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <p>The field labels marked with * are required input fields.</p>
       <p>The correct column order is (name*, percentage*) & you must follow this. Please make sure the CSV file is UTF-8 encoded and not saved with byte order mark (BOM).</p>

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
        
        $('.open-EditCustomerGroupDialog').on('click', function() {
            var url = "customer_group/"
            var id = $(this).data('id').toString();
            url = url.concat(id).concat("/edit");

            $.get(url, function(data) {
                $("input[name='name']").val(data['name']);
                $("input[name='percentage']").val(data['percentage']);
                $("input[name='customer_group_id']").val(data['id']);
            });
        });

        var lims_customer_group_title = [ @foreach($lims_customer_group_list as $customer_group)
        <?php
            $customer_groupNameArray[] = $customer_group->name;
        ?>
         @endforeach
            <?php
            echo  '"'.implode('","', $customer_groupNameArray).'"';
            ?> ];
        var lims_customer_groupNameSearch = $('#lims_customer_groupNameSearch');

        lims_customer_groupNameSearch.autocomplete({
          source: function( request, response ) {
                  var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
                  response( $.grep( lims_customer_group_title, function( item ){
                      return matcher.test( item );
                  }) );
              },
          select: function(event,ui){
            lims_customer_groupNameSearch.val(ui.item.value);
            var lims_customer_group_search = $("#lims_customer_group_search");
            $("#lims_customer_group_search").submit();
            }
        });
    })

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
    var customer_group = [];
    $(':checkbox:checked').each(function(i){
      customer_group[i] = $(this).val();
    });
    $.ajax({
       type:'POST',
       url:'/exportcustomer_group',
       data:{
            customer_groupArray: customer_group
        },
       success:function(data){
         alert('Exported to CSV file successfully! Click Ok to download file');
         window.location.href = data;
       }
    });
});
</script>

@endsection