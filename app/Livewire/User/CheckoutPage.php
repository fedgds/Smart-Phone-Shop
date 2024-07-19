<?php

namespace App\Livewire\User;

use App\Helpers\CartManagement;
use Livewire\Component;

class CheckoutPage extends Component
{
    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);

        return view('livewire.user.checkout-page', [
            'cart_items' => $cart_items,
            'grand_total' => $grand_total
        ]);
    }
}
