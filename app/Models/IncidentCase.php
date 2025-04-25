<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class IncidentCase extends Model {
    use HasFactory;

    protected $table = 'incident_cases';
    protected $fillable = ['incident_type_id', 'case_number'];

    /**
     * Relationship: Each incident case belongs to an incident type.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
    public function incidentType() {
        return $this->belongsTo(IncidentType::class);
    }

    /**
     * Relationship: An incident case can have multiple request calls.
     */
    public function requestCalls() {
        return $this->hasMany(RequestCall::class, 'incident_case_id');
    }
    public function requestMessages() {
        return $this->hasMany(RequestMessage::class, 'incident_case_id');
    }

    /**
     * Generate a unique case number like "CRIME #1"
     */
    public static function generateCaseNumber($incidentTypeId) {
        $incidentType = DB::table('incident_type')->where('id', $incidentTypeId)->value('name');
        $count = self::where('incident_type_id', $incidentTypeId)->count() + 1;
        return strtoupper($incidentType) . " #" . $count;
    }

    
}
