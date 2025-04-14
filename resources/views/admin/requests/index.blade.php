@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Room Requests</h5>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($requests->isEmpty())
                        <div class="alert alert-info">
                            No pending room requests found.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Gender</th>
                                        <th>Request Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $request)
                                        <tr>
                                            <td>{{ $request->user->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $request->user->gender === 'male' ? 'primary' : 'danger' }}">
                                                    {{ ucfirst($request->user->gender) }}
                                                </span>
                                            </td>
                                            <td>{{ $request->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'approved' ? 'success' : 'danger') }}">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($request->status === 'pending')
                                                    <div class="btn-group" role="group">
                                                        <button type="button" onclick="showRoomSelection({{ $request->id }}, '{{ $request->user->gender }}')" class="btn btn-sm btn-success me-1">Approve</button>
                                                        <button type="button" onclick="submitForm('reject-form-{{ $request->id }}')" class="btn btn-sm btn-danger">Reject</button>

                                                        <form id="approve-form-{{ $request->id }}" action="{{ route('admin.requests.approve', $request) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            <input type="hidden" name="room_id" id="room_id_{{ $request->id }}">
                                                        </form>

                                                        <form id="reject-form-{{ $request->id }}" action="{{ route('admin.requests.reject', $request) }}" method="POST" style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </div>
                                                @else
                                                    <span class="text-muted">No actions available</span>
                                                @endif
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

<!-- Room Selection Modal -->
<div class="modal fade" id="roomSelectionModal" tabindex="-1" aria-labelledby="roomSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roomSelectionModalLabel">Select Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="block_select" class="form-label">Block</label>
                    <select class="form-select" id="block_select" onchange="loadRooms()">
                        <option value="">Select Block</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="room_select" class="form-label">Room</label>
                    <select class="form-select" id="room_select">
                        <option value="">Select Room</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="approveRequest()">Approve & Allocate</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentRequestId = null;
let currentGender = null;

function submitForm(formId) {
    if (formId.includes('reject') && !confirm('Are you sure you want to reject this request?')) {
        return;
    }
    document.getElementById(formId).submit();
}

function showRoomSelection(requestId, gender) {
    currentRequestId = requestId;
    currentGender = gender;

    // Clear previous selections
    document.getElementById('block_select').innerHTML = '<option value="">Select Block</option>';
    document.getElementById('room_select').innerHTML = '<option value="">Select Room</option>';

    // Load blocks
    fetch('/api/blocks')
        .then(response => response.json())
        .then(blocks => {
            const blockSelect = document.getElementById('block_select');
            blocks.forEach(block => {
                blockSelect.innerHTML += `<option value="${block.id}">${block.name}</option>`;
            });
        });

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('roomSelectionModal'));
    modal.show();
}

function loadRooms() {
    const blockId = document.getElementById('block_select').value;
    if (!blockId) return;

    // Load rooms for selected block and gender
    fetch(`/api/blocks/${blockId}/rooms?gender=${currentGender}`)
        .then(response => response.json())
        .then(rooms => {
            const roomSelect = document.getElementById('room_select');
            roomSelect.innerHTML = '<option value="">Select Room</option>';
            rooms.forEach(room => {
                roomSelect.innerHTML += `<option value="${room.id}">${room.name}</option>`;
            });
        });
}

function approveRequest() {
    const roomId = document.getElementById('room_select').value;
    if (!roomId) {
        alert('Please select a room');
        return;
    }

    // Set room_id and submit form
    document.getElementById(`room_id_${currentRequestId}`).value = roomId;
    document.getElementById(`approve-form-${currentRequestId}`).submit();

    // Hide modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('roomSelectionModal'));
    modal.hide();
}
</script>
@endsection
