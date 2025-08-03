@extends("layouts.admin-layout")

@section("content")
    <div class="w-full">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Products</h1>
            <a href="{{ route("admin.products.create") }}"
                class="inline-flex items-center px-4 py-2 border-2 border-blue-600 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 hover:border-blue-700 hover:scale-105 transition-all duration-200">
                <i class="fas fa-plus mr-2"></i>
                Add Product
            </a>
        </div>

        <!-- Search Form -->
        <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
            <form method="GET" action="{{ route('admin.products.index') }}" class="flex items-center gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Products</label>
                    <input type="text"
                           id="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search by name, price (USD/NGN), or category..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>
                <div class="flex gap-2 mt-6">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.products.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white shadow-lg rounded-xl p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Image
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">USD
                                Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NGN
                                Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sale
                                Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                    <div class="flex flex-wrap items-center gap-1">
                                        <a href="{{ route("admin.products.show", $product) }}"
                                            class="inline-flex items-center justify-center w-6 h-6 hover:scale-110 transition-all duration-200"
                                            title="View Product Details">
                                            <i class="fas fa-eye text-[#222222]"></i>
                                        </a>
                                        <a href="{{ route("admin.products.edit", $product) }}"
                                            class="inline-flex items-center justify-center w-6 h-6 hover:scale-110 transition-all duration-200"
                                            title="Edit Product">
                                            <i class="fas fa-edit text-green-800"></i>
                                        </a>
                                        <form action="{{ route("admin.products.destroy", $product) }}" method="POST"
                                            class="inline-block m-0 p-0 delete-product-form">
                                            @csrf
                                            @method("DELETE")
                                            <button type="button"
                                                class="inline-flex items-center justify-center w-6 h-6 cursor-pointer hover:scale-110 transition-all duration-200 open-delete-product-modal"
                                                title="Delete Product" data-product-name="{{ $product->name }}">
                                                <i class="fas fa-trash text-[#B22234]"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $product->name }}</td>
                                                                                                <td class="px-4 py-3 whitespace-nowrap w-16">
                                    @if ($product->images->count() > 0)
                                                                                <img src="{{ asset('storage/' . $product->images->first()->image) }}"
                                             alt="{{ $product->name }}"
                                             class="w-8 h-8 object-cover rounded border border-gray-200">
                                    @else
                                        <div class="w-8 h-8 bg-gray-100 rounded border border-gray-200 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-xs"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($product->price_usd, 2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    ₦{{ number_format($product->price_ngn, 2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    @if ($product->sale_price)
                                        ₦{{ number_format($product->sale_price, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $product->quantity }}</td>

                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    {{ $product->category?->name }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Product Modal -->
    </div>
    <div id="deleteProductModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-20 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
            <h2 class="text-lg font-semibold mb-4">Delete Product</h2>
            <p class="mb-6">Are you sure you want to delete this product? This action cannot be undone.</p>
            <div class="flex justify-end gap-3">
                <button id="cancelDeleteProduct" type="button" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancel</button>
                <button id="confirmDeleteProduct" type="button" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Delete</button>
            </div>
        </div>
    </div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script loaded, looking for delete buttons...');

    let formToDelete = null;
    let productNameToDelete = '';

    const deleteButtons = document.querySelectorAll('.open-delete-product-modal');
    console.log('Found delete buttons:', deleteButtons.length);

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            console.log('Delete button clicked!');
            e.preventDefault();
            formToDelete = this.closest('form');
            productNameToDelete = this.dataset.productName;

            // Update modal content with product name
            const modalTitle = document.querySelector('#deleteProductModal h3');
            if (modalTitle) {
                modalTitle.textContent = `Are you sure you want to delete "${productNameToDelete}"?`;
            }

            const modal = document.getElementById('deleteProductModal');
            if (modal) {
                modal.classList.remove('hidden');
                console.log('Modal should be visible now');
            } else {
                console.log('Modal not found!');
            }
        });
    });

    // Handle modal close (Cancel) button
    document.getElementById('cancelDeleteProduct').addEventListener('click', function() {
        document.getElementById('deleteProductModal').classList.add('hidden');
        formToDelete = null;
        productNameToDelete = '';
    });
    // Handle "Yes, I'm sure" (Delete) button
    document.getElementById('confirmDeleteProduct').addEventListener('click', function() {
        if (formToDelete) {
            formToDelete.submit();
            document.getElementById('deleteProductModal').classList.add('hidden');
            formToDelete = null;
            productNameToDelete = '';
        }
    });

    // Close modal when clicking outside
    const modal = document.getElementById('deleteProductModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                formToDelete = null;
                productNameToDelete = '';
            }
        });
    }
});
</script>
@endsection
