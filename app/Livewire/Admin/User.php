<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User as UserModel;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class User extends Component
{
    use LivewireAlert;
    use WithPagination;
    #[Url]
    public $sort;
    #[Url]
    public $search;

    public $name, $email, $password;
    public $is_admin = 0;

    public $userId;
    public $isEditMode = false;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'name.required' => 'Vui lòng nhập tên',
        'name.max' => 'Tên không được đặt quá 255 kí tự',
        'email.required' => 'Vui lòng nhập email',
        'email.email' => 'Email không đúng định dạng',
        'email.unique' => 'Email đã tồn tại',
        'email.max' => 'Email không được đặt quá 255 kí tự',
        'password.required' => 'Vui lòng nhập mật khẩu',
        'password.min' => 'Mật khẩu phải lớn hon 6 kí tự',
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
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->is_admin = 0;
        $this->userId = null;
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

        UserModel::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'is_admin' => $this->is_admin,
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
        $user = UserModel::find($id);
    
        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->userId = $user->id;
            $this->is_admin = $user->is_admin;
            $this->isEditMode = true;
            $this->showModal();
        } else {
            session()->flash('error', 'Không tìm thấy tài khoản');
        }
    }
    
    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->userId)],
        ]);
    
        $user = UserModel::find($this->userId);
    
        if ($user) {
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'is_admin' => $this->is_admin ? 1 : 0,
            ]);
    
            $this->hideModal();
            $this->resetInputFields();
            $this->alert('success', 'Sửa thành công!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        } else {
            session()->flash('error', 'Không tìm thấy tài khoản');
        }
    }    
    
    public function delete($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();

        $this->alert('success', 'Xóa thành công!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        $query = UserModel::query();
    
        if ($this->sort) {
            switch ($this->sort) {
                case 'default':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'admin':
                    $query->where('is_admin', 1);
                    break;
                case 'user':
                    $query->where('is_admin', 0);
                    break;
            }
        }
    
        if ($this->search) {
            $query->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }
    
        $users = $query->paginate(5);
    
        return view('livewire.admin.user', [
            'users' => $users,
        ])->layout('components.layouts.admin');
    }    
    
}
