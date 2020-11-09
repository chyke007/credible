<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        \Artisan::call('passport:install',['-vvv' => true]);
        $this->seed();
    }
}
