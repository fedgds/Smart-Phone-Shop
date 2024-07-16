<?php

namespace App\Livewire\User;

use App\Models\Category;
use Livewire\Component;

class CategoriesPage extends Component
{
    public function render()
    {
        $categories = Category::where('is_active', '1')->get();
        return view('livewire.user.categories-page', [
            'categories' => $categories
        ]);
    }
}
