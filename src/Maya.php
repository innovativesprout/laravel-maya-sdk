<?php

namespace Iss\LaravelMayaSdk;

use Iss\LaravelMayaSdk\Services\BillingAddress;
use Iss\LaravelMayaSdk\Services\Buyer;
use Iss\LaravelMayaSdk\Services\Customization;
use Iss\LaravelMayaSdk\Services\Item;
use Iss\LaravelMayaSdk\Services\MayaCheckout;
use Iss\LaravelMayaSdk\Services\MayaClient;
use Iss\LaravelMayaSdk\Services\Redirect;
use Iss\LaravelMayaSdk\Services\ShippingAddress;
use Iss\LaravelMayaSdk\Services\TotalAmount;
use Iss\LaravelMayaSdk\Services\Wallet;
use Iss\LaravelMayaSdk\Services\Webhook;

class Maya
{
    public function client(): MayaClient
    {
        return new MayaClient;
    }

    public function billingAddress(): BillingAddress
    {
        return new BillingAddress;
    }

    public function buyer(): Buyer
    {
        return new Buyer;
    }

    public function customization(): Customization
    {
        return new Customization;
    }

    public function item(): Item
    {
        return new Item;
    }

    public function checkout(): MayaCheckout
    {
        return new MayaCheckout;
    }

    public function redirect(): Redirect
    {
        return new Redirect;
    }

    public function shippingAddress(): ShippingAddress
    {
        return new ShippingAddress;
    }

    public function totalAmount(): TotalAmount
    {
        return new TotalAmount;
    }

    public function webhook(): Webhook
    {
        return new Webhook;
    }

    public function wallet(): Wallet
    {
        return new Wallet;
    }
}
