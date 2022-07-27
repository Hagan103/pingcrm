<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class Exercise extends Model
{
    use SoftDeletes;

//    use HasFactory;
//
//    public string $name;
//    public string $user_id;
//
    abstract public function calculateCaloriesBurnt(WorkoutEvent $workoutEvent): int;

    protected static function booted()
    {
        parent::boot();

        static::created(function ($exercise) {
            UserWorkouts::create([
                'user_id' => $exercise->user_id,
                'exercise_type' => get_called_class(),
                'exercise_id' => $exercise->id,
            ]);
        });

        static::deleted(function ($exercise) {
            UserWorkouts::Where('exercise_id', $exercise->id)
                ->where('user_id', $exercise->user_id)
                ->where('exercise_type', get_called_class())
                ->first()
                ->delete();
        });
    }
}
