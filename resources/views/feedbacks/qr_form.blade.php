@extends('dashboard.admin')

@section('content')
<div class="container mt-4">
    <h3>Customer Feedback for Interaction #{{ $interaction->id }}</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('feedback.customer.store', $interaction->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-5)</label>
            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Comments (optional)</label>
            <textarea class="form-control" id="comment" name="comment" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Feedback</button>
    </form>
</div>
@endsection