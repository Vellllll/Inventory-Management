@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Customer Wise Report</h4>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <strong>Customer Wise Credit Report</strong>
                                <input type="radio" name="customer_wise_report" value="credit_wise" class="search_value" id="">
                                &nbsp;&nbsp;
                                <strong>Customer Wise Paid Report</strong>
                                <input type="radio" name="customer_wise_report" value="paid_wise" class="search_value" id="">
                            </div>
                        </div>

                        <div class="show_credit" style="display: none">
                            <form action="{{ route('customer.credit.report') }}" method="GET" id="credit-form" target="_blank">
                                <div class="row">
                                    <label for="customer_id">Customer Name</label>
                                    <div class="col-sm-8 form-group">
                                        <select name="customer_id" id="customer_id" class="form-select select2">
                                            <option selected disabled>Select Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="show_paid" style="display: none">
                            <form action="{{ route('customer.paid.report') }}" method="GET" id="paid-form" target="_blank">
                                <div class="row">
                                    <label for="customer_id">Customer Name</label>
                                    <div class="col-sm-8 form-group">
                                        <select name="customer_id" id="customer_id" class="form-select select2">
                                            <option selected disabled>Select Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

<script>
    $(document).ready(function(){
        $(document).on('change', '.search_value', function(){
            var search_value = $(this).val();
            if(search_value == 'credit_wise'){
                $('.show_credit').show();
            } else {
                $('.show_credit').hide();
            }
        })
    })
</script>

<script>
    $(document).ready(function(){
        $(document).on('change', '.search_value', function(){
            var search_value = $(this).val();
            if(search_value == 'paid_wise'){
                $('.show_paid').show();
            } else {
                $('.show_paid').hide();
            }
        })
    })
</script>

@endsection

