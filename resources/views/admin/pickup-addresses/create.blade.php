@extends('layouts.admin-layout')

@section('content')
<div class="w-full">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Add New Pickup Address</h2>
        <a href="{{ route('admin.pickup-addresses.index') }}" 
           class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
            Back to List
        </a>
    </div>

    @include('admin.pickup-addresses.form')
</div>
@endsection
