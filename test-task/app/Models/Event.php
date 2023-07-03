<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_title',
        'event_start_date',
        'event_end_date',
        'organization_id'
    ];

    protected $casts = [
        'event_start_date' => 'timestamp',
        'event_end_date' => 'timestamp'
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organization_id');
    }
}
