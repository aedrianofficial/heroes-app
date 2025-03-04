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
        'sender_type'
    ];

    public function incidentTypes()
    {
        return $this->belongsToMany(IncidentType::class, 'incident_message');
    }

    public function agencies()
    {
        return $this->belongsToMany(Agency::class, 'agency_message');
    }
}
