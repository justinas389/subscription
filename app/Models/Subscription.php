<?php

namespace App\Models;

use App\States\PhaseState;
use Spatie\ModelStates\HasStates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;
    use HasStates;

    protected $fillable = [
        'user_id',
        'phase',
        'start_date',
        'end_date',
        'price',
    ];

    protected $casts = [
        'phase' => PhaseState::class,
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];
}
