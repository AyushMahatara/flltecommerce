<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Product Page')]

class ProductsPage extends Component
{
    use WithPagination;
    #[Url]
    public $selected_categories = [];
    #[Url]
    public $selected_brands = [];
    #[Url]
    public $featured;

    #[Url]
    public $on_sale;
    #[Url]
    public $price_range = 300000;
    public function render()
    {
        $products = Product::where('is_active', 1)->with('media');

        if (!empty($this->selected_categories)) {
            $products->whereIn('category_id', $this->selected_categories);
        }
        if (!empty($this->selected_brands)) {
            $products->whereIn('brand_id', $this->selected_brands);
        }
        if ($this->featured == 1) {
            $products->where('is_featured', 1);
        }
        if ($this->on_sale == 1) {
            $products->where('on_sale', 1);
        }
        if ($this->price_range) {
            $products->whereBetween('price', [0, $this->price_range]);
        }
        $categories = Category::where('status', 1)->get(['id', 'name', 'slug']);
        $brands = Brand::where('status', 1)->get(['id', 'name', 'slug']);

        return view(
            'livewire.products-page',
            [
                'products' => $products->paginate(6),
                'categories' => $categories,
                'brands' => $brands
            ]
        );
    }
}
