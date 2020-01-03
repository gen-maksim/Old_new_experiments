<?php

namespace Tests\Feature;

use App\Training;
use App\User;
use Tests\TestCase;

class TrainingRequestTest extends TestCase
{

    /** @test */
    public function user_can_store_a_training()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $training_duration = $this->faker()->numberBetween(120, 600);

        $this->post(route('trainings.store'), [
            'owner_id' => $user->id,
            'duration_in_mins' => $training_duration,
            'start_datetime' => \Carbon\Carbon::now()->addDays(5),
            'max_participants' => 3,
        ])->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('trainings', ['duration_in_mins' => $training_duration]);
    }

    /** @test */
    public function user_can_delete_a_training()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $training = factory(Training::class)->create(['owner_id' => $user->id]);
        $user->attend($training);
        $this->assertNotEmpty($user->trainings, "user doesn't have any training, but supposed to");

        $this->delete(route('trainings.destroy', $training->id))->assertSessionDoesntHaveErrors();

        $user->refresh();
        $this->assertEmpty($user->trainings, 'user has some trainings, but he should not');
    }

    /** @test */
    public function user_can_see_a_training()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $training = factory(Training::class)->create(['owner_id' => $user->id]);
        $user->attend($training);

        $response = $this->get(route('trainings.show', $training->id));

        $this->assertEquals($training->id, $response->json('data.training.id'));
    }

    /** @test */
    public function user_can_see_all_trainings()
    {
        $trainings = factory(Training::class, 10)->create();

        $response = $this->get(route('trainings.index'));

        $this->assertCount(10, $response->viewData('trainings'));
    }
}
