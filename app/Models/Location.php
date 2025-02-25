<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable = ['report_id', 'address', 'latitude', 'longitude'];

    public function report() {
        return $this->belongsTo(Report::class);
    }
}
