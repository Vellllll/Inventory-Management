@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Supplier & Product Wise Report</h4>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <strong>Supplier Wise Report</strong>
                                <input type="radio" name="supplier_product_wise" value="supplier_wise" class="search_value" id="">
                                &nbsp;&nbsp;
                                <strong>Product Wise Report</strong>
                                <input type="radio" name="supplier_product_wise" value="product_wise" class="search_value" id="">
                            </div>
                        </div>

                        <div class="show_supplier" style="display: none">
                            <form action="{{ route('supplier.wise.pdf') }}" method="GET" id="supplier-form" target="_blank">
                                <div class="row">
                                    <label for="supplier_id">Supplier Name</label>
                                    <div class="col-sm-8 form-group">
                                        <select name="supplier_id" id="supplier_id" class="form-select select2">
                                            <option selected disabled>Select Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="show_product" style="display: none">
                            <form action="{{ route('product.wise.pdf') }}" method="GET" id="product-form" target="_blank">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="md-3">
                                            <label for="category_id" class="col-sm-2 col-form-label">Category</label>
                                            <select name="category_id" class="form-select select2" aria-label="Default select example" id="category_id">
                                                <option selected="" disabled>Open this select menu</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="md-3">
                                            <label for="product_id" class="col-sm-2 col-form-label">Product</label>
                                            <select name="product_id" class="form-select select2" aria-label="Default select example" id="product_id">
                                                <option selected="" disabled>Open this select menu</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 37px">Search</button>
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
        $('#supplier-form').validate({
            rules: {
                supplier_id: {
                    required: true,
                },
            },
            messages: {
                supplier_id: {
                    required: 'Please select supplier!',
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

<script>
    $(document).ready(function(){
        $(document).on('change', '.search_value', function(){
            var search_value = $(this).val();
            if(search_value == 'supplier_wise'){
                $('.show_supplier').show();
            } else {
                $('.show_supplier').hide();
            }
        })
    })
</script>

<script>
    $(document).ready(function(){
        $(document).on('change', '.search_value', function(){
            var search_value = $(this).val();
            if(search_value == 'product_wise'){
                $('.show_product').show();
            } else {
                $('.show_product').hide();
            }
        })
    })
</script>

<script>
    $(function(){
        $(document).on('change','#category_id',function(){
            var category_id = $(this).val();
            $.ajax({
                url:"{{ route('get.product') }}",
                type:"GET",
                data:{category_id:category_id},
                success:function(data){
                    var html = '<option selected disabled>Select Product</option>';
                    $.each(data,function(key,v){
                        html += '<option value=" '+v.id+' "> '+v.name+'</option>';
                    });
                    $('#product_id').html(html);
                }
            })
        })
    })
</script>

@endsection

