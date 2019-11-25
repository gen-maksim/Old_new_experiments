<?php

namespace Tests\Feature;

use App\Training;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrainingTest extends TestCase
{
    protected $training;

    public function setUp() :void
    {
        parent::setUp();

        $this->training = factory(Training::class)->create();
    }

    //it really can involve them by its own???
    /** @test */
    public function it_can_involve_one_user()
    {
        $ivan = factory(User::class)->create();

        $this->training->involve($ivan->id);

        $this->assertEquals($ivan->name, $this->training->participants->first()->name);
    }

    /** @test */
    public function it_can_involve_multiple_users_at_once()
    {
        $party = factory(User::class, 2)->create();

        $this->training->involve($party->pluck('id'));

        $this->assertEquals($party->pluck('name'), $this->training->participants->pluck('name'));
    }
}
