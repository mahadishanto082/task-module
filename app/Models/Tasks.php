<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_completed', // rename 'status' to 'is_completed' to match your DB
        'user_id',      // add user_id
    ];

    // Each task belongs to one user
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function tasks()
{
    return $this->hasMany(\App\Models\Tasks::class);
}
}
