<?php

namespace Tests\Feature;

use App\Training;
use App\TrainingApplication;
use App\User;
use Tests\TestCase;

class TrainingApplicationTest extends TestCase
{
    /** @test */
    public function it_has_user_and_training_relations()
    {
        $training = factory(Training::class)->create();
        $application = factory(TrainingApplication::class)->create(['training_id' => $training->id]);

        $this->assertEquals($training->id, $application->training->id);
        $this->assertNotNull($application->user);
    }

    /** @test */
    public function user_can_confirm_application_and_add_applicant_to_training_participants()
    {
        $bob = factory(User::class)->create();
        $ivan = factory(User::class)->create();
        $training = factory(Training::class)->create(['owner_id' => $ivan->id]);
        $application = factory(TrainingApplication::class)->create([
            'training_id' => $training->id,
            'user_id' => $bob->id,
            ]);


        $ivan->confirm($application);

        $this->assertContains($bob->id, $training->participants->pluck('id'));
    }
}
