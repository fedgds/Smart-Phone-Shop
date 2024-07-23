<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
	<section class="py-10 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg p-4">
		<h1 style="font-family: cursive" class="text-center mb-5 text-5xl text-blue-600">Thanh toán</h1>
		<form action="{{ url('/vnpay_payment') }}" method="POST">
			@csrf
			<div class="grid grid-cols-12 gap-4">
				<div class="md:col-span-12 lg:col-span-8 col-span-12">
					<!-- Card -->
					<div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
						<!-- Shipping Address -->
						<div class="mb-6">
							<h2 class="text-2xl font-bold text-black dark:text-white mb-2">
								Thông tin nhận hàng
							</h2>
							<div class="mt-4">
								<label class="block text-gray-700 dark:text-white mb-1" for="name">
									Họ và Tên
								</label>
								<input name='full_name' value="{{ old('full_name') }}" class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="name" type="text" placeholder="Nhập họ và tên"></input>
								@error('full_name')
									<p class="text-xs text-red-600 mt-2">{{ $message }}</p>
								@enderror
							</div>
							<div class="mt-4">
								<label class="block text-gray-700 dark:text-white mb-1" for="phone">
									Số điện thoại
								</label>
								<input name='phone_number' value="{{ old('phone_number') }}" class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="phone" type="text" placeholder="Nhập số điện thoại"></input>
								@error('phone_number')
									<p class="text-xs text-red-600 mt-2">{{ $message }}</p>
								@enderror
							</div>
							<div class="grid grid-cols-2 gap-4 mt-4">
								<div>
									<label class="block text-gray-700 dark:text-white mb-1" for="city">
										Thành phố
									</label>
									<select name='city' class="form-select city w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="city" onchange="loadDistrict()">
										<option selected>Chọn thành phố</option>
									</select>
									@error('city')
										<p class="text-xs text-red-600 mt-2">{{ $message }}</p>
									@enderror
								</div>
								<div>
									<label class="block text-gray-700 dark:text-white mb-1" for="district">
										Quận/Huyện
									</label>
									<select name='district' class="form-select district w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="district">
										<option selected>Chọn quận huyện</option>
									</select>
									@error('district')
										<p class="text-xs text-red-600 mt-2">{{ $message }}</p>
									@enderror
								</div>
							</div>
							<div class="mt-4">
								<label class="block text-gray-700 dark:text-white mb-1" for="address">
									Địa chỉ
								</label>
								<input name='address' value="{{ old('address') }}" class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="address" type="text" placeholder="Nhập địa chỉ"></input>
								@error('address')
									<p class="text-xs text-red-600 mt-2">{{ $message }}</p>
								@enderror
							</div>
							<div class="mt-4">
								<label class="block text-gray-700 dark:text-white mb-1" for="note">
									Ghi chú
								</label>
								<textarea name='notes' value="{{ old('notes') }}" class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="note" type="text" placeholder="Ghi chú"></textarea>
							</div>
						</div>
						<div class="text-lg font-semibold mb-4">
							Chọn phương thức thanh toán
						</div>
						<div class="flex justify-center">
							<select name="payment_method" id="" class="border border-gray-500 rounded-lg py-1 px-3 bg-black text-white">
								<option value="cod">Trả tiền khi nhận hàng</option>
								<option value="vnpay">Thanh toán VN PAY</option>
							</select>
						</div>
					</div>
					<!-- End Card -->
				</div>
				<div class="md:col-span-12 lg:col-span-4 col-span-12">
					<div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
						<div class="text-2xl font-bold text-black dark:text-white mb-2">
							Tóm tắt đơn hàng
						</div>
						<div class="flex justify-between mb-2 font-bold">
							<span>
								Tổng tiền
							</span>
							<span>
								{{ number_format($grand_total) }} đ
							</span>
						</div>
						<div class="flex justify-between mb-2 font-bold">
							<span>
								Thuế
							</span>
							<span>
								0 đ
							</span>
						</div>
						<div class="flex justify-between mb-2 font-bold">
							<span>
								Phí giao hàng
							</span>
							<span>
								0 đ
							</span>
						</div>
						<hr class="bg-slate-400 my-4 h-1 rounded">
						<div class="flex justify-between mb-2 font-bold">
							<span>
								Tổng cộng
							</span>
							<span>
								{{ number_format($grand_total) }} đ
							</span>
						</div>
						</hr>
					</div>
					<input type="hidden" name="grand_total" value="{{ $grand_total }}">
					<button type="submit" name="redirect" class="bg-gray-900 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-gray-800">
						Đặt hàng
					</button>
					<div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
						<div class="text-xl font-bold text-black dark:text-white mb-2">
							Giỏ hàng
						</div>
						<ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
							@foreach ($cart_items as $item)
								<li class="py-3 sm:py-4" wire:key='{{ $item['product_id'] }}'>
									<div class="flex items-center">
										<div class="flex-shrink-0">
											<img alt="Neil image" class="w-12 h-12 rounded-full" src="{{ url('storage', $item['image']) }}"></img>
										</div>
										<div class="flex-1 min-w-0 ms-4">
											<p class="text-sm font-medium text-gray-900 truncate dark:text-white">
												{{ $item['name'] }}
											</p>
											<p class="text-sm text-gray-500 truncate dark:text-gray-400">
												Số lượng: {{ $item['quantity'] }}
											</p>
										</div>
										<div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
											{{ number_format($item['total_amount']) }} đ
										</div>
									</div>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</form>
	</section>
	<script>

		var config = {
			cUrl: 'http://localhost/laravel/api-vn/public/api/cities'
		};

		var citySelect = document.querySelector('.city'),
			districtSelect = document.querySelector('.district');

		function loadCities() {
			citySelect.disabled = false;
			districtSelect.disabled = true;
			citySelect.style.pointerEvents = 'auto';
			districtSelect.style.pointerEvents = 'none';

			fetch(`${config.cUrl}`)
			.then(response => response.json())
			.then(data => {
				console.log(data);
				citySelect.innerHTML = '<option value="">Chọn thành phố</option>'; 

				data.cities.forEach(city => {
					const option = document.createElement('option');
					option.textContent = city.city_name;
					option.value = city.city_name;
					option.dataset.id = city.id;
					citySelect.appendChild(option);
				});
			})
			.catch(error => console.error('Lỗi tải thành phố:', error));
		}

		function loadDistrict() {
			districtSelect.disabled = false;
			districtSelect.style.pointerEvents = 'auto';

			const selectedCity = citySelect.options[citySelect.selectedIndex];
			const selectedCityCode = selectedCity.dataset.id;

			districtSelect.innerHTML = '<option value="">Chọn quận huyện</option>';

			fetch(`${config.cUrl}/${selectedCityCode}/districts`)
			.then(response => response.json())
			.then(data => {
				data.district.forEach(district => {
					const option = document.createElement('option');
					option.value = district.district_name;
					option.textContent = district.district_name;
					districtSelect.appendChild(option);
				});
			})
			.catch(error => console.error('Lỗi tải quận huyện:', error));
		}

		window.onload = loadCities;
	</script>
</div>