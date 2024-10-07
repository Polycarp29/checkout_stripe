<!-- resources/views/products/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Edit Product</h1>
    
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf

        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" value="{{ $product->name }}">
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="text" name="price" value="{{ $product->price }}">
        </div>
        <div>
            <label for='name'>Image:</label>
            <input type='text' name = 'image' value="{{$product->image}}">
        </div>
        <button type="submit">Update Product</button>
    </form>
@endsection
