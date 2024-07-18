<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="py-10 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg">
      <h1 style="font-family: cursive" class="text-center mb-5 text-5xl text-blue-600">Chi tiết sản phẩm</h1>
        <div class="max-w-6xl px-4 py-4 mx-auto lg:py-8 md:px-6">
          <div class="flex flex-wrap -mx-4">
            <div class="w-full mb-8 md:w-1/2 md:mb-0" x-data="{ mainImage: '{{ url('storage', $product->images[0]) }}' }">
              <div class="sticky top-0 z-10 overflow-hidden ">
                <div class="relative mb-6 lg:mb-10 lg:h-2/4 border-2 border-gray-400 rounded-md">
                  <img x-bind:src="mainImage" alt="" class="object-cover w-full lg:h-full z-10">
                </div>
                <div class="flex-wrap hidden md:flex ">
                  @foreach ($product->images as $image)
                    <div class="w-1/2 p-2 sm:w-1/4" x-on:click="mainImage='{{ url('storage', $image) }}'">
                      <img src="{{ url('storage', $image) }}" alt="" class="object-cover w-full lg:h-20 cursor-pointer border border-gray-400 rounded-lg hover:border hover:border-blue-400 hover:opacity-85">
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="w-full px-4 md:w-1/2 ">
              <div class="lg:pl-20">
                <div class="mb-8 ">
                  <div class="max-w-xl text-3xl font-bold dark:text-gray-400 md:text-4xl mb-5">
                    {{ $product->name }}
                  </div>
                  <p class="inline-block mb-3 text-2xl font-bold text-gray-900 dark:text-gray-400 ">
                    Giá: 
                    @if ($product->sale_price)
                      <span class="font-bold text-xl mr-1 text-blue-600 dark:text-blue-600">{{ number_format($product->sale_price) }} đ</span>
                      <span class="font-bold text-sm line-through text-gray-800 dark:text-gray-800">{{ number_format($product->price) }} đ</span>
                      <span class="text-sm border border-blue-300 bg-blue-700 text-white px-2 py-1 rounded-full">-{{ round(($product->price-$product->sale_price)*100/$product->price) }} %</span>
                    @else
                      <span class="font-bold text-blue-600 dark:text-blue-600">{{ number_format($product->price) }} đ</span>
                    @endif
                  </p>
  
                </div>
                <div class="w-32 mb-8 ">
                  <label for="" class="inline-block mb-3 text-2xl font-bold text-gray-900 dark:text-gray-400 border-b border-blue-500">Số lượng</label>
                  <div class="relative flex flex-row w-full h-10 mt-6 bg-transparent rounded-lg">
                    <button wire:click='decreaseQty' class="w-20 h-full text-white bg-gray-900 rounded-l outline-none cursor-pointer dark:text-white hover:bg-gray-800">
                      <span class="m-auto text-2xl font-thin">-</span>
                    </button>
                    <input type="number" wire:model.live='quantity' readonly class="flex items-center w-full font-semibold text-center text-gray-800 placeholder-gray-900 bg-gray-100 border-black dark:text-gray-400 dark:placeholder-gray-400 focus:outline-none text-md hover:text-black" placeholder="1">
                    <button wire:click='increaseQty' class="w-20 h-full text-white bg-gray-900 rounded-r outline-none cursor-pointer dark:text-white hover:bg-gray-800">
                      <span class="m-auto text-2xl font-thin">+</span>
                    </button>
                  </div>
                </div>
                <div class="flex flex-wrap items-center gap-4">
                  <button wire:click='addToCart({{ $product->id }})' class="w-full p-3 bg-gray-900 rounded-full lg:w-2/5 dark:text-gray-200 text-gray-50 hover:bg-blue-600 dark:bg-blue-500 dark:hover:bg-blue-500">
                    <span wire:loading.remove wire:target='addToCart({{ $product->id }})'>Thêm vào giỏ</span>
                    <span wire:loading wire:target='addToCart({{ $product->id }})'>Đang thêm...</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="mt-10">
            <h2 class="font-bold text-xl mb-5">Mô tả</h2>
            <p class="text-gray-700 dark:text-gray-400">{{ $product->description }}</p>
          </div>
          <div class="mt-10">
            <h2 class="font-bold text-xl mb-5">Bình luận</h2>
            @if ($product->comments->isEmpty())
              <p class="text-center text-gray-500 mb-4">Chưa có bình luận nào cho sản phẩm này.</p>
            @else
              <div class="p-4 h-20 mb-5">
                <table class="w-full table-auto border-collapse border border-slate-200 rounded-md">
                  <thead>
                    <tr class="text-blue-600">
                      <th class="p-2">Khách hàng</th> 
                      <th class="p-2">Nội dung</th>
                      <th class="p-2">Ngày bình luận</th>
                      @if (auth()->user())
                        @if (auth()->user()->is_admin == 1)
                          <th class="p-2">Xóa bình luận</th>
                        @endif
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($product->comments as $comment)
                      <tr class="text-center">
                        <td class="p-2">{{ $comment->user->name }}</td>
                        <td class="p-2">{{ $comment->content }}</td>
                        <td class="p-2">{{ $comment->created_at->format('d-m-Y') }}</td>
                        @if (auth()->user())
                          @if (auth()->user()->is_admin == 1)
                            <td class="p-2">
                              <a wire:click.prevent='deleteComments({{ $comment->id }})' href="" class="text-blue-600 font-bold">Gỡ</a>
                            </td>
                          @endif
                        @endif
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
            @if (auth()->user())
              <form wire:submit.prevent='comment'>
                <div>
                  <textarea wire:model='content' class="w-full rounded-md p-2 border border-gray-600" rows="3" placeholder="Nội dung bình luận..."></textarea>
                  <button type="submit" class="rounded-xl bg-black text-white hover:bg-blue-600 px-4 py-1">Gửi</button>
                </div>
              </form> 
            @endif
  
          </div>
          
          <div class="mt-10">
            <h2 class="font-bold text-xl mb-5">Sản phẩm liên quan</h2>
            <div class="flex flex-wrap items-center ">
                
              @foreach($relatedProducts as $product)
                <div class="w-full h-full px-3 mb-6 sm:w-1/2 md:w-1/4" wire:key="{{ $product->id }}">
                  <div class="border border-gray-300 dark:border-gray-700">
                    <div class="relative bg-gray-200">
                      <a href="/products/{{ $product->slug }}" class="">
                        <img src="{{ url('storage', $product->images[0]) }}" alt="" class="object-cover w-full h-56 mx-auto ">
                      </a>
                    </div>
                    <div class="p-3 ">
                      <div class="flex items-center justify-between gap-2 mb-2">
                        <h3 class="text-x font-medium dark:text-gray-400">
                          {{ strlen($product->name) > 20 ? substr($product->name, 0, 20) . '...' : $product->name }}
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
    
                      <a wire:click.prevent='addToCart({{ $product->id }})' href="#" class="text-gray-500 flex items-center space-x-2 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-300">
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
          </div>
        </div>
      </section>
    </div>