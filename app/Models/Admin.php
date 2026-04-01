<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['name', 'image', 'phone', 'address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
