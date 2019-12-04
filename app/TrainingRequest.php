<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingRequest extends Model
{
    protected $fillable = ['user_id', 'training_id', 'comment'];
}
