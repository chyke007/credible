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
        \Artisan::call('transfer:cron',['-vvv' => true]);
    
        $this->seed();
    }
    public function tearDown(): void
    {
        \Artisan::call('transfer:cron',['-vvv' => true]);
    }
}
