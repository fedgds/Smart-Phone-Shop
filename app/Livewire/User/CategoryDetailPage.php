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

class CategoryDetailPage extends Component
{
    use WithPagination;

    use LivewireAlert;
    public $per_page = 4;
    public $slug;
    #[Url]
    public $search;
    function loadMore()
    {
        $this->per_page += 4;
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
        $categoryDetail = Category::where('slug', $this->slug)
                        ->with(['products' => function($query) {
                            if ($this->search) {
                                $query->where('name', 'like', '%' . $this->search . '%');
                            }
                            $query->paginate($this->per_page);
                        }])
                        ->firstOrFail();

        $products = $categoryDetail->products;

        return view('livewire.user.category-detail-page',[
            'categoryDetail' => $categoryDetail,
            'products' => $products,
        ]);
    }
}
