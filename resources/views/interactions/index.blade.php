@extends('dashboard.admin')
@php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Interactions</h2>
        <a href="{{ route('interactions.create') }}" class="btn btn-primary">Add Interaction</a>
    </div>

    <div class="card p-4">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Customer</th>
                    <th>Rating</th>
                    <th>Response Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($interactions as $interaction)
                <tr>
                    <td>{{ $interaction->id }}</td>
                   <td>{{ $interaction->employee?->name ?? 'N/A' }}</td>
                    <td>{{ $interaction->customer_name }}</td>
                    <td>{{ $interaction->rating }} ⭐</td>
                    <td>{{ $interaction->response_time }} sec</td>
                  <td>
    <a href="{{ route('feedback.customer.create', $interaction->id) }}" target="_blank">
        {!! QrCode::size(120)->generate(route('feedback.customer.create', $interaction->id)) !!}
    </a>
</td>
                    <td>
                        <a href="{{ route('interactions.edit', $interaction->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('interactions.destroy', $interaction->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this interaction?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection