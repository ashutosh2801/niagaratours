<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourNotification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'type',
        'message',
        'icon',
        'color',
        'url',
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
