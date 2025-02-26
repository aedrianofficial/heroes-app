<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'incident_type_id', 'title', 'description', 'status_id', 'contact_number'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function incidentType() {
        return $this->belongsTo(IncidentType::class);
    }
    
    public function agencies() {
        return $this->belongsToMany(Agency::class, 'agency_report');
    }


    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function location() {
        return $this->hasOne(Location::class);
    }

    public function reportAttachments() {
        return $this->hasMany(ReportAttachment::class);
    }
}
