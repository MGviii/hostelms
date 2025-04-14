<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'block_id',
        'name',
        'gender',
    ];

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function allocations()
    {
        return $this->hasMany(RoomAllocation::class);
    }
}
