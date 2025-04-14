@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Room Allocation</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.allocations.update', $allocation) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Student</label>
                            <input type="text" class="form-control" value="{{ $allocation->user->name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Room</label>
                            <input type="text" class="form-control" value="{{ $allocation->room->block->name }} - {{ $allocation->room->name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="room_id" class="form-label">New Room</label>
                            <select class="form-select @error('room_id') is-invalid @enderror" id="room_id" name="room_id" required>
                                <option value="">Select New Room</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id', $allocation->room_id) == $room->id ? 'selected' : '' }}>
                                        {{ $room->block->name }} - {{ $room->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.allocations.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Allocation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
