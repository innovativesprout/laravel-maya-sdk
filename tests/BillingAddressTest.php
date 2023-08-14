<?php

namespace Iss\LaravelMayaSdk\Tests;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Str;
use Iss\LaravelMayaSdk\Facades\Maya;

class BillingAddressTest extends TestCase
{

    protected $billingAddress;

    public function billingAddress(): void
    {
        $faker = Factory::create();
        $this->billingAddress = Maya::billingAddress();
        $this->billingAddress->setLine1($faker->streetSuffix)
            ->setLine2($faker->streetName)
            ->setCity($faker->city)
            ->setState($faker->city)
            ->setZipCode($faker->postcode)
            ->setCountryCode($faker->countryCode);
    }

    /** @test */
    public function it_can_set_billing_address_details()
    {
        $this->billingAddress();
        $this->assertIsArray($this->billingAddress->get());
        $this->assertArrayHasKey('line2', $this->billingAddress->get());
        $this->assertArrayHasKey('zipCode', $this->billingAddress->get());
        $this->assertArrayHasKey('countryCode', $this->billingAddress->get());
    }

    /** @test */
    public function it_can_get_billing_address_details()
    {
        $this->billingAddress();
        $this->assertIsArray($this->billingAddress->get());
    }

}
