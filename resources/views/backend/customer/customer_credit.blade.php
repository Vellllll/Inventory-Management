@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('customer.credit.print') }}" target="_blank" class="btn btn-dark btn-rounded waves-effect waves-light" style="float: right"><i class="fa fa-print"></i> Print Customer Credit</a>
                        <br>
                        <h4 class="card-title">All Customer Credit</h4>
                        {{-- <p class="card-title-desc">DataTables has most features enabled by
                            default, so all you need to do to use it with your own tables is to call
                            the construction function: <code>$().DataTable();</code>.
                        </p> --}}

                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Invoice Number</th>
                                <th>Date</th>
                                <th>Due Amount</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>
                                @foreach ($payments as $key => $payment)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $payment->customer->name }}</td>
                                        <td>#{{ $payment->invoice->invoice_no }}</td>
                                        <td>{{ date('d-m-Y', strtotime($payment->invoice->date)) }}</td>
                                        <td>${{ $payment->due_amount }}</td>
                                        <td>
                                            <a href="{{ route('edit.customer.credit.invoice.page', $payment->invoice_id) }}" class="btn btn-info btn-sm" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('customer.invoice.details.pdf', $payment->invoice_id) }}" target="_blank" class="btn btn-danger btn-sm" title="Delete Data" id="">
                                                <i class="fa fa-eye"></i>
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
