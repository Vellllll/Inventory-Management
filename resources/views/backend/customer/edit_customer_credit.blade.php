@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Customer Invoice (Invoice Number : #{{ $payment->invoice->invoice_no }})</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ route('credit.customer') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float: right"><i class="fa fa-list"></i> Back</a>

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">
                                        <h3 class="font-size-16"><strong>Customer Invoice</strong></h3>
                                    </div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <td><strong>Custumer Name</strong></td>
                                                    <td class="text-center"><strong>Mobile Number</strong></td>
                                                    <td class="text-center"><strong>Address</strong></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                <tr>
                                                    <td>{{ $payment->customer->name }}</td>
                                                    <td class="text-center">{{ $payment->customer->mobile_number }}</td>
                                                    <td class="text-center">{{ $payment->customer->address }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('update.customer.invoice', $payment->invoice_id) }}" method="POST">
                                    @csrf

                                    <div>
                                        <div class="">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <td><strong>#</strong></td>
                                                        <td class="text-center"><strong>Category</strong></td>
                                                        <td class="text-center"><strong>Product Name</strong></td>
                                                        <td class="text-center"><strong>Current Stock</strong></td>
                                                        <td class="text-center"><strong>Quantity</strong></td>
                                                        <td class="text-center"><strong>Unit Price</strong></td>
                                                        <td class="text-center"><strong>Total Price</strong></td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->

                                                    @php
                                                        $sub_total = 0;
                                                        $invoice_details = App\Models\InvoiceDetails::where('invoice_id', $payment->invoice_id)->get();
                                                    @endphp

                                                    @foreach ($invoice_details as $key => $details )
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td class="text-center">{{ $details->category->name }}</td>
                                                        <td class="text-center">{{ $details->product->name }}</td>
                                                        <td class="text-center">{{ $details->product->quantity }}</td>
                                                        <td class="text-center">${{ $details->selling_qty }}</td>
                                                        <td class="text-center">${{ $details->unit_price }}</td>
                                                        <td class="text-end">${{ $details->selling_price }}</td>
                                                    </tr>
                                                    @php
                                                        $sub_total = $sub_total + $details->selling_price;
                                                    @endphp

                                                    @endforeach

                                                    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                                        <td class="thick-line text-end"><strong>${{$sub_total}}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center"><strong>Discount Amount</strong></td>
                                                        <td class="no-line text-end"><strong>${{ $payment->discount_amount }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line text-center"><strong>Paid Amount</strong></td>
                                                        <td class="thick-line text-end"><strong>${{ $payment->paid_amount }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line text-center"><strong>Due Amount</strong></td>
                                                        <input type="hidden" name="new_paid_amount" value="{{ $payment->due_amount }}">
                                                        <td class="thick-line text-end"><strong>${{ $payment->due_amount }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center"><strong>Grand Amount</strong></td>
                                                        <td class="no-line text-end"><h4 class="m-0">${{ $payment->total_amount }}</h4></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <div class="md-3">
                                                        <label for="paid_status">Paid Status</label>

                                                        <select name="paid_status" id="paid_status" class="form-select mb-3">
                                                            <option value="" selected disabled>Select Status</option>
                                                            <option value="full_paid">Full Paid</option>
                                                            <option value="partial_paid">Partial Paid</option>
                                                        </select>
                                                        <input type="text" name="paid_amount" id="paid_amount" class="form-control paid_amount" placeholder="Enter paid amount!" style="display: none">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="md-3">
                                                        <label for="invoice_date" class="">Date</label>
                                                        <input class="form-control" type="date" name="invoice_date" id="invoice_date" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="md-3" style="padding-top: 30px">
                                                        <button class="btn btn-info" type="submit">Update Invoice!</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div> <!-- end row -->

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

<script>
    $(document).ready(function(){
        $(document).on('change', '#paid_status', function(){
            var paid_status = $(this).val();
            if (paid_status == 'partial_paid'){
                $('.paid_amount').show();
            } else {
                $('.paid_amount').hide();
            }
        })
    })
</script>

@endsection
