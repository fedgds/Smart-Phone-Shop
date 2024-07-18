<?php

namespace App\Livewire\Admin;

use App\Models\Banner as ModelsBanner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class Banner extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    public $per_page = 5;
    #[URL]
    public $sort;
    #[Url]

    public $image;
    public $is_active = 1;

    public $bannerId;
    
    public $isEditMode = false;
    public $showModal = false;
    function loadMore()
    {
        $this->per_page += 5;
    }
    
    protected $rules = [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    ];

    protected $messages = [
        'image.required' => 'Vui lòng chọn ảnh',
        'image.image' => 'Tệp tải lên phải là một hình ảnh.',
        'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg, webp.',
        'image.max' => 'Hình ảnh không được vượt quá 2048 KB.',
    ];
    
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
        $this->is_active = 1;
        $this->image = null;
        $this->bannerId = null;
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
            $imagePath = $this->image->store('banners', 'public');
        }

        ModelsBanner::create([
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
        $banner = ModelsBanner::find($id);
    
        if ($banner) {
            $this->bannerId = $banner->id;
            $this->image = asset('storage/' . $banner->image);
            $this->is_active = $banner->is_active;
            $this->isEditMode = true;
            $this->showModal();
        } else {
            session()->flash('error', 'Không tìm thấy ảnh');
        }
    }
    
    public function update()
    {
        $banner = ModelsBanner::find($this->bannerId);

        if ($this->image instanceof UploadedFile) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $imagePath = $this->image->store('banners', 'public');
            $banner->image = $imagePath;
        }

        if ($banner) {
            $banner->update([
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
        $banner = ModelsBanner::findOrFail($id);
        Storage::disk('public')->delete($banner->image);
        $banner->delete();

        $this->alert('success', 'Xóa thành công!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
    public function render()
    {
        $query = ModelsBanner::query();

        $banners = $query->paginate($this->per_page);
        return view('livewire.admin.banner', [
            'banners' => $banners,
        ])->layout('components.layouts.admin');
    }
}
