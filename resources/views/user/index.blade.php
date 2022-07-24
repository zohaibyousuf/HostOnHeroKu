@extends('layout.main') @section('content')
@if(session()->has('message1'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message1') }}</div> 
@endif
@if(session()->has('message2'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message2') }}</div> 
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif

<section>
    <div class="container-fluid">
        @if(in_array("users-add", $all_permission))
            <a href="{{route('users.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> {{trans('file.Add')}} {{trans('file.User')}}</a>
        @endif
    </div>
    <div class="table-responsive">
        <table id="user-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.UserName')}}</th>
                    <th>{{trans('file.Email')}}</th>
                    <th>{{trans('file.Company Name')}}</th>
                    <th>{{trans('file.Phone Number')}}</th>
                    <th>{{trans('file.Role')}}</th>
                    <th class="not-exported">{{trans('file.Action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lsms_user_list as $key=>$user)
                <tr>
                    <td>{{$key}}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email}}</td>
                    <td>{{ $user->company_name}}</td>
                    <td>{{ $user->phone}}</td>
                    <?php $role = DB::table('roles')->find($user->role)?>
                    <td>{{ $role->name }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.Action')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                @if(in_array("users-edit", $all_permission))
                                <li>
                                	<a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-link"><i class="fa fa-edit"></i> {{trans('file.Edit')}}</a>
                                </li>
                                @endif
                                @if(in_array("users-delete", $all_permission))
                                {{ Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> {{trans('file.Delete')}}</button>
                                </li>
                                {{ Form::close() }}
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<script type="text/javascript">

    $("ul#user").siblings('a').attr('aria-expanded','true');
    $("ul#user").addClass("show");
    $("ul#user li").eq(0).addClass("active");

	function confirmDelete() {
	    if (confirm("Are you sure want to delete?")) {
	        return true;
	    }
	    return false;
	}

    $('#user-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 6]
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
</script>
@endsection