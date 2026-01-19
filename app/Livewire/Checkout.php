<?php

namespace App\Livewire;

use App\Jobs\CheckLowStockJob;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Checkout extends Component
{
    /**
     * @throws \Throwable
     */
    public function placeOrder(): void
    {
        if (!Auth::check()) {
            $this->redirect(route('login'));
            return;
        }

        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            session()->flash('error', 'Your cart is empty.');
            return;
        }

        // Verify stock availability
        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock_quantity) {
                session()->flash('error', "Not enough stock for {$item->product->name}. Available: {$item->product->stock_quantity}");
                return;
            }
        }

        DB::transaction(function () use ($cart) {
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $cart->total,
                'status' => 'completed',
            ]);

            // Create order items and update stock
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                ]);

                // Decrement stock
                $item->product->decrement('stock_quantity', $item->quantity);

                // Check for low stock and dispatch job
                CheckLowStockJob::dispatch($item->product->fresh());
            }

            // Clear cart
            $cart->items()->delete();
        });

        $this->dispatch('cart-updated');
        session()->flash('success', 'Order placed successfully!');
        $this->redirect(route('products'));
    }

    public function render()
    {
        $cart = null;
        $cartItems = collect();

        if (Auth::check()) {
            $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
            $cartItems = $cart->items ?? collect();
        }

        return view('livewire.checkout', [
            'cart' => $cart,
            'cartItems' => $cartItems,
        ]);
    }
}
