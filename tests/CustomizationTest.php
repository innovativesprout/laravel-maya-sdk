<?php

namespace Iss\LaravelMayaSdk\Tests;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Iss\LaravelMayaSdk\Facades\Maya;

class CustomizationTest extends TestCase
{

    protected $customization;

    public function customization(): void
    {
        $this->customization = Maya::customization();
        $this->customization->setLogoUrl("https://www.merchantsite.com/icon-store.b575c975.svg")
            ->setIconUrl("https://www.merchantsite.com/favicon.ico")
            ->setAppleTouchIconUrl("https://www.merchantsite.com/touch-icon-ipad-retina.png")
            ->setCustomTitle("Merchant Store")
            ->setColorScheme("#85c133")
            ->showReceipt()
            ->skipResultPage()
            ->showMerchantName()
            ->setRedirectTimer(10);
    }

    /** @test */
    public function it_can_set_customization()
    {

        Http::fake(['*' => Http::response([
            "logoUrl" => "https://www.merchantsite.com/icon-store.b575c975.svg",
            "customTitle" => "Merchant Store"
        ], 200)]);

        $this->customization();
        $response = $this->customization->set();

        $this->assertNotEmpty($response);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertTrue($response['code'] == 200);
        $this->assertArrayHasKey('logoUrl', $response['data']);
        $this->assertArrayHasKey('customTitle', $response['data']);
    }

    /** @test */
    public function it_can_retrieve_customization()
    {
        Http::fake(['*' => Http::response([
            "logoUrl" => "https://www.merchantsite.com/icon-store.b575c975.svg",
            "customTitle" => "Merchant Store"
        ], 200)]);

        $this->customization();
        $response = $this->customization->get();

        $this->assertNotEmpty($response);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertTrue($response['code'] == 200);
        $this->assertArrayHasKey('logoUrl', $response['data']);
        $this->assertArrayHasKey('customTitle', $response['data']);
    }

    /** @test */
    public function it_can_delete_customization()
    {
        $this->customization();
        Http::fake(['*' => Http::response([], 204)]);
        $response = $this->customization->delete();

        $this->assertNotEmpty($response);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertTrue($response['code'] == 204);
        $this->assertEmpty($response['data']);
    }

}
