<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    const ADMIN = 1;

    const STUDENT = 2;

    const FACULTY = 3;

    const ACCOUTANT = 4;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
