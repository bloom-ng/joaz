<!-- Orders Section (inner content only) -->
@php
    use App\Models\Order;
    $query = Order::with(["items.product.images"])->where("user_id", auth()->id());
    if (
        request()->has("order_status") &&
        in_array(request("order_status"), ["pending", "processing", "shipped", "delivered", "cancelled"])
    ) {
        $query->where("order_status", request("order_status"));
    }
    $orders = $query->orderBy("created_at", "desc")->paginate(10);
@endphp

<div>
    <div class="flex flex-row font-rustler text-4xl items-center justify-center pt-8 pb-4">MY ORDERS</div>

    <div class="flex flex-col items-stretch gap-8 px-16 rounded-2xl">
        <div class="flex font-bricolage font-semibold text-[#212121]/60 flex-row gap-10">
            <div class="relative">
                <a href="{{ url('account-center#orders') }}"
                class="{{ !request('order_status') ? 'text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]' : 'text-[#212121]/60' }}">
                All orders
             </a>
                @if (!request("order_status"))
                    <div
                        class="absolute bottom-0 left-0 w-full h-[1.5px] bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">
                    </div>
                @endif
            </div>

            <div class="relative">
                <a href="?order_status=delivered#orders"
                    class="{{ request("order_status") === "delivered" ? "text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]" : "text-[#212121]/60" }}">Delivered</a>
                @if (request("order_status") === "delivered")
                    <div
                        class="absolute bottom-0 left-0 w-full h-[1.5px] bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">
                    </div>
                @endif
            </div>

            <div class="relative">
                <a href="?order_status=pending#orders"
                    class="{{ request("order_status") === "pending" ? "text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]" : "text-[#212121]/60" }}">Pending</a>
                @if (request("order_status") === "pending")
                    <div
                        class="absolute bottom-0 left-0 w-full h-[1.5px] bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">
                    </div>
                @endif
            </div>

            <div class="relative">
                <a href="?order_status=shipped#orders"
                    class="{{ request("order_status") === "shipped" ? "text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]" : "text-[#212121]/60" }}">Shipped</a>
                @if (request("order_status") === "shipped")
                    <div
                        class="absolute bottom-0 left-0 w-full h-[1.5px] bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">
                    </div>
                @endif
            </div>

            <div class="relative">
                <a href="?order_status=processing#orders"
                    class="{{ request("order_status") === "processing" ? "text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]" : "text-[#212121]/60" }}">Processing</a>
                @if (request("order_status") === "processing")
                    <div
                        class="absolute bottom-0 left-0 w-full h-[1.5px] bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">
                    </div>
                @endif
            </div>

            <div class="relative">
                <a href="?order_status=cancelled#orders"
                    class="{{ request("order_status") === "cancelled" ? "text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]" : "text-[#212121]/60" }}">Cancelled</a>
                @if (request("order_status") === "cancelled")
                    <div
                        class="absolute bottom-0 left-0 w-full h-[1.5px] bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">
                    </div>
                @endif
            </div>
        </div>

        <div class="border border-[1px] border-[#21212199]/30 font-bricolage w-full rounded-2xl overflow-hidden">
            <div class="overflow-y-auto max-h-[574px] custom-scrollbar">
                <table class="table-auto w-full">
                    <thead class="sticky top-0 bg-[#FCFCFC] z-10 w-full border-b-[1px] border-[#212121]/20">
                        <tr>
                            <th class="text-left px-6 py-4">#</th>
                            <th class="text-left px-6 py-4">Product Name</th>
                            <th class="text-left px-6 py-4">Quantity</th>
                            <th class="text-left px-6 py-4">Total</th>
                            <th class="text-left px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#FFFFFF]">
                        @forelse ($orders as $order)
                            @php
                                $firstItem = $order->items->first();
                                $product = $firstItem?->product;
                                $image = $product?->images->first()->image ?? null;
                            @endphp

                            <tr class="border-b-[1px] border-[#212121]/20 last:border-b-0">
                                <td class="px-6 py-4 align-middle">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex flex-row gap-3 items-center">
                                        @if ($image)
                                            <img class="w-[120px] h-[132px] object-cover rounded-xl"
                                                src="{{ asset("storage/" . $image) }}" alt="{{ $product?->name }}">
                                        @else
                                            <div
                                                class="w-[120px] h-[132px] bg-gray-200 rounded-xl flex items-center justify-center">
                                                <span class="text-sm">No Image</span>
                                            </div>
                                        @endif
                                        <div class="flex flex-col gap-1">
                                            <h1 class="font-semibold">{{ $product?->name }}</h1>
                                            <p>{{ $product?->description }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-middle">{{ $order->items->sum("quantity") }}</td>
                                <td class="px-6 py-4 align-middle whitespace-nowrap">
                                    <span class="flex flex-row gap-1 items-center">
                                        <img class="w-4 h-4" src="/images/naira.png" alt="">
                                        <p>{{ number_format($order->total_amount, 2) }}</p>
                                    </span>
                                </td>
                                <td class="px-6 py-4 align-middle">
                                    @php
                                        $statusClass = match ($order->order_status) {
                                            "delivered" => "bg-green-100 text-green-800",
                                            "pending" => "bg-yellow-100 text-yellow-800",
                                            "cancelled" => "bg-red-100 text-red-800",
                                            "processing" => "bg-blue-100 text-blue-800",
                                            "shipped" => "bg-purple-100 text-purple-800",
                                        };
                                    @endphp

                                    <p class="w-full text-sm text-center rounded-3xl px-5 py-2 {{ $statusClass }}">
                                        {{ ucfirst($order->order_status) }}
                                    </p>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-500">No orders found.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <!-- Pagination inside the card -->

        </div>
    </div>
</div>
