@extends('layout.main') @section('content')

@if($errors->has('name'))
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('name') }}</div>
@endif
@if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<!-- Trigger the modal with a button -->
<section>
    <div class="container-fluid">
      <div class="input-group">
          <div class="input-group-prepend">
                <a href="" data-toggle="modal" data-target="#createModal" class="btn btn-info"><i class="fa fa-plus"></i> {{trans('file.Add')}} {{trans('file.Category')}}</a>
                &nbsp;&nbsp;
                <a href="#" data-toggle="modal" data-target="#import-category" class="btn btn-primary"><i class="fa fa-file"></i> {{trans('file.Import')}} {{trans('file.Category')}} {{trans('file.By')}} CSV</a>
          </div>    
        </div>
    </div> 

  <table id="category-table" class="table table-hover">
    <thead>
        <tr>
            <th class="not-exported"></th>
            <th>{{trans('file.Category')}}</th>
            <th class="not-exported">{{trans('file.Action')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lsms_category_all as $key => $category)
        <tr>
            <td>{{$key}}</td>
            <td>{{ $category->name }}</td>
            <td>
                <div class="btn-group">
                    <button type="button" data-id="{{$category->id}}" class="open-EditCategoryDialog btn btn-primary" data-toggle="modal" data-target="#editModal" title="Edit"><i class="fa fa-edit"></i>
                        </button>
                    {{ Form::open(['route' => ['category.destroy', $category->id], 'method' => 'DELETE'] ) }}
                    <button type="submit" class="btn btn-danger" onclick="return confirmDelete()" title="Delete"> <i class="fa fa-times"></i></button> 
                    {{ Form::close() }}
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
</section>

<div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
<div role="document" class="modal-dialog">
  <div class="modal-content">
    {!! Form::open(['route' => 'category.store', 'method' => 'post']) !!}
    <div class="modal-header">
      <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Add')}} {{trans('file.Category')}}</h5>
      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
      <p class="italic">{{trans('file.The field labels marked with * are required input fields')}}.</p>
      <form>
        <div class="form-group">
          <label><strong>{{trans('file.Name')}} *</strong></label>
          <input type="text" name="name" required="required" class="form-control">
        </div>                
        <div class="form-group">       
          <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
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
    {!! Form::open(['route' => ['category.update',1], 'method' => 'put']) !!}
    <div class="modal-header">
      <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Update')}} {{trans('file.Category')}}</h5>
      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
      <p class="italic">{{trans('file.The field labels marked with * are required input fields')}}.</p>
        <div class="form-group">
            <input type="hidden" name="category_id">
          <label><strong>{{trans('file.Name')}} *</strong></label>
          <input type="text" name="name" required="required" class="form-control" />
          <input type="hidden" name="category_id" />
        </div>                
        <div class="form-group">       
          <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
        </div>
    </div>
    {{ Form::close() }}
  </div>
</div>
</div>

<div id="import-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
<div role="document" class="modal-dialog">
  <div class="modal-content">
    {!! Form::open(['route' => 'category.import', 'method' => 'post', 'files' => true]) !!}
    <div class="modal-header">
      <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Import')}} {{trans('file.Category')}}</h5>
      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <p>{{trans('file.The field labels marked with * are required input fields')}}.</p>
       <p>{{trans('file.The correct column order is')}} (name*) {{trans('file.and you must follow this')}}. {{trans('file.Every Category Name must be unique')}}.</p>

        <label><strong>{{trans('file.Upload CSV File')}} *</strong></label>
        <div class="form-group">
            {{Form::file('file', array('class' => 'form-control', 'required'))}}
        </div>
        <div class="form-group" id="operation_value"></div>
        <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
    </div>
    {{ Form::close() }}
  </div>
</div>
</div>

<script type="text/javascript">
    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");
    $("ul#product li").eq(0).addClass("active");

  $('#category-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 2]
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
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
    } );
  
    function confirmDelete() {
      if (confirm("If you delete this category all the products under this category will also be deleted! Are you sure want to delete?")) {
          return true;
      }
      return false;
    }
$(document).ready(function() {
    $('.open-EditCategoryDialog').on('click', function(){
      var url ="category/"  
      var id = $(this).data('id').toString();
      url = url.concat(id).concat("/edit");
      
      $.get(url, function(data){
        $("input[name='name']").val(data['name']);
        $("input[name='category_id']").val(data['id']);
      });
    });
})
</script>
@endsection