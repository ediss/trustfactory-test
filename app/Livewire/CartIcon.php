<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CartIcon extends Component
{
    public int $itemCount = 0;

    public function mount(): void
    {
        $this->updateCount();
    }

    #[On('cart-updated')]
    public function updateCount(): void
    {
        $this->itemCount = 0;

        if (Auth::check()) {
            $cart = Cart::with('items')->where('user_id', Auth::id())->first();
            if ($cart) {
                $this->itemCount = $cart->items->sum('quantity');
            }
        }
    }

    public function render()
    {
        return view('livewire.cart-icon');
    }
}
