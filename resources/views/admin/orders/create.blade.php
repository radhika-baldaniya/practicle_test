@extends('admin.layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Create New Order</h4>
        </div>

        <div class="card-body p-4">

            <form id="orderForm" action="{{ route('admin.orders.store') }}" method="POST" data-parsley-validate>
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Customer</label>
                    <select name="customer_id"
                            class="form-control select2"
                            required
                            data-parsley-errors-container="#customer-error"
                            data-parsley-required-message="Please select a customer">
                        <option value="" disabled selected>Select Customer</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->email }})</option>
                        @endforeach
                    </select>
                    <div id="customer-error"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Order Date</label>
                    <input type="text"
                           name="order_date"
                           class="form-control datepicker"
                           required
                           placeholder="Select date"
                           data-parsley-required-message="Order date is required">
                </div>

                <hr>

                <h5 class="fw-bold">Products</h5>

                <div id="products-container">

                    <div class="product-row border rounded p-3 mb-3">
                        <div class="row g-3 align-items-end">

                            <div class="col-md-5">
                                <label class="form-label">Product</label>
                                <select name="products[0][product_id]"
                                        class="form-control select2 product-select"
                                        required
                                        data-parsley-errors-container="#product-error-0"
                                        data-parsley-required-message="Please select a product">
                                    <option value="" disabled selected>Select Product</option>
                                    @foreach($products->where('stock_quantity', '>', 0) as $p)
                                        <option value="{{ $p->id }}" data-price="{{ $p->price }}" data-stock="{{ $p->stock_quantity }}">
                                            {{ $p->name }} (Stock: {{ $p->stock_quantity }})
                                        </option>
                                    @endforeach
                                </select>
                                <div id="product-error-0"></div>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Qty</label>
                                <input type="number"
                                       min="1"
                                       value="1"
                                       name="products[0][quantity]"
                                       class="form-control quantity-input"
                                       required
                                       data-parsley-min="1"
                                       data-parsley-required-message="Enter quantity">
                            </div>

                            

                            <div class="col-md-2">
                                <label class="form-label">Price</label>
                                {{-- <input type="number"
                                       step="0.01"
                                       min="0.01"
                                       data-parsley-min-message="Price must be greater than 0"
                                       name="products[0][price]"
                                       value="0.00"
                                       class="form-control price-input"
                                       required
                                       data-parsley-required-message="Enter price"> --}}

                                <input type="number"
                                step="0.01"
                                min="0.01"
                                max="999999.99"
                                name="products[0][price]"
                                value="0.01"
                                class="form-control price-input"
                                required
                                data-parsley-required-message="Enter price"
                                data-parsley-min="0.01"
                                data-parsley-min-message="Price must be greater than 0"
                                data-parsley-max="999999.99"
                                data-parsley-max-message="Price is too large">
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <button type="button" class="btn btn-danger w-100 btn-remove">Remove</button>
                            </div>

                        </div>

                        <small class="text-danger stock-error d-none">⚠ Quantity exceeds stock!</small>

                    </div>

                </div>

                <button type="button" id="addProduct" class="btn btn-outline-primary mb-3">+ Add Product</button>

                <div class="mb-3">
                    <label class="form-label fw-bold">Total Amount</label>
                    <input type="text" id="totalAmount" class="form-control" readonly value="0.00">
                </div>

                <button class="btn btn-success w-100 py-2">Create Order</button>

            </form>

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
$(function(){

    function initSelect2(){
        $('.select2').select2({ width:'100%' });
    }
    initSelect2();

    $(".datepicker").flatpickr({ dateFormat: "Y-m-d" });

    let form = $("#orderForm").parsley();

    function recalcTotal(){
        let total = 0;
        $(".product-row").each(function(){
            let qty = parseFloat($(this).find(".quantity-input").val()) || 0;
            let price = parseFloat($(this).find(".price-input").val()) || 0;
            total += qty * price;
        });
        $("#totalAmount").val(total.toFixed(2));
    }

    $("#addProduct").click(function(){
        let index = $(".product-row").length;
        let id = Date.now(); 

        let html = `
        <div class="product-row border rounded p-3 mb-3">
            <div class="row g-3 align-items-end">

                <div class="col-md-5">
                    <label class="form-label">Product</label>
                    <select name="products[${index}][product_id]"
                            class="form-control select2 product-select"
                            required
                            data-parsley-errors-container="#product-error-${id}">
                        <option value="" disabled selected>Select Product</option>
                        @foreach($products->where('stock_quantity', '>', 0) as $p)
                            <option value="{{ $p->id }}" data-price="{{ $p->price }}" data-stock="{{ $p->stock_quantity }}">
                                {{ $p->name }} (Stock: {{ $p->stock_quantity }})
                            </option>
                        @endforeach
                    </select>
                    <div id="product-error-${id}"></div>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Qty</label>
                    <input type="number" min="1"
                           name="products[${index}][quantity]"
                           value="1"
                           class="form-control quantity-input"
                           required data-parsley-min="1">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Price</label>
                    <input type="number"
                                step="0.01"
                                min="0.01"
                                max="999999.99"
                                name="products[${index}][price]"
                                value="0.01"
                                class="form-control price-input"
                                required
                                data-parsley-required-message="Enter price"
                                data-parsley-min="0.01"
                                data-parsley-min-message="Price must be greater than 0"
                                data-parsley-max="999999.99"
                                data-parsley-max-message="Price is too large">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-danger w-100 btn-remove">Remove</button>
                </div>

            </div>

            <small class="text-danger stock-error d-none">⚠ Quantity exceeds stock!</small>
        </div>`;

        $("#products-container").append(html);

        initSelect2();
        form.refresh();
    });

    $(document).on("click", ".btn-remove", function(){
        $(this).closest(".product-row").remove();
        recalcTotal();
    });

    $(document).on("change", ".product-select", function() {
        let row = $(this).closest(".product-row");

        let price = parseFloat($(this).find("option:selected").data("price")) || 0;
        let stock = parseFloat($(this).find("option:selected").data("stock")) || 0;

        row.find(".price-input").val(price.toFixed(2));
        row.find(".quantity-input").attr("data-stock", stock);

        recalcTotal();
    });

    $(document).on("input", ".quantity-input, .price-input", function(){
        let row = $(this).closest(".product-row");
        let qty = parseInt(row.find(".quantity-input").val());
        let stock = parseInt(row.find(".quantity-input").data("stock"));

        if(stock && qty > stock){
            row.find(".stock-error").removeClass("d-none");
        } else {
            row.find(".stock-error").addClass("d-none");
        }
        recalcTotal();
    });
    recalcTotal();

});
</script>
@endpush
