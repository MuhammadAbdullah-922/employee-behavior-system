@extends('dashboard.admin')

@section('content')
<div class="container-fluid">
    <h2>Edit Employee</h2>

    <div class="card p-4">
        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" value="{{ $employee->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" value="{{ $employee->email }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="role_id" class="form-label">Role</label>
                <select name="role_id" class="form-select" required>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $employee->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection