<div class="max-w-5xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Your Cart</h1>

        <a href="{{ route('products.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">
            ← Continue shopping
        </a>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-white shadow-sm rounded-2xl border overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 text-left text-sm text-gray-600">
                    <tr>
                        <th class="px-6 py-3">Product</th>
                        <th class="px-6 py-3">Price</th>
                        <th class="px-6 py-3">Qty</th>
                        <th class="px-6 py-3 text-right">Total</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($items as $item)
                        <tr class="text-sm">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $item->product->name }}</td>
                            <td class="px-6 py-4">${{ number_format($item->product->price_cents / 100, 2) }}</td>

                            <td class="px-6 py-4">
                                <div class="inline-flex items-center gap-2">
                                    <button wire:click="decrement({{ $item->id }})"
                                            class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200">−</button>

                                    <span class="min-w-[2rem] text-center">{{ $item->quantity }}</span>

                                    <button wire:click="increment({{ $item->id }})"
                                            class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200">+</button>
                                </div>

                                <div class="text-xs text-gray-500 mt-1">
                                    In stock: {{ $item->product->stock_quantity }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-right font-medium">
                                ${{ number_format(($item->quantity * $item->product->price_cents) / 100, 2) }}
                            </td>

                            <td class="px-6 py-4 text-right">
                                <button wire:click="removeItem({{ $item->id }})"
                                        class="text-red-600 hover:text-red-700">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                Your cart is empty.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white shadow-sm rounded-2xl border p-6 h-fit">
            <h2 class="text-lg font-semibold mb-4">Summary</h2>

            <div class="flex items-center justify-between text-sm mb-2">
                <span class="text-gray-600">Subtotal</span>
                <span class="font-medium">${{ number_format($subtotalCents / 100, 2) }}</span>
            </div>

            
            <div class="border-t pt-4 mt-4">
            <button
                wire:click="checkout"
                wire:loading.attr="disabled"
                @disabled($items->isEmpty())
                class="w-full px-4 py-3 rounded-xl text-white
                    {{ $items->isEmpty() ? 'bg-gray-400 cursor-not-allowed' : 'bg-gray-900 hover:bg-gray-800' }}">
                Checkout
            </button>

            </div>
        </div>
    </div>
</div>
