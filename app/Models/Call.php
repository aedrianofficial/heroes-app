<?php

namespace App\Models;

use App\Events\CallNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    protected $table = 'calls';
    protected $fillable = [
        'caller_contact',
        'call_time',
        'is_processed',
    ];
   
}
