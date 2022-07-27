<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkoutEvent extends Model
{
    use HasFactory;
    use SoftDeletes;

//    public function exercise()
//    {
//        return $this->belongsTo($this->exercise_type);
//    }

    public function schedule()
    {
//        return Schedule::find($this->schedule_id);
        return $this->belongsTo(Schedule::class,  'schedule_id');
    }

    public function userWorkout()
    {
        return $this->belongsTo(UserWorkouts::class,  'user_workout_id');
    }
}
