<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function products()
    {
        $products = Product::with('categories')->get();
        return view('front.products',compact('products'));
    }

    public function addToCart(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        
        
        $product = Product::findOrFail($productId);

        $cartItem = CartItem::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            
            $cartItem->increment('quantity', $request->quantity);
        } else {
        
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $request->quantity,
            ]);
    }
    return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function viewCart()
    {
        $cartItems = CartItem::with('product', 'user')->get();
        return view('front.cart', compact('cartItems'));
    }

    public function removeFromCart(Request $request,$cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->delete();
    
        return redirect()->route('front.cart.view')->with('success', 'Item removed from cart successfully!');
    }
}
