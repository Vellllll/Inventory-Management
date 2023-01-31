@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Unit</h4> <br>
                        <form id="add-unit-form" action="{{ route('edit.unit', $unit->id) }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="unit_name" class="col-sm-2 col-form-label">Unit Name</label>
                                <div class="form-group col-sm-10">
                                    <input name="unit_name" class="form-control" type="text" value="{{ $unit->name }}" id="unit_name">
                                </div>
                            </div>

                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Edit Unit!">
                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#add-unit-form').validate({
            rules: {
                unit_name: {
                    required: true,
                },
            },
            messages: {
                unit_name: {
                    required: 'Please input unit name!',
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
