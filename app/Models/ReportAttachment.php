<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAttachment extends Model
{
    use HasFactory;
    protected $table = 'report_attachments';
    protected $fillable = ['report_id', 'file_path'];

    public function report() {
        return $this->belongsTo(Report::class);
    }
}
