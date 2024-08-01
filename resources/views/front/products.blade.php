@extends('layouts.app')


@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
    <div class="container">
        <a href="{{ route('front.cart.view') }}" class="text-center" style="float: right;">Cart</h2></a>
            <h2 class="text-center">Product List</h2>

            <div class="card" style=" margin: 15px;">
            <div class="row">
               
                @foreach($products as $product)
                    <div class="col-md-4 col-sm-6">
                        <div class="card" style=" margin: 15px;">
                           
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->title }}</h5>
                                <p>Description: {{ \Str::limit($product->description, 50, '...') }}  </p>
                                <p>Price: ${{ number_format($product->price, 2) }}</p>
                                <form id="add-to-cart-form-{{ $product->id }}" action="{{ route('cart.add', $product->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1"> 
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        </div>
    

@endsection