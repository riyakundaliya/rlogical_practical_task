

@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('front.products') }}" class="btn btn-sm btn-primary">Back</a>
                                
    <h1>Your Cart</h1>

    @if($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->title }}</td>
                         <td>${{ number_format($item->quantity, 2) }}</td>
                        <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                        <td>
                           <a href="{{ route('cart.remove', $item->id) }}" class="btn btn-sm btn-danger">Remove</a>
                                
                        
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Total: ${{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</strong></p>

        <a href="#" class="btn btn-primary">Proceed to Checkout</a>
    @endif
</div>
@endsection
