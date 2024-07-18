<?php

namespace App\Livewire\User;

use App\Helpers\CartManagement;
use App\Livewire\User\Section\Navbar;
use App\Models\Category;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsPage extends Component
{
    use WithPagination;

    use LivewireAlert;
    public $per_page = 9;

    #[Url]
    public $selected_categories = [];
    #[Url]
    public $selected_brands = [];
    #[Url]
    public $featured;
    #[Url]
    public $on_sale;
    #[Url]
    public $price_range;
    #[Url]
    public $sort;
    #[Url]
    public $search;
    function loadMore()
    {
        $this->per_page += 6;
    }
    public function addToCart($product_id) {
        $total_count = CartManagement::addItemToCart($product_id);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Thêm vào giỏ thành công!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
           ]);
    }
    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);
    
        $categories = Category::where('is_active', 1)->get(['id', 'name', 'slug']);
    
        if(!empty($this->selected_categories)) {
            $productQuery->whereIn('category_id', $this->selected_categories);
        }

        if($this->featured) {
            $productQuery->where('is_featured', 1);
        }

        if($this->on_sale) {
            $productQuery->where('on_sale', 1);
        }

        if($this->price_range) {
            $productQuery->whereBetween('price', [0, $this->price_range]);
        }

        if ($this->search) {
            $productQuery->where('name', 'like', '%' . $this->search . '%');
        }
        
        switch ($this->sort) {
            case 'latest':
                $productQuery->orderBy('created_at', 'desc');
                break;
            case 'price_asc':
                $productQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productQuery->orderBy('price', 'desc');
                break;
        }
    
        $products = $productQuery->paginate($this->per_page);
    
        return view('livewire.user.products-page', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
