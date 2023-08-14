<?php

return [
    "environment" => "sandbox",
    "api_url" => "https://pg.maya.ph",
    "web_url" => "https://payments.maya.ph",
    "public_key" => env('MAYA_PUBLIC_KEY', ""),
    "private_key" => env('MAYA_PRIVATE_KEY', ""),

    "sandbox_api_url" => "https://pg-sandbox.paymaya.com",
    "sandbox_web_url" => "https://payments.maya.ph",

    "sandbox_public_key" => env("MAYA_PUBLIC_KEY_SANDBOX","pk-yaj6GVzYkce52R193RIWpuRR5tTZKqzBWsUeCkP9EAf"),
    "sandbox_private_key" => env("MAYA_PRIVATE_KEY_SANDBOX","sk-8MqXdZYWV9UJB92Mc0i149CtzTWT7BYBQeiarM27iAi"),

    "services" => [
        "checkout" => [
            "url" => "/checkout/v1/checkouts",
            "auth_type" => "public_key"
        ],
        "webhook" => [
            "url" => "/payments/v1/webhooks",
            "auth_type" => "private_key"
        ],
        "customization" => [
            "url" => "/payments/v1/customizations",
            "auth_type" => "private_key"
        ],
        "ping" => [
            "url" => "/p3/util/ping",
            "auth_type" => "private_key"
        ],
        "singlePayment" => [
            "url" => "/payby/v2/paymaya/payments",
            "auth_type" => "public_key"
        ]
    ]
];
