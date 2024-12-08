<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Title;

#[Title('Product Page')]

class ProductsPage extends Component
{
    public function render()
    {
        $products = Product::where('is_active', 1)->with('media')->paginate(6);
        $categories = Category::where('status', 1)->get(['id', 'name', 'slug']);
        $brands = Brand::where('status', 1)->get(['id', 'name', 'slug']);

        return view(
            'livewire.products-page',
            [
                'products' => $products,
                'categories' => $categories,
                'brands' => $brands
            ]
        );
    }
}
