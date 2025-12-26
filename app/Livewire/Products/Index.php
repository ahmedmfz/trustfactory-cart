<?php

namespace App\Livewire\Products;
use App\Models\Product;
use App\Services\CartService;
use Livewire\Attributes\Validate;
use Livewire\Component;


class Index extends Component
{
    #[Validate('required|integer|min:1|max:99')]
    public int $qty = 1;

    
    #[Validate('required|integer|exists:products,id')]
    public int $productId;


    public function addToCart(int $productId, CartService $cartService): void
    {
        $this->productId = $productId;

        $this->validate();

        $product = Product::query()->findOrFail($this->productId);

        $cartService->add(auth()->user(), $product, $this->qty);

        $this->dispatch('cart-updated');
        
        session()->flash('success', "{$product->name} added to cart.");
    }


    public function render()
    {
        return view('livewire.pages.products.index', [
            'products' => Product::query()->orderBy('name')->paginate(10),
        ]);
    }
}
