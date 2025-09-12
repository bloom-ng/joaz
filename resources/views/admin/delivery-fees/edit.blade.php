@extends('layouts.admin-layout')

@section('content')
<div class="w-full">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Edit Delivery Fee</h2>
    </div>

    @include('admin.delivery-fees.form')
</div>
@endsection
