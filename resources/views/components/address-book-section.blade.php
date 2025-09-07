@php
    $user = auth()->user();
    $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();
    $defaultAddress = $addresses->firstWhere('is_default', true);
    $otherAddress = $addresses->where('is_default', false)->first();
@endphp

<!-- Address Book Section (inner content only) -->
<div>
    <div class="flex flex-row font-rustler text-4xl items-center justify-center py-12">ADDRESS DETAILS</div>
    <div class="flex flex-row justify-center gap-8 pb-40 px-16">
        <!-- Address Card 1 (Default Address) -->
        <form method="POST" action="{{ route("profile.update-address") }}" id="address-form-1"
            class="flex flex-col border border-[1px] border-[#21212199]/30 font-bricolage w-full lg:w-1/2 rounded-2xl p-6 gap-5">
            @csrf
            <input type="hidden" name="address_id" value="{{ $defaultAddress->id ?? "" }}">
            <input type="hidden" name="is_default" value="1">

            <div class="flex justify-between items-center pb-4">
                <h2 class="font-bold text-lg">Address 1 <span class="text-base text-[#212121]">( default address
                        )</span></h2>
                <button type="button"
                    class="edit-btn font-semibold text-lg font-bricolage border-b-[1px] border-[#212121]">EDIT</button>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-[#212121] text-lg font-bold">Address Type</span>
                <span class="text-right editable" data-field="label">{{ $defaultAddress->label ?? " ----- " }}</span>
            </div>
            <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

            <div class="flex justify-between items-center">
                <span class="text-[#212121] text-lg font-bold">Address</span>
                <span class="text-right editable" data-field="address">{{ $defaultAddress->address ?? " ----- " }}</span>
            </div>
            <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

            <div class="flex justify-between items-center">
                <span class="text-[#212121] text-lg font-bold">Country</span>
                <span class="text-right editable" data-field="country">{{ $defaultAddress->country ?? " ----- " }}</span>
            </div>
            <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

            <div class="flex justify-between items-center">
                <span class="text-[#212121] font-bold">State</span>
                <span class="text-right editable" data-field="state">{{ $defaultAddress->state ?? " ----- " }}</span>
            </div>
            <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

            <div class="flex justify-between items-center">
                <span class="text-[#212121] font-bold">City</span>
                <span class="text-right editable" data-field="city">{{ $defaultAddress->city ?? " ----- " }}</span>
            </div>
            <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

            <div class="flex justify-between pb-3 items-center">
                <span class="text-[#212121] font-bold">Postal Code</span>
                <span class="text-right editable"
                    data-field="postal_code">{{ $defaultAddress->postal_code ?? " ----- " }}</span>
            </div>
        </form>

        <!-- Address Card 2 (Optional Address or Add New) -->
        <form method="POST" action="{{ route("profile.update-address") }}" id="address-form-2"
            class="flex flex-col border border-[1px] border-[#21212199]/30 font-bricolage w-full lg:w-1/2 rounded-2xl p-6 gap-5">
            @csrf
            <input type="hidden" name="address_id" value="{{ $otherAddress->id ?? "" }}">
            <input type="hidden" name="is_default" value="0">

            <div class="flex justify-between items-center pb-4">
                <h2 class="font-bold text-lg">Address 2</h2>
                <button type="button"
                    class="edit-btn font-semibold text-lg font-bricolage border-b-[1px] border-[#212121]">
                    {{ $otherAddress ? "EDIT" : "ADD" }}
                </button>
            </div>

            @if ($otherAddress)
                <div class="flex justify-between items-center">
                    <span class="text-[#212121] text-lg font-bold">Address Type</span>
                    <span class="text-right editable" data-field="label">{{ $otherAddress->label ?? " ----- " }}</span>
                </div>
                <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

                <div class="flex justify-between items-center">
                    <span class="text-[#212121] text-lg font-bold">Address</span>
                    <span class="text-right editable" data-field="address">{{ $otherAddress->address ??  " ----- " }}</span>
                </div>
                <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

                <div class="flex justify-between items-center">
                    <span class="text-[#212121] text-lg font-bold">Country</span>
                    <span class="text-right editable" data-field="country">{{ $otherAddress->country ??  " ----- " }}</span>
                </div>
                <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

                <div class="flex justify-between items-center">
                    <span class="text-[#212121] font-bold">State</span>
                    <span class="text-right editable" data-field="state">{{ $otherAddress->state ??  " ----- " }}</span>
                </div>
                <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

                <div class="flex justify-between items-center">
                    <span class="text-[#212121] font-bold">City</span>
                    <span class="text-right editable" data-field="city">{{ $otherAddress->city ??  " ----- " }}</span>
                </div>
                <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

                <div class="flex justify-between pb-3 items-center">
                    <span class="text-[#212121] font-bold">Postal Code</span>
                    <span class="text-right editable"
                        data-field="postal_code">{{ $otherAddress->postal_code ?? "" }}</span>
                </div>
            @else
                <!-- Empty state for adding new address -->
                <p class="text-gray-500 italic">No secondary address added yet.</p>
            @endif
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".edit-btn").forEach(btn => {
            let isEditing = false;
            let cancelBtn;

            btn.addEventListener("click", () => {
                const form = btn.closest("form");

                if (!isEditing) {
                    isEditing = true;
                    btn.textContent = "SAVE";

                    cancelBtn = document.createElement("button");
                    cancelBtn.textContent = "CANCEL";
                    cancelBtn.type = "button";
                    cancelBtn.className =
                        "font-semibold text-lg font-bricolage border-b-[1px] border-[#212121]";
                    btn.parentNode.appendChild(cancelBtn);

                    const editableFields = form.querySelectorAll(".editable");
                    if (editableFields.length > 0) {
                        // Turn existing spans into inputs
                        editableFields.forEach(span => {
                            const input = document.createElement("input");
                            input.type = "text";
                            input.name = span.dataset.field;
                            input.value = span.textContent.trim();
                            input.className =
                                "border-b border-gray-400 focus:outline-none focus:border-black text-right bg-transparent";
                            span.replaceWith(input);
                        });
                    } else {
                        // Empty card: create input fields for new address
                        const fields = [
                            { name: 'label', placeholder: 'Address Type' },
                            { name: 'address', placeholder: 'Address' },
                            { name: 'country', placeholder: 'Country' },
                            { name: 'state', placeholder: 'State' },
                            { name: 'city', placeholder: 'City' },
                            { name: 'postal_code', placeholder: 'Postal Code' }
                        ];
                        const container = document.createElement("div");
                        container.className = "flex flex-col gap-3";
                        fields.forEach(field => {
                            const wrapper = document.createElement("div");
                            wrapper.className = "flex justify-between items-center";
                            
                            const label = document.createElement("span");
                            label.className = "text-[#212121] text-lg font-bold";
                            label.textContent = field.placeholder;
                            
                            const input = document.createElement("input");
                            input.type = "text";
                            input.name = field.name;
                            input.placeholder = field.placeholder;
                            input.className = "border-b border-gray-400 focus:outline-none focus:border-black text-right bg-transparent";
                            
                            wrapper.appendChild(label);
                            wrapper.appendChild(input);
                            container.appendChild(wrapper);
                        });
                        form.appendChild(container);
                    }

                    cancelBtn.addEventListener("click", () => {
                        location.reload();
                    });
                } else {
                    form.submit();
                }
            });
        });
    });
</script>