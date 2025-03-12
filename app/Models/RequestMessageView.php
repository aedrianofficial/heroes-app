<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestMessageView extends Model
{
    use HasFactory;
    protected $table = 'request_message_views';
    protected $fillable = ['request_message_id', 'user_id'];

    public function request() {
        return $this->belongsTo(RequestMessage::class, 'request_message_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
