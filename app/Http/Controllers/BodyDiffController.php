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

class BodyDiffController extends Controller
{
    public function index(Schedule $schedule)
    {
        return Inertia::render('Schedules/BodyDiff', [
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
                'caloriesRemainder' => [
                    $schedule->caloriesBurntOnDay(1),
                    $schedule->caloriesBurntOnDay(2),
                    $schedule->caloriesBurntOnDay(3),
                    $schedule->caloriesBurntOnDay(4),
                    $schedule->caloriesBurntOnDay(5),
                    $schedule->caloriesBurntOnDay(6),
                    $schedule->caloriesBurntOnDay(7),
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
                    'data' => $workoutEvent->userWorkout->exercise->getData($workoutEvent),
                ]),
            'bodies' => Auth::user()->account->bodies
                ->transform(fn($body) => [
                    'id' => $body->id,
                    'name' => $body->name,
                ])
        ]);
    }
}
