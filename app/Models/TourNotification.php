<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourNotification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'type',
        'name',
        'email',
        'subject',
        'message',
        'message',
        'is_read',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }
}
