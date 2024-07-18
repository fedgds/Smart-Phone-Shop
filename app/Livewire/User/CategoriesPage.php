<?php

namespace App\Livewire\User;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriesPage extends Component
{
    use WithPagination;
    
    public $per_page = 5; 
    function loadMore()
    {
        $this->per_page += 2;
    }  
    public function render()
    {
        $categories = Category::where('is_active', '1')->paginate($this->per_page);
        return view('livewire.user.categories-page', [
            'categories' => $categories
        ]);
    }
}
