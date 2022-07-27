<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserWorkouts extends Model
{
    use SoftDeletes;

    public function user()
    {
        $this->belongsTo(Account::class, 'user_id');
    }

    public function exercise()
    {
        return $this->belongsTo($this->exercise_type);
    }
}
