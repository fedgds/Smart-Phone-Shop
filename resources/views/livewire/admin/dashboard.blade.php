<div>
    <div class="py-2 px-6 bg-white flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30">
        <button type="button" class="text-lg text-gray-600 sidebar-toggle">
            <i class="ri-menu-line"></i>
        </button>
        <ul class="flex items-center text-sm ml-4">
            <li class="mr-2">
                <a href="/admin" class="text-gray-400 hover:text-gray-600 font-medium">Dashboard</a>
            </li>
        </ul>
        <ul class="ml-auto flex items-center">
            <li class="mr-1 dropdown">
                <button type="button" class="dropdown-toggle text-gray-400 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">
                    <i class="ri-search-line"></i>
                </button>
            </li>
            <li class="dropdown">
                <button type="button" class="dropdown-toggle text-gray-400 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">
                    <i class="ri-notification-3-line"></i>
                </button>
            </li>
            <li class="dropdown ml-3">
                <button type="button" class="dropdown-toggle flex items-center">
                    <img src="/img/logo.png" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                </button>
                <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                    <li>
                        <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md lg:col-span-2">
        <div class="flex justify-between mb-4 items-start">
            <div class="font-medium">Order Statistics</div>
            <div class="dropdown">
                <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600"><i class="ri-more-fill"></i></button>
                <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                    <li>
                        <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="grid gap-4 mb-4">
            <div class="grid grid-cols-3 gap-4">
                <div class="rounded-md border border-dashed border-gray-200 p-4">
                    <div class="flex items-center mb-0.5">
                        <div class="text-xl font-semibold">17</div>
                        <span class="p-1 rounded text-[12px] font-semibold bg-blue-500/10 text-blue-500 leading-none ml-1">$80</span>
                    </div>
                    <span class="text-gray-400 text-sm">Active</span>
                </div>
                <div class="rounded-md border border-dashed border-gray-200 p-4">
                    <div class="flex items-center mb-0.5">
                        <div class="text-xl font-semibold">50</div>
                        <span class="p-1 rounded text-[12px] font-semibold bg-emerald-500/10 text-emerald-500 leading-none ml-1">+$469</span>
                    </div>
                    <span class="text-gray-400 text-sm">Completed</span>
                </div>
                <div class="rounded-md border border-dashed border-gray-200 p-4">
                    <div class="flex items-center mb-0.5">
                        <div class="text-xl font-semibold">4</div>
                        <span class="p-1 rounded text-[12px] font-semibold bg-rose-500/10 text-rose-500 leading-none ml-1">-$130</span>
                    </div>
                    <span class="text-gray-400 text-sm">Canceled</span>
                </div>
            </div>
            <div>
                <canvas id="order-chart"></canvas>
            </div>
        </div>
    </div>
</div>
