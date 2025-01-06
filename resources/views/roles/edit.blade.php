@extends('layout')

@section('content')
<h1>Edit Role</h1>
<form action="{{ route('roles.update', $role) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="name">Role Name:</label>
    <input type="text" name="name" value="{{ $role->name }}" required>

    <h3>Permissions</h3>
    @foreach ($permissions as $permission)
        <div>
            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
            <label>{{ $permission->name }}</label>
        </div>
    @endforeach

    <button type="submit">Update</button>
</form>
@endsection
