


@extends('layouts.admin-layout')

@section('title', 'View Review')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Review Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $review->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Product</th>
                                        <td>
                                            <a href="{{ route('admin.products.edit', $review->product->id) }}">{{ $review->product->name }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>User</th>
                                        <td>{{ $review->user->name }} ({{ $review->user->email }})</td>
                                    </tr>
                                    <tr>
                                        <th>Rating</th>
                                        <td>
                                            <div class="d-flex">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star text-warning"></i>
                                                @endfor
                                                <span class="ml-2">({{ $review->rating }} out of 5)</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Review</th>
                                        <td>{{ $review->review }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date Posted</th>
                                        <td>{{ $review->created_at->format('d M, Y H:i A') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Back to List</a>
                    <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this review?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
