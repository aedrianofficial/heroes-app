<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;

    protected $fillable = ['incident_type_id', 'keyword'];

    public function incidentType()
    {
        return $this->belongsTo(IncidentType::class);
    }//
}
