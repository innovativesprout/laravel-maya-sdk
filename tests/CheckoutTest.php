<?php

namespace Iss\LaravelMayaSdk\Tests;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Str;
use Iss\LaravelMayaSdk\Facades\Maya;

class CheckoutTest extends TestCase
{
    /** @test */
    public function it_can_process_checkout()
    {
        $faker = Factory::create();
        $item = Maya::item();
        $quantity = $faker->randomNumber(1);
        $price = $faker->randomDigit();

        $buyer = Maya::buyer();
        $gender = ['M', 'F'];


        $billingAddress = Maya::billingAddress();
        $billingAddress->setLine1($faker->streetSuffix)
            ->setLine2($faker->streetName)
            ->setCity($faker->city)
            ->setState($faker->city)
            ->setZipCode($faker->postcode)
            ->setCountryCode($faker->countryCode);

        $shippingAddress = Maya::shippingAddress();
        $shippingAddress->setLine1($faker->streetSuffix)
            ->setLine2($faker->streetName)
            ->setCity($faker->city)
            ->setState($faker->city)
            ->setZipCode($faker->postcode)
            ->setCountryCode($faker->countryCode);


        $buyer->setFirstName($faker->firstName)
            ->setLastName($faker->lastName)
            ->setMiddleName($faker->lastName)
            ->setSex($gender[rand(0, 1)])
            ->setEmail($faker->safeEmail)
            ->setPhone($faker->phoneNumber)
            ->setBirthday(Carbon::today()->subYears($faker->randomNumber(1))->format('Y-m-d'))
            ->setShippingAddress($shippingAddress->get())
            ->setBillingAddress($billingAddress->get());

        $redirect = Maya::redirect();
        $redirect->setCancel($faker->url)
            ->setFailure($faker->url)
            ->setSuccess($faker->url);

        $item->addItem([
            "name" => (string) $faker->word(),
            "code" => (string) $faker->randomNumber(8),
            "description" => (string) $faker->text(5),
            "quantity" => (string) $quantity,
            "amount" => [
                "value" => $price
            ],
            "totalAmount" => [
                "value" => $price * $quantity
            ]
        ]);

        $totalAmount = Maya::totalAmount();
        $totalAmount->setItems($item->getItems());
        $totalAmount->setCurrency('PHP');
        $totalAmount->setDiscount('100.00');
        $totalAmount->setServiceCharge('100.00');
        $totalAmount->setShippingFee('100.00');
        $totalAmount->setTax('20.00');

        $custom_uuid = Str::uuid();
        $parameters = [
            "totalAmount" => $totalAmount->get(),
            "items" => $item->getItems(),
            "buyer" => $buyer->get(),
            "redirectUrl" => $redirect->getRedirectUrls(),
            "requestReferenceNumber" => $custom_uuid
        ];

        $checkout = Maya::checkout();
        $response = $checkout->checkout($parameters);

        $this->assertNotEmpty($response);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertTrue($response['code'] == 200);
        $this->assertArrayHasKey('checkoutId', $response['data']);
        $this->assertArrayHasKey('redirectUrl', $response['data']);
    }


}
