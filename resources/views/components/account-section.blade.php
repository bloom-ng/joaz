<!-- Account Section (inner content only) -->
@php
    $user = auth()->user();
    $profile = $user->profile;
@endphp

<div x-data="{
    editing: false,
    phone: '{{ $user->phone ?? '' }}',
    gender: '{{ $profile->gender ?? '' }}',

    toggleEdit() {
        this.editing = !this.editing;
        // Reset form values when canceling edit
        if (!this.editing) {
            this.phone = '{{ $user->phone ?? '' }}';
            this.gender = '{{ $profile->gender ?? '' }}';
        }
    },

    async saveChanges() {
        try {
            const response = await fetch('{{ route('profile.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    phone: this.phone,
                    gender: this.gender
                })
            });

            if (response.ok) {
                window.location.reload();
            } else {
                const data = await response.json();
                alert(data.message || 'Failed to update profile');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while updating your profile');
        }
    }
}">
  <div class="flex flex-row font-rustler text-4xl items-center justify-center py-12">PROFILE DETAILS</div>

  <div class="flex justify-center pb-36 px-16">
    <div class="flex flex-col border border-[1px] border-[#21212199]/30 font-bricolage w-full lg:w-3/5 rounded-2xl px-5 pt-6 pb-9 gap-6">
      <!-- My Profile Section -->
      <div class="flex justify-between items-center pb-4">
        <h2 class="font-bold text-xl">My profile</h2>
        <div>
            <template x-if="!editing">
                <button @click="toggleEdit()" class="font-semibold text-xl font-bricolage border-b-[1px] border-[#212121]">
                    EDIT
                </button>
            </template>
            <template x-if="editing">
                <div class="flex gap-4">
                    <button @click="toggleEdit()" class="font-semibold text-xl font-bricolage text-gray-600">
                        CANCEL
                    </button>
                    <button @click="saveChanges()" class="font-semibold text-xl font-bricolage border-b-[1px] border-[#212121]">
                        SAVE
                    </button>
                </div>
            </template>
        </div>
      </div>

      <!-- Name -->
      <div class="flex justify-between items-center">
        <span class="text-[#212121] font-bold">Name</span>
        <span class="">{{ $user->name ?? 'Not set' }}</span>
      </div>
      <hr class="border-[0.5px] border-[#212121]/20 -mt-2 -mx-5">

      <!-- Email Address -->
      <div class="flex justify-between items-center">
        <span class="text-[#212121] font-bold">Email address</span>
        <span class="">{{ $user->email ?? 'Not set' }}</span>
      </div>
      <hr class="border-[0.5px] border-[#212121]/20 -mt-2 -mx-5">

      <!-- Phone Number -->
      <div class="flex justify-between items-center">
        <span class="text-[#212121] font-bold">Phone number</span>
        <template x-if="!editing">
            <span x-text="phone || 'Not set'"></span>
        </template>
        <template x-if="editing">
            <input type="tel" x-model="phone" class="border-b border-gray-400 focus:outline-none focus:border-black text-right">
        </template>
      </div>
      <hr class="border-[0.5px] border-[#212121]/20 -mt-2 -mx-5">

      <!-- Gender -->
      <div class="flex justify-between items-center">
        <span class="text-[#212121] font-bold">Gender</span>
        <template x-if="!editing">
            <span x-text="gender ? gender.charAt(0).toUpperCase() + gender.slice(1) : 'Not set'"></span>
        </template>
        <template x-if="editing">
            <select x-model="gender" class="border-b border-gray-400 focus:outline-none focus:border-black text-right bg-transparent">
                <option value="">Select gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </template>
      </div>
      <hr class="border-[0.5px] border-[#212121]/20 -mt-2 -mx-5">
      <div class="flex justify-between items-center">
        <form method="POST" action="{{ route('user-logout') }}" class="flex items-center gap-2 w-full">
            @csrf
            <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M14.8308 14.9008L18.2526 10.9083C18.416 10.7219 18.4996 10.4866 18.4998 10.25C18.4998 10.0882 18.4608 9.92571 18.3816 9.77797C18.3464 9.71213 18.3033 9.64958 18.2526 9.59173L14.8308 5.59921C14.4714 5.17986 13.8401 5.13127 13.4208 5.49066C13.0015 5.85006 12.9529 6.48136 13.3123 6.90071L15.3257 9.24995L7.58103 9.24995C7.02875 9.24995 6.58103 9.69767 6.58103 10.25C6.58103 10.8022 7.02875 11.25 7.58103 11.25L15.3258 11.25L13.3123 13.5993C12.9529 14.0187 13.0015 14.65 13.4208 15.0094C13.8401 15.3688 14.4714 15.3202 14.8308 14.9008ZM8.49976 4.24994C9.05204 4.24994 9.49976 4.69765 9.49976 5.24994L9.49976 6.74994C9.49976 7.30222 9.94747 7.74994 10.4998 7.74994C11.052 7.74994 11.4998 7.30222 11.4998 6.74994L11.4998 5.24994C11.4998 3.59308 10.1566 2.24994 8.49976 2.24994L5.49976 2.24994C3.8429 2.24994 2.49976 3.59308 2.49976 5.24994L2.49976 15.2499C2.49976 16.9068 3.8429 18.2499 5.49976 18.2499L8.49976 18.2499C10.1566 18.2499 11.4998 16.9068 11.4998 15.2499L11.4998 13.7499C11.4998 13.1977 11.052 12.7499 10.4998 12.7499C9.94747 12.7499 9.49976 13.1977 9.49976 13.7499L9.49976 15.2499C9.49976 15.8022 9.05204 16.2499 8.49976 16.2499L5.49976 16.2499C4.94747 16.2499 4.49976 15.8022 4.49976 15.2499L4.49976 5.24994C4.49976 4.69765 4.94747 4.24994 5.49976 4.24994Z"
                    fill="#B22234" />
            </svg>
            <button type="submit" class="text-[#B22234] font-bold cursor-pointer text-left">
                Logout
            </button>
        </form>
    </div>


    </div>
  </div>
</div>
