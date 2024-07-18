<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement {
    // Thêm vào giỏ
    static public function addItemToCart($product_id) {
        $cart_items = self::getCartItemsFromCookie();

        $existing_item = null;

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }
        //  Nếu đã tồn tại trong giỏ thì tăng số lượng, nếu không thì thêm mới vào giỏ
        if ($existing_item !== null) {
            $cart_items[$existing_item]['quantity']++;
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
            $cart_items[$existing_item]['total_amout'] = $cart_items[$existing_item]['total_amount'];
        } else {
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'sale_price','images']);
            if ($product) {
                 // Kiểm tra và lấy sale_price nếu có, ngược lại lấy giá gốc
                $unit_amount = $product->sale_price ? $product->sale_price : $product->price;
                $cart_items[] = [
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'image' => $product->images[0],
                    'quantity' => 1,
                    'unit_amount' => $unit_amount,
                    'total_amout' => $unit_amount,
                    'total_amount' => $unit_amount
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

    // Thêm vào giỏ với số lượng
    static public function addItemToCartWithQty($product_id, $qty = 1) {
        $cart_items = self::getCartItemsFromCookie();

        $existing_item = null;

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }
        //  Nếu đã tồn tại trong giỏ thì tăng số lượng, nếu không thì thêm mới vào giỏ
        if ($existing_item !== null) {
            $cart_items[$existing_item]['quantity'] += $qty;
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
            $cart_items[$existing_item]['total_amout'] = $cart_items[$existing_item]['total_amount'];
        } else {
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'sale_price','images']);
            if ($product) {
                    // Kiểm tra và lấy sale_price nếu có, ngược lại lấy giá gốc
                $unit_amount = $product->sale_price ? $product->sale_price : $product->price;
                $cart_items[] = [
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'image' => $product->images[0],
                    'quantity' => $qty,
                    'unit_amount' => $unit_amount,
                    'total_amout' => $unit_amount,
                    'total_amount' => $unit_amount
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }
    
    // Xóa khỏi giỏ
    static public function removeCartItem($product_id) {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($cart_items[$key]);
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // Thêm vào cookie
    static public function addCartItemsToCookie($cart_items) {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);  // đặt 30 ngày
    }

    // Xóa cookie
    static public function clearCartItems() {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    // Lấy tất cả từ cookie
    static public function getCartItemsFromCookie() {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if (!$cart_items) {
            $cart_items = [];
        }
        return $cart_items;
    }

    // Tăng số lượng
    static public function incrementQuantityToCartItem($product_id) {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item["product_id"] == $product_id) {
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
            }
        }
        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // Giảm số lượng
    static public function decrementQuantityToCartItem($product_id) {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item["product_id"] == $product_id) {
                if ($cart_items[$key]['quantity'] > 1) {
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
                }
            }
        }
        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // Tính tổng cộng
    static public function calculateGrandTotal($items) {
        return array_sum(array_column($items, 'total_amount'));
    }
}