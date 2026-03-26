@extends('dashboard.admin')

@section('content')
<div class="container-fluid">
    <h2>Edit Feedback</h2>

    <div class="card p-4">
        <form action="{{ route('feedbacks.update', $feedback->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <input type="number" name="rating" min="1" max="5" value="{{ $feedback->rating }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea name="comment" class="form-control" rows="4" required>{{ $feedback->comment }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('feedbacks.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection