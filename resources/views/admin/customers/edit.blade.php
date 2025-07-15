@extends('layouts.admin-layout')

@section('content')
<div class="w-full">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Customer</h1>
    <form action="{{ route('admin.customers.update', $customer) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-lg rounded-xl p-6">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('name')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('email')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $customer->phone ?? '') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('phone')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div class="mb-4">
            <label for="avatar" class="block text-gray-700 font-semibold mb-2">Avatar</label>
            @if($customer->profile && $customer->profile->avatar)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $customer->profile->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border">
                </div>
            @endif
            <input type="file" name="avatar" id="avatar" accept="image/*" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('avatar')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div class="mb-4">
            <label for="gender" class="block text-gray-700 font-semibold mb-2">Gender</label>
            <select name="gender" id="gender" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="" disabled selected>Select gender</option>
                <option value="male" {{ old('gender', $customer->profile->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $customer->profile->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender', $customer->profile->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div class="mb-4">
            <label for="date_of_birth" class="block text-gray-700 font-semibold mb-2">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', isset($customer->profile->date_of_birth) ? $customer->profile->date_of_birth->format('Y-m-d') : '') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('date_of_birth')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div class="mb-4">
            <label for="bio" class="block text-gray-700 font-semibold mb-2">Bio</label>
            <textarea name="bio" id="bio" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('bio', $customer->profile->bio ?? '') }}</textarea>
            @error('bio')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div class="mb-4">
            <label for="social_links" class="block text-gray-700 font-semibold mb-2">Social Links (comma separated)</label>
            <input type="text" name="social_links" id="social_links" value="{{ old('social_links', isset($customer->profile->social_links) ? implode(',', $customer->profile->social_links) : '') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('social_links')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection
