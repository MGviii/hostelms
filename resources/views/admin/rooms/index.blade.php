@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Rooms Management</h5>
                    <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">Add New Room</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($rooms->isEmpty())
                        <div class="alert alert-info">
                            No rooms found. Click the "Add New Room" button to create one.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Block</th>
                                        <th>Room Name</th>
                                        <th>Gender</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rooms as $room)
                                        <tr>
                                            <td>{{ $room->block->name }}</td>
                                            <td>{{ $room->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $room->gender === 'male' ? 'primary' : 'danger' }}">
                                                    {{ ucfirst($room->gender) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this room?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
