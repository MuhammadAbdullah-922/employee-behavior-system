@extends('dashboard.admin')

@section('content')
<h3>All Feedbacks</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Employee</th>
            <th>Interaction ID</th>
            <th>Rating</th>
            <th>Comments</th>
            <th>Submitted At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($feedbacks as $fb)
            <tr>
                <td>{{ $fb->id }}</td>
                <td>{{ $fb->employee->name ?? 'N/A' }}</td>
                <td>{{ $fb->interaction_id }}</td>
                <td>{{ $fb->customer_rating }}</td>
                <td>{{ $fb->comments }}</td>
                <td>{{ $fb->created_at->format('d-m-Y H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection