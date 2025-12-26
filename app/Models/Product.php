<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'low_stock_notified_at' => 'datetime',
    ];

    public function formattedPrice(): string
    {
        return number_format($this->price_cents / 100, 2);
    }
}
