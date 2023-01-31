@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Stock Report</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-title">
                                    <h3>
                                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="logo" height="24"/> Suzy's Shop
                                    </h3>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <address>
                                            <strong>Suzy's Shop</strong><br>
                                            Jingsuk VI<br>
                                            South Korea<br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">
                                    </div>
                                </div>

                            </div>
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <td><strong>#</strong></td>
                                                    <td class="text-center"><strong>Supplier Name</strong></td>
                                                    <td class="text-center"><strong>Unit</strong></td>
                                                    <td class="text-center"><strong>Category</strong></td>
                                                    <td class="text-center"><strong>Product Name</strong></td>
                                                    <td class="text-center"><strong>In Quantity</strong></td>
                                                    <td class="text-center"><strong>Out Quantity</strong></td>
                                                    <td class="text-center"><strong>Stock</strong></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <!-- foreach ($order->lineItems as $line) or some such thing here -->



                                                @foreach ($products as $key => $product )

                                                @php
                                                    $buying_total = App\Models\Purchase::where('category_id', $product->category_id)->where('product_id', $product->id)->where('status', '1')->sum('buying_qty');
                                                    $selling_total = App\Models\InvoiceDetails::where('category_id', $product->category_id)->where('product_id', $product->id)->where('status', '1')->sum('selling_qty');
                                                @endphp

                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td class="text-center">{{ $product->supplier->name }}</td>
                                                    <td class="text-center">{{ $product->unit->name }}</td>
                                                    <td class="text-center">{{ $product->category->name }}</td>
                                                    <td class="text-center">{{ $product->name }}</td>
                                                    <td class="text-center">{{ $buying_total }}</td>
                                                    <td class="text-center">{{ $selling_total }}</td>
                                                    <td class="text-center">{{ $product->quantity }}</td>
                                                </tr>

                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        @php
                                            $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                                        @endphp

                                        <i>Printing Time : {{ $date->format('F j, Y, g:i a') }}</i>

                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                                <a href="#" class="btn btn-primary waves-effect waves-light ms-2">Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- end row -->

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

@endsection