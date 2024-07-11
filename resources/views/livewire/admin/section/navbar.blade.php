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
        <li class="mb-1 group">
            <a href="#" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 sidebar-dropdown-toggle">
                <i class="fa-solid fa-box mr-3 text-lg"></i>
                <span class="text-sm">Sản phẩm</span>
                <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="pl-7 mt-2 hidden group-[.selected]:block">
                <li class="mb-4">
                    <a href="#" class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Manage services</a>
                </li>
            </ul>
        </li>
        <li class="mb-1 group">
            <a href="#" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="fa-solid fa-image mr-3 text-lg"></i>
                <span class="text-sm">Banner</span>
            </a>
        </li>
    </ul>
</div>