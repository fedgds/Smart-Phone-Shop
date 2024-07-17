<?php

namespace App\Livewire\User;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class HomePage extends Component
{
    use WithPagination;
    public $per_page = 4;
    function loadMoreFeatured()
    {
        $this->per_page += 4;
    }
    public function render()
    {
        $categories = Category::where('is_active', '1')->get();
        $featured_products = Product::where('is_active', '1')->where('is_featured', '1')->paginate($this->per_page);
        return view('livewire.user.home-page', [
            'categories' => $categories,
            'featured_products' => $featured_products,
        ]);
    }
}
