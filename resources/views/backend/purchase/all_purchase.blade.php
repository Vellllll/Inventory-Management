@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('add.purchase.page') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float: right"><i class="fa fa-plus-circle"></i> Add Purchase</a>
                        <br>
                        <h4 class="card-title">All Purchases</h4>
                        {{-- <p class="card-title-desc">DataTables has most features enabled by
                            default, so all you need to do to use it with your own tables is to call
                            the construction function: <code>$().DataTable();</code>.
                        </p> --}}

                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Purchase Number</th>
                                <th>Date</th>
                                <th>Supplier</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Product Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>
                                @foreach ($purchases as $key => $purchase)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $purchase->purchase_no }}</td>
                                        <td>{{ date('d-m-Y', strtotime($purchase->date)) }}</td>
                                        <td>{{ $purchase['supplier']['name'] }}</td>
                                        <td>{{ $purchase['category']['name'] }}</td>
                                        <td>{{ $purchase->buying_qty }}</td>
                                        <td>{{ $purchase->product->name }}</td>

                                        @if($purchase->status == '0')
                                            <td><span class="btn btn-warning">PENDING</span></td>
                                            <td>
                                                <a href="{{ route('delete.purchase', $purchase->id) }}" class="btn btn-danger btn-sm" title="Delete Purchase" id="delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>

                                        @elseif($purchase->status == '1')
                                            <td><span class="btn btn-success">APPROVED</span></td>
                                            <td></td>
                                        @endif





                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

@endsection
