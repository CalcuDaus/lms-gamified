<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XpLog extends Model
{
    /** @use HasFactory<\Database\Factories\XpLogFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'source',
        'xp_amount',
    ];
}
