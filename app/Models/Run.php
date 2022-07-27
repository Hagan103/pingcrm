<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Run extends Exercise
{
    public function getData(WorkoutEvent $workoutEvent)
    {
        return [
            'distance' => $this->distance,
            'duration' => $this->duration,
            'calories_burnt' => $this->calculateCaloriesBurnt($workoutEvent),
        ];
    }

    public function calculateCaloriesBurnt(WorkoutEvent $workoutEvent): int
    {
        $body = $workoutEvent->schedule->body;

        $weight = $body->weight;
        $height = $body->weight;
        $duration = $this->duration;
        $distance = $this->distance;

        $time = 0;
        $timeHour = 0;

        //weight in kg
        $weight = $weight;

        //distance in miles
        $distance = $distance / 1609;
        $speedText = "min per mile";


        $time = $time + $duration;
        $timeHour = $timeHour + ($duration / 60);
        $speed = $distance / $timeHour;
        $speedNew = 60 / $speed;
        $initialSpeed = $speedNew;

        $met = 0;
        $calories = 0;
        $counts = collect([4, 5, 5.2, 6, 6.7, 7, 7.5, 8, 8.6, 9, 10, 11, 12, 13, 14]);
        $goal = $speed;
        $closest = $counts->reduce(function ($prev, $curr) use ($goal) {
            return (abs($curr - $goal) < abs($prev - $goal) ? $curr : $prev);
        });
        if ($closest == 4) {
            $met = 5;
        } else if ($closest == 5) {
            $met = 8.3;
        } else if ($closest == 5.2) {
            $met = 9;
        } else if ($closest == 6) {
            $met = 9.8;
        } else if ($closest == 6.7) {
            $met = 10.5;
        } else if ($closest == 7) {
            $met = 11;
        } else if ($closest == 7.5) {
            $met = 11.5;
        } else if ($closest == 8) {
            $met = 11.8;
        } else if ($closest == 8.6) {
            $met = 12.3;
        } else if ($closest == 9) {
            $met = 12.8;
        } else if ($closest == 10) {
            $met = 14.5;
        } else if ($closest == 11) {
            $met = 16;
        } else if ($closest == 12) {
            $met = 19;
        } else if ($closest == 13) {
            $met = 19.8;
        } else if ($closest == 14) {
            $met = 23;
        }

        $calories = ($met * $time * $weight * 3.5) / 200;
        return $calories;
    }


}
