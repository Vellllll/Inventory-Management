@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('stock.report.pdf') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float: right"><i class="fa fa-print"></i> Stock Report Print</a>
                        <br>
                        <h4 class="card-title">Stock Report</h4>
                        {{-- <p class="card-title-desc">DataTables has most features enabled by
                            default, so all you need to do to use it with your own tables is to call
                            the construction function: <code>$().DataTable();</code>.
                        </p> --}}

                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Supplier Name</th>
                                <th>Unit</th>
                                <th>Category</th>
                                <th>Product Name</th>
                                <th>In Quantity</th>
                                <th>Out Quantity</th>
                                <th>Stock</th>
                            </tr>
                            </thead>


                            <tbody>
                                @foreach ($products as $key => $product)

                                @php
                                    $buying_total = App\Models\Purchase::where('category_id', $product->category_id)->where('product_id', $product->id)->where('status', '1')->sum('buying_qty');
                                    $selling_total = App\Models\InvoiceDetails::where('category_id', $product->category_id)->where('product_id', $product->id)->where('status', '1')->sum('selling_qty');
                                @endphp

                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $product['supplier']['name'] }}</td>
                                        <td>{{ $product['unit']['name'] }}</td>
                                        <td>{{ $product['category']['name'] }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $buying_total }}</td>
                                        <td>{{ $selling_total }}</td>
                                        <td>{{ $product->quantity }}</td>
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
