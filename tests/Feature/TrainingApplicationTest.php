<?php

namespace Tests\Feature;

use App\Training;
use App\TrainingApplication;
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
}
