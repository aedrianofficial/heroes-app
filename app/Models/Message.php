<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'sender_contact',
        'message_content',
        'sender_type',
        'user_id',
        'status_id',
        'is_processed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function incidentTypes()
    {
        return $this->belongsToMany(IncidentType::class, 'incident_message');
    }

    public function agencies()
    {
        return $this->belongsToMany(Agency::class, 'agency_message');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    
    public function statusLogMessages()
    {
        return $this->hasMany(StatusLogMessage::class, 'message_id');
    }

    public function requests()
    {
        return $this->hasMany(RequestMessage::class);
    }
}
