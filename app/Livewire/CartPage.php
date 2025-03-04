<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helper\CartManagement;
use Livewire\Attributes\Title;
use App\Livewire\Partials\Navbar;

#[Title('My Cart')]
class CartPage extends Component
{

    public $cart_items = [];
    public $grand_total = 0;

    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
    }

    public function removeFromCart($product_id)
    {
        $this->cart_items = CartManagement::removeItemFromCart($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
        $this->dispatch('update-cart-count', count($this->cart_items))->to(Navbar::class);
    }

    public function increaseQuantity($product_id)
    {
        $this->cart_items = CartManagement::incrementItemQuantity($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
    }

    public function decreaseQuantity($product_id)
    {
        $this->cart_items = CartManagement::decrementItemQuantity($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
    }
    public function render()
    {
        return view('livewire.cart-page');
    }
}
