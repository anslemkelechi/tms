<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
        'full_name',
        'email',
        'ticket_number',
        'title',
        'description',
        'status',
    ];
}
