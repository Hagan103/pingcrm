<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Exercise
{
    public function calculateCaloriesBurnt(WorkoutEvent $workoutEvent): int
    {
        //https://caloriesburnedhq.com/calories-burned-biking/
        $body = $workoutEvent->schedule->body;

        $w = $body->weight;
        $m = $this->duration;
        $c = 0;
        $met = 0;
        $islb = isSwitchChecked('pounds');

//        if (speedKnown) {
//            met = getMetByKnownSpeed(form, m);
//        } else {
        $met = $this->getMetByUnknownSpeed($this->distance, $m);
//        }

        $c = $this->cckg($w, $met, $m);

        return $c;
    }

    function cckg($kg, $met, $mins)
    {
        return round($met * 3.5 * ($kg) / 200 * $mins);
    }

    function getMetByUnknownSpeed($distance, $duration)
    {
        $met = -1;
        $speed = $this->closestSpeed((($distance / $duration) * 60) * 0.621371192);
        $select = document . getElementById('speed_select');
        $selectIndex = -1;
        switch ($speed) {
            case 5.5:
                $selectIndex = 0;
                $met = 3.5;
                break;
            case 9.4:
                $selectIndex = 1;
                $met = 5.8;
                break;
            case 10:
                $selectIndex = 2;
                $met = 6.8;
                break;
            case 12:
                $selectIndex = 3;
                $met = 8;
                break;
            case 14:
                $selectIndex = 4;
                $met = 10;
                break;
            case 16:
                $selectIndex = 5;
                $met = 12;
                break;
            case 20:
                $selectIndex = 6;
                $met = 15.8;
                break;
        }

        return $met;
    }

    public function closestSpeed($num)
    {
        $knownSpeeds = [5.5, 9.4, 10, 12, 14, 16, 20];
        $curr = $knownSpeeds[0];
        $diff = abs($num - $curr);
        for ($val = 0; $val < $knownSpeeds . length; $val++) {
            $newdiff = abs($num - $knownSpeeds[$val]);
            if ($newdiff < $diff) {
                $diff = $newdiff;
                $curr = $knownSpeeds[val];
            }
        }
        return $curr;
    }
}
