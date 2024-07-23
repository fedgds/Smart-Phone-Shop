<?php

namespace App\Livewire\User;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyOrdersPage extends Component
{
    public function render()
    {
        $user = Auth::user();
        $order = Order::where('user_id', '=', $user->id)->get();
        // dd($order);
        return view('livewire.user.my-orders-page', [
            'order' => $order
        ]);
    }
}
