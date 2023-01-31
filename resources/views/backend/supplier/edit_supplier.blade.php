@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Supplier</h4> <br>
                        <form id="add-supplier-form" action="{{ route('edit.supplier', $supplier->id) }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="form-group col-sm-10">
                                    <input name="name" class="form-control" type="text" value="{{ $supplier->name }}" id="name">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="mobile_number" class="col-sm-2 col-form-label">Mobile Number</label>
                                <div class="form-group col-sm-10">
                                    <input name="mobile_number" class="form-control" type="text" value="{{ $supplier->mobile_number }}" id="mobile_number">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">E-mail</label>
                                <div class="form-group col-sm-10">
                                    <input name="email" class="form-control" type="email" value="{{ $supplier->email }}" id="email">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="address" class="col-sm-2 col-form-label">Address</label>
                                <div class="form-group col-sm-10">
                                    <input name="address" class="form-control" type="text" value="{{ $supplier->address }}" id="address">
                                </div>
                            </div>

                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Supplier!">
                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#add-supplier-form').validate({
            rules: {
                name: {
                    required: true,
                },
                mobile_number: {
                    required: true,
                },
                email: {
                    required: true,
                },
                address: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: 'Please input your name!',
                },
                mobile_number: {
                    required: 'Please input your mobile number!',
                },
                email: {
                    required: 'Please input your email address!',
                },
                address: {
                    required: 'Please input your address!',
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
