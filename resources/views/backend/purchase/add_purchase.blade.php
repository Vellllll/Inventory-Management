@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Purchase</h4> <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="md-3">
                                    <label for="purchase_date" class="col-sm-2 col-form-label">Date</label>
                                    <input class="form-control" type="date" name="purchase_date" id="purchase_date">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-3">
                                    <label for="purchase_number" class="col-form-label">Purchase Number</label>
                                    <input class="form-control" type="text" name="purchase_number" id="purchase_number">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-3">
                                    <label for="supplier_id" class="col-sm-2 col-form-label">Supplier</label>
                                    <select name="supplier_id" class="form-select select2" aria-label="Default select example" id="supplier_id">
                                        <option selected="">Open this select menu</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="md-3">
                                    <label for="category_id" class="col-sm-2 col-form-label">Category</label>
                                    <select name="category_id" class="form-select select2" aria-label="Default select example" id="category_id">
                                        <option selected="">Open this select menu</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-3">
                                    <label for="product_id" class="col-sm-2 col-form-label">Product</label>
                                    <select name="product_id" class="form-select select2" aria-label="Default select example" id="product_id">
                                        <option selected="">Open this select menu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="md-3">
                                    <button class="btn btn-dark btn-rounded waves-effect waves-light addeventmore" type="submit" style="margin-top: 2.7em"><i class="fas fa-plus-circle"></i> Add More</button>
                                    {{-- <i class="fas fa-plus-circle btn btn-dark btn-rounded waves-effect waves-light addeventmore" style="margin-top: 2.7em"> Add More</i> --}}
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="card-body">
                        <form action="{{ route('add.purchase') }}" method="POST">
                            @csrf
                            <table class="table-sm table-bordered" width="100%" style="border-color:#ddd;">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Product Name</th>
                                        <th>PSC/KG</th>
                                        <th>Unit Price</th>
                                        <th>Description</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody class="addRow" id="addRow"></tbody>

                                <tbody>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td>
                                            <input type="text" name="estimated_amount" id="estimated_amount" value="0" class="form-control estimated_amount" readonly style="background-color: #ddd">
                                        </td>
                                    </tr>
                                </tbody>
                            </table> <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info" id="storeButton">Purchase Store</button>
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
        $('#add-product-form').validate({
            rules: {
                product_name: {
                    required: true,
                },
                supplier_id: {
                    required: true,
                },
                unit_id: {
                    required: true,
                },
                category_id: {
                    required: true,
                },
            },
            messages: {
                product_name: {
                    required: 'Please input product name!',
                },
                supplier_id: {
                    required: 'Please select supplier!',
                },
                unit_id: {
                    required: 'Please select unit!',
                },
                category_id: {
                    required: 'Please select category!',
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
    $(function(){
        $(document).on('change','#supplier_id',function(){
            var supplier_id = $(this).val();
            $.ajax({
                url:"{{ route('get.category') }}",
                type:"GET",
                data:{supplier_id:supplier_id},
                success:function(data){
                    var html = '<option value="">Select Category</option>';
                    $.each(data,function(key,v){
                        html += '<option value=" '+v.category_id+' "> '+v.category.name+'</option>';
                    });
                    $('#category_id').html(html);
                }
            })
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
                    var html = '<option value="">Select Product</option>';
                    $.each(data,function(key,v){
                        html += '<option value=" '+v.id+' "> '+v.name+'</option>';
                    });
                    $('#product_id').html(html);
                }
            })
        })
    })
</script>

<script id="document-template" type="text/x-handlebars-template">

    <tr class="delete_add_more_item" id="delete_add_more_item">
        <input type="hidden" name="date[]" value="@{{ date }}">
        <input type="hidden" name="purchase_number[]" value="@{{ purchase_number }}">
        <input type="hidden" name="supplier_id[]" value="@{{ supplier_id }}">

        <td>
            <input type="hidden" name="category_id[]" value="@{{ category_id }}">
            @{{ category_name }}
        </td>
        <td>
            <input type="hidden" name="product_id[]" value="@{{ product_id }}">
            @{{ product_name }}
        </td>
        <td>
            <input type="number" name="buying_qty[]" min="1" class="form-control buying_qty text-right" id="">
        </td>
        <td>
            <input type="number" name="unit_price[]" class="form-control unit_price text-right" id="">
        </td>
        <td>
            <input type="text" name="description[]" class="form-control" id="">
        </td>
        <td>
            <input type="number" class="form-control buying_price text-right" name="buying_price[]" value="0" readonly>
        </td>
        <td>
            <i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i>
        </td>
    </tr>
</script>

<script>
    $(document).ready(function(){
        $(document).on("click", ".addeventmore", function(){
            var purchase_date = $('#purchase_date').val();
            var purchase_number = $('#purchase_number').val();
            var supplier_id = $('#supplier_id').val();
            var category_id = $('#category_id').val();
            var category_name = $('#category_id').find('option:selected').text();
            var product_id = $('#product_id').val();
            var product_name = $('#product_id').find('option:selected').text();

            if(purchase_date == ''){
                $.notify("Date is required!", {globalPosition:'top right', className:'error'});
                return false;
            }
            if(purchase_number == ''){
                $.notify("Purchase number is required!", {globalPosition:'top right', className:'error'});
                return false;
            }
            if(supplier_id == ''){
                $.notify("Supplier is required!", {globalPosition:'top right', className:'error'});
                return false;
            }
            if(category_id == ''){
                $.notify("Category is required!", {globalPosition:'top right', className:'error'});
                return false;
            }
            if(product_id == ''){
                $.notify("Product is required!", {globalPosition:'top right', className:'error'});
                return false;
            }

            var source = $("#document-template").html();
            var template = Handlebars.compile(source);

            var data = {
                date:purchase_date,
                purchase_number:purchase_number,
                supplier_id:supplier_id,
                category_id:category_id,
                category_name:category_name,
                product_id:product_id,
                product_name:product_name
            }

            var html = template(data);
            $('#addRow').append(html);
        });

        $(document).on("click", ".removeeventmore", function(e){
            $(this).closest('.delete_add_more_item').remove();
            totalAmountPrice();
        });

        $(document).on("keyup click", ".buying_qty, .unit_price", function(){
            var unit_price = $(this).closest("tr").find("input.unit_price").val();
            var buying_qty = $(this).closest("tr").find("input.buying_qty").val();
            var total_price = unit_price * buying_qty;
            $(this).closest("tr").find("input.buying_price").val(total_price);
            totalAmountPrice();
        });

        function totalAmountPrice(){
            var sum = 0;
            $(".buying_price").each(function(){
                var price = $(this).val();
                if(!isNaN(price) && price.length != 0){
                    sum += parseFloat(price);
                }
            })
            $("#estimated_amount").val(sum);
        }
    });
</script>

@endsection
