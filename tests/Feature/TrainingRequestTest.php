<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrainingRequestTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /** @test */
    public function user_can_store_a_training()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $training_duration = $this->faker()->numberBetween(120, 600);

        $this->post(route('training.store'), [
            'owner_id' => $user->id,
            'duration_in_mins' => $training_duration,
            'start_datetime' => \Carbon\Carbon::now()->addDays(5),
            'max_participants' => 3,
        ]);

        $this->assertDatabaseHas('trainings', ['duration_in_mins' => $training_duration]);
    }
}
