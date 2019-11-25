<?php

namespace Tests\Feature;

use App\Training;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

        $this->ivan->attend($training->id);

        $this->assertEquals($training->id, $this->ivan->trainings->first()->id);
    }

    /** @test */
    public function it_can_has_many_trainings_planned()
    {
        $training = factory(Training::class, 2)->create();

        $this->ivan->attend($training->pluck('id'));

        $this->assertEquals($training->pluck('id'), $this->ivan->trainings->pluck('id'));
    }
}
