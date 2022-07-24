@extends('layout.main') @section('content')
<div class="row">  
    <div class="col-md-4">
        <form action="{{ route('transfer.search') }}" id="lims_transfer_search"  method="get" name="lims_transfer_search">
            @csrf          
            <div class="search-box input-group">
            	<button class="btn btn-primary"><i class="fa fa-search"></i></button>       
            <input class="form-control" type="text" name="lims_transferSearch" id="lims_transferSearch" placeholder="Type Transfer reference and click...">
            </div>
        </form>      
    </div>
    <div class="col-md-3">
    	<div class="input-group">
          <div class="input-group-prepend">
          	<input type="text" disabled="" placeholder="Select Your Options..." class="form-control">
            <button data-toggle="dropdown" type="button" class="btn btn-outline-secondary dropdown-toggle"><span class="caret"></span></button>
            <div class="dropdown-menu">
            	<a href="{{route('transfer.create')}}" class="dropdown-item">Add Transfer</a>
            	<a href="#" data-toggle="modal" data-target="#importtransfer" class="dropdown-item">Import transfer</a>
            	{{ Form::open(['route' => 'transfer.export', 'method' => 'post'] ) }}
            	<a href="" id="export" class="dropdown-item">Export To CSV File</a>
                {!! Form::close() !!}
            </div>
          </div>    
        </div>
    </div>
    <div class="col-md-3">
        <div class="btn-toolbar pull-right">
          <div class="btn-group">{{ $lims_transfer_all->links() }}</div>
        </div>   
    </div>
</div>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover purchase-list">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select_all" value="-1"> Export</th>
                    <th>Date</th>
                    <th>Reference No</th>
                    <th>Warehouse(From)</th>
                    <th>Warehouse(To)</th>
                    <th>Product Cost</th>
                    <th>Product Tax</th>
                    <th>Grand Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_transfer_all as $transfer)
                <tr>
                    <td>
                        <input type="checkbox" name="transfer[]" value="{{$transfer->id}}">
                    </td>
                    <td>{{ $transfer->created_at->toDateString() . ' '. $transfer->created_at->toTimeString() }}</td>
                    <td>{{ $transfer->reference_no }}</td>
                    <?php $warehouse = DB::table('Warehouses')->find($transfer->from_warehouse_id) ?>
                    <td>{{ $warehouse->name }}</td>
                    <?php $warehouse = DB::table('Warehouses')->find($transfer->to_warehouse_id) ?>
                    <td>{{ $warehouse->name }}</td>
                    <td class="total-cost">{{ $transfer->total_cost }}</td>
                    <td class="total-tax">{{ $transfer->total_tax }}</td>
                    <td class="grand-total">{{ $transfer->grand_total }}</td>
                    @if($transfer->status == 1)
                        <td>Completed</td>
                    @elseif($transfer->status == 2)
                        <td>Pending</td>
                    @elseif($transfer->status == 3)
                        <td>Sent</td>
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
                                    <button type="button" class="btn btn-link"><a href="{{ route('transfer.edit', ['id' => $transfer->id]) }}"> Edit</a></button> 
                                </li>
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['transfer.destroy', $transfer->id], 'method' => 'DELETE'] ) }}
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
            <tfoot class="tfoot active">
                <th colspan="5">Total Calculation:</th>
                <th id="total-cost">0.00</th>
                <th id="total-tax">0.00</th>
                <th id="grand-total">0.00</th>
            </tfoot>
        </table>
    </div>
</div>

<script type="text/javascript">
    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    var grand_total = 0;
    var total_cost = 0;
    var total_tax = 0;

    $(".grand-total").each(function() {
        grand_total += parseFloat($(this).text());
    });
    $(".total-cost").each(function() {
        total_cost += parseFloat($(this).text());
    });
    $(".total-tax").each(function() {
        total_tax += parseFloat($(this).text());
    });

    $('#grand-total').text(grand_total.toFixed(2));
    $('#total-cost').text(total_cost.toFixed(2));
    $('#total-tax').text(total_tax.toFixed(2));
</script>
@endsection