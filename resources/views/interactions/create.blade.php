@extends('dashboard.admin')

@section('content')
<div class="container-fluid">
    <h2>Add Interaction</h2>

    <div class="card p-4">
        <form action="{{ route('interactions.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="employee_id" class="form-label">Employee</label>
                <select name="employee_id" class="form-select" required>
                    @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="customer_name" class="form-label">Customer Name</label>
                <input type="text" name="customer_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <input type="number" name="rating" min="1" max="5" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="response_time" class="form-label">Response Time (sec)</label>
                <input type="number" name="response_time" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('interactions.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection