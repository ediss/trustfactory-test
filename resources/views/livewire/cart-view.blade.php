<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-6">
    @if($cartItems->isEmpty())
        <div class="bg-white rounded-xl border border-slate-100 shadow-card text-center py-12">
            <svg class="mx-auto h-16 w-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-semibold text-slate-900">Your cart is empty</h3>
            <p class="mt-2 text-slate-500">Start shopping to add items to your cart.</p>
            <a href="{{ route('products') }}" class="mt-4 inline-flex items-center justify-center rounded-lg font-semibold transition duration-150 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-60 disabled:cursor-not-allowed bg-brand-600 text-white hover:bg-brand-700 focus-visible:outline-brand-600 px-6 py-2">Browse Products</a>
        </div>
    @else
        <div class="bg-white rounded-xl border border-slate-100 shadow-card overflow-hidden">
            <div class="p-4 sm:p-6 pb-0">
                <h1 class="text-xl font-semibold mb-4">Shopping Cart</h1>
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-12 w-12 object-cover rounded">
                                                @else
                                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $item->product->stock_quantity }} in stock</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($item->product->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                                class="p-1 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-600">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <input type="number" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity }}"
                                                wire:change="updateQuantity({{ $item->id }}, $event.target.value)"
                                                class="w-16 text-center border border-gray-300 rounded-md py-1">
                                            <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                                @if($item->quantity >= $item->product->stock_quantity) disabled @endif
                                                class="p-1 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-600 disabled:opacity-50">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${{ number_format($item->subtotal, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button wire:click="removeItem({{ $item->id }})"
                                            class="text-red-600 hover:text-red-800 font-medium">
                                            Remove
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="bg-white rounded-xl border border-slate-100 shadow-card">
            <div class="p-4 sm:p-6 space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-4">
                    <span class="text-lg font-medium text-slate-900">Total</span>
                    <span class="text-2xl font-bold text-brand-600">${{ number_format($cart->total, 2) }}</span>
                </div>
                <div class="flex flex-col sm:flex-row sm:justify-end sm:items-center gap-3">
                    <a href="{{ route('products') }}" class="inline-flex items-center justify-center rounded-lg font-semibold transition duration-150 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-60 disabled:cursor-not-allowed bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 focus-visible:outline-brand-600 px-5 py-2">Continue Shopping</a>
                    <a href="{{ route('checkout') }}" class="inline-flex items-center justify-center rounded-lg font-semibold transition duration-150 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-60 disabled:cursor-not-allowed bg-brand-600 text-white hover:bg-brand-700 focus-visible:outline-brand-600 px-5 py-2">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    @endif
</div>
