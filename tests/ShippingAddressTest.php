<?php

namespace Iss\LaravelMayaSdk\Tests;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Str;
use Iss\LaravelMayaSdk\Facades\Maya;

class ShippingAddressTest extends TestCase
{

    protected $shippingAddress;

    public function shippingAddress(): void
    {
        $faker = Factory::create();
        $this->shippingAddress = Maya::shippingAddress();
        $this->shippingAddress->setLine1($faker->streetSuffix)
            ->setLine2($faker->streetName)
            ->setCity($faker->city)
            ->setState($faker->city)
            ->setZipCode($faker->postcode)
            ->setCountryCode($faker->countryCode);
    }

    /** @test */
    public function it_can_set_shipping_address_details()
    {
        $this->shippingAddress();
        $this->assertIsArray($this->shippingAddress->get());
        $this->assertArrayHasKey('line2', $this->shippingAddress->get());
        $this->assertArrayHasKey('zipCode', $this->shippingAddress->get());
        $this->assertArrayHasKey('countryCode', $this->shippingAddress->get());
    }

    /** @test */
    public function it_can_get_shipping_address_details()
    {
        $this->shippingAddress();
        $this->assertIsArray($this->shippingAddress->get());
    }

}
