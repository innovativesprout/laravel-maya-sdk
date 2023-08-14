<?php

namespace Iss\LaravelMayaSdk\Tests;

use Faker\Factory;
use Illuminate\Support\Facades\Http;
use Iss\LaravelMayaSdk\Facades\Maya;

class WebhookTest extends TestCase
{

    public function init()
    {
        $response = Maya::webhook()->get();
        return $response['data'];
    }

    /** @test */
    public function it_can_get_all_webhooks()
    {

        $webhooks = $this->init();
        $response = Maya::webhook()->get();

        $this->assertNotEmpty($response);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertTrue($response['code'] == 200);
        $this->assertTrue(isset($response['data'][0]));
        $this->assertArrayHasKey('id', (array) $response['data'][0]);
        $this->assertArrayHasKey('name', (array) $response['data'][0]);
        $this->assertArrayHasKey('callbackUrl', (array) $response['data'][0]);
        $id = (array) $response['data'][0];
        $this->assertEquals($webhooks[0]->id, $id['id']);
    }


    /** @test */
    public function it_can_create_webhook()
    {

        Http::fake(['*' => Http::response([
            "id" => "954cd5a7-1316-4ea1-a014-8f848bd87726",
            "name" => "PAYMENT_SUCCESS",
            "callbackUrl" => "http://www.merchantsite.com/success",
            "createdAt" => "2021-07-05T15:11:53.000Z",
            "updatedAt" => "2021-07-05T15:11:53.000Z"
        ], 200)]);

        $faker = Factory::create();
        $response = Maya::webhook()->for("PAYMENT_SUCCESS")->create( $faker->url() . '/success');

        $this->assertNotEmpty($response);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertTrue($response['code'] == 200);
        $this->assertArrayHasKey('id', $response['data']);
        $this->assertArrayHasKey('name', $response['data']);
        $this->assertArrayHasKey('callbackUrl', $response['data']);

    }

    /** @test */
    public function it_can_get_webhook()
    {
        $webhooksData = $this->init();
        $response = Maya::webhook()->getById($webhooksData[0]->id);

        $this->assertNotEmpty($response);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertTrue($response['code'] == 200);
        $this->assertArrayHasKey('id', $response['data']);
        $this->assertArrayHasKey('name', $response['data']);
        $this->assertArrayHasKey('callbackUrl', $response['data']);
        $this->assertEquals($webhooksData[0]->id, $response['data']['id']);


    }

    /** @test */
    public function it_can_update_webhook()
    {
        $webhooksData = $this->init();
        $faker = Factory::create();
        $response = Maya::webhook()->update($webhooksData[0]->id, $faker->url);
        $this->assertNotEmpty($response);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertTrue($response['code'] == 200);
        $this->assertArrayHasKey('id', $response['data']);
        $this->assertArrayHasKey('name', $response['data']);
        $this->assertArrayHasKey('callbackUrl', $response['data']);
        $this->assertEquals($webhooksData[0]->id, $response['data']['id']);
    }


    /** @test */
    public function it_can_delete_webhook()
    {
        $webhooksData = $this->init();

        Http::fake(['*' => Http::response([
            "id" => "954cd5a7-1316-4ea1-a014-8f848bd87726",
            "name" => "PAYMENT_SUCCESS",
            "callbackUrl" => "http://www.merchantsite.com/success",
            "createdAt" => "2021-07-05T15:11:53.000Z",
            "updatedAt" => "2021-07-05T15:11:53.000Z"
        ], 200)]);

        $response = Maya::webhook()->delete($webhooksData[0]->id);
        $this->assertNotEmpty($response);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertTrue($response['code'] == 200);
        $this->assertArrayHasKey('id', $response['data']);
        $this->assertArrayHasKey('name', $response['data']);
        $this->assertArrayHasKey('callbackUrl', $response['data']);
        $this->assertEquals("954cd5a7-1316-4ea1-a014-8f848bd87726", $response['data']['id']);
    }

}
