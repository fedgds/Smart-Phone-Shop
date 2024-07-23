<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Voucher as ModelsVoucher;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Voucher extends Component
{
    use LivewireAlert;
    use WithPagination;
    
    public $per_page = 15;
    #[Url]
    public $sort;
    #[Url]
    public $search;

    public $code, $discount, $discount_type, $usage_limit, $min_order_value, $max_order_value, $start_date, $end_date, $status;
    public $products = [];
    public $voucherId;
    public $isEditMode = false;
    public $showModal = false;

    function loadMore()
    {
        $this->per_page += 10;
    }

    protected $rules = [
        'code' => 'required|max:255|unique:vouchers,code',
        'discount' => 'required|numeric',
        'usage_limit' => 'required|numeric',
        'min_order_value' => 'numeric',
        'max_order_value' => 'numeric|gt:min_order_value',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ];

    protected $messages = [
        'code.required' => 'Vui lòng nhập mã voucher',
        'code.max' => 'Mã voucher không được đặt quá 255 kí tự',
        'code.unique' => 'Mã voucher đã tồn tại',
        'discount.required' => 'Vui lòng nhập số tiền giảm giá',
        'discount.numeric' => 'Giá trị giảm giá phải là số',
        'usage_limit.required' => 'Vui lòng nhập số lượng mã',
        'usage_limit.numeric' => 'Số lượng mã giảm giá phải là số',
        'min_order_value.numeric' => 'Áp dụng cho đơn hàng nhỏ nhất phải là số',
        'max_order_value.numeric' => 'Áp dụng cho đơn hàng lớn nhất phải là số',
        'max_order_value.gt' => 'Áp dụng cho đơn hàng lớn nhất phải > đơn hàng nhỏ nhất',
        'start_date.required' => 'Vui lòng nhập ngày bắt đầu',
        'start_date.date' => 'Ngày bắt đầu không đúng định dạng',
        'end_date.required' => 'Vui lòng nhập ngày kết thúc',
        'end_date.date' => 'Ngày kết thúc không đúng định dạng',
        'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
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
        $this->code = '';
        $this->discount = '';
        $this->discount_type = '';
        $this->usage_limit = '';
        $this->min_order_value = '';
        $this->max_order_value = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->status = '';
        $this->products = [];
        $this->voucherId = null;
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

        ModelsVoucher::create([
            'code' => $this->code,
            'discount' => $this->discount,
            'usage_limit' => $this->usage_limit,
            'min_order_value' => $this->min_order_value,
            'max_order_value' => $this->max_order_value,
            'discount_type' => $this->discount_type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
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
        $voucher = ModelsVoucher::find($id);
    
        if ($voucher) {
            $this->code = $voucher->code;
            $this->discount = $voucher->discount;
            $this->discount_type = $voucher->discount_type;
            $this->usage_limit = $voucher->usage_limit;
            $this->min_order_value = $voucher->min_order_value;
            $this->max_order_value = $voucher->max_order_value;
            $this->start_date = Carbon::parse($voucher->start_date)->format('Y-m-d');
            $this->end_date = Carbon::parse($voucher->end_date)->format('Y-m-d');
            $this->status = $voucher->status;
            $this->voucherId = $voucher->id;
            $this->isEditMode = true;
            $this->showModal();
        } else {
            session()->flash('error', 'Không tìm thấy voucher');
        }
    }
    
    public function update()
    {
        $this->validate([
            'code' => ['required', 'string', 'max:255', Rule::unique('vouchers')->ignore($this->voucherId)],
            'discount' => 'required|numeric',
            'usage_limit' => 'required|numeric',
            'min_order_value' => 'numeric',
            'max_order_value' => 'numeric|gt:min_order_value',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|boolean',
            'products' => 'array'
        ]);

        $voucher = ModelsVoucher::find($this->voucherId);
        if ($voucher) {
            $voucher->update([
                'code' => $this->code,
                'discount' => $this->discount,
                'usage_limit' => $this->usage_limit,
                'min_order_value' => $this->min_order_value,
                'max_order_value' => $this->max_order_value,
                'discount_type' => $this->discount_type,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'status' => $this->status,
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
        $voucher = ModelsVoucher::findOrFail($id);
        $voucher->delete();

        $this->alert('success', 'Xóa thành công!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
    }


    public function render()
    {
        $query = ModelsVoucher::query();
    
        if ($this->sort) {
            switch ($this->sort) {
                case 'default':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'active':
                    $query->where('status', 1);
                    break;
                case 'inactive':
                    $query->where('status', 0);
                    break;
            }
        }
    
        if ($this->search) {
            $query->where(function($query) {
                $query->where('code', 'like', '%' . $this->search . '%');
            });
        }
    
        $vouchers = $query->paginate($this->per_page);

        return view('livewire.admin.voucher', [
            'vouchers' => $vouchers,
            'list_products' => Product::all(),
        ])->layout('components.layouts.admin');
    }  
}
