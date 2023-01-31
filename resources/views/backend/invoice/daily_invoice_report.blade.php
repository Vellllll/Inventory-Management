@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Daily Invoice Report</h4> <br>


                        <form action="{{ route('daily.invoice.report.pdf') }}" method="GET" target="_blank" id="daily-report-form">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="md-3 form-group">
                                        <label for="start_date" class="col-sm-4 col-form-label">Start Date</label>
                                        <input class="form-control" type="date" name="start_date" id="start_date" placeholder="YY-MM-DD">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="md-3 form-group">
                                        <label for="end_date" class="col-sm-4 col-form-label">End Date</label>
                                        <input class="form-control" type="date" name="end_date" id="end_date">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="md-3">
                                        <button style="margin-top: 38px" type="submit" class="btn btn-info">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>

                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#daily-report-form').validate({
            rules: {
                start_date: {
                    required: true,
                },
                end_date: {
                    required: true,
                },
            },
            messages: {
                start_date: {
                    required: 'Please input start date!',
                },
                end_date: {
                    required: 'Please input end date!',
                },
            },
            errorElement: 'span',
            errorPlacement: function(error,element){
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        })
    })
</script>

@endsection
