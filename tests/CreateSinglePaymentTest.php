<?php

namespace Iss\LaravelMayaSdk\Tests;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Iss\LaravelMayaSdk\Facades\Maya;

class CreateSinglePaymentTest extends TestCase
{
    /** @test */
    public function it_can_create_single_payment()
    {
        $faker = Factory::create();
        $redirect = Maya::redirect();
        $redirect->setCancel($faker->url)
            ->setFailure($faker->url)
            ->setSuccess($faker->url);

        Http::fake(['https://pg-sandbox.paymaya.com/payby/v2/paymaya/payments' => Http::response([
            "paymentId" => "c3373b0c-decc-48bd-995d-ddcb0688f7ca",
            "redirectUrl" => "https://payments-web-sandbox.paymaya.com/paymaya/payment?id=c3373b0c-decc-48bd-995d-ddcb0688f7ca"
        ], 200)]);

        $totalAmount = Maya::totalAmount();
        $totalAmount->setCurrency('PHP');
        $totalAmount->setAmount("100");

        $custom_uuid = Str::uuid();
        $parameters = [
            "totalAmount" => $totalAmount->get(),
            "redirectUrl" => $redirect->getRedirectUrls(),
            "requestReferenceNumber" => $custom_uuid
        ];

        $wallet = Maya::wallet();
        $response = $wallet->createSinglePayment($parameters);

        $this->assertNotEmpty($response);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertTrue($response['code'] == 200);
        $this->assertArrayHasKey('paymentId', $response['data']);
        $this->assertArrayHasKey('redirectUrl', $response['data']);
    }


}
