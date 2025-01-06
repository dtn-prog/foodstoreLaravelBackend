@extends('layout')

@section('content')
<h1>Create Role</h1>
<form action="{{ route('roles.store') }}" method="POST">
    @csrf
    <label for="name">Role Name:</label>
    <input type="text" name="name" required>

    <h3>Permissions</h3>
    @foreach ($permissions as $permission)
        <div>
            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
            <label>{{ $permission->name }}</label>
        </div>
    @endforeach

    <button type="submit">Create</button>
</form>
@endsection
