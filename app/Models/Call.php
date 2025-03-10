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
        'is_processed',
        'status_id',
    ];
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function statusLogCalls()
    {
        return $this->hasMany(StatusLogCall::class, 'call_id');
    }
    public function requests()
    {
        return $this->hasMany(Request::class);
    }

}
