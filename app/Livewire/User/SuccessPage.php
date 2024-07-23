<?php

namespace App\Livewire\User;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SuccessPage extends Component
{
    public $orderId;
    public $order;
    public $address;

    public function mount($order)
    {
        $this->orderId = $order;
        
        $this->order = Order::findOrFail($this->orderId);

        if ($this->order->user_id !== Auth::id()) {
            abort(404, 'Not Found');
        }
    }

    public function render()
    {
        return view('livewire.user.success-page', [
            'order' => $this->order,
        ]);
    }
}
