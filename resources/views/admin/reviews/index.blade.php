@extends("layouts.admin-layout")

@section("content")

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Reviews</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>User</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reviews as $review)
                                <tr>
                                    <td>{{ $review->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.products.edit', $review->product->id) }}">
                                            {{ $review->product->name }}
                                        </a>
                                    </td>
                                    <td>{{ $review->user->name }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star text-warning"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($review->review, 50) }}</td>
                                    <td>{{ $review->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No reviews found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
