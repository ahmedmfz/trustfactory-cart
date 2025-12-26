
<div class="max-w-5xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Orders</h1>
        <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">
            ← Products
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 text-green-800 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="bg-white border rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <div class="font-semibold">Order #{{ $order->id }}</div>
                    <div class="text-sm text-gray-600">
                        Total: <span class="font-medium">${{ number_format($order->total_cents / 100, 2) }}</span>
                    </div>
                </div>

                <div class="text-xs text-gray-500 mt-1">
                    Completed: {{ optional($order->completed_at)->format('Y-m-d H:i') }}
                </div>

                <div class="mt-4 divide-y">
                    @foreach($order->items as $item)
                        <div class="py-2 flex items-center justify-between text-sm">
                            <div>{{ $item->product->name }} × {{ $item->quantity }}</div>
                            <div class="font-medium">${{ number_format($item->line_total_cents / 100, 2) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-gray-500">No orders yet.</div>
        @endforelse
    </div>
</div>

