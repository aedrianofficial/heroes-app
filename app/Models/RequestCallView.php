<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestCallView extends Model
{
    use HasFactory;
    protected $table = 'request_call_views';
    protected $fillable = ['request_call_id', 'user_id'];

    public function request() {
        return $this->belongsTo(RequestCall::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
