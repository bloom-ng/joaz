@if(isset($deliveryFee) && $deliveryFee->exists)
    @php $isEdit = true; @endphp
    @php $action = route('admin.delivery-fees.update', $deliveryFee); @endphp
    @php $method = 'PUT'; @endphp
@else
    @php $isEdit = false; @endphp
    @php $action = route('admin.delivery-fees.store'); @endphp
    @php $method = 'POST'; @endphp
@endif

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @method($method)

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Country -->
            <div class="md:col-span-1">
                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                <select name="country" id="country"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-green-500 focus:outline-none focus:ring-green-500 sm:text-sm"
                        {{ $isEdit ? 'disabled' : 'required' }}>
                    <option value="">Select a country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->name }}" {{ old('country', $deliveryFee->country ?? '') == $country->name ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
                @error('country')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Amount -->
            <div class="md:col-span-1">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm"></span>
                    </div>
                    <input type="number" name="amount" id="amount"
                           step="0.01" min="0" max="999999.99"
                           value="{{ old('amount', $deliveryFee->amount ?? '') }}"
                           class="focus:ring-green-500 focus:border-green-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                           placeholder="0.00" required>
                </div>
                @error('amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.delivery-fees.index') }}"
               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Cancel
            </a>
            <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#85BB3F] hover:bg-[#6e9e33] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                {{ $isEdit ? 'Update' : 'Create' }} Fee
            </button>
        </div>
    </div>
</form>

@if($isEdit)
<script>
    // Enable the disabled select when the form is submitted
    document.querySelector('form').addEventListener('submit', function() {
        document.getElementById('country').disabled = false;
    });
</script>
@endif
