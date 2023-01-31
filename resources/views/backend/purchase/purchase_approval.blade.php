@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pending Purchases</h4>
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
                                        <td><span class="btn btn-warning">PENDING</span></td>
                                        <td>
                                            <a href="{{ route('approve.purchase', $purchase->id) }}" class="btn btn-success" id="approve">
                                                <i class="fas fa-check-circle"></i> Approve
                                            </a>
                                        </td>

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
