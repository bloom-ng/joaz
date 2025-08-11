@extends('layouts.admin-layout')

@section('title', 'Edit Review')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Review for {{ $review->product->name }}</h3>
                </div>
                <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="user">User</label>
                            <input type="text" class="form-control" id="user" value="{{ $review->user->name }}" disabled>
                        </div>

                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <select class="form-control" id="rating" name="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>
                                        {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="review">Review</label>
                            <textarea class="form-control" id="review" name="review" rows="5">{{ old('review', $review->review) }}</textarea>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Review</button>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
