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
    public function render()
    {
        $products = Product::where('is_active', 1)->with('media')->paginate(6);
        if (!empty($this->selected_categories)) {
            $products = Product::where('is_active', 1)->whereIn('category_id', $this->selected_categories)->with('media')->paginate(6);
        }
        if (!empty($this->selected_brands)) {
            $products = Product::where('is_active', 1)->whereIn('brand_id', $this->selected_brands)->with('media')->paginate(6);
        }
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
