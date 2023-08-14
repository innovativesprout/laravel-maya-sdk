<?php

namespace Iss\LaravelMayaSdk\Tests;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Str;
use Iss\LaravelMayaSdk\Facades\Maya;

class BuyerTest extends TestCase
{

    protected $buyer;

    public function buyer(): void
    {
        $faker = Factory::create();
        $buyer = Maya::buyer();
        $gender = ['M', 'F'];
        $buyer->setFirstName($faker->firstName)
            ->setLastName($faker->lastName)
            ->setMiddleName($faker->lastName)
            ->setSex($gender[rand(0, 1)])
            ->setEmail($faker->safeEmail)
            ->setPhone((string) $faker->phoneNumber)
            ->setBirthday(Carbon::today()->subYears($faker->randomNumber(1))->format('Y-m-d'));

        $this->buyer = $buyer;
    }

    /** @test */
    public function it_can_set_buyer_details()
    {
        $this->buyer();
        $this->assertIsArray($this->buyer->get());
        $this->assertArrayHasKey('firstName', $this->buyer->get());
        $this->assertArrayHasKey('lastName', $this->buyer->get());
        $this->assertArrayHasKey('contact', $this->buyer->get());
    }

    /** @test */
    public function it_can_get_buyer_details()
    {
        $this->buyer();
        $this->assertIsArray($this->buyer->get());
    }

}
