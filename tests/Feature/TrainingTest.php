<?php

namespace Tests\Feature;

use App\Training;
use App\TrainingPlace;
use App\User;
use Tests\TestCase;

class TrainingTest extends TestCase
{
    protected $training;

    public function setUp() :void
    {
        parent::setUp();

        $this->training = factory(Training::class)->create();
    }

    //it really can involve users by its own???
    /** @test */
    public function it_can_involve_one_user()
    {
        $ivan = factory(User::class)->create();

        $this->training->involve($ivan->id);

        $this->assertContains($ivan->name, $this->training->guests->pluck('name'));
    }

    /** @test */
    public function it_can_involve_multiple_users_at_once()
    {
        $party = factory(User::class, 2)->create();
        $ivan = factory(User::class)->create();

        $this->training->involve($party->pluck('id'));
        $this->training->involve($ivan->id);

        $this->assertEquals($party->push($ivan)->pluck('name'), $this->training->guests->pluck('name'));
    }

    /** @test */
    public function it_doesnt_allow_participant_overflow()
    {
        $training = factory(Training::class)->create(['max_participants' => 2]);
        $too_big_party = factory(User::class, 3)->create();
        $training->involve($too_big_party->pluck('id'));

        $this->assertEmpty($training->guests);
    }

    /** @test */
    public function is_allows_to_add_exact_number_of_persons_and_forbid_even_single_person_after()
    {
        //assuming there is already one participant (owner)
        $training = factory(Training::class)->create(['max_participants' => 3]);

        $party = factory(User::class, 2)->create();
        $ivan = factory(User::class)->create();

        $training->involve($party->pluck('id'));
        $training->involve($party->pluck('id'));
        $training->involve($ivan->id);
        $training->involve($ivan->id);

        $this->assertEquals($party->pluck('name'), $training->guests->pluck('name'));
    }

    /** @test */
    public function it_cant_involve_more_participants_than_maximum()
    {
        $party = factory(User::class, 2)->create();

        $this->training->involve($party->pluck('id'));

        $this->assertEquals($party->pluck('name'), $this->training->guests->pluck('name'));
    }

    /** @test */
    public function user_can_invite_a_friend_and_attend_a_training_in_a_specific_place()
    {
        $ivan = $this->createUser('Ivan');
        $mark = $this->createUser('Mark');
        $climbing_jym = factory(TrainingPlace::class)->create();

        //maybe $ivan->invite($mark, $training) is better...
        $this->training->involve($mark->id);
        $this->training->takePlace($climbing_jym->id);

        $ivan->attend($this->training);

        $this->assertEquals($climbing_jym->name, $this->training->training_place->name);

        $participants_id = $this->training->guests->pluck('id')->toArray();

        $guys = array($ivan->id, $mark->id);
        $this->assertTrue($participants_id == sort($guys));
    }

    /** @test */
    public function owner_become_a_participant_by_default()
    {
        $ivan = $this->createUser('Ivan');

        $training = factory(Training::class)->create(['owner_id' => $ivan->id]);

        $this->assertEquals($training->owner_id, $training->participants()->first()->id);
    }
}
