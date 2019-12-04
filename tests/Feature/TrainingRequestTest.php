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

        $this->post(route('training.store'), [
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
//
//    /** @test */
//    public function user_can_update_a_training()
//    {
//        $user = factory(User::class)->create();
//        $this->actingAs($user);
//
//        $training_duration = $this->faker()->numberBetween(120, 600);
//
//        $this->post(route('training.store'), [
//            'owner_id' => $user->id,
//            'duration_in_mins' => $training_duration,
//            'start_datetime' => \Carbon\Carbon::now()->addDays(5),
//            'max_participants' => 3,
//        ])->assertSessionDoesntHaveErrors();
//
//        $this->assertDatabaseHas('trainings', ['duration_in_mins' => $training_duration]);
//    }
//
    /** @test */
    public function user_can_see_a_training()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $training = factory(Training::class)->create(['owner_id' => $user->id]);


        $this->get(route('trainings.show', $training->id));


        $this->assertDatabaseHas('trainings', ['duration_in_mins' => 240]);
    }
//
//    /** @test */
//    public function user_can_see_all_trainings_created()
//    {
//        $user = factory(User::class)->create();
//        $this->actingAs($user);
//
//        $training_duration = $this->faker()->numberBetween(120, 600);
//
//        $this->post(route('training.store'), [
//            'owner_id' => $user->id,
//            'duration_in_mins' => $training_duration,
//            'start_datetime' => \Carbon\Carbon::now()->addDays(5),
//            'max_participants' => 3,
//        ])->assertSessionDoesntHaveErrors();
//
//        $this->assertDatabaseHas('trainings', ['duration_in_mins' => $training_duration]);
//    }
//
//    /** @test */
//    public function user_can_see_create_from_for_a_training()
//    {
//        $user = factory(User::class)->create();
//        $this->actingAs($user);
//
//        $training_duration = $this->faker()->numberBetween(120, 600);
//
//        $this->post(route('training.store'), [
//            'owner_id' => $user->id,
//            'duration_in_mins' => $training_duration,
//            'start_datetime' => \Carbon\Carbon::now()->addDays(5),
//            'max_participants' => 3,
//        ])->assertSessionDoesntHaveErrors();
//
//        $this->assertDatabaseHas('trainings', ['duration_in_mins' => $training_duration]);
//    }
//
//    /** @test */
//    public function user_can_see_edit_from_a_training()
//    {
//        $user = factory(User::class)->create();
//        $this->actingAs($user);
//
//        $training_duration = $this->faker()->numberBetween(120, 600);
//
//        $this->post(route('training.store'), [
//            'owner_id' => $user->id,
//            'duration_in_mins' => $training_duration,
//            'start_datetime' => \Carbon\Carbon::now()->addDays(5),
//            'max_participants' => 3,
//        ])->assertSessionDoesntHaveErrors();
//
//        $this->assertDatabaseHas('trainings', ['duration_in_mins' => $training_duration]);
//    }
}
