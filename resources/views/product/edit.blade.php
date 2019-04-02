@extends('master')
@section('body')
<div class="container">
    <div class="text-center mt-5">
        <h2>Coalition Test</h2>
    </div>
    <div class="text-right mb-3">
        <a class="btn btn-primary" href="{{ route('products.index') }}">
            Products
        </a>
    </div>

    <form id="product-form">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="product_name"> Product Name </label>
            <input type="text" class="form-control" name="product_name" id="product_name" value="{{ $product->product_name ?? '' }}" required>
        </div>
        <div class="form-group">
            <label for="quantity"> Quantity in stock</label>
            <input type="number" class="form-control" name="quantity" id="quantity" value="{{ $product->quantity ?? '' }}" required>
        </div>
        <div class="form-group">
            <label for="price"> Price per item </label>
            <input type="text" class="form-control" name="price" id="price" value="{{ $product->price ?? '' }}" required>
        </div>

        <div class="form-group">
            <button type="button" onclick="updateProduct()">
                Update Product
            </button>
        </div>
    </form>
</div>
@endsection
@section('js')
<script>
    function updateProduct () {
        $.ajax({
            'type': 'POST',
            'url': '{{ route('products.update', $product->id) }}',
            'data': $('#product-form').serialize(),
            'success': function () {
                window.location.href = '{{ route('products.index') }}';
            },
            'error': function () {}
        });
    }
</script>
@endsection

