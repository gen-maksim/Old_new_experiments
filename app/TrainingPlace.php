<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingPlace extends Model
{
    protected $fillable = ['name', 'description', 'address'];

    public function trainings()
    {
        return $this->hasMany(Training::class);
    }
}
