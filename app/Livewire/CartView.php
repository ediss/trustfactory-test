<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CartView extends Component
{
    public function updateQuantity(int $cartItemId, int $quantity): void
    {
        $cartItem = CartItem::with('product')->findOrFail($cartItemId);

        if ($cartItem->cart->user_id !== Auth::id()) {
            return;
        }

        if ($quantity < 1) {
            $this->removeItem($cartItemId);
            return;
        }

        if ($quantity > $cartItem->product->stock_quantity) {
            $this->dispatch('notify', type: 'error', title: 'Stock limit', message: 'Requested quantity exceeds available stock.');
            return;
        }

        $cartItem->update(['quantity' => $quantity]);
        $this->dispatch('cart-updated');
        $this->dispatch('notify', type: 'success', title: 'Updated', message: 'Cart quantity updated.');
    }

    public function removeItem(int $cartItemId): void
    {
        $cartItem = CartItem::findOrFail($cartItemId);

        // Verify ownership
        if ($cartItem->cart->user_id !== Auth::id()) {
            return;
        }

        $cartItem->delete();
        $this->dispatch('cart-updated');
        $this->dispatch('notify', type: 'success', title: 'Removed', message: 'Item removed from cart.');
    }

    #[On('cart-updated')]
    public function refreshCart(): void
    {
        // This will trigger a re-render
    }

    public function render()
    {
        $cart = null;
        $cartItems = collect();

        if (Auth::check()) {
            $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
            $cartItems = $cart->items ?? collect();
        }

        return view('livewire.cart-view', [
            'cart' => $cart,
            'cartItems' => $cartItems,
        ]);
    }
}
