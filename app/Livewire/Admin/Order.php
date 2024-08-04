<?php

namespace App\Livewire\Admin;

use App\Models\Order as ModelsOrder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;

class Order extends Component
{
    use LivewireAlert;
    public $per_page = 10;
    #[Url]
    public $sort;
    #[Url]
    public $search;

    public $user_id, $grand_total, $final_total, $payment_method, $payment_status, $full_name, $phone_number, $city, $district, $address, $status, $notes;
    public $orderId;
    public $item;
    public $showModal = false;
    function loadMore()
    {
        $this->per_page += 5;
    }
    public function showModal()
    {
        $this->showModal = true;
    }

    public function hideModal()
    {
        $this->showModal = false;
    }
    public function show($id)
    {
        $order = ModelsOrder::find($id);

        if ($order) {
            $this->user_id = $order->user->name;
            $this->grand_total = $order->grand_total;
            $this->final_total = $order->final_total;
            $this->payment_method = $order->payment_method;
            $this->payment_status = $order->payment_status;
            $this->full_name = $order->full_name;
            $this->phone_number = $order->phone_number;
            $this->city = $order->city;
            $this->district = $order->district;
            $this->address = $order->address;
            $this->status = $order->status;
            $this->notes = $order->notes;
            $this->orderId = $order->id;
            $this->item = $order->order_item;
            $this->showModal();
        } else {
            session()->flash('error', 'Không tìm thấy sản phẩm');
        }
    }
    
    public function update()
    {
        $order = ModelsOrder::find($this->orderId);
        if ($order) {
            $order->update([
                'payment_status' => $this->payment_status,
                'status' => $this->status,
            ]);
    
            $this->hideModal();
            $this->alert('success', 'Sửa thành công!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        } 
        
    }
    public function render()
    {
        $query = ModelsOrder::query();
        if ($this->sort) {
            switch ($this->sort) {
                case 'default':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'time_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'time_desc':
                    $query->orderBy('created_at', 'asc');
                    break;
            }
        }

        if ($this->search) {
            $query->where(function($query) {
                $query->where('full_name', 'like', '%' . $this->search . '%')
                    ->orWhere('phone_number', 'like', '%' . $this->search . '%');
            });
        }
        $orders = $query->paginate($this->per_page);

        return view('livewire.admin.order', [
            'orders' => $orders,
        ])->layout('components.layouts.admin');
    }
}
