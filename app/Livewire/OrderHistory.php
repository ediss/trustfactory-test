<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Orders')]
class OrderHistory extends Component
{
    use WithPagination;

    private function orders(): LengthAwarePaginator
    {
        return Order::query()
            ->with(['items.product'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
    }

    public function render(): View
    {
        $orders = $this->orders();

        return view('livewire.order-history', [
            'orders' => $orders,
        ]);
    }
}

