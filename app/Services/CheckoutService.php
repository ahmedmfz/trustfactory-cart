<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function checkout(\App\Models\User $user): Order
    {
        $cartService = new CartService();
        $cart = $cartService->getOrCreateCart($user);

        $items = $cart->items()->with('product')->get();

        if ($items->isEmpty()) {
            throw ValidationException::withMessages(['cart' => 'Your cart is empty.']);
        }

        return DB::transaction(function () use ($user, $cart, $items) {
            $totalCents = 0;

            $order = Order::create([
                'user_id'      => $user->id,
                'status'       => 'completed',
                'total_cents'  => 0,
            ]);

            foreach ($items as $item) {
                $product = Product::query()
                    ->whereKey($item->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($item->quantity > $product->stock_quantity) {
                    throw ValidationException::withMessages([
                        'stock' => "Not enough stock for {$product->name}. Available: {$product->stock_quantity}."
                    ]);
                }

                $unit = $product->price_cents;
                $line = $unit * $item->quantity;
                $totalCents += $line;

                OrderItem::create([
                    'order_id'         => $order->id,
                    'product_id'       => $product->id,
                    'quantity'         => $item->quantity,
                    'unit_price_cents' => $unit,
                    'line_total_cents' => $line,
                ]);

                // Decrease stock
                $product->stock_quantity -= $item->quantity;
                $product->save();

                // Low stock trigger (queue job) - avoid spamming by marking notified_at
                if ($product->stock_quantity <= $product->low_stock && $product->low_stock_notified_at === null) {
                    $product->low_stock_notified_at = now();
                    $product->save();

                    \App\Jobs\SendLowStockEmailJob::dispatch($product->id);
                }
            }

            $order->update(['total_cents' => $totalCents]);

            $cart->delete();

            return $order;
        });
    }
}
