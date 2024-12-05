<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Title;

class HomePage extends Component
{

    #[Title('Home')]
    public function render()
    {
        $brands = Brand::where('status', 1)->with('media')->get();
        $categories = Category::where('status', 1)->get();
        return view('livewire.home-page', [
            'brands' => $brands,
            'categories' => $categories
        ]);
    }
}
