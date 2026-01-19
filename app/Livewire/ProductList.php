<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products')]
class ProductList extends Component
{
    use WithPagination;

    public string $search = '';

    public function addToCart(int $productId): void
    {
        if (!Auth::check()) {
            $this->redirect(route('login'));
            return;
        }

        $product = Product::findOrFail($productId);

        if ($product->stock_quantity < 1) {
            session()->flash('error', 'This product is out of stock.');
            return;
        }

        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            if ($cartItem->quantity < $product->stock_quantity) {
                $cartItem->increment('quantity');
            } else {
                session()->flash('error', 'Cannot add more items. Stock limit reached.');
                return;
            }
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        $this->dispatch('cart-updated');
        session()->flash('success', 'Product added to cart!');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->paginate(9);

        return view('livewire.product-list', [
            'products' => $products,
        ]);
    }
}
