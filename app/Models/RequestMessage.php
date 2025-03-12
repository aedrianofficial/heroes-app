<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id',
        'name',
        'address',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the message that originated this request.
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function agencies()
    {
        return $this->belongsToMany(Agency::class, 'request_message_agency');
    }

    public function views() {
        return $this->hasMany(RequestMessageView::class);
    }
}
