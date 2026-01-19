<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Order history</h1>
            <p class="text-slate-500 text-sm">All orders placed from this account.</p>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-xl border border-slate-100 shadow-card text-center py-12">
            <h3 class="text-lg font-semibold text-slate-900">No orders yet</h3>
            <p class="mt-2 text-slate-500">When you place an order, it will appear here.</p>
            <a href="{{ route('products') }}" class="mt-4 inline-flex items-center justify-center rounded-lg font-semibold transition duration-150 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 bg-brand-600 text-white hover:bg-brand-700 focus-visible:outline-brand-600 px-6 py-2">Shop products</a>
        </div>
    @else
        <div class="bg-white rounded-xl border border-slate-100 shadow-card overflow-hidden">
            <div class="divide-y divide-slate-100">
                @foreach($orders as $order)
                    <div class="p-4 sm:p-6 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div class="space-y-1">
                                <p class="text-sm text-slate-500">Order #{{ $order->id }}</p>
                                <p class="text-lg font-semibold text-slate-900">${{ number_format($order->total_amount, 2) }}</p>
                                <p class="text-sm text-slate-500">{{ $order->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-blue-50 text-blue-700">{{ ucfirst($order->status) }}</span>
                        </div>
                        <div class="border border-slate-100 rounded-lg divide-y divide-slate-100">
                            @foreach($order->items as $item)
                                <div class="p-3 flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 bg-slate-100 rounded flex items-center justify-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-10 w-10 object-cover rounded">
                                            @else
                                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900">{{ $item->product->name ?? 'Deleted product' }}</p>
                                            <p class="text-slate-500">Qty: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</p>
                                        </div>
                                    </div>
                                    <p class="font-medium text-slate-900">${{ number_format($item->quantity * $item->unit_price, 2) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            {{ $orders->links() }}
        </div>
    @endif
</div>

