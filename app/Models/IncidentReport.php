<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_case_id',
        'report_number',
        'generated_by',
        'resolution_details',
        'resolution_date',
        'report_path',
    ];

    /**
     * Relationship: Each report belongs to an incident case.
     */
    public function incidentCase()
    {
        return $this->belongsTo(IncidentCase::class);
    }

    /**
     * Relationship: Each report belongs to a user who generated it.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
    
    /**
     * Generate a unique report number
     */
    public static function generateReportNumber($incidentCaseId)
    {
        $case = IncidentCase::find($incidentCaseId);
        $timestamp = now()->format('Ymd');
        return "RES-" . $case->case_number . "-" . $timestamp;
    }
}
