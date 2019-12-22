<?php

namespace Tests\Feature;

use App\Training;
use App\TrainingApplication;
use App\TrainingPlace;
use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    protected $ivan;

    public function setUp() :void
    {
        parent::setUp();

        $this->ivan = factory(User::class)->create();
    }

    /** @test */
    public function it_can_attend_training()
    {
        $training = factory(Training::class)->create();

        $this->ivan->attend($training);

        $this->assertEquals($training->id, $this->ivan->trainings->first()->id);
    }

    /** @test */
    public function it_can_has_many_trainings_planned()
    {
        $training = factory(Training::class, 2)->create();

        $this->ivan->attend($training);

        $this->assertEquals($training->pluck('id'), $this->ivan->trainings->pluck('id'));
    }


    /** @test */
    public function it_can_see_all_trainings_in_specific_place()
    {
        $ivan = factory(User::class)->create();
        $mark = factory(User::class)->create();
        $climbing_jym = factory(TrainingPlace::class)->create();

        $ivan_training = factory(Training::class)->create();
        $mark_training = factory(Training::class)->create();

        $ivan->attend($ivan_training);
        $ivan_training->takePlace($climbing_jym->id);
        $ivan_training->save();

        $ivan->attend($mark_training);
        $mark_training->takePlace($climbing_jym->id);
        $mark_training->save();

        $this->assertCount(2, $climbing_jym->trainings);
    }


    /** @test */
    public function it_gets_redirect_to_trainings_after_login()
    {
        $this->actingAs($this->ivan);

        $this->get(route('login'))->assertRedirect(route('trainings.index'));
    }

    /** @test */
    public function it_can_get_information_about_user()
    {
        $this->actingAs($this->ivan);

        $another_user = factory(User::class)->create();

        $response = $this->get(route('user.profile', $this->ivan->id))->assertSessionDoesntHaveErrors();

        $this->assertEquals($response->json('name'), $this->ivan->name);
    }

    /** @test */
    public function it_can_view_own_trainings()
    {
        //it includes trainings it participate and ones it creates (owns)

        $user_created_trainings = factory(Training::class, 2)->create(['owner_id' => $this->ivan->id]);

        $trainings_participated = factory(Training::class, 3)->create();
        $this->ivan->attend($trainings_participated->push($user_created_trainings->first()));

        $other_trainings = factory(Training::class, 5)->create();

        $response = $this->get(route('user.trainings', $this->ivan->id))->assertSessionDoesntHaveErrors();

        $this->assertCount(4, $response->json('trainings'));
    }

    /** @test */
    public function it_can_access_own_applications()
    {
        factory(TrainingApplication::class)->create(['user_id' => $this->ivan->id]);

        $this->assertNotEmpty($this->ivan->applications);
    }


    /** @test */
    public function it_can_see_trainings_it_owns()
    {
        factory(Training::class, 3)->create(['owner_id' => $this->ivan]);

        $this->assertCount(3, $this->ivan->establishedTrainings);
    }

    /** @test */
    public function it_can_access_application_inbox()
    {
        $training = factory(Training::class)->create(['owner_id' => $this->ivan->id]);
        factory(TrainingApplication::class)->create(['training_id' => $training->id]);

        $this->assertNotEmpty($this->ivan->applicationInbox());
    }

    /** @test */
    public function it_can_apply_for_a_training()
    {
        $bob = factory(User::class)->create();
        $training = factory(Training::class)->create(['owner_id' => $this->ivan->id]);

        $bob->applyFor($training, 'please, let me participate');

        $this->assertEquals($training->id, $bob->applications->last()->training->id);
    }
}
