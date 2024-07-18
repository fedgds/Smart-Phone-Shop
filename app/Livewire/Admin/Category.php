<?php

namespace App\Livewire\Admin;

use App\Models\Category as ModelsCategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Category extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    public $per_page = 5;
    #[Url]
    public $sort;
    #[Url]
    public $search;

    public $name, $slug, $image;
    public $is_active = 1;

    public $categoryId;
    
    public $isEditMode = false;
    public $showModal = false;

    function loadMore()
    {
        $this->per_page += 5;
    }

    protected $rules = [
        'name' => 'required|max:255',
        'slug' => 'required|max:255|unique:categories,slug',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    ];

    protected $messages = [
        'name.required' => 'Vui lòng nhập tên',
        'name.max' => 'Tên không được đặt quá 255 kí tự',
        'slug.required' => 'Vui lòng nhập slug',
        'slug.unique' => 'Slug đã tồn tại',
        'slug.max' => 'Slug không được đặt quá 255 kí tự',
        'image.required' => 'Vui lòng chọn ảnh',
        'image.image' => 'Tệp tải lên phải là một hình ảnh.',
        'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg, webp.',
        'image.max' => 'Hình ảnh không được vượt quá 2048 KB.',
    ];
    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function showModal()
    {
        $this->showModal = true;
    }

    public function hideModal()
    {
        $this->showModal = false;
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->slug = '';
        $this->is_active = 1;
        $this->image = null;
        $this->categoryId = null;
    }

    public function create()
    {
        $this->isEditMode = false;
        $this->resetInputFields();
        $this->showModal();
    }

    public function store()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('categories', 'public');
        }

        ModelsCategory::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $imagePath,
            'is_active' => $this->is_active,
        ]);

        $this->hideModal();
        $this->resetInputFields();

        $this->alert('success', 'Tạo thành công!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
    
    public function edit($id)
    {
        $category = ModelsCategory::find($id);
    
        if ($category) {
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->categoryId = $category->id;
            $this->image = asset('storage/' . $category->image);
            $this->is_active = $category->is_active;
            $this->isEditMode = true;
            $this->showModal();
        } else {
            session()->flash('error', 'Không tìm thấy danh mục');
        }
    }
    
    public function update()
    {
        $this->validate([
            'name' => 'required|max:255',
            'slug' => ['required', 'max:255', Rule::unique('categories')->ignore($this->categoryId)],
        ]);

        $category = ModelsCategory::find($this->categoryId);

        if ($this->image instanceof UploadedFile) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $this->image->store('categories', 'public');
            $category->image = $imagePath;
        }

        if ($category) {
            $category->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'is_active' => $this->is_active ? 1 : 0,
            ]);

            $this->hideModal();
            $this->resetInputFields();
            $this->alert('success', 'Sửa thành công!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        } else {
            session()->flash('error', 'Không tìm thấy danh mục');
        }
    }
    public function delete($id)
    {
        $category = ModelsCategory::findOrFail($id);
        Storage::disk('public')->delete($category->image);
        $category->delete();

        $this->alert('success', 'Xóa thành công!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
    public function render()
    {
        $query = ModelsCategory::query();
    
        if ($this->sort) {
            switch ($this->sort) {
                case 'default':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
            }
        }
    
        if ($this->search) {
            $query->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
            });
        }
    
        $categories = $query->paginate($this->per_page);

        return view('livewire.admin.category', [
            'categories' => $categories
        ])->layout('components.layouts.admin');
    }

}
