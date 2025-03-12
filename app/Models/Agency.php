<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function incidentTypes() {
        return $this->belongsToMany(IncidentType::class, 'agency_incident_type');
    }
    public function reports()
    {
        return $this->belongsToMany(Report::class, 'agency_report');
    }
    public function messages()
    {
        return $this->belongsToMany(Message::class, 'agency_message');
    }
    public function requests()
    {
        return $this->belongsToMany(RequestCall::class, 'request_call_agency');
    }
}
