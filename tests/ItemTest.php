<?php

namespace Iss\LaravelMayaSdk\Tests;

use Faker\Factory;
use Iss\LaravelMayaSdk\Facades\Maya;

class ItemTest extends TestCase
{
    /** @test */
    public function it_can_add_item()
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

        $this->assertNotEmpty($item->getItems());
    }

    /** @test */
    public function it_can_update_item_with_the_same_code()
    {
        $faker = Factory::create();
        $item = Maya::item();
        $quantity = $faker->randomNumber(1);
        $price = $faker->randomDigit();
        $code = (string) $faker->randomNumber(8);

        $item->addItem([
            "name" => (string) $faker->word(),
            "code" => $code,
            "description" => (string) $faker->text(5),
            "quantity" => (string) $quantity,
            "amount" => [
                "value" => $price
            ],
            "totalAmount" => [
                "value" => $price * $quantity
            ]
        ]);


        $quantity = $faker->randomNumber(1);
        $item->addItem([
            "name" => (string) $faker->word(),
            "code" => $code,
            "description" => (string) $faker->text(5),
            "quantity" => (string) $quantity,
            "amount" => [
                "value" => $price
            ],
            "totalAmount" => [
                "value" => $price * $quantity
            ]
        ]);

        $this->assertIsArray($item->getItems());
        $this->assertNotEmpty($item->getItems());
        $this->assertCount(1, $item->getItems());
    }

}
