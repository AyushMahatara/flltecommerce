<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Product Detail')]

class ProdectDetailPage extends Component
{
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }
    public function render()
    {
        $product = Product::where('slug', $this->slug)->with('media')->firstOrFail();
        return view('livewire.prodect-detail-page', [
            'product' => $product
        ]);
    }
}
