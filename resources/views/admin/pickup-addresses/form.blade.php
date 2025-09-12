@if(isset($pickupAddress) && $pickupAddress->exists)
    @php $isEdit = true; @endphp
    @php $action = route('admin.pickup-addresses.update', $pickupAddress); @endphp
    @php $method = 'PUT'; @endphp
@else
    @php $isEdit = false; @endphp
    @php $action = route('admin.pickup-addresses.store'); @endphp
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
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-green-500 focus:outline-none focus:ring-green-500 sm:text-sm">
                    <option value="">Select a country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->name }}" {{ old('country', $pickupAddress->country ?? '') == $country->name ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
                @error('country')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- State -->
            <div class="md:col-span-1">
                <label for="state" class="block text-sm font-medium text-gray-700">State/Region</label>
                <input type="text" name="state" id="state" 
                       value="{{ old('state', $pickupAddress->state ?? '') }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                       placeholder="Enter state or region">
                @error('state')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div class="md:col-span-3">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" id="address" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">{{ old('address', $pickupAddress->address ?? '') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.pickup-addresses.index') }}"
               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Cancel
            </a>
            <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                {{ $isEdit ? 'Update' : 'Create' }} Address
            </button>
        </div>
    </div>
</form>
