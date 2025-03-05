<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentType extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function agencies()
    {
        return $this->belongsToMany(Agency::class, 'agency_incident_type');
    }
    public function messages()
    {
        return $this->belongsToMany(Message::class, 'incident_message');
    }
    public function keywords()
    {
        return $this->hasMany(Keyword::class);
    }
}
