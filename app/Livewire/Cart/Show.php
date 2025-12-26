<?php

namespace App\Livewire\Cart;

use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Services\CheckoutService;


class Show extends Component
{
    private function cartItems(CartService $cartService)
    {
        $cart = $cartService->getOrCreateCart(auth()->user());

        return $cart->items()
            ->with('product')
            ->orderBy('id', 'desc')
            ->get();
    }


    public function increment(int $itemId, CartService $cartService): void
    {
        $items = $this->cartItems($cartService);
        $item = $items->where('id', $itemId)->first();
        
        if (!$item){
            session()->flash('error', 'Cart does not have that product');
            return;
        }

        $cartService->setQuantity(auth()->user(), $itemId, $item->quantity + 1);
        $this->dispatch('cart-updated');
    }

    public function decrement(int $itemId, CartService $cartService): void
    {
        $items = $this->cartItems($cartService);
        $item = $items->where('id', $itemId)->first();
        
        if (!$item){
            session()->flash('error', 'Cart does not have that product');
            return;
        }

        $newQty = max(1, $item->quantity - 1);
        $cartService->setQuantity(auth()->user(), $itemId, $newQty);
        $this->dispatch('cart-updated');
    }

    public function removeItem(int $itemId, CartService $cartService): void
    {
        $cartService->remove(auth()->user(), $itemId);
        $this->dispatch('cart-updated');
        session()->flash('success', 'Item removed from cart.');
    }

    public function checkout(CheckoutService $checkoutService): void
    {
     
        try {
            $order = $checkoutService->checkout(auth()->user());

            session()->flash('success', "Order #{$order->id} completed successfully!");
            $this->dispatch('cart-updated');

            $this->redirect(route('orders.index'));
        } catch (\Throwable $e) {
            session()->flash('error', $e->getMessage());
        }
    }


    public function render(CartService $cartService): View
    {
        $items = $this->cartItems($cartService);

        $subtotalCents = $items->sum(fn ($i) => $i->quantity * $i->product->price_cents);

        return view('livewire.pages.cart.show', [
            'items' => $items,
            'subtotalCents' => $subtotalCents,
        ]);
    }
}
