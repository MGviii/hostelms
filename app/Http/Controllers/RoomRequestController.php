<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomRequest;
use Illuminate\Support\Facades\Auth;

class RoomRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $requests = RoomRequest::where('user_id', Auth::id())->get();
        return view('student.requests.index', compact('requests'));
    }

    public function create()
    {
        return view('student.requests.create');
    }

    public function store(Request $request)
    {
        $validated = [
            'user_id' => Auth::id(),
            'status' => 'pending'
        ];

        RoomRequest::create($validated);
        return redirect()->route('student.requests.index')->with('success', 'Room request submitted successfully.');
    }

    public function show(RoomRequest $request)
    {
        if ($request->user_id !== Auth::id()) {
            abort(403);
        }
        return view('student.requests.show', compact('request'));
    }

    public function cancel(RoomRequest $request)
    {
        if ($request->user_id !== Auth::id()) {
            abort(403);
        }

        $request->update(['status' => 'cancelled']);
        return redirect()->route('student.requests.index')->with('success', 'Room request cancelled successfully.');
    }
}
