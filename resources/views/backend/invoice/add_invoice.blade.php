@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Invoice</h4> <br>



                        <div class="row">

                            <div class="col-md-1">
                                <div class="md-3">
                                    <label for="invoice_no" class="col-form-label">Invoice Number</label>
                                    <input class="form-control" type="text" name="invoice_no" id="invoice_no" value="{{ $invoice_no }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="md-3">
                                    <label for="invoice_date" class="col-sm-2 col-form-label">Date</label>
                                    <input class="form-control" type="date" name="invoice_date" id="invoice_date" value="{{ $date }}">
                                </div>
                            </div>

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

                            <div class="col-md-3">
                                <div class="md-3">
                                    <label for="product_id" class="col-sm-2 col-form-label">Product</label>
                                    <select name="product_id" class="form-select select2" aria-label="Default select example" id="product_id">
                                        <option selected="" disabled>Open this select menu</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="md-3">
                                    <label for="stock" class="col-form-label">Stock</label>
                                    <input class="form-control" type="text" name="stock" id="stock" readonly>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="md-3">
                                    <button class="btn btn-dark btn-rounded waves-effect waves-light addeventmore" type="submit" style="margin-top: 2.7em"><i class="fas fa-plus-circle"></i> Add More</button>
                                    {{-- <i class="fas fa-plus-circle btn btn-dark btn-rounded waves-effect waves-light addeventmore" style="margin-top: 2.7em"> Add More</i> --}}
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="card-body">
                        <form action="{{ route('add.invoice') }}" method="POST">
                            @csrf
                            <table class="table-sm table-bordered" width="100%" style="border-color:#ddd;">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Product Name</th>
                                        <th>PSC/KG</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody class="addRow" id="addRow"></tbody>

                                <tbody>
                                    <tr>
                                        <td colspan="4">Discount</td>
                                        <td>
                                            <input type="text" name="discount_amount" id="discount_amount" class="form-control" placeholder="Discount Amount">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">Grand Total</td>
                                        <td>
                                            <input type="text" name="estimated_amount" id="estimated_amount" value="0" class="form-control estimated_amount" readonly style="background-color: #ddd">
                                        </td>
                                    </tr>
                                </tbody>
                            </table> <br>

                            <div class="form-row mb-3">
                                <div class="form-group col-md-12">
                                    <textarea name="description" id="description" class="form-control" placeholder="Write description here!"></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="form-group col-md-3">
                                    <label for="paid_status">Paid Status</label>
                                    <select name="paid_status" id="paid_status" class="form-select mb-3">
                                        <option value="" selected disabled>Select Status</option>
                                        <option value="full_paid">Full Paid</option>
                                        <option value="full_due">Full Due</option>
                                        <option value="partial_paid">Partial Paid</option>
                                    </select>
                                    <input type="text" name="paid_amount" id="paid_amount" class="form-control paid_amount" placeholder="Enter paid amount!" style="display: none">
                                </div>

                                <div class="form-group col-md-9">
                                    <label for="customer">Customer Name</label>
                                    <select name="customer_id" id="customer_id" class="form-select mb-3">
                                        <option value="" selected disabled>Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->mobile_number }}</option>
                                        @endforeach
                                        <option value="0">New Customer</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Hidden Customer Form --}}
                            <div class="row new-customer mb-3" style="display: none">
                                <div class="form-group col-md-4">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Customer name">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" name="mobile_number" id="mobile_number" class="form-control" placeholder="Customer mobil number">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Customer email">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-info" id="storeButton">Add Invoice</button>
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

<script>
    $(function(){
        $(document).on('change','#product_id',function(){
            var product_id = $(this).val();
            $.ajax({
                url:"{{ route('get.stock') }}",
                type:"GET",
                data:{product_id:product_id},
                success:function(data){
                    $('#stock').val(data);
                }
            })
        })
    })
</script>

<script id="document-template" type="text/x-handlebars-template">

    <tr class="delete_add_more_item" id="delete_add_more_item">
        <input type="hidden" name="invoice_date" value="@{{ invoice_date }}">
        <input type="hidden" name="invoice_no" value="@{{ invoice_no }}">

        <td>
            <input type="hidden" name="category_id[]" value="@{{ category_id }}">
            @{{ category_name }}
        </td>
        <td>
            <input type="hidden" name="product_id[]" value="@{{ product_id }}">
            @{{ product_name }}
        </td>
        <td>
            <input type="number" name="selling_qty[]" min="1" class="form-control selling_qty text-right" id="">
        </td>
        <td>
            <input type="number" name="unit_price[]" class="form-control unit_price text-right" id="">
        </td>
        <td>
            <input type="number" class="form-control selling_price text-right" name="selling_price[]" value="0" readonly>
        </td>
        <td>
            <i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i>
        </td>
    </tr>
</script>

<script>
    $(document).ready(function(){
        $(document).on("click", ".addeventmore", function(){
            var invoice_date = $('#invoice_date').val();
            var invoice_no = $('#invoice_no').val();
            var category_id = $('#category_id').val();
            var category_name = $('#category_id').find('option:selected').text();
            var product_id = $('#product_id').val();
            var product_name = $('#product_id').find('option:selected').text();



            if(invoice_date == ''){
                $.notify("Date is required!", {globalPosition:'top right', className:'error'});
                return false;
            }
            if(invoice_no == ''){
                $.notify("Purchase number is required!", {globalPosition:'top right', className:'error'});
                return false;
            }
            if(category_id == null){
                $.notify("Category is required!", {globalPosition:'top right', className:'error'});
                return false;
            }
            if(product_id == null){
                $.notify("Product is required!", {globalPosition:'top right', className:'error'});
                return false;
            }

            var source = $("#document-template").html();
            var template = Handlebars.compile(source);

            var data = {
                invoice_date:invoice_date,
                invoice_no:invoice_no,
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

        $(document).on("keyup click", ".selling_qty, .unit_price", function(){
            var unit_price = $(this).closest("tr").find("input.unit_price").val();
            var selling_qty = $(this).closest("tr").find("input.selling_qty").val();
            var total_price = unit_price * selling_qty;
            $(this).closest("tr").find("input.selling_price").val(total_price);
            $('#discount_amount').trigger('keyup');
        });

        $(document).on('keyup', '#discount_amount', function(){
            totalAmountPrice();
        })

        function totalAmountPrice(){
            var sum = 0;
            $(".selling_price").each(function(){
                var price = $(this).val();
                if(!isNaN(price) && price.length != 0){
                    sum += parseFloat(price);
                }
            });

            var discount_amount = parseFloat($('#discount_amount').val());

            if(!isNaN(discount_amount) && discount_amount.length != 0){
                sum -= parseFloat(discount_amount);
            }

            $("#estimated_amount").val(sum);
        }
    });
</script>

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

<script>
    $(document).on('change', '#customer_id', function(){
        var customer_id = $(this).val();
        if (customer_id == '0'){
            $('.new-customer').show();
        } else {
            $('.new-customer').hide();
        }
    })
</script>

@endsection
