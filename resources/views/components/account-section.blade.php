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
        <form method="POST" action="{{ route('user-logout') }}" class="w-full">
            @csrf
            <button type="submit" class="text-[#E53935] font-bold cursor-pointer w-full text-left">Logout</button>
        </form>
      </div>

    </div>
  </div>
</div>
