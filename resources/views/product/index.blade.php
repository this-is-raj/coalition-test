@extends('master')
@section('body')
<div class="container">
    <div class="text-center mt-5">
        <h2>Coalition Test</h2>
    </div>
    <div class="text-right mb-3">
        <a class="btn btn-primary" href="{{ route('products.create') }}">
            Create Product
        </a>
    </div>


    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Product name </th>
                <th>Quantity in stock</th>
                <th>Price per item</th>
                <th>Datetime submitted</th>
                <th>Total value</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->product_name ?? '' }} </td>
                    <td>{{ $product->quantity ?? '' }} </td>
                    <td>{{ $product->price ?? '' }} </td>
                    <td>{{ !empty($product->datetime) ? \Carbon\Carbon::parse($product->datetime)->toFormattedDateString() : ''}} </td>
                    <td>{{ (!empty($product->quantity) && !empty($product->price)) ? $product->quantity * $product->price : '' }}</td>
                    <td><a href="{{ route('products.edit', $product->id) }}" class="btn btn-success btn-sm">Edit</a></td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
