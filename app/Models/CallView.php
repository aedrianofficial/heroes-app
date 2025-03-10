<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallView extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'call_id',
        'user_id',
    ];

    /**
     * Get the call that was viewed.
     */
    public function call()
    {
        return $this->belongsTo(Call::class);
    }

    /**
     * Get the user who viewed the call.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include views for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include views for a specific call.
     */
    public function scopeForCall($query, $callId)
    {
        return $query->where('call_id', $callId);
    }

    /**
     * Check if a call has been viewed by a specific user.
     *
     * @param int $callId
     * @param int $userId
     * @return bool
     */
    public static function hasBeenViewed($callId, $userId)
    {
        return static::where('call_id', $callId)
            ->where('user_id', $userId)
            ->exists();
    }
}
