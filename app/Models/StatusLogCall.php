<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusLogCall extends Model
{
    use HasFactory;

    protected $fillable = ['call_id', 'status_id', 'user_id', 'log_details'];

    public function call()
    {
        return $this->belongsTo(Call::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
