<?php

namespace App\Livewire\Admin;

use App\Models\Product as ModelsProduct;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Product extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $per_page = 6;

    #[Url]
    public $sort;
    #[Url]
    public $search;

    public $name, $slug, $price, $sale_price, $description, $category_id, $images = [];
    public $is_active = 1;
    public $is_featured = 0;
    public $in_stock = 1;
    public $on_sale = 0;

    public $productId;
    
    public $isEditMode = false;
    public $showModal = false;
    function loadMore()
    {
        $this->per_page += 6;
    }

    public function toggleSalePrice()
    {
        $this->on_sale = $this->on_sale;
    }

    protected $rules = [
        'name' => 'required|max:255',
        'slug' => 'required|max:255|unique:products,slug',
        'price' => 'required|numeric',
        'sale_price' => 'nullable|numeric|lt:price',
        'description' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'images' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Vui lòng nhập tên sản phẩm',
        'name.max' => 'Tên sản phẩm không được đặt quá 255 kí tự',
        'slug.required' => 'Vui lòng nhập slug',
        'slug.unique' => 'Slug đã tồn tại',
        'slug.max' => 'Slug không được đặt quá 255 kí tự',
        'price.required' => 'Vui lòng nhập giá',
        'price.numeric' => 'Giá phải là số',
        'sale_price.numeric' => 'Giá khuyến mãi phải là số',
        'sale_price.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc',
        'category_id.required' => 'Vui lòng chọn danh mục',
        'category_id.exists' => 'Danh mục không hợp lệ',
        'images.required' => 'Vui lòng chọn ảnh',
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
        $this->price = '';
        $this->sale_price = '';
        $this->description = '';
        $this->category_id = '';
        $this->images = [];
        $this->is_active = 1;
        $this->is_featured = 0;
        $this->in_stock = 1;
        $this->on_sale = 0;
        $this->productId = null;
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

        $imagesPath = [];
        if ($this->images) {
            foreach ($this->images as $image) {
                $imagesPath[] = $image->store('products', 'public');
            }
        }

        ModelsProduct::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'sale_price' =>  $this->sale_price ? $this->sale_price : null,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'images' => json_encode($imagesPath),
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'in_stock' => $this->in_stock,
            'on_sale' => $this->on_sale,
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
        $product = ModelsProduct::find($id);

        if ($product) {
            $this->name = $product->name;
            $this->slug = $product->slug;
            $this->price = $product->price;
            $this->sale_price = $product->sale_price;
            $this->description = $product->description;
            $this->category_id = $product->category_id;
            $this->images = $product->images;
            $this->is_active = $product->is_active;
            $this->is_featured = $product->is_featured;
            $this->in_stock = $product->in_stock;
            $this->on_sale = $product->on_sale;
            $this->productId = $product->id;
            $this->isEditMode = true;
            $this->showModal();
        } else {
            session()->flash('error', 'Không tìm thấy sản phẩm');
        }
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|max:255',
            'slug' => ['required', 'max:255', Rule::unique('products')->ignore($this->productId)],
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric|lt:price',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        $product = ModelsProduct::find($this->productId);
        
        // Lấy những ảnh cũ
        $oldImages = $product->images;
        $imagesPath = [];
    
        if (is_array($this->images)) {
            foreach ($this->images as $image) {
                if ($image instanceof UploadedFile) {
                    $imagesPath[] = $image->store('products', 'public');
                } elseif (is_string($image)) {
                    $imagesPath[] = $image; 
                }
            }
        }
    
        // xóa những ảnh cũ không có trong mảng hình ảnh mới
        foreach ($oldImages as $oldImage) {
            if (!in_array($oldImage, $imagesPath)) {
                Storage::disk('public')->delete($oldImage);
            }
        }
    
        if ($product) {
            $product->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'price' => $this->price,
                'sale_price' => $this->sale_price ? $this->sale_price : null,
                'description' => $this->description,
                'category_id' => $this->category_id,
                'images' => json_encode($imagesPath),
                'is_active' => $this->is_active ? 1 : 0,
                'is_featured' => $this->is_featured ? 1 : 0,
                'in_stock' => $this->in_stock ? 1 : 0,
                'on_sale' => $this->on_sale ? 1 : 0,
            ]);
    
            $this->hideModal();
            $this->resetInputFields();
            $this->alert('success', 'Sửa thành công!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        } else {
            session()->flash('error', 'Không tìm thấy sản phẩm');
        }
    }
    

    public function delete($id)
    {
        $product = ModelsProduct::findOrFail($id);
        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        $product->delete();

        $this->alert('success', 'Xóa thành công!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        $query = ModelsProduct::query();

        if ($this->sort) {
            switch ($this->sort) {
                case 'default':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'is_active':
                    $query->where('is_active', '1');
                    break;
                case 'is_featured':
                    $query->where('is_featured', '1');
                    break;
                case 'in_stock':
                    $query->where('in_stock', '1');
                    break;
                case 'on_sale':
                    $query->where('on_sale', '1');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
            }
        }

        if ($this->search) {
            $query->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
            });
        }
        $products = $query->paginate($this->per_page);

        return view('livewire.admin.product', [
            'products' => $products,
            'categories' => Category::all(),
        ])->layout('components.layouts.admin');
    }
}   