@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <h4 class="card-title mb-3">Approve Invoice</h4>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4>Invoice Number : #{{ $invoice->invoice_no }} - {{ date('d-m-Y', strtotime($invoice->date)) }}</h4>
                        <a href="{{ route('pending.invoices.page') }}" class="btn btn-dark btn-rounded waves-effect waves-light mb-3" style="float: right"><i class="fa fa-list"></i> Pending Invoice List</a>

                        @php
                            $payment = App\Models\Payment::where('invoice_id', $invoice->id)->first();
                        @endphp

                        <table class="table table-dark" width="100%">
                            <tbody>
                                <tr>
                                    <td>Customer Info</td>
                                    <td>Name : {{ $payment->customer->name }}</td>
                                    <td>Mobile Number : {{ $payment->customer->mobile_number }}</td>
                                    <td>E-mail : {{ $payment->customer->email }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3">Description : {{ $invoice->description }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <form action="{{ route('approve.invoice', $invoice->id) }}" method="post">
                            @csrf
                            <table class="table table-dark" width="100%">
                                <thead>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Product Name</th>
                                    <th style="background-color: #8b008b">Current Stock</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                </thead>

                                @php
                                    $sub_total = 0;
                                @endphp

                                <tbody>
                                    @foreach ($invoice->invoice_details as $key => $details )
                                        <input type="hidden" name="category_id[]" value="{{ $details->category_id }}">
                                        <input type="hidden" name="product_id[]" value="{{ $details->product_id }}">
                                        <input type="hidden" name="selling_qty[{{ $details->id }}]" value="{{ $details->selling_qty }}">

                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $details->category->name }}</td>
                                            <td>{{ $details->product->name }}</td>
                                            <td style="background-color: #8b008b">{{ $details->product->quantity }}</td>
                                            <td>{{ $details->selling_qty }}</td>
                                            <td>{{ $details->unit_price }}</td>
                                            <td>{{ $details->selling_price }}</td>
                                        </tr>
                                        @php
                                            $sub_total = $sub_total + $details->selling_price;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="6">Sub Total</td>
                                        <td>{{ $sub_total }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">Discount</td>
                                        <td>{{ $payment->discount_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">Paid Amount</td>
                                        <td>{{ $payment->paid_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">Due Amount</td>
                                        <td>{{ $payment->due_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">Grand Amount</td>
                                        <td>{{ $payment->total_amount }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <button class="btn btn-info" type="submit">Approve Invoice</button>
                        </form>


                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

@endsection
