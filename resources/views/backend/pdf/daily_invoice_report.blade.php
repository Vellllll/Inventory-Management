@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Daily Invoice Report</h4>

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
                                        <h3 class="font-size-16"><strong>Daily Invoice Report
                                            <span class="btn btn-info">{{ date('d-m-Y', strtotimE($start_date)) }}</span>
                                            <span class="btn btn-success">{{ date('d-m-Y', strtotimE($end_date)) }}
                                        </strong></h3>
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
                                                    <td class="text-center"><strong>Customer Name</strong></td>
                                                    <td class="text-center"><strong>Invoice Number</strong></td>
                                                    <td class="text-center"><strong>Date</strong></td>
                                                    <td class="text-center"><strong>Description</strong></td>
                                                    <td class="text-center"><strong>Amount</strong></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <!-- foreach ($order->lineItems as $line) or some such thing here -->

                                                @php
                                                    $sub_total = 0;
                                                @endphp

                                                @foreach ($invoices as $key => $invoice )
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td class="text-center">{{ $invoice->payment->customer->name }}</td>
                                                    <td class="text-center">{{ $invoice->invoice_no }}</td>
                                                    <td class="text-center">{{ date('d-m-Y', strtotime($invoice->date)) }}</td>
                                                    <td class="text-center">{{ $invoice->description }}</td>
                                                    <td class="text-center">${{ $invoice->payment->total_amount }}</td>
                                                </tr>
                                                @php
                                                    $sub_total = $sub_total + $invoice->payment->total_amount;
                                                @endphp

                                                @endforeach

                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center"><strong>Grand Amount</strong></td>
                                                    <td class="no-line text-end"><h4 class="m-0">${{ $sub_total }}</h4></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
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
