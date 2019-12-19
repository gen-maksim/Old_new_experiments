<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function attend($training_ids)
    {
        $this->trainings()->attach($training_ids);
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class);
    }

    public function establishedTrainings()
    {
        return $this->hasMany(Training::class, 'owner_id');
    }

    public function applications()
    {
        return $this->hasMany(TrainingApplication::class);
    }

//    public function applicationInbox()
//    {
//        $applications = $this->establishedTrainings()->with('applications')->get()->pluck('applications');
//
//        return $applications;
//    }
}
