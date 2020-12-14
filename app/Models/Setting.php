<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    public $timestamps = false;
    protected $fillable = [
        'window_size',
        'saving_level',
        'time_base',
        'comparition_page'
    ];

    protected $casts = [
        'comparition_page' => 'object',
    ];
}
