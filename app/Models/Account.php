<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function bodies()
    {
        return $this->hasMany(Body::class, 'user_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'user_id');
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'user_id');
    }

    public function workoutEvents()
    {
        return $this->hasMany(WorkoutEvent::class, 'user_id');
    }

    public function workouts()
    {
        return $this->hasMany(UserWorkouts::class, 'user_id');
    }

    public function runs()
    {
        return $this->hasMany(Run::class, 'user_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
