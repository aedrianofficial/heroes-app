<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusLogMessage extends Model
{
    use HasFactory;

    protected $fillable = ['message_id', 'status_id', 'user_id', 'log_details'];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
