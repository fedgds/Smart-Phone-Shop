<?php

namespace App\Livewire\User;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyOrderDetailPage extends Component
{
    public $id;
    public $order;
    public $address;
    public $order_items;
    public function mount($id)
    {
        $this->id = $id;

        $this->order = Order::findOrFail($this->id);

        if ($this->order->user_id !== Auth::id()) {
            abort(404, 'Not Found');
        }

        $this->order_items = OrderItem::with('product')->where('order_id', $this->id)->get();
    }
    public function render()
    {
        return view('livewire.user.my-order-detail-page', [
            'order' => $this->order,
            'order_items' => $this->order_items,
        ]);
    }
}
