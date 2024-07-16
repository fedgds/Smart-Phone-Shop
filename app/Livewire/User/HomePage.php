<?php

namespace App\Livewire\User;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        $categories = Category::where('is_active', '1')->get();
        $featured_products = Product::where('is_active', '1')->where('is_featured', '1')->get();
        return view('livewire.user.home-page', [
            'categories' => $categories,
            'featured_products' => $featured_products,
        ]);
    }
}
