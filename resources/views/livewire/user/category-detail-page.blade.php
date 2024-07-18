<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="py-10 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg">
      <h1 style="font-family: cursive" class="text-center mb-5 text-5xl text-black">Danh mục <span class="text-blue-600">"{{ $categoryDetail->name }}"</span></h1>
      <div class="px-4 py-4 mx-auto max-w-7xl lg:py-6 md:px-6">
        <div class="flex flex-wrap mb-24 -mx-3">
          <div class="w-full px-3">
            <div class="flex justify-between px-3 mb-4">
                <input wire:model.live="search" type="text" class="block w-50 text-base bg-gray-200 px-3 py-2 cursor-pointer dark:text-gray-400 dark:bg-gray-900 rounded-lg" placeholder="Tìm kiếm sản phẩm...">
            </div>
            <div class="flex flex-wrap items-center ">
              
              @foreach($products as $product)
                <div class="w-full h-full px-3 mb-6 sm:w-1/2 md:w-1/4" wire:key="{{ $product->id }}">
                  <div class="border border-gray-300 dark:border-gray-700">
                    <div class="relative bg-gray-200">
                      <a href="/products/{{ $product->slug }}" class="">
                        <img src="{{ url('storage', $product->images[0]) }}" alt="" class="object-fill w-full h-56 mx-auto">
                      </a>
                    </div>
                    <div class="p-3 ">
                      <div class="flex items-center justify-between gap-2 mb-2">
                        <h3 class="text-x font-medium dark:text-gray-400">
                          {{ strlen($product->name) > 23 ? substr($product->name, 0, 23) . '...' : $product->name }}
                        </h3>
                        @if ($product->sale_price)
                          <span class="text-sm border border-blue-300 bg-blue-700 text-white px-1 rounded-full">-{{ round(($product->price-$product->sale_price)*100/$product->price) }} %</span>
                        @endif
                      </div>
                      <p class="text-l ">
                        @if ($product->sale_price)
                          <span class="font-bold mr-1 text-blue-600 dark:text-blue-600">{{ number_format($product->sale_price) }} đ</span>
                          <span class="font-bold text-sm line-through text-gray-800 dark:text-gray-800">{{ number_format($product->price) }} đ</span>
                        @else
                        <span class="font-bold text-blue-600 dark:text-blue-600">{{ number_format($product->price) }} đ</span>
                        @endif
                      </p>
                    </div>
                    <div class="flex justify-center p-4 border-t border-gray-300 dark:border-gray-700">
    
                      <a wire:click.prevent='addToCart({{ $product->id }})' href="" class="text-gray-500 flex items-center space-x-2 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 h-4 bi bi-cart3 " viewBox="0 0 16 16">
                          <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
                        </svg>
                        <span wire:loading.remove wire:target='addToCart({{ $product->id }})'>Thêm vào giỏ</span>
                        <span wire:loading wire:target='addToCart({{ $product->id }})'>Đang thêm...</span>
                      </a>
    
                    </div>
                  </div>
                </div>
              @endforeach
  
            </div>
            {{-- Phân trang --}}
            <div class="mt-4 text-center">
              @if (count($products) >= 4)
                  <button wire:loading.remove wire:click='loadMore' class="py-1 px-2 bg-blue-500 text-white rounded-lg hover:bg-red-600 mb-3">Xem thêm</button>
                  <button wire:loading wire:click='loadMore' class="py-1 px-2 bg-blue-500 text-white rounded-lg hover:bg-red-600 mb-3">Đang load...</button>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>
  
  </div>