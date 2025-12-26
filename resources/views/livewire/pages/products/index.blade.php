<div class="max-w-5xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Products</h1>
        <livewire:cart.counter />
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="bg-white shadow-sm rounded-2xl overflow-hidden border">
        <table class="w-full">
            <thead class="bg-gray-50 text-sm text-gray-600">
                <tr>
                    <th class="px-6 py-3">Product</th>
                    <th class="px-6 py-3">Price</th>
                    <th class="px-6 py-3">Stock</th>
                    <th class="px-6 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($products as $product)
                    <tr class="text-sm text-center">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4">${{ $product->formattedPrice() }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs
                                {{ $product->stock_quantity <= $product->low_stock_threshold ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-700' }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button
                                wire:click="addToCart({{ $product->id }})"
                                wire:loading.attr="disabled"
                                @disabled($product->stock_quantity === 0)
                                class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-white
                                    {{ $product->stock_quantity === 0 ? 'bg-gray-400' : 'bg-blue-600 hover:bg-blue-500' }}">
                                Add to cart
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>



