@extends('layout.main') @section('content')

@if($errors->has('unit_code'))
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('unit_code') }}</div>
@endif

@if($errors->has('unit_name'))
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('unit_name') }}</div>
@endif

<div class="row">
    <div class="col-md-4">
        <form action="{{ route('unit.search') }}" id="lims_unit_search" method="get" name="lims_unit_search">
            @csrf
            <div class="search-box input-group">
                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                <input class="form-control" type="text" name="lims_unitNameSearch" id="lims_unitNameSearch" placeholder="Type unit name and click...">
            </div>
        </form>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <div class="input-group-prepend">
                <input type="text" disabled="" placeholder="Select Your Options..." class="form-control">
                <button data-toggle="dropdown" type="button" class="btn btn-outline-secondary dropdown-toggle"><span class="caret"></span></button>
                <div class="dropdown-menu">
                    <a href="" data-toggle="modal" data-target="#createModal" class="dropdown-item open-CreateUnitDialog">Add Unit</a>
                    <a href="#" data-toggle="modal" data-target="#importUnit" class="dropdown-item">Import Unit</a> {{ Form::open(['route' => 'unit.export', 'method' => 'post'] ) }}
                    <a href="" id="export" class="dropdown-item">Export To CSV File</a> {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="btn-toolbar pull-right">
          <div class="btn-group">{{ $lims_unit_all->links() }}</div>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select_all" value="-1"> Export</th>
                    <th>Unit Code</th>
                    <th>Unit Name</th>
                    <th>Base Unit</th>                 
                    <th>Operator</th>
                    <th>Operation Value</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_unit_all as $unit)
                <tr>
                    <td>
                        <input type="checkbox" name="unit[]" value="{{$unit->id}}">
                    </td>
                    <td>{{ $unit->unit_code }}</td>
                    <td>{{ $unit->unit_name }}</td>
                    @if($unit->base_unit)
                        <?php $base_unit = DB::table('units')->where('id', $unit->base_unit)->first(); ?>
                        <td>{{ $base_unit->unit_name }}</td>
                    @else
                        <td>N/A</td>
                    @endif
                    @if($unit->operator)
                        <td>{{ $unit->operator }}</td>
                    @else
                        <td>N/A</td>
                    @endif
                    @if($unit->operation_value)
                        <td>{{ $unit->operation_value }}</td>
                    @else
                        <td>N/A</td>
                    @endif
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default">Action</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-default pull-right" user="menu">
                                <li>
                                    <button type="button" data-id="{{$unit->id}}" class="open-EditUnitDialog btn btn-link" data-toggle="modal" data-target="#editModal">Edit
                                </button>
                                </li>
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['unit.destroy', $unit->id], 'method' => 'DELETE'] ) }}
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
<!-- Modal -->

<div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => 'unit.store', 'method' => 'post']) !!}
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">Add Unit</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <p>The field labels marked with * are required input fields.</p>
                <form>
                    <div class="form-group">
                    <label><strong>Unit Code *</strong></label>
                    {{Form::text('unit_code',null,array('required' => 'required', 'class' => 'form-control'))}}
                    </div>
                    <div class="form-group">
                        <label><strong>Unit Name *</strong></label>
                        {{Form::text('unit_name',null,array('required' => 'required', 'class' => 'form-control'))}}
                    </div>
                    <div class="form-group">
                        <label><strong>Base Unit</strong></label>
                        <select class="form-control" id="base_unit_create" name="base_unit">
                            <option value="">No Base Unit</option>
                            @foreach($lims_unit_list as $unit)
                                @if($unit->base_unit==null)
                                <option value="{{$unit->id}}">{{$unit->unit_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group operator">
                        <label><strong>Operator</strong></label> <input type="text" name="operator" placeholder="Enter your Name" class="form-control" />
                    </div>
                    <div class="form-group operation_value">
                        <label><strong>Operation Value</strong></label><input type="text" name="operation_value" placeholder="Enter operation value" class="form-control" />
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
    {!! Form::open(['route' => ['unit.update',1], 'method' => 'put']) !!}
    <div class="modal-header">
      <h5 id="exampleModalLabel" class="modal-title">Update Unit</h5>
      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
      <p>The field labels marked with * are required input fields.</p>
        <form>
            <input type="hidden" name="unit_id">
            <div class="form-group">
            <label><strong>Unit Code *</strong></label>
            {{Form::text('unit_code',null,array('required' => 'required', 'class' => 'form-control'))}}
            </div>
            <div class="form-group">
                <label><strong>Unit Name *</strong></label>
                {{Form::text('unit_name',null,array('required' => 'required', 'class' => 'form-control'))}}
            </div>
            <div class="form-group">
                <label><strong>Base Unit</strong></label>
                <select class="form-control" id="base_unit_edit" name="base_unit">
                    <option value="">No Base Unit</option>
                    @foreach($lims_unit_list as $unit)
                        @if($unit->base_unit==null)
                        <option value="{{$unit->id}}">{{$unit->unit_name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group operator">
                <label><strong>Operator</strong></label> <input type="text" name="operator" placeholder="Enter your Name" class="form-control" />
            </div>
            <div class="form-group operation_value">
                <label><strong>Operation Value</strong></label><input type="text" name="operation_value" placeholder="Enter operation value" class="form-control" />
            </div>
            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        </form>
    </div>
    {{ Form::close() }}
  </div>
</div>
</div>

<div id="importUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
<div role="document" class="modal-dialog">
  <div class="modal-content">
    {!! Form::open(['route' => 'unit.import', 'method' => 'post', 'files' => true]) !!}
    <div class="modal-header">
      <h5 id="exampleModalLabel" class="modal-title">Import unit</h5>
      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <p>The field labels marked with * are required input fields.</p>
       <p>The correct column order is (unit_code*, unit_name*, base_unit, operator, operation_value) & you must follow this. Please make sure the CSV file is UTF-8 encoded and not saved with byte order mark (BOM).</p>

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
    $(".operator").hide();
    $(".operation_value").hide();
     function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }
$(document).ready(function() {
    $('.open-EditUnitDialog').on('click', function() {
        var url = "unit/"
        var id = $(this).data('id').toString();
        url = url.concat(id).concat("/edit");

        $.get(url, function(data) {
            $("input[name='unit_code']").val(data['unit_code']);
            $("input[name='unit_name']").val(data['unit_name']);
            $("input[name='operator']").val(data['operator']);
            $("input[name='operation_value']").val(data['operation_value']);
            $("input[name='unit_id']").val(data['id']);
            $("#base_unit_edit").val(data['base_unit']);
            if(data['base_unit']!=null)
            {
                $(".operator").show();
                $(".operation_value").show();
            }
            else
            {
                $(".operator").hide();
                $(".operation_value").hide();
            }

        });
    });

    var lims_unit_title = [ @foreach($lims_unit_list as $unit)
    <?php
        $unitNameArray[] = $unit->unit_name;
    ?>
     @endforeach
        <?php
        echo  '"'.implode('","', $unitNameArray).'"';
        ?> ];
    var lims_unitNameSearch = $('#lims_unitNameSearch');

    lims_unitNameSearch.autocomplete({
      source: function( request, response ) {
              var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
              response( $.grep( lims_unit_title, function( item ){
                  return matcher.test( item );
              }) );
          },
      select: function(event,ui){
        lims_unitNameSearch.val(ui.item.value);
        var lims_unit_search = $("#lims_unit_search");
        $("#lims_unit_search").submit();
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
        var unit = [];
        $(':checkbox:checked').each(function(i){
          unit[i] = $(this).val();
        });
        $.ajax({
           type:'POST',
           url:'/exportunit',
           data:{

                unitArray: unit
            },
           success:function(data){
            alert('Exported to CSV file successfully! Click Ok to download file');
            window.location.href = data;
           }
        });
    });

    $('.open-CreateUnitDialog').on('click', function() {
        $(".operator").hide();
        $(".operation_value").hide();
        
    });

    $('#base_unit_create').on('change', function() {
         $(".operator").show();
         $(".operation_value").show();
    });

    $('#base_unit_edit').on('change', function() {
         $(".operator").show();
         $(".operation_value").show();
    });
});
</script>
@endsection