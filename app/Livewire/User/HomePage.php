<?php

namespace App\Livewire\User;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class HomePage extends Component
{
    use WithPagination;
    public function render()
    {
        $categories = Category::where('is_active', '1')->get();

        $featured_products = Product::where('is_active', '1')->where('is_featured', '1')->paginate(4);

        $latest_products = Product::where('is_active', '1')->orderBy('id', 'desc')->paginate(4);

        return view('livewire.user.home-page', [
            'categories' => $categories,
            'featured_products' => $featured_products,
            'latest_products' => $latest_products,
        ]);
    }
}
