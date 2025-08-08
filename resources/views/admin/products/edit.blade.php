@extends("layouts.admin-layout")

@section("content")
    <div class="w-full  ">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Product</h1>
                <p class="text-gray-600 text-sm">Update product information and settings</p>
            </div>
            <a href="{{ route("admin.products.index") }}"
                class="inline-flex items-center px-3 py-2 border-2 border-blue-600 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 hover:border-blue-700 hover:scale-105 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Back to Products
            </a>
        </div>

        <div class="bg-white shadow-lg rounded-xl p-4 lg:p-6">
            <form action="{{ route("admin.products.update", $product) }}" method="POST" enctype="multipart/form-data"
                class="space-y-4" id="editProductForm">
                @csrf
                @method("PUT")

                <!-- Global Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h4 class="font-medium">Please fix the following errors:</h4>
                        </div>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Success Message -->
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Warning Message -->
                @if (session('warning'))
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="font-medium">{{ session('warning') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Database Connection Error -->
                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Basic Information Section -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Basic Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                        </path>
                                    </svg>
                                </div>
                                <input type="text" name="name"
                                    class="pl-9 w-full border py-2 pr-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                    value="{{ old("name", $product->name) }}" placeholder="Enter product name" required>
                            </div>
                            @error("name")
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </div>
                                <select name="category_id"
                                    class="pl-9 w-full border py-2 pr-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                    required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @if (old("category_id", $product->category_id) == $category->id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error("category_id")
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea name="description" rows="3"
                            class="w-full border py-2 pr-3 pl-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                            placeholder="Enter product description" required>{{ old("description", $product->description) }}</textarea>
                        @error("description")
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Pricing Section -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                            </path>
                        </svg>
                        Pricing Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">USD Price *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">$</span>
                                </div>
                                <input type="number" step="0.01" name="price_usd"
                                    class="pl-8 w-full border py-2 pr-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                    value="{{ old("price_usd", $product->price_usd) }}" placeholder="0.00" required>
                            </div>
                            @error("price_usd")
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NGN Price *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">₦</span>
                                </div>
                                <input type="number" step="0.01" name="price_ngn"
                                    class="pl-8 w-full border py-2 pr-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                    value="{{ old("price_ngn", $product->price_ngn) }}" placeholder="0.00" required>
                            </div>
                            @error("price_ngn")
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sale Price (NGN)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">₦</span>
                                </div>
                                <input type="number" step="0.01" name="sale_price"
                                    class="pl-8 w-full border py-2 pr-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                    value="{{ old("sale_price", $product->sale_price) }}" placeholder="0.00">
                            </div>
                            @error("sale_price")
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Inventory Section -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Inventory Management
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-14 0h14">
                                        </path>
                                    </svg>
                                </div>
                                <input type="number" name="quantity"
                                    class="pl-9 w-full border py-2 pr-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                    value="{{ old("quantity", $product->quantity) }}" placeholder="0" required>
                            </div>
                            @error("quantity")
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Variants Section -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m-9 8h12a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Product Variants
                    </h3>

                    <div id="variants-container">
                        @foreach($product->variants as $index => $variant)
                            <div class="variant-group grid grid-cols-1 md:grid-cols-6 gap-4 items-center mb-3 p-3 bg-gray-50 rounded-lg">
                                <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                                    <input type="text" name="variants[{{ $index }}][color]" class="w-full border py-2 px-3 border-gray-300 rounded-lg" value="{{ old('variants.'.$index.'.color', $variant->color) }}" placeholder="e.g., Red">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Length (inches)</label>
                                    <input type="number" step="0.01" name="variants[{{ $index }}][length_in_inches]" class="w-full border py-2 px-3 border-gray-300 rounded-lg" value="{{ old('variants.'.$index.'.length_in_inches', $variant->length_in_inches) }}" placeholder="e.g., 10.5">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Price Modifier (USD)</label>
                                    <input type="number" step="0.01" name="variants[{{ $index }}][price_usd_modifier]" class="w-full border py-2 px-3 border-gray-300 rounded-lg" value="{{ old('variants.'.$index.'.price_usd_modifier', $variant->price_usd_modifier) }}" placeholder="e.g., 5.00">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Price Modifier (NGN)</label>
                                    <input type="number" step="0.01" name="variants[{{ $index }}][price_ngn_modifier]" class="w-full border py-2 px-3 border-gray-300 rounded-lg" value="{{ old('variants.'.$index.'.price_ngn_modifier', $variant->price_ngn_modifier) }}" placeholder="e.g., 2500.00">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                                    <input type="number" name="variants[{{ $index }}][stock]" class="w-full border py-2 px-3 border-gray-300 rounded-lg" value="{{ old('variants.'.$index.'.stock', $variant->stock) }}" placeholder="e.g., 100">
                                </div>
                                <div class="pt-5">
                                    <button type="button" class="remove-variant-btn text-red-500 hover:text-red-700 font-medium">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="add-variant-btn" class="mt-2 inline-flex items-center px-3 py-2 border border-dashed border-gray-400 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Add New Variant
                    </button>
                </div>

                <!-- Add New Images Section (Inside main form) -->
                <div class="pb-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-yellow-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Add New Images
                    </h3>

                    <div
                        class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-gray-400 transition-colors duration-200">
                        <div class="mt-2">
                            <label for="images" class="cursor-pointer">
                                <span class="block text-sm font-medium text-gray-900">Add more images</span>
                                <span class="block text-xs text-gray-500">PNG, JPG, GIF up to 2MB each</span>
                            </label>
                            <input id="images" type="file" name="images[]" multiple class="sr-only"
                                accept="image/*">
                        </div>
                    </div>
                    @error("images.*")
                        <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route("admin.products.index") }}"
                        class="inline-flex items-center px-4 py-2 border-2 border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border-2 border-blue-600 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 hover:border-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Update Product
                    </button>
                </div>
            </form>
        </div>

        <!-- Current Images Section (Outside main form) -->
        <div class="bg-white shadow-lg rounded-xl p-4 lg:p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-yellow-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                Current Images
            </h3>

            <!-- Current Images -->
            <div class="mb-4">
                @if ($product->images->count() > 0)
                    <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-2">
                        @foreach ($product->images as $image)
                            <div class="relative group existing-image">
                                <img src="{{ asset("storage/" . $image->image) }}"
                                    class="w-full h-12 object-cover rounded border border-gray-200"
                                    alt="Product Image">
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded flex items-center justify-center">
                                    <form action="/admin/products/{{ $product->id }}/images/{{ $image->id }}"
                                        method="POST" class="inline delete-image-form" data-debug-url="/admin/products/{{ $product->id }}/images/{{ $image->id }}">
                                        @csrf
                                        @method("DELETE")
                                        <button type="button"
                                            class="bg-red-600 text-white rounded-full p-1 hover:bg-red-700 transition-colors duration-200 border border-white open-delete-modal"
                                            data-image-id="{{ $image->id }}" data-product-id="{{ $product->id }}">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex justify-start items-center gap-2">
                        <div
                            class="w-12 h-12 flex items-center justify-center border-2 border-dashed border-gray-300 rounded">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <span class="text-sm text-gray-500">No product images uploaded yet</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal for delete confirmation --}}
    <div id="deleteImageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-20 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
            <h2 class="text-lg font-semibold mb-4">Delete Image</h2>
            <p class="mb-6">Are you sure you want to delete this image? This action cannot be undone.</p>
            <div class="flex justify-end gap-3">
                <button id="cancelDeleteImage" type="button" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancel</button>
                <button id="confirmDeleteImage" type="button" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Delete</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Logic for handling image deletion confirmation modal
        const deleteModal = document.getElementById('deleteImageModal');
        if (deleteModal) {
            const confirmDeleteBtn = document.getElementById('confirmDeleteImage');
            const cancelDeleteBtn = document.getElementById('cancelDeleteImage');
            let formToSubmit;

            document.querySelectorAll('.open-delete-modal').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    formToSubmit = e.target.closest('form');
                    deleteModal.classList.remove('hidden');
                });
            });

            cancelDeleteBtn.addEventListener('click', () => {
                deleteModal.classList.add('hidden');
            });

            confirmDeleteBtn.addEventListener('click', () => {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
            });
        }

        // Logic for image upload preview
        const imageInput = document.getElementById('images');
        const imagePreviewContainer = document.querySelector('.image-preview-container');
        if (imageInput && imagePreviewContainer) {
            imageInput.addEventListener('change', function(e) {
                const files = e.target.files;

                // Clear existing previews in the specific container
                const existingPreviews = imagePreviewContainer.querySelectorAll('.image-preview');
                existingPreviews.forEach(p => p.remove());

                if (files.length > 0) {
                    const previewGrid = document.createElement('div');
                    previewGrid.className = 'image-preview mt-4 grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-2';

                    Array.from(files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const imgWrapper = document.createElement('div');
                            imgWrapper.className = 'relative';
                            const img = document.createElement('img');
                            img.src = event.target.result;
                            img.className = 'w-full h-16 object-cover rounded border border-gray-200';
                            imgWrapper.appendChild(img);
                            previewGrid.appendChild(imgWrapper);
                        };
                        reader.readAsDataURL(file);
                    });
                    imagePreviewContainer.appendChild(previewGrid);
                }
            });
        }

        // Logic for Product Variants
        const variantsContainer = document.getElementById('variants-container');
        if (variantsContainer) {
            let variantIndex = {{ $product->variants->count() }};

            document.getElementById('add-variant-btn').addEventListener('click', function () {
                const newVariantForm = `
                    <div class="variant-group grid grid-cols-1 md:grid-cols-6 gap-4 items-center mb-3 p-3 bg-gray-50 rounded-lg">
                        <input type="hidden" name="variants[${variantIndex}][id]" value="">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                            <input type="text" name="variants[${variantIndex}][color]" class="w-full border py-2 px-3 border-gray-300 rounded-lg" placeholder="e.g., Red">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Length (inches)</label>
                            <input type="number" step="0.01" name="variants[${variantIndex}][length_in_inches]" class="w-full border py-2 px-3 border-gray-300 rounded-lg" placeholder="e.g., 10.5">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price Modifier (USD)</label>
                            <input type="number" step="0.01" name="variants[${variantIndex}][price_usd_modifier]" class="w-full border py-2 px-3 border-gray-300 rounded-lg" placeholder="e.g., 5.00">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price Modifier (NGN)</label>
                            <input type="number" step="0.01" name="variants[${variantIndex}][price_ngn_modifier]" class="w-full border py-2 px-3 border-gray-300 rounded-lg" placeholder="e.g., 2500.00">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                            <input type="number" name="variants[${variantIndex}][stock]" class="w-full border py-2 px-3 border-gray-300 rounded-lg" placeholder="e.g., 100">
                        </div>
                        <div class="pt-5">
                            <button type="button" class="remove-variant-btn text-red-500 hover:text-red-700 font-medium">Remove</button>
                        </div>
                    </div>
                `;
                variantsContainer.insertAdjacentHTML('beforeend', newVariantForm);
                variantIndex++;
            });

            variantsContainer.addEventListener('click', function (e) {
                if (e.target && e.target.classList.contains('remove-variant-btn')) {
                    e.target.closest('.variant-group').remove();
                }
            });
        }
    });
</script>
@endpush
