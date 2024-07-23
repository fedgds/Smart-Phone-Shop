<div class="fixed left-0 top-0 w-64 h-full bg-gray-900 p-4 z-50 sidebar-menu transition-transform">
    <a href="#" class="text-center border-b border-b-gray-800">
        <img src="/img/logo.png" alt="" class="h-8 rounded object-cover">
    </a>
    <ul class="mt-4">
        <li class="mb-1 group {{ request()->is('admin')?'active':'' }}">
            <a href="/admin" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="fa-solid fa-house mr-3 text-lg"></i>
                <span class="text-sm">Dashboard</span>
            </a>
        </li>
        <li class="mb-1 group {{ request()->is('admin/user')?'active':'' }}">
            <a href="/admin/user" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="fa-solid fa-user mr-3 text-lg"></i>
                <span class="text-sm">Tài khoản</span>
            </a>
        </li>
        <li class="mb-1 group {{ request()->is('admin/category')?'active':'' }}">
            <a href="/admin/category" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="fa-solid fa-list mr-3 text-lg"></i>
                <span class="text-sm">Danh mục</span>
            </a>
        </li>
        <li class="mb-1 group {{ request()->is('admin/product')?'active':'' }}">
            <a href="/admin/product" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="fa-solid fa-box mr-3 text-lg"></i>
                <span class="text-sm">Sản phẩm</span>
            </a>
        </li>
        <li class="mb-1 group {{ request()->is('admin/product')?'active':'' }}">
            <a href="/admin/product" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="fa-solid fa-box-open mr-3 text-lg"></i>
                <span class="text-sm">Đơn hàng</span>
            </a>
        </li>
        <li class="mb-1 group {{ request()->is('admin/voucher')?'active':'' }}">
            <a href="/admin/voucher" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="fa-solid fa-ticket mr-3 text-lg"></i>
                <span class="text-sm">Voucher</span>
            </a>
        </li>
        <li class="mb-1 group {{ request()->is('admin/banner')?'active':'' }}">
            <a href="/admin/banner" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="fa-solid fa-image mr-3 text-lg"></i>
                <span class="text-sm">Banner</span>
            </a>
        </li>
    </ul>
</div>