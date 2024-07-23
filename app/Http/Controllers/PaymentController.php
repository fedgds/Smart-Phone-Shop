<?php

namespace App\Http\Controllers;

use App\Helpers\CartManagement;
use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function vnpay_payment(CheckoutRequest $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $cart_items = CartManagement::getCartItemsFromCookie();

        if ($data['payment_method'] == 'vnpay') {
            $vnp_Url = env('VNP_URL');
            $vnp_Returnurl = env('VNP_RETURN_URL');
            $vnp_TmnCode = env('VNP_TMN_CODE');
            $vnp_HashSecret = env('VNP_HASH_SECRET');

            $vnp_TxnRef = "3"; //Mã đơn hàng
            $vnp_OrderInfo = "Thanh toán hóa đơn";
            $vnp_OrderType = "Sang Shop";
            $vnp_Amount = $data['grand_total'] * 100;
            $vnp_Locale = "VN";
            $vnp_BankCode = "NCB";
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }

            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array(
                'code' => '00'
                ,
                'message' => 'success'
                ,
                'data' => $vnp_Url
            );
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }

            Order::create([
                'user_id' => $user->id,
                'grand_total' => $data['grand_total'],
                'final_total' => $data['grand_total'],
                'payment_method' => $data['payment_method'],
                'full_name' => $data['full_name'],
                'phone_number' => $data['phone_number'],
                'city' => $data['city'],
                'district' => $data['district'],
                'address' => $data['address'],
                'notes' => $data['notes']
            ]);
        }
        // dd($data);

        // Thêm vào bảng orders
        $order = Order::create([
            'user_id' => $user->id,
            'grand_total' => $data['grand_total'],
            'final_total' => $data['grand_total'],
            'payment_method' => $data['payment_method'],
            'full_name' => $data['full_name'],
            'phone_number' => $data['phone_number'],
            'city' => $data['city'],
            'district' => $data['district'],
            'address' => $data['address'],
            'notes' => $data['notes']
        ]);

        // Thêm vào bảng order_items
        foreach ($cart_items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_amount'],
                'total_price' => $item['total_amount'],
            ]);
        }

        // Xóa giỏ
        CartManagement::clearCartItems();

        return redirect()->route('order.success', ['order' => $order->id]);
    }
}
