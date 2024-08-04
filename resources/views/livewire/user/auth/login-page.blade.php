<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <div class="flex h-full items-center">
    <main class="w-full max-w-2xl mx-auto p-6">
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="p-4 sm:p-7">
          <div class="text-center">
            <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Đăng nhập</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
              Bạn chưa có tài khoản?
              <a wire:navigate
                class="text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                href="/register">
                Đăng ký
              </a>
            </p>
          </div>

          <hr class="my-5 border-slate-300">

          <!-- Form -->
          <form wire:submit.prevent='save'>
            
            @csrf
            
            <div class="grid gap-y-4">
              <!-- Form Group -->
              <label for="email" class="block text-sm mb-2 dark:text-white">Email</label>
              <div class="relative">
                <input type="text" id="email" wire:model="email"
                  class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                  aria-describedby="email-error">

                @error('email')
                <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                  <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"
                    aria-hidden="true">
                    <path
                      d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                  </svg>
                </div>
                @enderror

              </div>
              @error('email')
              <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
              @enderror
            </div>
            <!-- End Form Group -->

            <!-- Form Group -->
            <div>
              <div class="flex justify-between items-center">
                <label for="password" class="block text-sm mb-2 dark:text-white">Password</label>

              </div>
              <div class="relative">
                <input type="password" id="password" wire:model="password"
                  class="py-3 border px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                  aria-describedby="password-error">

                @error('password')
                <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                  <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"
                    aria-hidden="true">
                    <path
                      d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                  </svg>
                </div>
                @enderror

              </div>
              @error('password')
              <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
              @enderror
            </div>
            <a class="flex justify-end text-blue-600" href="/forgot">Quên mật khẩu</a>
            <!-- End Form Group -->
            <button type="submit" class="w-full my-3 py-3 inline-flex justify-center items-center text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Đăng nhập</button>
            <div class="flex gap-2 justify-between">
              <a href="/auth/facebook/redirect" class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
                <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                </svg>
                Đăng nhập bằng Facebook
              </a>
              <a href="/auth/google/redirect" class="text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#4285F4]/55 me-2 mb-2">
                <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                  viewBox="0 0 18 19">
                  <path fill-rule="evenodd"
                    d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 5.053-3.463 8.449-8.4 8.449l-.186-.002Z"
                    clip-rule="evenodd" />
                </svg>
                Đăng nhập bằng Google
              </a>
            </div>
        </div>
        </form>
        <!-- End Form -->
      </div>
  </div>
</div>
</div>