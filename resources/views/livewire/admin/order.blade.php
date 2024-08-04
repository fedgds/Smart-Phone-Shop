<div>
    <h2 class="text-3xl text-center py-4">Đơn hàng</h2>
    <div class="flex gap-3">
        <select wire:model.live="sort" class="block w-50 text-base bg-gray-200 px-3 py-2 cursor-pointer dark:text-gray-400 dark:bg-gray-900 rounded-lg">
            <option value="default">Mặc định</option>
            <option value="time_asc">Mới nhất</option>
            <option value="time_desc">Cũ nhất</option>
        </select>
        <input wire:model.live="search" type="text" class="block w-50 text-base bg-gray-200 px-3 py-2 cursor-pointer dark:text-gray-400 dark:bg-gray-900 rounded-lg" placeholder="Tìm kiếm danh mục...">
    </div>
    
    <div class="mt-4">
        <table class="table-auto w-full border border-gray-200 border-collapse">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Tài khoản</th>
                    <th>Người nhận</th>
                    <th>Số điện thoại</th>
                    <th>Tổng giá</th>
                    <th>Giá cuối</th>
                    <th>PT thanh toán</th>
                    <th>TT thanh toán</th>
                    <th>TT đơn hàng</th>
                    <th>SLSP</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @if ($orders)
                    @foreach($orders as $order)
                        <tr class="text-center">
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->full_name }}</td>
                            <td>{{ $order->phone_number }}</td>
                            <td>{{ number_format($order->grand_total) }} đ</td>
                            <td>{{ number_format($order->final_total) }} đ</td>
                            <td>
                                @if ($order->payment_method == 'cod')
                                    <span class="bg-blue-500 py-1 px-3 rounded text-white shadow">COD</span>
                                @elseif($order->payment_status == 'vnpay')
                                    <span class="bg-green-500 py-1 px-3 rounded text-white shadow">VNPAY</span>
                                @endif
                            </td>
                            <td>
                                @if ($order->payment_status == 'pending')
                                    <span class="bg-blue-500 py-1 px-3 rounded text-white shadow">Chờ xử lý</span>
                                @elseif($order->payment_status == 'paid')
                                    <span class="bg-green-500 py-1 px-3 rounded text-white shadow">Đã thanh toán</span>
                                @elseif($order->payment_status == 'failed')
                                    <span class="bg-red-500 py-1 px-3 rounded text-white shadow">Thất bại</span>
                                @endif
                            </td>
                            <td>                        
                                @if ($order->status == 'new')
                                    <span class="bg-blue-500 py-1 px-3 rounded text-white shadow">Mới</span>
                                @elseif($order->status == 'processing')
                                    <span class="bg-yellow-500 py-1 px-3 rounded text-white shadow">Đang xử lý</span>
                                @elseif($order->status == 'shipped')
                                    <span class="bg-orange-500 py-1 px-3 rounded text-white shadow">Đang giao hàng</span>
                                @elseif($order->status == 'delivered')
                                    <span class="bg-green-500 py-1 px-3 rounded text-white shadow">Đã giao hàng</span>
                                @elseif($order->status == 'cancel')
                                    <span class="bg-red-500 py-1 px-3 rounded text-white shadow">Đã hủy</span>
                                @endif
                            </td>
                            <td>{{ count($order->order_item) }}</td>
                            <td colspan="2">
                                <button wire:click="show({{ $order->id }})" class="px-3 py-1.5 text-sm rounded bg-yellow-500 hover:bg-yellow-600 text-white"><i class="fa-regular fa-eye"></i></button>
                                <button onclick="return confirm('Bạn có chắc muốn xóa?')" wire:click="delete({{ $order->id }})" class="px-3 py-1.5 text-sm rounded bg-red-500 hover:bg-red-600 text-white"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                    @endforeach

                @else
                    <tr>
                        <td colspan="12" class="text-center text-red-600 mt-5">Chưa có dữ liệu</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="mt-4">
            @if (count($orders) >= 10)
                <button wire:loading.remove wire:click='loadMore' class="py-1 px-2 bg-blue-500 text-white rounded-lg hover:bg-red-600 mb-3">Xem thêm</button>
                <button wire:loading wire:click='loadMore' class="py-1 px-2 bg-blue-500 text-white rounded-lg hover:bg-red-600 mb-3">Đang load...</button>
            @endif
        </div>
    </div>
    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-3/7 max-h-[700px] overflow-auto">
                <h2 class="text-2xl text-center py-4">Chi tiết đơn hàng</h2>
                <form wire:submit.prevent="update">
                    <div class="mb-4 flex flex-col-3 gap-2">
                        <div class="w-1/3">
                            <div class="mb-4">
                                <label for="orderId" class="block text-sm font-medium text-gray-700">Mã đơn</label>
                                <input type="text" wire:model="orderId" id="orderId" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md bg-gray-300" readonly>
                            </div>
                        </div>
                        <div class="w-1/3">
                            <div class="mb-4">
                                <label for="user_id" class="block text-sm font-medium text-gray-700">Tài khoản</label>
                                <input type="text" wire:model="user_id" id="user_id" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md bg-gray-300" readonly>
                            </div>
                        </div>
                        <div class="w-1/3">
                            <div class="mb-4">
                                <label for="full_name" class="block text-sm font-medium text-gray-700">Người nhận</label>
                                <input type="text" wire:model="full_name" id="full_name" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md bg-gray-300" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 flex flex-col-3 gap-2">
                        <div class="w-1/3">
                            <div class="mb-4">
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                                <input type="text" wire:model="phone_number" id="phone_number" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md bg-gray-300" readonly>
                            </div>
                        </div>
                        <div class="w-1/3">
                            <div class="mb-4">
                                <label for="grand_total" class="block text-sm font-medium text-gray-700">Tổng giá</label>
                                <input type="text" wire:model="grand_total" id="grand_total" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md bg-gray-300" readonly>
                            </div>
                        </div>
                        <div class="w-1/3">
                            <div class="mb-4">
                                <label for="final_total" class="block text-sm font-medium text-gray-700">Giá cuối</label>
                                <input type="text" wire:model="final_total" id="final_total" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md bg-gray-300" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 flex flex-col-2 gap-2">
                        <div class="w-1/2">
                            <div class="mb-4">
                                <label for="city" class="block text-sm font-medium text-gray-700">Thành phố</label>
                                <input type="text" wire:model="city" id="city" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md bg-gray-300" readonly>
                            </div>
                        </div>
                        <div class="w-1/2">
                            <div class="mb-4">
                                <label for="district" class="block text-sm font-medium text-gray-700">Quận huyện</label>
                                <input type="text" wire:model="district" id="district" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md bg-gray-300" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                        <input type="text" wire:model="address" id="address" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md bg-gray-300" readonly>
                    </div>
                    @if ($notes)
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Ghi chú</label>
                            <textarea wire:model="notes" id="notes" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md bg-gray-300" readonly></textarea>
                        </div>
                    @endif
                    <div class="mb-4 flex flex-col-3 gap-2">
                        <div class="w-1/3">
                            <div class="mb-4">
                                <label for="payment_method" class="block text-sm font-medium text-gray-700">Phương thức thanh toán</label>
                                <select wire:model="payment_method" id="payment_method" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md" disabled>
                                    <option class="text-white bg-blue-500" value="cod">Trả tiền khi nhận hàng</option>
                                    <option class="text-white bg-red-500" value="vnpay">Thanh toán VN PAY</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-1/3">
                            <div class="mb-4">
                                <label for="payment_status" class="block text-sm font-medium text-gray-700">Trạng thái thanh toán</label>
                                <select wire:model="payment_status" id="payment_status" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md">
                                    <option class="text-white bg-blue-500" value="pending">Chờ xử lý</option>
                                    <option class="text-white bg-green-500" value="paid">Đã thanh toán</option>
                                    <option class="text-white bg-red-500" value="failed">Thất bại</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-1/3">
                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái đơn hàng</label>
                                <select wire:model="status" id="status" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md">
                                    <option class="text-white bg-blue-500" value="new">Mới</option>
                                    <option class="text-white bg-yellow-500" value="processing">Đang xử lý</option>
                                    <option class="text-white bg-orange-500" value="shipped">Đang giao hàng</option>
                                    <option class="text-white bg-green-500" value="delivered">Đã giao hàng</option>
                                    <option class="text-white bg-red-500" value="cancel">Đã hủy</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 flex flex-col-{{count($order->order_item)}} gap-2">
                        @foreach ($order->order_item as $item)
                            <div class="w-1/{{count($order->order_item)}} text-center">
                                <b>{{ $item->product->name }}</b>
                                <img src="{{ url('storage', $item->product->images[0]) }}" alt="" class="object-fill h-20 mx-auto">
                                @if ($item->product->sale_price)
                                    <p class="text-red-500">{{ number_format($item->product->sale_price) }} đ</p>
                                @else
                                    <p class="text-red-500">{{ number_format($item->product->price) }} đ</p>
                                @endif
                                <b>Số lượng: {{ $item->quantity }}</b>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center">
                        <button type="button" wire:click="hideModal" class="px-3 py-1.5 text-sm rounded bg-red-500 hover:bg-red-600 text-white mr-2">Thoát</button>
                        <button type="submit" class="px-3 py-1.5 text-sm rounded bg-green-500 hover:bg-green-600 text-white">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>