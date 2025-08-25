<!-- Cart Section (inner content only) -->
<div>
  <div class="flex flex-row font-rustler text-4xl items-center justify-center py-12">MY CART</div>

  <div class="flex flex-row items-stretch gap-4 px-16 rounded-2xl">
    @forelse($cart->items as $item)
    @php
        $total = 0;
        $product = $item->product;
        $images = $product->images ?? collect();
    @endphp
    <div class="flex flex-col border border-[1px] border-[#21212199]/30 font-bricolage w-[70%] rounded-2xl">

      <table class="table-auto">
        <thead class="w-full border-b-[1px] border-[#212121]/20">
          <tr>
            <th class="text-left px-6 py-4">Product Name</th>
            <th class="text-left px-6 py-4">Quantity</th>
            <th class="text-left px-6 py-4">Total</th>
            <th class="text-left px-6 py-4">Action</th>
          </tr>
        </thead>
        <tbody>
                <tr class="border-b-[1px] border-[#212121]/20 last:border-b-0">
                    <td class="px-6 py-4 align-middle">
                        <div class="flex flex-row gap-3 items-center">
                            @if($images->isNotEmpty())
                                <img class="w-[100px] h-[112px] object-cover rounded-xl"
                                     src="{{ asset('storage/' . $images->first()->image) }}"
                                     alt="{{ $product->name }}">
                            @else
                                <div class="w-[140px] h-[132px] bg-gray-200 rounded-xl flex items-center justify-center">
                                    <span>No Image</span>
                                </div>
                            @endif
                            <div class="flex flex-col gap-1">
                                <h1 class="font-semibold">{{ $product->name }}</h1>
                                <p>{{ $product->description ?? 'No description available' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 align-middle">
                        <div class="flex flex-row items-center justify-center gap-2">
                            <!-- Decrement -->
                            <button type="button"
                                    onclick="updateCart({{ $item->id }}, 'decrement')"
                                    class="w-6 h-6 bg-[#E7E4E1] text-[#212121] rounded-sm flex items-center justify-center font-bold text-xl">-</button>

                            <!-- Quantity display -->
                            <span id="quantity-{{ $item->id }}"
                                  class="w-6 h-6 text-[#FCFCFC] flex items-center justify-center bg-[#85BB3F] text-center font-semibold">
                                {{ $item->quantity }}
                            </span>

                            <!-- Increment -->
                            <button type="button"
                                    onclick="updateCart({{ $item->id }}, 'increment')"
                                    class="w-6 h-6 bg-[#E7E4E1] text-[#212121] rounded-sm flex items-center justify-center font-bold text-xl">+</button>
                        </div>
                    </td>
                    <td class="px-6 py-4 align-middle whitespace-nowrap">
                        <span class="flex flex-row gap-1 items-center">
                            <img class="w-4 h-4" src="/images/naira.png" alt="">
                            <p id="item-total-{{ $item->id }}">{{ number_format($product->price_ngn * $item->quantity, 2) }}</p>
                        </span>
                    </td>
                    <td class="px-6 py-4 align-middle">
                        <form action="{{ route('cart.remove', $item->id) }}#cart" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                <img class="w-4 h-4 cursor-pointer" src="/images/trash.png" alt="Remove">
                            </button>
                        </form>
                    </td>
                </tr>

        </tbody>
      </table>
    </div>
    <div class="flex flex-col h-full border border-[1px] border-[#21212199]/30 font-bricolage w-[30%] rounded-2xl">
      <div class="font-semibold flex flex-row items-start pt-7 pb-4 items-center px-4 border-b-[1px] border-[#212121]/20 justify-start">Cart Summary</div>
      <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
        <p class="font-semibold">Total Items</p>
        <p id="total-items">{{ $cart->items->sum('quantity') }}</p>
    </div>
    <div class="flex flex-row font-semibold py-4 px-4 border-b-[1px] border-[#212121]/20 justify-between items-center">
        <p>Price</p>
        <span class="flex flex-row gap-1 items-center">
            <img class="w-4 h-4" src="/images/naira.png" alt="">
            @php
                $total = $cart->items->sum(function($item) {
                    return $item->product->price_ngn * $item->quantity;
                });
            @endphp
            <p id="cart-total">{{ number_format($total, 2) }}</p>
        </span>
    </div>
      <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
        <p class="font-semibold">Delivery</p>
        <p>Not Included</p>
      </div>
      <div class="flex flex-col justify-between gap-4 p-4 pb-7 mt-auto">
        <p class="text-xs pb-8">*Please confirm your order to add your delivery/pickup details.</p>
        <div class="flex pb-5 flex-row font-bold justify-between">
          <p>Total</p>
          <span class="flex flex-row gap-1 items-center">
            <img class="w-4 h-4" src="/images/naira.png" alt="">
            <p>{{ number_format($total, 2) }}</p>
          </span>
        </div>
        <button style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                class="text-[#FCFCFC] text-sm px-10 py-5 rounded-lg">
          CONFIRM ORDER
        </button>
      </div>
    </div>
    @empty
    <div class="font-rustler text-4xl items-center justify-center py-8">
    <p class="text-center">Your cart is empty</p>
    </div>
    @endforelse
  </div>

  <div class="flex flex-row justify-start px-16 pb-10 pt-10 items-center gap-2">
    <a href="{{ route('shop.category') }}">
      <h1 class="text-xl font-semibold font-bricolage border-b-[1px] border-[#212121]">CONTINUE SHOPPING</h1>
    </a>
  </div>
</div>

<script>
    async function updateCart(cartItemId, action) {
        try {
            const response = await fetch(`/cart/${cartItemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ action })
            });

            const data = await response.json();

            if (data.success) {
                // Update quantity
                document.getElementById(`quantity-${cartItemId}`).innerText = data.quantity;

                // Update item total
                document.getElementById(`item-total-${cartItemId}`).innerText = data.itemTotal;

                // Update cart total (summary section)
                document.querySelectorAll('#cart-total').forEach(el => el.innerText = data.cartTotal);

                // Update total items count
                location.reload(); // Reload the page to update all values

            } else if (data.error) {
                alert(data.error);
            }
        } catch (err) {
            console.error(err);
            alert('Something went wrong updating the cart.');
        }
    }
    </script>

