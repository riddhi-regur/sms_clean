<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'image', 'phone', 'address', 'roll_no', 'user_id',  'classroom_id', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
