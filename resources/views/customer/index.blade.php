@extends('layout.main') @section('content')
@if(session()->has('message1'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message1') }}</div> 
@endif
@if(session()->has('message2'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message2') }}</div> 
@endif
@if(session()->has('message3'))
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message3') }}</div> 
@endif
@if(session()->has('message4'))
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message4') }}</div> 
@endif
@if(session()->has('import_message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('import_message') }}</div> 
@endif
@if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section>
    <div class="container-fluid">
        <div class="input-group">
            <div class="input-group-prepend">
                @if(in_array("customers-add", $all_permission))
                <a href="{{route('customer.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> {{trans('file.Add')}} {{trans('file.Customer')}}</a>
                &nbsp;&nbsp;
                <a href="#" data-toggle="modal" data-target="#import-customer" class="btn btn-primary"> <i class="fa fa-file"></i> {{trans('file.Import')}} {{trans('file.Customer')}}</a>
                @endif
            </div>    
        </div>
    </div>


    <table id="customer-table" class="table table-hover">
        <thead>
            <tr>
                <th class="not-exported"></th>
                <th>{{trans('file.Name')}}</th>
                <th>{{trans('file.Company Name')}}</th>
                <th>{{trans('file.Address')}}</th>
                <th>{{trans('file.Phone Number')}}</th>
                <th class="not-exported">{{trans('file.Action')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lsms_customer_all as $key=>$customer)
            <tr>
                <td>{{$key}}</td>
                <td>{{ $customer->name }}</td>
                @if($customer->company_name)
                <td>{{ $customer->company_name}}</td>
                @else
                <td>N/A</td>
                @endif
                @if($customer->address)
                <td>{{ $customer->address}}</td>
                @else
                <td>N/A</td>
                @endif
                <td>{{ $customer->phone}}</td>
                <td>
                    <div class="btn-group">
                        @if(in_array("customers-edit", $all_permission))
                        <a class="btn btn-primary" href="{{ route('customer.edit', ['id' => $customer->id]) }}" title="{{trans('file.Edit')}}"><i class="fa fa-edit"></i></a>
                        @endif
                        @if(in_array("customers-delete", $all_permission))
                        {{ Form::open(['route' => ['customer.destroy', $customer->id], 'method' => 'DELETE'] ) }}
                        <button type="submit" class="btn btn-danger" onclick="return confirmDelete()" title="{{trans('file.Delete')}}"> <i class="fa fa-times"></i></button>
                        {{ Form::close() }}
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ Form::close() }}
    <div id="import-customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            {!! Form::open(['route' => 'customer.import', 'method' => 'post', 'files' => true]) !!}
            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Import')}} {{trans('file.Customer')}}</h5>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
               <p>{{trans('file.The correct column order is')}} (name, company, address, phone) {{trans('file.and you must follow this')}}. {{trans('file.All columns are required')}}.</p>
                <label><strong>{{trans('file.Upload CSV File')}} *</strong></label>
                <div class="form-group">
                    {{Form::file('file', array('class' => 'form-control','required'))}}
                </div>
                <div class="form-group" id="operation_value"></div>
                <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
            </div>
            {!! Form::close() !!}
          </div>
        </div>
    </div>
</section>
<script type="text/javascript">

    $("ul#customer").siblings('a').attr('aria-expanded','true');
    $("ul#customer").addClass("show");
    $("ul#customer li").eq(0).addClass("active");

    $('#customer-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 5]
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
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
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