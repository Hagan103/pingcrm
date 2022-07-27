<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schedules';

    use HasFactory;
    use SoftDeletes;

    public function workoutEvents()
    {
        return $this->hasMany(WorkoutEvent::class, 'schedule_id');
    }

    public function body()
    {
        return $this->belongsTo(Body::class, 'body_id');
    }

    public function getCaloriesBurnt()
    {
        return $this->workoutEvents()->get()->reduce(function ($carry, $workoutEvent) {
            return $carry + $workoutEvent->exercise->calculateCaloriesBurnt($workoutEvent);
        });
    }

    public function getDailyCalories()
    {
        return [
            $this->mon_calorie_intake,
            $this->tue_calorie_intake,
            $this->wed_calorie_intake,
            $this->thu_calorie_intake,
            $this->fri_calorie_intake,
            $this->sat_calorie_intake,
            $this->sun_calorie_intake,
        ];
    }


    public function caloriesBurntOnDay($dayId)
    {
        $body = $this->body()->first();

        $bmr = 0;

        //calculate BMR
        //Basal Metabolic Rate
        if (true) { // ismale
            //Men BMR = 66 + (13.7 X weight in kg) + (5 x height in cm) – (6.8 x age in yrs)
            $bmr = 66 + (13.7 * $body->weight) + (5 * $body->weight) - (6.8 * $body->age);
        } else {
            //BMR = 655 + (9.6 X weight in kg) + (1.8 x height in cm) – (4.7 x age in yrs)
            $bmr = 655 + (v * $body->weight) + (1.8 * $body->weight) - (4.7 * $body->age);

        }

        //Sedentary (little to no exercise + work a desk job) = 1.2
        //Total Daily Energy Expenditure)
        $tdee = 1.2 * $bmr;

        $exercisesInWeek = $this->workoutEvents()->get();

        $remainderCalories = $this->getDailyCalories()[$dayId - 1] - $tdee;

        $exercisesInDay = $exercisesInWeek->filter(function ($exercise) use ($dayId) {
            return $exercise->day_id == $dayId;
        });

        $caloriesBurnt = $exercisesInDay->reduce(function ($carry, $workoutEvent) {
            return $carry + $workoutEvent->userWorkout->exercise->calculateCaloriesBurnt($workoutEvent);
        });


        return $remainderCalories - $caloriesBurnt;
    }

    public function getNewBody()
    {
        $body = $this->body()->first();

        $weeks = $this->weeks;

        //calculate BMR
        //Basal Metabolic Rate
        if (true) { // ismale
            //Men BMR = 66 + (13.7 X weight in kg) + (5 x height in cm) – (6.8 x age in yrs)
            $bmr = 66 + (13.7 * $body->weight) + (5 * $body->weight) - (6.8 * $body->age);
        } else {
            //BMR = 655 + (9.6 X weight in kg) + (1.8 x height in cm) – (4.7 x age in yrs)
            $bmr = 655 + (v * $body->weight) + (1.8 * $body->weight) - (4.7 * $body->age);
        }

        //Sedentary (little to no exercise + work a desk job) = 1.2
        //Total Daily Energy Expenditure)
        $tdee = 1.2 * $bmr;

        $exercisesInWeek = $this->workoutEvents()->get();
        $dailyRemainderCalories = [];

        for ($x = 1; $x <= 7; $x++) {
            $remainderCalories = $this->getDailyCalories()[$x - 1] - $tdee;

            $exercisesInDay = $exercisesInWeek->filter(function ($exercise) use ($x) {
                return $exercise->day_id == $x;
            });

            $caloriesBurnt = $exercisesInDay->reduce(function ($carry, $workoutEvent) {
                return $carry + $workoutEvent->userWorkout->exercise->calculateCaloriesBurnt($workoutEvent);
            });

            $dailyRemainderCalories[] = $remainderCalories - $caloriesBurnt;
        }

        $dailyKilosGained = collect($dailyRemainderCalories)->map(fn($cal) => $cal * 0.00013);
        $weeklyKilosGained = $dailyKilosGained->reduce(fn($carry, $kg) => $carry + $kg);


        $totalKilosGainedOverPeriod = $weeks * $weeklyKilosGained;

        $newWeight = $body->weight + $totalKilosGainedOverPeriod; //new weight after period

        //TODO: CALCULATE GAINED FAT % AND ADD TO CURRENT FAT %

        $fatInKg = ($body->body_fat_percentage / 100) * $body->weight; // fat in weight (kg)
        $newFatInKg = $totalKilosGainedOverPeriod + $fatInKg; // fat new weight (kg)

        $newkg = $fatInKg + $newWeight;

        $newBodyFatPercent = $newFatInKg / $newkg * 100;

        $newBody = $body->replicate()->fill([
            'weight' => $newWeight,
            'body_fat_percentage' => $newBodyFatPercent,
        ]);

        return $newBody;
    }
}
