@extends('layouts.app')


@section('content')
<div class="container">
    <h1>User Cart Items</h1>

    @if($cartItems->isEmpty())
        <p>No items in any user's cart.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $cartItem)
                    <tr>
                        <td>{{ $cartItem->user->name }}</td>
                        <td>{{ $cartItem->product->title }}</td>
                        <td>{{ $cartItem->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection