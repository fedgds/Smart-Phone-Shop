<div>
    <h2 class="text-3xl text-center py-4">Danh mục</h2>
    <div class="flex justify-between py-2 px-6">
        <button type="button" wire:click="create" class="px-3 py-1.5 text-sm rounded bg-blue-500 hover:bg-blue-600 text-white">Thêm danh mục</button>
        <div class="flex gap-3">
            <select wire:model.live="sort" class="block w-50 text-base bg-gray-200 px-3 py-2 cursor-pointer dark:text-gray-400 dark:bg-gray-900 rounded-lg">
                <option value="default">Mặc định</option>
                <option value="name_asc">A-Z</option>
                <option value="name_desc">Z-A</option>
            </select>
            <input wire:model.live="search" type="text" class="block w-50 text-base bg-gray-200 px-3 py-2 cursor-pointer dark:text-gray-400 dark:bg-gray-900 rounded-lg" placeholder="Tìm kiếm danh mục...">
        </div>
    </div>
    
    <div class="mt-4">
        <table class="table-auto w-full border border-gray-200 border-collapse">
            <thead>
                <tr>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Ảnh</th>
                    <th>Kích hoạt</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @if ($categories)
                    @foreach($categories as $category)
                        <tr class="text-center">
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td class="flex justify-center"><img src="{{ url('storage', $category->image) }}" alt="" class="border h-20 rounded-lg hover:opacity-70 hover:border-blue-400"></td>
                            <td>{!! $category->is_active==1 ? '<i class="fa-solid fa-check text-blue-600"></i>' : '<i class="fa-solid fa-xmark text-red-600"></i>' !!}</td>
                            <td colspan="2">
                                <button wire:click="edit({{ $category->id }})" class="px-3 py-1.5 text-sm rounded bg-yellow-500 hover:bg-yellow-600 text-white"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button onclick="return confirm('Bạn có chắc muốn xóa?')" wire:click="delete({{ $category->id }})" class="px-3 py-1.5 text-sm rounded bg-red-500 hover:bg-red-600 text-white"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                    @endforeach

                @else
                    <tr>
                        <td colspan="6" class="text-center text-red-600 mt-5">Chưa có dữ liệu</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h2 class="text-2xl text-center py-4">{{ $isEditMode ? 'Sửa danh mục' : 'Tạo danh mục' }}</h2>
                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Tên danh mục</label>
                        <input type="text" wire:model="name" id="name" class="mt-1 block w-full" wire:change="generateSlug">
                        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Đường dẫn</label>
                        <input type="text" wire:model.defer="slug" id="slug" class="mt-1 block w-full" disabled>
                        @error('slug') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Ảnh</label>
                        <input type="file" wire:model="image" id="image" class="mt-1 block w-full">
                        @if ($isEditMode)
                            <img class="mt-2 h-32" src="{{$image}}" alt="">
                        @endif
                        @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="is_active" class="block text-sm font-medium text-gray-700">Kích hoạt</label>
                        <input type="checkbox" wire:model="is_active" id="is_active" {{ $is_active ? 'checked' : '' }}>
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