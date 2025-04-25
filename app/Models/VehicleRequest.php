<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleRequest extends Model
{
    use HasFactory;

    protected $table = 'vehicle_requests';

    protected $fillable = [
        'full_name',
        'requested_by',
        'vehicle_type',
        'quantity',
        'location',
        'reason',
        'priority',
        'status',
        'incident_case_id',
    ];

    /**
     * The user who made the request.
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    /**
     * The incident case related to this vehicle request.
     */
    public function incidentCase()
    {
        return $this->belongsTo(IncidentCase::class, 'incident_case_id');
    }
}
