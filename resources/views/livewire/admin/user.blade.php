<div>
    <h2 class="text-3xl text-center py-4">Tài khoản</h2>
    <div class="flex justify-between py-2 px-6">
        <button type="button" wire:click="create" class="px-3 py-1.5 text-sm rounded bg-blue-500 hover:bg-blue-600 text-white">Thêm tài khoản</button>
        <div class="flex gap-3">
            <select wire:model.live="sort" class="block w-50 text-base bg-gray-200 px-3 py-2 cursor-pointer dark:text-gray-400 dark:bg-gray-900 rounded-lg">
                <option value="default">Mặc định</option>
                <option value="admin">Tài khoản admin</option>
                <option value="user">Tài khoản user</option>
                <option value="latest">Sắp xếp theo mới nhất</option>
            </select>
            <input wire:model.live="search" type="text" class="block w-50 text-base bg-gray-200 px-3 py-2 cursor-pointer dark:text-gray-400 dark:bg-gray-900 rounded-lg" placeholder="Tìm kiếm tài khoản...">
        </div>
    </div>
    
    <div class="mt-4">
        <table class="table-auto w-full border border-gray-200 border-collapse">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @if ($users)
                    @foreach($users as $user)
                        <tr class="text-center">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{!! $user->is_admin==1 ? '<i class="fa-solid fa-user-gear text-red-600"></i>' : '<i class="fa-solid fa-user text-blue-600"></i>' !!}</td>
                            <td colspan="2">
                                <button wire:click="edit({{ $user->id }})" class="px-3 py-1.5 text-sm rounded bg-yellow-500 hover:bg-yellow-600 text-white"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button onclick="return confirm('Bạn có chắc muốn xóa?')" wire:click="delete({{ $user->id }})" class="px-3 py-1.5 text-sm rounded bg-red-500 hover:bg-red-600 text-white"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                    @endforeach

                @else
                    <tr>
                        <td colspan="5" class="text-center text-red-600 mt-5">Chưa có dữ liệu</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h2 class="text-2xl text-center py-4">{{ $isEditMode ? 'Sửa tài khoản' : 'Tạo tài khoản' }}</h2>
                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Tên</label>
                        <input type="text" wire:model="name" id="name" class="mt-1 block w-full">
                        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" wire:model="email" id="email" class="mt-1 block w-full">
                        @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    @if(!$isEditMode)
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                            <input type="password" wire:model="password" id="password" class="mt-1 block w-full">
                            @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    @endif
                    <div class="mb-4">
                        <label for="is_admin" class="block text-sm font-medium text-gray-700">Quyền quản trị</label>
                        <input type="checkbox" wire:model="is_admin" id="is_admin" {{ $is_admin ? 'checked' : '' }}>
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
