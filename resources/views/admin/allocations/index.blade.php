@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Room Allocations</h5>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($allocations->isEmpty())
                        <div class="alert alert-info">
                            No room allocations found.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Gender</th>
                                        <th>Block</th>
                                        <th>Room</th>
                                        <th>Allocated Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allocations as $allocation)
                                        <tr>
                                            <td>{{ $allocation->user->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $allocation->user->gender === 'male' ? 'primary' : 'danger' }}">
                                                    {{ ucfirst($allocation->user->gender) }}
                                                </span>
                                            </td>
                                            <td>{{ $allocation->room->block->name }}</td>
                                            <td>{{ $allocation->room->name }}</td>
                                            <td>{{ $allocation->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.allocations.edit', $allocation) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <form action="{{ route('admin.allocations.destroy', $allocation) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this allocation?')">Delete</button>
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
