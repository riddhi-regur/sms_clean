<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'code',
        'duration',
        'fees',
        'department_id',
        'description',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // public function classrooms()
    // {
    //     return $this->hasMany(Classroom::class);
    // }

    // public function students()
    // {
    //     return $this->hasMany(Student::class);
    // }
}
