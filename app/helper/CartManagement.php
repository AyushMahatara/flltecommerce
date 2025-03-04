<?php

namespace App\Helper;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{
    //add item to cart
    static public function addItemToCart($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        $existing_item = null;
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }

        if ($existing_item !== null) {
            $cart_items[$existing_item]['quantity']++;
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
        } else {
            $product = Product::where('id', $product_id)->with('media')->first(['id', 'name', 'images', 'price']);
            if ($product) {
                // dd($product->media[0]['file_name']);
                $cart_items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'images' => $product->media[0]['file_name'],
                    'quantity' => 1,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }
        self::addCartItemToCookie($cart_items);
        return count($cart_items);
    }
    //add item to cart with quantity
    static public function addItemToCartWithQty($product_id, $quantity)
    {
        $cart_items = self::getCartItemsFromCookie();
        $existing_item = null;
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }

        if ($existing_item !== null) {
            $cart_items[$existing_item]['quantity'] = $quantity;
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
        } else {
            $product = Product::where('id', $product_id)->with('media')->first(['id', 'name', 'images', 'price']);
            if ($product) {
                // dd($product->media[0]['file_name']);
                $cart_items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'images' => $product->media[0]['file_name'],
                    'quantity' => $quantity,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }
        self::addCartItemToCookie($cart_items);
        return count($cart_items);
    }
    // remove item from cart
    static public function removeItemFromCart($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($cart_items[$key]);
            }
        }
        self::addCartItemToCookie($cart_items);
        return $cart_items;
    }
    // add cart items to cookie
    static public function addCartItemToCookie($cart_items)
    {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
    }

    // clear cart items from cookie
    static public function clearCartItemsFromCookie()
    {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    // get all cart items from cookie
    static public function getCartItemsFromCookie()
    {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if (!$cart_items) {
            $cart_items = [];
        }
        return $cart_items;
    }


    // increment item quantity
    static public function incrementItemQuantity($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
            }
        }
        self::addCartItemToCookie($cart_items);
        return $cart_items;
    }
    // decrement item quantity
    static public function decrementItemQuantity($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                if ($cart_items[$key]['quantity'] > 1) {
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
                }
            }
        }
        self::addCartItemToCookie($cart_items);
        return $cart_items;
    }
    // calculate cart total
    static public function calculateGrandTotal($items)
    {
        return array_sum(array_column($items, 'total_amount'));
    }
}
