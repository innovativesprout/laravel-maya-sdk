<?php namespace Iss\LaravelMayaSdk\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra{


    protected function getPackageProviders($app)
    {
        return [
            'Iss\LaravelMayaSdk\MayaServiceProvider',
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Maya' => 'Iss\LaravelMayaSdk\Facades\Maya',
        ];
    }

    public function setUp(): void
    {
        parent::setUp();
    }
}