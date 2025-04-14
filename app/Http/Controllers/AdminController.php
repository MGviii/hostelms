<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Block;
use App\Models\Room;
use App\Models\RoomAllocation;
use App\Models\RoomRequest;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_blocks' => Block::count(),
            'total_rooms' => Room::count(),
            'total_allocations' => RoomAllocation::count(),
            'pending_requests' => RoomRequest::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // Blocks Management Methods
    public function blocksIndex()
    {
        $blocks = Block::all();
        return view('admin.blocks.index', compact('blocks'));
    }

    public function blocksCreate()
    {
        return view('admin.blocks.create');
    }

    public function blocksStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Block::create($validated);
        return redirect()->route('admin.blocks.index')->with('success', 'Block created successfully.');
    }

    public function blocksEdit(Block $block)
    {
        return view('admin.blocks.edit', compact('block'));
    }

    public function blocksUpdate(Request $request, Block $block)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $block->update($validated);
        return redirect()->route('admin.blocks.index')->with('success', 'Block updated successfully.');
    }

    public function blocksDestroy(Block $block)
    {
        $block->delete();
        return redirect()->route('admin.blocks.index')->with('success', 'Block deleted successfully.');
    }

    // Rooms Management Methods
    public function roomsIndex()
    {
        $rooms = Room::with('block')->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function roomsCreate()
    {
        $blocks = Block::all();
        return view('admin.rooms.create', compact('blocks'));
    }

    public function roomsStore(Request $request)
    {
        $validated = $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
        ]);

        Room::create($validated);
        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }

    public function roomsEdit(Room $room)
    {
        $blocks = Block::all();
        return view('admin.rooms.edit', compact('room', 'blocks'));
    }

    public function roomsUpdate(Request $request, Room $room)
    {
        $validated = $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
        ]);

        $room->update($validated);
        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    public function roomsDestroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }

    // Room Allocations Management Methods
    public function allocationsIndex()
    {
        $allocations = RoomAllocation::with(['user', 'room.block'])->get();
        return view('admin.allocations.index', compact('allocations'));
    }

    public function allocationsCreate()
    {
        $users = User::where('role', 'student')->get();
        $rooms = Room::where('status', 'available')->with('block')->get();
        return view('admin.allocations.create', compact('users', 'rooms'));
    }

    public function allocationsStore(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Check if room is available
        $room = Room::findOrFail($validated['room_id']);
        if ($room->status !== 'available') {
            return back()->withErrors(['room_id' => 'Selected room is not available.'])->withInput();
        }

        // Create allocation
        $allocation = RoomAllocation::create($validated);

        // Update room status
        $room->update(['status' => 'occupied']);

        return redirect()->route('admin.allocations.index')->with('success', 'Room allocated successfully.');
    }

    public function allocationsEdit(RoomAllocation $allocation)
    {
        $rooms = Room::where('gender', $allocation->user->gender)->with('block')->get();
        return view('admin.allocations.edit', compact('allocation', 'rooms'));
    }

    public function allocationsUpdate(Request $request, RoomAllocation $allocation)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        // Check if the new room is of the same gender as the student
        $newRoom = Room::findOrFail($validated['room_id']);
        if ($newRoom->gender !== $allocation->user->gender) {
            return back()->withErrors(['room_id' => 'Selected room is not for the student\'s gender.'])->withInput();
        }

        $allocation->update($validated);
        return redirect()->route('admin.allocations.index')->with('success', 'Allocation updated successfully.');
    }

    public function allocationsDestroy(RoomAllocation $allocation)
    {
        $allocation->delete();
        return redirect()->route('admin.allocations.index')->with('success', 'Allocation deleted successfully.');
    }

    // Room Requests Management Methods
    public function requestsIndex()
    {
        $requests = RoomRequest::with(['user'])->get();
        return view('admin.requests.index', compact('requests'));
    }

    public function requestsApprove(RoomRequest $request)
    {
        if ($request->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $room = Room::findOrFail(request('room_id'));
        $student = $request->user;

        // Verify room gender matches student gender
        if ($room->gender !== $student->gender) {
            return back()->with('error', 'Selected room gender does not match student gender.');
        }

        // Check if room is full (max 8 students)
        $currentOccupants = $room->allocations()->count();
        if ($currentOccupants >= 8) {
            return back()->with('error', 'Selected room is already full.');
        }

        // Create room allocation
        RoomAllocation::create([
            'user_id' => $student->id,
            'room_id' => $room->id
        ]);

        // Update request status
        $request->update(['status' => 'approved']);

        return back()->with('success', 'Room request approved and room allocated successfully.');
    }

    public function requestsReject(RoomRequest $request)
    {
        // Check if request is already processed
        if ($request->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        // Update request status
        $request->update(['status' => 'rejected']);

        return redirect()->route('admin.requests.index')->with('success', 'Request rejected successfully.');
    }
}
