<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'agency_id', 'title', 'description', 'status_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function agency() {
        return $this->belongsTo(Agency::class);
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
