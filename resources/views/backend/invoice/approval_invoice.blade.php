@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <br>
                        <h4 class="card-title">Pending Invoices</h4>
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
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>
                                @foreach ($pending_invoices as $key => $invoice)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $invoice->payment->customer->name }}</td>
                                        <td>#{{ $invoice->invoice_no }}</td>
                                        <td>{{ date('d-m-Y', strtotime($invoice->date)) }}</td>
                                        <td>{{ $invoice->description }}</td>
                                        <td>${{ $invoice->payment->total_amount }}</td>
                                        @if ($invoice->status == '0')
                                            <td>
                                                <button class="btn btn-warning btn-sm">PENDING</button>
                                            </td>
                                        @elseif ($invoice->status == '1')
                                            <td>
                                                <button class="btn btn-success btn-sm">SUCCESS</button>
                                            </td>
                                        @endif
                                        @if ($invoice->status == '0')
                                        <td>
                                            <a href="{{ route('approve.invoice.page', $invoice->id) }}" class="btn btn-dark btn-sm" title="Approve Data"><i class="fas fa-check-circle"></i></a>
                                            <a href="{{ route('delete.invoice', $invoice->id) }}" class="btn btn-danger btn-sm" title="Delete Purchase" id="delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                        @elseif ($invoice->status == '1')
                                        <td>
                                            <a href="{{ route('delete.invoice', $invoice->id) }}" class="btn btn-danger btn-sm" title="Delete Purchase" id="delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
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
