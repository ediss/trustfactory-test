<div class="relative">
    <a href="{{ route('cart') }}" wire:navigate class="flex items-center gap-2 rounded-full px-3 py-2 hover:bg-slate-100 text-slate-700">
        <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <span class="hidden sm:inline text-sm font-medium">Cart</span>
        @if($itemCount > 0)
            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-red-100 text-red-700">{{ $itemCount }}</span>
        @endif
    </a>
</div>
