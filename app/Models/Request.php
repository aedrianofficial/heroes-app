<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
 

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'call_id',
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
     * Get the call that originated this request.
     */
    public function call()
    {
        return $this->belongsTo(Call::class);
    }
    public function agencies()
    {
        return $this->belongsToMany(Agency::class, 'request_agency');
    }
    public function views() {
        return $this->hasMany(RequestView::class);
    }
    
}
