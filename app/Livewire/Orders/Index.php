<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use App\Models\Order;

class Index extends Component
{
    public function render()
    {
        $orders = Order::query()
            ->where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->get();

        return view('livewire.pages.orders.index', compact('orders'));
    }
   
}
