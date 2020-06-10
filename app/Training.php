<?php

namespace App;

use App\Notifications\ParticipantLeft;
use App\Notifications\TrainingWasCanceled;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;

class Training extends Model
{
    use SoftDeletes;

    protected $fillable = ['owner_id', 'max_participants', 'description', 'start_datetime', 'duration_in_mins', 'type', 'training_place_id'];

    protected $appends = ['participants_progress', 'jym_name', 'owner_name', 'can_be_applied'];

    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($training) {
            $training->involve($training->owner_id);
        });
    }

    protected $attributes = [
        'max_participants' => 2,
    ];

    /**
     * @param array|int $user_id
     * @return Training
     */
    public function involve($user_id)
    {
        if ($this->canInvolveThoseParticipants($user_id))
        {
            $this->participants()->attach($user_id);
        }

        return $this;
    }

    /**
     * @param array|int $user_id
     * @return Training
     */
    public function exclude($user_id)
    {
        $this->participants()->detach($user_id);

        Notification::send($this->participants, new ParticipantLeft($user_id, $this));

        return $this;

    }

    public function guests()
    {
        return $this->participants()->where('user_id', '!=', $this->owner_id);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class);
    }

    public function applications()
    {
        return $this->hasMany(TrainingApplication::class);
    }

    public function active_applications()
    {
        return $this->applications()->where('state', 1);
    }

    public function getParticipantsProgressAttribute()
    {
        return $this->participants()->count() . '/' . $this->max_participants . " ({$this->active_applications_count})";
    }

    public function takePlace($place)
    {
        $this->training_place()->associate($place);
        $this->save();
    }

    public function training_place()
    {
        return $this->belongsTo(TrainingPlace::class)->withDefault(new TrainingPlace());
    }

    public function getJymNameAttribute()
    {
        return $this->training_place->name;
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function getOwnerNameAttribute()
    {
        return $this->owner->name;
    }

    public function cancel()
    {
        Notification::send($this->guests, new TrainingWasCanceled($this));
        $this->participants()->detach();

        $this->delete();
    }

    public function canBeApplied()
    {
        return !$this->applications()->where('user_id', auth()->id())->where('state', '!=', 3)->exists() and $this->owner_id != auth()->id();
    }

    public function getCanBeAppliedAttribute()
    {
        return $this->canBeApplied();
    }

    /**
     * @return bool
     */
    private function canInvolveThoseParticipants($user_id)
    {
        //check if any of them are already participate
        $users = is_int($user_id) ? collect($user_id) : $user_id;
        foreach ($users as $user) {
            if ($this->participants()->where('user_id', $user)->count()) return false;
        }

        //check if there is a room for those people
        $count = is_int($user_id) ? 1 : count($user_id);
        $current_participants_count = $this->participants()->count();
        $count_after_adding = $current_participants_count + $count;

        return $count_after_adding <= $this->max_participants;
    }
}
