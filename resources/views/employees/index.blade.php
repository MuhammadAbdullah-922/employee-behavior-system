@extends('dashboard.admin')

@section('content')
<div class="container-fluid">
    

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Employees</h2>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
    </div>

    <div class="card p-4">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                  
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
             @foreach($employees as $employee)
<tr>
    <td>{{ $employee->id }}</td>
    <td>{{ $employee->name }}</td>
    <td>{{ $employee->email }}</td>
    
    <td>
        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this employee?')">Delete</button>
        </form>
    </td>
</tr>
@endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection