<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use Livewire\Component;

class Counter extends Component
{
    protected $listeners = ['cart-updated' => '$refresh'];

    public function getCountProperty(): int
    {
        $userId = auth()->id();
        
        if (!$userId) return 0;

        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) return 0;

        return (int) $cart->items()->sum('quantity');
    }
   
    public function render()
    {
        return view('livewire.pages.cart.counter');
    }

}
