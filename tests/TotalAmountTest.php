<?php

namespace Iss\LaravelMayaSdk\Tests;

use Faker\Factory;
use Iss\LaravelMayaSdk\Facades\Maya;

class TotalAmountTest extends TestCase
{
    /** @test */
    public function it_can_add_total_amount_object()
    {
        $faker = Factory::create();
        $item = Maya::item();
        $quantity = $faker->randomNumber(1);
        $price = $faker->randomDigit();

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

        $this->assertNotEmpty($totalAmount->get());
    }


}
