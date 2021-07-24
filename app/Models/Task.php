<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'finished',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
