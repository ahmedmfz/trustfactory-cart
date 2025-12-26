<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Validation\ValidationException;


class CartService
{
    public function getOrCreateCart(User $user): Cart
    {
        return Cart::firstOrCreate(['user_id' => $user->id]);
    }

    public function add(User $user, Product $product, int $qty = 1): void
    {
        $cart = $this->getOrCreateCart($user);

        $item = CartItem::query()
            ->where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        $newQty = ($item?->quantity ?? 0) + $qty;

        if ($newQty > $product->stock_quantity) {
            throw ValidationException::withMessages([
                'stock' => "Only {$product->stock_quantity} items available in stock."
            ]);
        }

        CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $product->id],
            ['quantity' => $newQty]
        );
    }

    public function setQuantity(User $user, int $cartItemId, int $qty): void
    {
        $cart = $this->getOrCreateCart($user);

        $item = CartItem::query()
            ->with('product')
            ->where('cart_id', $cart->id)
            ->where('id', $cartItemId)
            ->firstOrFail();

        if ($qty > $item->product->stock_quantity) {
            throw ValidationException::withMessages([
                'stock' => "Only {$item->product->stock_quantity} items available in stock."
            ]);
        }

        $item->update(['quantity' => $qty]);
    }

    public function remove(User $user, int $cartItemId): void
    {
        $cart = $this->getOrCreateCart($user);

        CartItem::query()
            ->where('cart_id', $cart->id)
            ->where('id', $cartItemId)
            ->delete();
    }
}
