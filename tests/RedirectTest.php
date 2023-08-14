<?php

namespace Iss\LaravelMayaSdk\Tests;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Str;
use Iss\LaravelMayaSdk\Facades\Maya;

class RedirectTest extends TestCase
{

    protected $redirect;

    public function redirect(): void
    {
        $faker = Factory::create();
        $this->redirect = Maya::redirect();
        $this->redirect->setCancel($faker->url)
        ->setFailure($faker->url)
        ->setSuccess($faker->url);
    }

    /** @test */
    public function it_can_set_redirect_details()
    {
        $this->redirect();
        $this->assertIsArray($this->redirect->getRedirectUrls());
        $this->assertArrayHasKey('success', $this->redirect->getRedirectUrls());
        $this->assertArrayHasKey('failure', $this->redirect->getRedirectUrls());
        $this->assertArrayHasKey('cancel', $this->redirect->getRedirectUrls());
    }


}
