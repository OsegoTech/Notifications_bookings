<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledClass extends Model
{
    use HasFactory;
    protected $guarded = null;

    protected $casts = [
        'date_time' => 'datetime',
    ];

    public function Instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function classType()
    {
        return $this->belongsTo(ClassType::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'bookings');
    }

    public function scopeUpcoming(Builder $query)
    {
        return $query->where('date_time', '>', now());
    }

    public function scopeNotBooked(Builder $query)
    {
       return $query->whereDoesntHave('members', function($query){
            $query->where('user_id', auth()->user()->id);
        });
    }
}
