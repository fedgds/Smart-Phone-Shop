<div>
    <h2 class="text-3xl text-center py-4">Voucher</h2>
    <div class="flex justify-between py-2 px-6">
        <button type="button" wire:click="create" class="px-3 py-1.5 text-sm rounded bg-blue-500 hover:bg-blue-600 text-white">Thêm voucher</button>
        <div class="flex gap-3">
            <select wire:model.live="sort" class="block w-50 text-base bg-gray-200 px-3 py-2 cursor-pointer dark:text-gray-400 dark:bg-gray-900 rounded-lg">
                <option value="default">Mặc định</option>
                <option value="active">Voucher active</option>
                <option value="inactive">Voucher inactive</option>
                <option value="latest">Sắp xếp theo mới nhất</option>
            </select>
            <input wire:model.live="search" type="text" class="block w-50 text-base bg-gray-200 px-3 py-2 cursor-pointer dark:text-gray-400 dark:bg-gray-900 rounded-lg" placeholder="Tìm kiếm voucher...">
        </div>
    </div>
    
    <div class="mt-4">
        <table class="table-auto w-full border border-gray-200 border-collapse">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Loại giảm giá</th>
                    <th>Giảm giá</th>
                    <th>Đơn nhỏ nhất</th>
                    <th>Đơn lớn nhất</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Trạng thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @if ($vouchers)
                    @foreach($vouchers as $voucher)
                        <tr class="text-center">
                            <td>{{ $voucher->code }}</td>
                            <td>{{ $voucher->discount_type == 'fixed' ? 'VND' : '%' }}</td>
                            <td>{{ number_format($voucher->discount) }}{{ $voucher->discount_type == 'fixed' ? ' đ' : ' %' }}</td>
                            <td>{{ $voucher->min_order_value != null ? number_format($voucher->min_order_value).' đ' : '' }}</td>
                            <td>{{ $voucher->max_order_value != null ? number_format($voucher->max_order_value).' đ' : '' }}</td>
                            <td>{{ date('d/m/Y', strtotime($voucher->start_date)) }}</td>
                            <td>{{ date('d/m/Y', strtotime($voucher->end_date)) }}</td>
                            <td>{!! $voucher->status == 1 ? '<i class="fa-solid fa-check text-blue-600"></i>' : '<i class="fa-solid fa-xmark text-red-600"></i>' !!}</td>
                            <td>
                                <button wire:click="edit({{ $voucher->id }})" class="px-2 py-1 bg-yellow-500 text-white rounded">Sửa</button>
                                <button wire:click="delete({{ $voucher->id }})" class="px-2 py-1 bg-red-500 text-white rounded">Xóa</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">Không có dữ liệu</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="mt-4">
            @if (count($vouchers) >= 15)
                <button wire:loading.remove wire:click='loadMore' class="py-1 px-2 bg-blue-500 text-white rounded-lg hover:bg-red-600 mb-3">Xem thêm</button>
                <button wire:loading wire:click='loadMore' class="py-1 px-2 bg-blue-500 text-white rounded-lg hover:bg-red-600 mb-3">Đang load...</button>
            @endif
        </div>
    </div>
    
    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-2/5 max-h-[700px] overflow-auto">
                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                    <h2 class="text-2xl text-center py-4">{{ $isEditMode ? 'Sửa tài khoản' : 'Tạo tài khoản' }}</h2>
                    <div class="mb-4">
                        <label for="code" class="block text-gray-700">Mã</label>
                        <input type="text" id="code" wire:model="code" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md" placeholder="VD: AbCXyZ"/>
                        @error('code') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4 flex gap-2">
                        <div class="w-1/2">
                            <label for="discount_type" class="block text-gray-700">Loại giảm giá</label>
                            <select wire:model="discount_type" id="discount_type" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md">
                                <option value="fixed">Theo giá</option>
                                <option value="percentage">Theo phần trăm</option>
                            </select>                            
                            @error('discount_type') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-1/2">
                            <label for="discount" class="block text-gray-700">Giảm giá</label>
                            <input type="number" id="discount" wire:model="discount" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md" />
                            @error('discount') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="usage_limit" class="block text-gray-700">Giới hạn</label>
                        <input type="number" id="usage_limit" wire:model="usage_limit" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md"/>
                        @error('usage_limit') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4 flex gap-2">
                        <div class="w-1/2">
                            <label for="min_order_value" class="block text-gray-700">Đơn nhỏ nhất</label>
                            <input type="number" id="min_order_value" wire:model="min_order_value" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md" />
                            @error('min_order_value') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-1/2">
                            <label for="max_order_value" class="block text-gray-700">Đơn lớn nhất</label>
                            <input type="number" id="max_order_value" wire:model="max_order_value" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md" />
                            @error('max_order_value') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mb-4 flex gap-2">
                        <div class="w-1/2">
                            <label for="start_date" class="block text-gray-700">Ngày bắt đầu</label>
                            <input type="date" id="start_date" wire:model="start_date" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md" />
                            @error('start_date') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-1/2">
                            <label for="end_date" class="block text-gray-700">Ngày kết thúc</label>
                            <input type="date" id="end_date" wire:model="end_date" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md" />
                            @error('end_date') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-gray-700">Trạng thái</label>
                        <select id="status" wire:model="status" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md">
                            <option value="0">Không kích hoạt</option>
                            <option value="1">Kích hoạt</option>
                        </select>
                        @error('status') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex items-center justify-end">
                        <button type="button" wire:click="hideModal" class="px-3 py-1.5 text-sm rounded bg-red-500 hover:bg-red-600 text-white mr-2">Hủy</button>
                        <button type="submit" class="px-3 py-1.5 text-sm rounded bg-green-500 hover:bg-green-600 text-white">{{ $isEditMode ? 'Cập nhật' : 'Thêm' }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
