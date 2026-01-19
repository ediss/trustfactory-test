<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-6">
    @if($cartItems->isEmpty())
        <div class="bg-white rounded-xl border border-slate-100 shadow-card text-center py-12">
            <svg class="mx-auto h-16 w-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-semibold text-slate-900">Your cart is empty</h3>
            <p class="mt-2 text-slate-500">Add some products to your cart before checking out.</p>
            <a href="{{ route('products') }}" class="mt-4 inline-flex items-center justify-center rounded-lg font-semibold transition duration-150 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-60 disabled:cursor-not-allowed bg-brand-600 text-white hover:bg-brand-700 focus-visible:outline-brand-600 px-6 py-2">Browse Products</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Summary -->
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-xl border border-slate-100 shadow-card">
                    <div class="p-4 sm:p-6">
                        <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex items-center justify-between border-b pb-4">
                                    <div class="flex items-center">
                                        <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-16 w-16 object-cover rounded">
                                            @else
                                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="font-medium text-gray-900">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × ${{ number_format($item->product->price, 2) }}</p>
                                        </div>
                                    </div>
                                    <span class="font-medium text-gray-900">${{ number_format($item->subtotal, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-slate-100 shadow-card sticky top-4">
                    <div class="p-4 sm:p-6 space-y-3">
                        <h2 class="text-xl font-semibold">Payment Summary</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>${{ number_format($cart->total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span class="text-green-600">Free</span>
                            </div>
                            <div class="border-t pt-3">
                                <div class="flex justify-between text-lg font-semibold">
                                    <span>Total</span>
                                    <span class="text-blue-600">${{ number_format($cart->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <button wire:click="placeOrder" wire:loading.attr="disabled"
                            class="w-full inline-flex items-center justify-center rounded-lg font-semibold transition duration-150 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-60 disabled:cursor-not-allowed bg-brand-600 text-white hover:bg-brand-700 focus-visible:outline-brand-600 py-3 px-6">
                            <span wire:loading.remove wire:target="placeOrder">Place Order</span>
                            <span wire:loading wire:target="placeOrder">Processing...</span>
                        </button>
                        <a href="{{ route('cart') }}" class="block text-center text-slate-600 hover:text-slate-800">
                            ← Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
