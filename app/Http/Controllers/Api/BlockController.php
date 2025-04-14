<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Room;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    // Get all blocks
    public function index()
    {
        return response()->json(Block::all(['id', 'name']));
    }

    // Get available rooms in a block for a given gender, with <8 allocations
    public function rooms($blockId, Request $request)
    {
        $gender = $request->query('gender');

        $rooms = Room::where('block_id', $blockId)
                    ->where('gender', $gender)
                    ->whereRaw('
                        (SELECT COUNT(*) FROM allocations WHERE allocations.room_id = rooms.id) < 8
                    ')
                    ->get(['id', 'name']);

        return response()->json($rooms);
    }
}
