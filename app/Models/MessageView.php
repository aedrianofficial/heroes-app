<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageView extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id',
        'user_id',
    ];

    /**
     * Get the message that was viewed.
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * Get the user who viewed the message.
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
     * Scope a query to only include views for a specific message.
     */
    public function scopeForMessage($query, $messageId)
    {
        return $query->where('message_id', $messageId);
    }

    /**
     * Check if a message has been viewed by a specific user.
     *
     * @param int $messageId
     * @param int $userId
     * @return bool
     */
    public static function hasBeenViewed($messageId, $userId)
    {
        return static::where('message_id', $messageId)
            ->where('user_id', $userId)
            ->exists();
    }
}
