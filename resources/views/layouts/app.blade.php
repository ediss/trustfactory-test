<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased min-h-screen bg-gradient-to-b from-slate-50 via-slate-50 to-white">
        <div class="min-h-screen">
            <div aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-start justify-end px-4 py-6 sm:p-6 z-50"
                 x-data="toastStack({
                    initial: [
                        @if (session()->has('success')) { type: 'success', title: 'Success', message: '{{ addslashes(session('success')) }}', duration: 6000 }, @endif
                        @if (session()->has('error')) { type: 'error', title: 'Error', message: '{{ addslashes(session('error')) }}', duration: 6000 }, @endif
                    ]
                 })">
                <div class="w-full max-w-sm space-y-3" id="toast-stack">
                    <template x-for="toast in toasts" :key="toast.id">
                        <div
                            :class="toast.type === 'error'
                                ? 'flex items-center gap-3 rounded-xl bg-white shadow-md border border-red-200 px-4 py-3 text-sm pointer-events-auto text-slate-900'
                                : 'flex items-center gap-3 rounded-xl bg-white shadow-md border border-green-200 px-4 py-3 text-sm pointer-events-auto text-slate-900'"
                            x-show="toast.visible" x-transition>
                            <template x-if="toast.type !== 'error'">
                                <div class="flex h-6 w-6 items-center justify-center rounded-full border border-green-200 bg-green-50 text-green-600" aria-hidden="true">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </template>
                            <template x-if="toast.type === 'error'">
                                <div class="flex h-6 w-6 items-center justify-center rounded-full border border-red-200 bg-red-50 text-red-600" aria-hidden="true">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </template>
                            <div class="space-y-0.5">
                                <p class="font-semibold text-slate-900" x-text="toast.title"></p>
                                <p class="text-slate-600 text-sm" x-text="toast.message"></p>
                            </div>
                            <button class="ml-auto text-slate-400 hover:text-slate-600 transition" @click="remove(toast.id)" aria-label="Close">×</button>
                        </div>
                    </template>
                </div>
            </div>
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow-sm border-b border-slate-100">
                    <div class="container px-4 sm:px-6 lg:px-8 py-6">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            function toastStack({ initial = [] } = {}) {
                return {
                    toasts: [],
                    init() {
                        initial.forEach(toast => this.push(toast));
                        const register = () => {
                            if (!window.Livewire || !Livewire.on) return;
                            Livewire.on('notify', (payload) => {
                                const toast = typeof payload === 'string' ? { message: payload } : payload;
                                this.push(toast);
                            });
                        };
                        if (window.Livewire) {
                            register();
                        } else {
                            document.addEventListener('livewire:init', register);
                        }
                    },
                    push(toast) {
                        const id = crypto.randomUUID ? crypto.randomUUID() : Date.now() + Math.random();
                        const item = {
                            id,
                            type: toast.type || 'success',
                            title: toast.title || (toast.type === 'error' ? 'Error' : 'Success'),
                            message: toast.message || '',
                            visible: true,
                        };
                        this.toasts.push(item);
                        const duration = toast.duration ?? 6000;
                        setTimeout(() => this.remove(id), duration);
                    },
                    remove(id) {
                        const toast = this.toasts.find(t => t.id === id);
                        if (toast) toast.visible = false;
                        setTimeout(() => {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                        }, 200);
                    },
                };
            }
        </script>
    </body>
</html>
