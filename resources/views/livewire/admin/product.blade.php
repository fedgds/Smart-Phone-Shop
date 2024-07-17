<div> 
    <h2 class="text-3xl text-center py-4">Sản phẩm</h2>
    <div class="flex justify-between py-2 px-6">
        <button type="button" wire:click="create" class="px-3 py-1.5 text-sm rounded bg-blue-500 hover:bg-blue-600 text-white">Thêm sản phẩm</button>
        <div class="flex gap-3">
            <select wire:model.live="sort" class="block w-50 text-base bg-gray-200 px-3 py-2 cursor-pointer dark:text-gray-400 dark:bg-gray-900 rounded-lg">
                <option value="default">Mặc định</option>
                <option value="is_active">Kích hoạt</option>
                <option value="is_featured">Nổi bật</option>
                <option value="in_stock">Còn hàng</option>
                <option value="on_sale">Giảm giá</option>
                <option value="price_asc">Tăng dần</option>
                <option value="price_desc">Giảm dần</option>
            </select>
            <select wire:model.live="sort" class="block w-50 text-base bg-gray-200 px-3 py-2 cursor-pointer dark:text-gray-400 dark:bg-gray-900 rounded-lg">
                <option value="default">Chọn danh mục</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <input wire:model.live="search" type="text" class="block w-50 text-base bg-gray-200 px-3 py-2 cursor-pointer dark:text-gray-400 dark:bg-gray-900 rounded-lg" placeholder="Tìm kiếm sản phẩm...">
        </div>
    </div>
    <div class="mt-4">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th>Danh mục</th>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Giá giảm</th>
                    <th>Kích hoạt</th>
                    <th>Nổi bật</th>
                    <th>Còn hàng</th>
                    <th>Giảm giá</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if ($products)
                    @foreach($products as $product)
                        <tr class="text-center">
                            <td>{{ $product->category->name }}</td>
                            <td class="flex justify-center"><img src="{{ url('storage', $product->images[0]) }}" alt="" class="border h-20 rounded-lg hover:opacity-70 hover:border-blue-400"></td>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($product->price) }}</td>
                            <td>{{ $product->sale_price ? number_format($product->sale_price) : '' }}</td>
                            <td>{!! $product->is_active==1 ? '<i class="fa-solid fa-check text-blue-600"></i>' : '<i class="fa-solid fa-xmark text-red-600"></i>' !!}</td>
                            <td>{!! $product->is_featured==1 ? '<i class="fa-solid fa-check text-blue-600"></i>' : '<i class="fa-solid fa-xmark text-red-600"></i>' !!}</td>
                            <td>{!! $product->in_stock==1 ? '<i class="fa-solid fa-check text-blue-600"></i>' : '<i class="fa-solid fa-xmark text-red-600"></i>' !!}</td>
                            <td>{!! $product->on_sale==1 ? '<i class="fa-solid fa-check text-blue-600"></i>' : '<i class="fa-solid fa-xmark text-red-600"></i>' !!}</td>
                            <td colspan="2">
                                <button wire:click="edit({{ $product->id }})" class="px-3 py-1.5 text-sm rounded bg-yellow-500 hover:bg-yellow-600 text-white"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button onclick="return confirm('Bạn có chắc muốn xóa?')" wire:click="delete({{ $product->id }})" class="px-3 py-1.5 text-sm rounded bg-red-500 hover:bg-red-600 text-white"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                    @endforeach

                @else
                    <tr>
                        <td colspan="11" class="text-center text-red-600 mt-5">Chưa có dữ liệu</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="mt-4 text-center">
            @if (count($products) >= 6)
                <button wire:loading.remove wire:click='loadMore' class="py-1 px-2 bg-blue-500 text-white rounded-lg hover:bg-red-600 mb-3">Xem thêm</button>
                <button wire:loading wire:click='loadMore' class="py-1 px-2 bg-blue-500 text-white rounded-lg hover:bg-red-600 mb-3">Đang load...</button>
            @endif
        </div>
    </div>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-3/6">
                <h2 class="text-2xl text-center py-2">{{ $isEditMode ? 'Sửa sản phẩm' : 'Thêm sản phẩm' }}</h2>
                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">

                    <div class="mb-4 flex gap-2">
                        <div class="w-1/2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Tên sản phẩm</label>
                            <input type="text" wire:model="name" id="name" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md" placeholder="Tên sản phầm" wire:change="generateSlug">
                            @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-1/2">
                            <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                            <input type="text" wire:model="slug" id="slug" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md pl bg-gray-300" placeholder="ten-san-pham" readonly>
                            @error('slug') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-4 flex gap-2">
                        <div class="w-1/2">
                            <label for="price" class="block text-sm font-medium text-gray-700">Giá</label>
                            <input type="number" wire:model="price" id="price" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md" placeholder="Giá">
                            @error('price') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-1/2" x-show="$wire.on_sale">
                            <label for="sale_price" class="block text-sm font-medium text-gray-700">Giá khuyến mãi</label>
                            <input type="number" wire:model="sale_price" id="sale_price" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md" placeholder="Giá khuyến mãi">
                            @error('sale_price') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>                    

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
                        <textarea wire:model="description" id="description" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md" placeholder="Mô tả"></textarea>
                        @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Danh mục</label>
                        <select wire:model="category_id" id="category_id" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md">
                            <option value="">Chọn danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="images" class="block text-sm font-medium text-gray-700">Hình ảnh</label>
                        <input type="file" wire:model="images" id="images" class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md" multiple>
                        @if ($isEditMode)
                            <div class="mt-2 flex gap-3 justify-center">
                                @foreach ($images as $image)
                                    <img src="{{ Storage::url($image) }}" class="w-16 h-16 object-cover rounded-md border-2 border-gray-700 hover:opacity-80">
                                @endforeach
                            </div>
                        @endif
                        @error('images') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4 flex gap-2">
                        <div class="w-1/4">
                            <label for="is_active" class="block text-sm font-medium text-gray-700">Kích hoạt</label>
                            <label class="inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" wire:model="is_active" id="is_active" {{ $is_active ? 'checked' : '' }} class="sr-only peer" value="">
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <div class="w-1/4">
                            <label for="is_featured" class="block text-sm font-medium text-gray-700">Nổi bật</label>
                            <label class="inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" wire:model="is_featured" id="is_featured" {{ $is_featured ? 'checked' : '' }} class="sr-only peer" value="">
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                            </label>
                        </div>
                        <div class="w-1/4">
                            <label for="in_stock" class="block text-sm font-medium text-gray-700">Còn hàng</label>
                            <label class="inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" wire:model="in_stock" id="in_stock" {{ $in_stock ? 'checked' : '' }} class="sr-only peer" value="">
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                            </label>
                        </div>
                        <div class="w-1/4">
                            <label for="on_sale" class="block text-sm font-medium text-gray-700">Giảm giá</label>
                            <label class="inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" wire:model="on_sale" wire:change="toggleSalePrice" id="on_sale" {{ $on_sale ? 'checked' : '' }} class="sr-only peer" value="">
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 dark:peer-focus:ring-yellow-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-yellow-600"></div>
                            </label>
                        </div>                        
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
