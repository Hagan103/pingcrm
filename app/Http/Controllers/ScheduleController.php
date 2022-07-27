<?php

namespace App\Http\Controllers;

use App\Models\Body;
use App\Models\Organization;
use App\Models\Run;
use App\Models\Schedule;
use App\Models\WorkoutEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class scheduleController extends Controller
{
    public function index()
    {

        return Inertia::render('Schedules/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search', 'trashed'),

            'schedules' => Auth::user()->account->schedules()
                ->orderBy('id')
//                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn($run) => [
                    'id' => $run->id,
                    'name' => $run->name,
                ]),
        ]);
    }

    public function edit(Schedule $schedule)
    {
//        $workoutEvent = $schedule->workoutEvents->first();
//        $workoutEvent->exercise->calculateCaloriesBurnt($workoutEvent);
//        dd(Auth::user()->account->workouts->pluck('exercise'));
        return Inertia::render('Schedules/Edit', [
            'schedule' => [
                'id' => $schedule->id,
                'body' => [
                    'id' => $schedule->body->id,
                    'name' => $schedule->body->name,
                ],
                'calorieIntake' => [
                    $schedule->mon_calorie_intake,
                    $schedule->tue_calorie_intake,
                    $schedule->wed_calorie_intake,
                    $schedule->thu_calorie_intake,
                    $schedule->fri_calorie_intake,
                    $schedule->sat_calorie_intake,
                    $schedule->sun_calorie_intake,
                ],
                'weeks' => $schedule->weeks,
                'dailyCalorieIntake' => $schedule->daily_calorie_intake,
            ],
            'workouts' => Auth::user()->account->workouts
                ->transform(fn($workout) => [
                    'id' => $workout->id,
                    'name' => $workout->exercise->name,
                ]),
            'workoutEvents' => $schedule->workoutEvents
                ->transform(fn($workoutEvent) => [
                    'exercise_type' => $workoutEvent->userWorkout->exercise_type,
                    'day_id' => $workoutEvent->day_id,
                    'id' => $workoutEvent->id,
                    'name' => $workoutEvent->userWorkout->exercise->name,
                    'data' => $workoutEvent->userWorkout->exercise->getData,
                ]),
            'bodies' => Auth::user()->account->bodies
                ->transform(fn($body) => [
                    'id' => $body->id,
                    'name' => $body->name,
                ])
        ]);
    }



    public function update(Schedule $schedule)
    {
        $body = Body::where('id', request()->get('body_id'))->first();

        if(!$body || $body->user_id !== auth()->user()->id){
            throw new \ErrorException('Error found');
        }


        $schedule->update(
            \Illuminate\Support\Facades\Request::validate([
                'body_id' => ['required', 'max:100'],
                'weeks' => ['required', 'numeric'],

//                'daily_calorie_intake' => ['required'],
                'mon_calorie_intake' => ['numeric'],
                'tues_calorie_intake' => ['numeric'],
                'wed_calorie_intake' => ['numeric'],
                'thu_calorie_intake' => ['numeric'],
                'fri_calorie_intake' => ['numeric'],
                'sat_calorie_intake' => ['numeric'],
                'sun_calorie_intake' => ['numeric'],
            ])
        );

//        return Redirect::back()->with('success', 'Schedule updated.');
    }
}
