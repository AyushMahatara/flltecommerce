<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Helper\CartManagement;
use Livewire\Attributes\Title;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Product Detail')]

class ProdectDetailPage extends Component
{
    use LivewireAlert;
    public $slug;
    public $quantity = 1;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function descreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id);
        $this->dispatch('update-cart-count', $total_count)->to(Navbar::class);

        $this->alert('success', 'Product added to cart successfully', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
    public function increaseQuantity()
    {
        $this->quantity++;
    }
    public function render()
    {
        $product = Product::where('slug', $this->slug)->with('media')->firstOrFail();
        return view('livewire.prodect-detail-page', [
            'product' => $product
        ]);
    }
}
