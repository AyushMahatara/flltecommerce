<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;

#[Title('Home Page')]

class HomePage extends Component
{

    public function render()
    {
        $brands = Brand::where('status', 1)->with('media')->get();
        $categories = Category::where('status', 1)->get();
        return view('livewire.home-page', [
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }
}
