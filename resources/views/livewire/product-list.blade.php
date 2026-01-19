<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-6">
    <!-- Search Bar and heading -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Products</h1>
            <p class="text-slate-500 text-sm">Browse and add items to your cart.</p>
        </div>
        <div class="w-full sm:w-80">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search products..."
                class="w-full rounded-lg border border-slate-200 focus:border-brand-400 focus:ring-brand-200/80 px-4 py-2">
        </div>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-xl border border-slate-100 shadow-card overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="h-48 bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center relative">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                    @else
                        <svg class="h-20 w-20 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    @endif
                    @if($product->stock_quantity <= 3)
                        <span class="absolute top-3 right-3 z-10 inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold shadow-sm border {{ $product->stock_quantity > 0 ? 'bg-sky-100 text-sky-800 border-sky-200' : 'bg-red-100 text-red-700 border-red-200' }}">
                            {{ $product->stock_quantity > 0 ? 'Low stock' : 'Out of stock' }}
                        </span>
                    @endif
                </div>
                <div class="p-4 sm:p-6 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">{{ $product->name }}</h3>
                            <p class="text-slate-600 text-sm line-clamp-2">{{ $product->description }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-brand-600">${{ number_format($product->price, 2) }}</span>
                            <p class="text-xs text-slate-500">{{ $product->stock_quantity }} in stock</p>
                        </div>
                    </div>
                    <button wire:click="addToCart({{ $product->id }})"
                        @if($product->stock_quantity < 1) disabled @endif
                        class="w-full inline-flex items-center justify-center rounded-lg font-semibold transition duration-150 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-60 disabled:cursor-not-allowed bg-brand-600 text-white hover:bg-brand-700 focus-visible:outline-brand-600 py-2 px-4">
                        <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
                            {{ $product->stock_quantity > 0 ? 'Add to Cart' : 'Unavailable' }}
                        </span>
                        <span wire:loading wire:target="addToCart({{ $product->id }})">
                            Adding...
                        </span>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-xl border border-slate-100 shadow-card">
                <p class="text-slate-500 text-lg">No products found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
