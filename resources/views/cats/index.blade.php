@extends('layout')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h1 class="text-3xl font-semibold mb-6">Categories</h1>

    @can('create cats')
        <a href="{{ route('cats.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Category</a>
    @endcan

    <table class="min-w-full bg-white border border-gray-200 mt-4 rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-4 text-left">ID</th>
                <th class="py-3 px-4 text-left">Name</th>
                <th class="py-3 px-4 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach ($cats as $cat)
                <tr class="hover:bg-gray-100 border-b border-gray-200">
                    <td class="py-3 px-4">{{ $cat->id }}</td>
                    <td class="py-3 px-4">{{ $cat->name }}</td>
                    <td class="py-3 px-4">
                        @can('edit cats')
                            <a href="{{ route('cats.edit', $cat) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Edit</a>
                        @endcan

                        @can('delete cats')
                            <form action="{{ route('cats.destroy', $cat) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function confirmDelete(event) {
        event.preventDefault();
        const confirmed = confirm("Are you sure you want to delete this category?");
        if (confirmed) {
            event.target.submit();
        }
    }
</script>
@endsection
