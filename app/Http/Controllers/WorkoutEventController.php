<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\UserWorkouts;
use App\Models\WorkoutEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class WorkoutEventController extends Controller
{
    public function store()
    {
        $workout = Auth::user()->account->workouts->find(request()->get('user_workout_id'));

        if(!$workout || $workout->user_id !== auth()->user()->id){
            throw new \ErrorException('Error found');
        }


        return WorkoutEvent::create(
            array_merge(
                [
                    'user_id' => auth()->user()->id
                ],
                \Illuminate\Support\Facades\Request::validate([
                    'user_workout_id' => ['required'],
                    'day_id' => ['required'],
                    'schedule_id' => ['required'],
                ])
            )
        );
    }


    public function destroy(WorkoutEvent $workoutEvent)
    {
        $workoutEvent->delete();
    }

}
