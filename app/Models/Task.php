<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'worker_id',
        'deadline',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * Get the task's expired status.
     *
     * @return string
     */
    public function getIsExpiredAttribute()
    {
        return $this->isExpired();
    }

    /**
     * Check if the task is expired
     *
     * @return boolean
     */
    public function isExpired()
    {
        return $this->deadline->isBefore(today());
    }

    /**
     * Get the user who create the task.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user assigned the task.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function worker()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the logs for the task.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
