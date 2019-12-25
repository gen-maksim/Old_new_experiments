<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        DatabaseTransactions,
        WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call("migrate");
    }

    protected function createUser($name)
    {
        return factory(User::class)->create(['name' => $name]);
    }
}
