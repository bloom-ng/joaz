<!-- Cart Section (inner content only) -->
<div>
    <div class="flex flex-row font-rustler text-4xl items-center justify-center py-12">MY CART</div>

    @if(isset($cart) && (count($cart->items) > 0 || (is_array($cart->items) && count($cart->items) > 0)))
    <div class="flex flex-row items-stretch gap-4 px-16 rounded-2xl">
      <div class="flex flex-col border border-[1px] border-[#21212199]/30 font-bricolage w-[70%] rounded-2xl">
        <table class="table-auto w-full">
          <thead class="w-full border-b-[1px] border-[#212121]/20">
            <tr>
              <th class="text-left px-6 py-4">Product Name</th>
              <th class="text-left px-6 py-4">Quantity</th>
              <th class="text-left px-6 py-4">Total</th>
              <th class="text-left px-6 py-4">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($cart->items as $item)
            @php

                $product = is_array($item) ? (object)$item['product'] : $item->product;
                $quantity = is_array($item) ? $item['quantity'] : $item->quantity;
                $itemTotal = is_array($item) ? $item['total'] : $item->unit_price;
                $itemId = is_array($item) ? $item['id'] : $item->id;
                $images = $product->images;
                $image = $images->isNotEmpty() ? asset('storage/' . $images->first()->image) : asset('images/product-placeholder.png');
            @endphp
            <tr class="border-b-[1px] border-[#212121]/20 last:border-b-0">
              <td class="px-6 py-4 align-middle">
                <div class="flex flex-row gap-3 items-center">
                  <img class="w-[120px] h-[132px] object-cover rounded-xl" src="{{ $image }}" alt="{{ $product->name }}">
                  <div class="flex flex-col gap-1">
                    <h1 class="font-semibold">{{ $product->name }}</h1>
                    @if(isset($product->description))
                    <p>{{ $product->description }}</p>
                    @endif
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 align-middle">
                <div class="flex flex-row items-center justify-center">
                  <div class="flex items-center" id="quantity-controls-{{ $itemId }}">
                    <button type="button" onclick="window.updateQuantity(event, 'decrease', '{{ route('cart.update', $itemId) }}', '{{ csrf_token() }}')" class="w-6 h-6 bg-[#E7E4E1] text-[#212121] rounded-sm flex items-center justify-center font-bold text-xl">-</button>
                    <span class="w-6 h-6 text-[#FCFCFC] flex items-center justify-center bg-[#85BB3F] text-center font-semibold">{{ $quantity }}</span>
                    <button type="button" onclick="window.updateQuantity(event, 'increase', '{{ route('cart.update', $itemId) }}', '{{ csrf_token() }}')" class="w-6 h-6 bg-[#E7E4E1] text-[#212121] rounded-sm flex items-center justify-center font-bold text-xl">+</button>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 align-middle whitespace-nowrap">
                <span class="flex flex-row gap-1 items-center">
                  <img class="w-4 h-4" src="{{ asset('images/naira.png') }}" alt="Naira">
                  <p>{{ number_format($itemTotal, 2) }}</p>
                </span>
              </td>
              <td class="px-6 py-4 align-middle">
                <form action="{{ route('cart.remove', $itemId) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit">
                    <img class="w-4 h-4" src="{{ asset('images/trash.png') }}" alt="Remove">
                  </button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="flex flex-col h-full border border-[1px] border-[#21212199]/30 font-bricolage w-[30%] rounded-2xl">
        <div class="font-semibold flex flex-row items-start pt-4 pb-4 items-center px-4 border-b-[1px] border-[#212121]/20 justify-start">Cart Summary</div>
        <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
          <p class="font-semibold">Total Items</p>
          <p data-total-items>{{ is_array($cart->items) ? array_sum(array_column($cart->items, 'quantity')) : $cart->items->sum('quantity') }}</p>
        </div>
        <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
          <p class="font-semibold">Price</p>
          <p data-cart-subtotal>₦ {{ number_format($cart->total, 2) }}</p>
        </div>
        <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
          <p class="font-semibold">Delivery</p>
          <p> Not Included</p>
        </div>
        <div class="flex flex-row justify-between py-4 px-4 items-center">
          <p class="text-sm">*Please confirm your order to add your delivery/pickup details.</p>
        </div>
        <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
          <p class="font-semibold">Total</p>
          <p class="font-semibold" data-cart-total>₦ {{ number_format($cart->total, 2) }}</p>
        </div>
        <div class="flex flex-col gap-4 p-4">
          <a href="" class="w-full bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)] text-white font-semibold py-2 px-4 rounded-lg text-center">CONFIRM ORDER</a>
        </div>
      </div>
    </div>

    <div class="flex flex-row justify-start px-16 pb-10 pt-10 items-center gap-2">
      <a href="{{ route('shop.category') }}">
        <h1 class="text-xl font-semibold font-bricolage border-b-[1px] border-[#212121]">CONTINUE SHOPPING</h1>
      </a>
      <img src="{{ asset('images/back-arrow.png') }}" alt="">
    </div>
    @else
    <div class="text-center py-12">
      <p class="text-lg mb-4">Your cart is empty</p>
      <a href="{{ route('shop.category') }}">
        <h1 class="text-xl font-semibold font-bricolage border-b-[1px] border-[#212121]">CONTINUE SHOPPING</h1>
      </a>
    </div>
    @endif
</div>

<script>
// Make the function globally available
window.updateQuantity = async function(event, action, url, csrfToken) {
    // Prevent default form submission if any
    if (event && event.preventDefault) {
        event.preventDefault();
    }
    
    // Get the button that was clicked
    const button = event.target;
    
    // Find the quantity container and elements
    const container = button.closest('div.flex.items-center');
    if (!container) {
        console.error('Could not find quantity container');
        return;
    }
    
    // Find the quantity display span (has the quantity number)
    const quantitySpan = container.querySelector('span:not(button span)');
    if (!quantitySpan) {
        console.error('Could not find quantity span');
        return;
    }
    
    // Get current quantity
    let currentQuantity = parseInt(quantitySpan.textContent.trim()) || 1;
    
    // Find the row containing this item
    const itemRow = button.closest('tr');
    
    // Calculate new quantity based on action
    let newQuantity = currentQuantity;
    if (action === 'increase') {
        newQuantity = currentQuantity + 1;
    } else if (action === 'decrease' && currentQuantity > 1) {
        newQuantity = currentQuantity - 1;
    } else {
        return; // Don't update if quantity would be less than 1
    }
    
    // Disable buttons during update
    const buttons = container.querySelectorAll('button');
    buttons.forEach(btn => {
        btn.disabled = true;
    });
    
    // Update the UI immediately for better UX
    quantitySpan.textContent = newQuantity;
    
    try {
        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('_method', 'PATCH');
        formData.append('action', action);
        formData.append('quantity', newQuantity);
        
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData
        });
        
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        
        const data = await response.json();
        
        if (data.success) {
            // Update the item total
            const itemTotalElement = itemRow.querySelector('td:nth-child(3) p');
            if (itemTotalElement) {
                itemTotalElement.textContent = '₦ ' + data.itemTotal;
            }
            
            // Update the cart totals
            document.querySelectorAll('[data-cart-subtotal]').forEach(el => {
                el.textContent = '₦ ' + data.cartTotal;
            });
            
            document.querySelectorAll('[data-cart-total]').forEach(el => {
                el.textContent = '₦ ' + data.cartTotal;
            });
            
            // Update the total items count
            const totalItemsElement = document.querySelector('[data-total-items]');
            if (totalItemsElement) {
                totalItemsElement.textContent = data.totalItems || newQuantity;
            }
        } else {
            // Revert the quantity if there was an error
            quantitySpan.textContent = currentQuantity;
            alert(data.error || 'Failed to update cart');
        }
    } catch (error) {
        console.error('Error:', error);
        // Revert the quantity on error
        quantitySpan.textContent = currentQuantity;
        alert('An error occurred while updating the cart');
    } finally {
        // Re-enable buttons
        buttons.forEach(btn => {
            btn.disabled = false;
        });
    }
}
</script>
