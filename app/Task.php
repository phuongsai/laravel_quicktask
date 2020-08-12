<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    // mass assignable value
    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    /**
     * Eloquent ORM
     * Get the user own the task - inverse relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the route key for the model instead of id
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Eloquent Query Scopes
     *
     * @param mixed $query
     */
    public function scopeOwner($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
