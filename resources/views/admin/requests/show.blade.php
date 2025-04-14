@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Room Request Details</h2>
            <a href="{{ route('admin.requests.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back to List</a>
        </div>

        <div class="mb-8">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Student Name:</p>
                    <p class="font-semibold">{{ $request->user->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Gender:</p>
                    <p class="font-semibold">{{ ucfirst($request->user->gender) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Status:</p>
                    <p class="font-semibold">
                        @if($request->status === 'pending')
                            <span class="text-yellow-600">Pending</span>
                        @elseif($request->status === 'approved')
                            <span class="text-green-600">Approved</span>
                        @else
                            <span class="text-red-600">Cancelled</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-gray-600">Request Date:</p>
                    <p class="font-semibold">{{ $request->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>

        @if($request->status === 'pending')
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">Approve Request</h3>
                <form action="{{ route('admin.requests.approve', $request) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="block" class="block text-sm font-medium text-gray-700">Select Block</label>
                        <select id="block" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select a block...</option>
                        </select>
                    </div>

                    <div>
                        <label for="room_id" class="block text-sm font-medium text-gray-700">Select Room</label>
                        <select name="room_id" id="room_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select a room...</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Approve Request
                        </button>
                    </div>
                </form>
            </div>

            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const blockSelect = document.getElementById('block');
                    const roomSelect = document.getElementById('room_id');
                    const studentGender = "{{ $request->user->gender }}";

                    // Fetch blocks
                    fetch('/api/blocks')
                        .then(response => response.json())
                        .then(blocks => {
                            blocks.forEach(block => {
                                const option = new Option(block.name, block.id);
                                blockSelect.add(option);
                            });
                        });

                    // Update rooms when block is selected
                    blockSelect.addEventListener('change', function() {
                        roomSelect.innerHTML = '<option value="">Select a room...</option>';

                        if (this.value) {
                            fetch(`/api/blocks/${this.value}/rooms?gender=${studentGender}`)
                                .then(response => response.json())
                                .then(rooms => {
                                    rooms.forEach(room => {
                                        const option = new Option(`Room ${room.number}`, room.id);
                                        roomSelect.add(option);
                                    });
                                });
                        }
                    });
                });
            </script>
            @endpush
        @endif
    </div>
</div>
@endsection
