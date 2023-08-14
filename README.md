<br/>
<p align="center">
  <a href="https://github.com/innovativesprout/laravel-maya-sdk">
    <img src="https://github.com/innovativesprout/laravel-maya-sdk/blob/main/MayaLaravelPackage.png" alt="Logo">
  </a>
</p>

<h3 align="center">Laravel Maya SDK</h3>

<p align="center">
    Laravel Package that will handle the Maya Payments / Checkout and other Maya API
    <br/>
    <br/>
    <a href="https://github.com/innovativesprout/laravel-maya-sdk/issues">Request Feature</a>
</p>

![Downloads](https://img.shields.io/github/downloads/innovativesprout/laravel-maya-sdk/total) ![Contributors](https://img.shields.io/github/contributors/innovativesprout/laravel-maya-sdk?color=dark-green) ![Issues](https://img.shields.io/github/issues/innovativesprout/laravel-maya-sdk) ![License](https://img.shields.io/github/license/innovativesprout/laravel-maya-sdk)

## Table Of Contents

* [What It Does](#what-it-does)
* [Getting Started](#getting-started)
    * [Installation](#installation)
* [Usage](#usage)
    * [Adding An Item](#adding-an-item)
    * [Customer Shipping](#customer-shipping-address)
    * [Customer Billing](#customer-billing-address)
    * [Buyer Details](#buyers-details)
    * [Redirect URLs](#redirect-urls)
    * [Checkout](#checkout)
    * [Webhook Management](#webhooks-management)
        * [Get All Webhook](#get-all-webhooks)
        * [Create New Webhook](#create-new-webhook)
        * [Get Webhook](#get-webhook)
        * [Update Webhook](#update-webhook)
        * [Delete Webhook](#delete-webhook)
    * [Customizations](#customizations)
* [Roadmap](#roadmap)
* [Contributing](#contributing)
    * [Etiquette](#etiquette)
    * [Viability](#viability)
    * [Procedure](#procedure)
* [Credits](#credits)
* [License](#license)

## What It Does

This package allows you manage your customer checkouts, webhooks, and other payments using Maya API.

#### Supported Features:

- Checkout
- Wallet
  - Create Single Payment
- Webhooks
- Customizations

#### Next Release:

- Payment Transactions
- Card Payment Vault
- Wallet
- QR

## Getting Started

This is how you can install or use the library.

### Installation

1. Install Maya Payment to your Laravel Application

```bash
  composer require iss/laravel-maya-sdk
```

2. Publish the configuration

```bash
  php artisan vendor:publish --tag=maya
```

3. In your `config/maya.php`, add your `public_key` and `private_key` from your PayMaya account.
#### config/maya.php
```php
return [
    "public_key" => env('MAYA_PUBLIC_KEY', ""),
    "private_key" => env('MAYA_PRIVATE_KEY', ""),

   // other configurations...
];
```

## Usage
Integrate to your Laravel Application.

### Adding an Item

```php
use Iss\LaravelMayaSdk\Facades\Maya;


$itemService = Maya::item();
$itemService->addItem([
    "amount" => [
        "value" => 1200
    ],
    "totalAmount" => [
        "value" => 1200
    ],
    "name" => "Shoes",
    "code" => "SHOE-1",
    "description" => "Nike Shoes",
    "quantity" => "1"
]);

```

### Calculating the total amount, discounts, shipping fee and other charges

```php
use Iss\LaravelMayaSdk\Facades\Maya;
```

You need to pass the `Maya::item()->getItems()` to calculate the total amount.

```php

$itemService = Maya::item();
$totalAmountService = Maya::totalAmount();

$totalAmountService->setItems($itemService->getItems());
$totalAmountService->setDiscount("0.05");
$totalAmountService->setCurrency("PHP");
$totalAmountService->setServiceCharge("100");
$totalAmountService->setShippingFee("250");
$totalAmountService->setTax("100");
```

or

```php

$totalAmountService = Maya::totalAmount();

$totalAmountService->setItems(Maya::item()->getItems());
$totalAmountService->setDiscount("0.05");
$totalAmountService->setCurrency("PHP");
$totalAmountService->setServiceCharge("100");
$totalAmountService->setShippingFee("250");
$totalAmountService->setTax("100");
```

To get the totalAmount object you can call the `get()` method:
```php
return $totalAmountService->get();
```

Result:
```php
[
    "currency" => "PHP",
    "value" => 1649.95, // float
    "details" => [
        "discount" => "0.05",
        "serviceCharge" => "100",
        "shippingFee" => "250",
        "tax" => "100",
        "subtotal" => "1200"
    ]
];
```

### Customer Shipping Address

```php
use Iss\LaravelMayaSdk\Facades\Maya;


$shippingService = Maya::shippingAddress();
$shippingService->setFirstName('Test First Name')
    ->setLastName('Test Last Name')
    ->setPhone('+63912345678')
    ->setEmail('client@innovativesprout.com')
    ->setCity('Test City')
    ->setLine1('Test Line 1')
    ->setLine2('Test Line 2')
    ->setState('Test State')
    ->setZipCode("2222")
    ->setCountryCode("PH");
```


### Customer Billing Address

```php
use Iss\LaravelMayaSdk\Facades\Maya;

$billingService = Maya::billingAddress();
$billingService->setLine1('Test Line 1');
$billingService->setLine2('Test Line  2');
$billingService->setCity('Test City');
$billingService->setState('Test State');
$billingService->setZipCode("2222");
$billingService->setCountryCode("PH");
```

### Buyer's Details

```php
use Iss\LaravelMayaSdk\Facades\Maya;

$buyerService = Maya::buyer();
$buyerService->setFirstName('Jerson')
    ->setLastName('Ramos')
    ->setEmail('jerson@innovativesprout.com')
    ->setPhone('+639052537600');
```

To add shipping / billing address to the buyer, you can use this:

#### For shipping address:
```php
$buyerService->setShippingAddress(Maya::shippingAddress()->get());
```

#### For billing address:
```php
$buyerService->setBillingAddress(Maya::billingAddress()->get());
```

### Redirect URLs

You can use route name from your `web.php` or `api.php` file or use static URL with parameters.

The `$custom_uuid` is from your order's table or any reference ID from your application.

```php
use Iss\LaravelMayaSdk\Facades\Maya;


$redirectService = Maya::redirect();
$redirectService->setCancel(route('checkout.cancel') . '?id=' . $custom_uuid);
$redirectService->setFailure(route('checkout.failure') . '?id=' . $custom_uuid);
$redirectService->setSuccess(route('checkout.success') . '?id=' . $custom_uuid);
```

### Checkout

Build body request for your checkout based on our created objects above.

```php

$parameters = [
    "totalAmount" => Maya::totalAmount()->get(),
    "items" => Maya::item()->getItems(),
    "buyer" => Maya::buyer()->get(),
    "redirectUrl" => Maya::redirect()->getRedirectUrls(),
    "requestReferenceNumber" => $custom_uuid
];

$checkoutService = Maya::checkout();
return $checkoutService->checkout($parameters);

```

#### Array Response from Maya Checkout Request:
```php
[
  "data" => [
    'checkoutId' => '',
    'redirectUrl' => ''
  ],
  "code" => 200,
  "message" => "success",
]
```

## Webhooks Management

Use the `MayaWebhook` by injecting the facade to your application and to be able to manage your webhooks.

```php
use Iss\LaravelMayaSdk\Facades\Maya;
```

### Get All Webhooks
```php
return Maya::webhook()->get();
```
#### Response:
```php
[
  "data" => [
    {
        "id": "7549dd53-38fb-49b9-9ad8-af6223937e92",
        "name": "PAYMENT_FAILED",
        "callbackUrl": "https://store-philippines.worldcup.basketball?wc-api=cynder_paymaya_payment",
        "createdAt": "2023-04-24T06:57:35.000Z",
        "updatedAt": "2023-04-24T06:57:35.000Z"
    },
    {
        "id": "e63c832b-e9dc-426e-831f-6756bbd33bbc",
        "name": "PAYMENT_EXPIRED",
        "callbackUrl": "https://store-philippines.worldcup.basketball?wc-api=cynder_paymaya_payment",
        "createdAt": "2023-04-24T06:57:30.000Z",
        "updatedAt": "2023-04-24T06:57:30.000Z"
    }
],
  "code" => 200,
  "message" => "success",
]
```

### Create New Webhook

The supported events that you can pass through `for` method are the following: <br>

`AUTHORIZED`,`PAYMENT_SUCCESS`,`PAYMENT_FAILED`,`PAYMENT_EXPIRED`,`PAYMENT_CANCELLED`,`3DS_PAYMENT_SUCCESS`,`3DS_PAYMENT_FAILURE`,`3DS_PAYMENT_DROPOUT`,`RECURRING_PAYMENT_SUCCESS`,`RECURRING_PAYMENT_FAILURE`,`CHECKOUT_SUCCESS`,`CHECKOUT_FAILURE`,`CHECKOUT_DROPOUT`,`CHECKOUT_CANCELLED`

Pass the `URL` parameter on `create()` method.

```php
return Maya::webhook()->for("PAYMENT_SUCCESS")->create('http://www.merchantsite.com/success');
```

#### Response:
```php
[
  "data" => [
    "id" => "98397531-e6cd-4c5c-ba6c-089546098989",
    "name" => "PAYMENT_SUCCESS",
    "callbackUrl" => "http://www.merchantsite.com/success",
    "createdAt" => "2023-05-07T05:28:27.000Z",
    "updatedAt" => "2023-05-07T05:28:27.000Z"
  ],
  "code" => 200,
  "message" => "success",
]
```

### Get Webhook

Pass the ID of the webhook

```php
return Maya::webhook()->getById('98397531-e6cd-4c5c-ba6c-089546098989');
```

#### Response:
```php
[
  "data" => [
    "id" => "98397531-e6cd-4c5c-ba6c-089546098989",
    "name" => "PAYMENT_SUCCESS",
    "callbackUrl" => "http://www.merchantsite.com/success",
    "createdAt" => "2023-05-07T05:28:27.000Z",
    "updatedAt" => "2023-05-07T05:28:27.000Z"
  ],
  "code" => 200,
  "message" => "success",
]
```

### Update Webhook

Pass the ID of the webhook that you want update and the new `URL`. The `first` parameter will be the ID of the webhook and the `second` parameter will be the new `URL`.


```php
return Maya::webhook()->update('98397531-e6cd-4c5c-ba6c-089546098989', 'http://www.merchantsite.com/success'); 
```

#### Response:
```php
[
  "data" => [
    "id" => "98397531-e6cd-4c5c-ba6c-089546098989",
    "name" => "PAYMENT_SUCCESS",
    "callbackUrl" => "http://www.merchantsite.com/success",
    "createdAt" => "2023-05-07T05:28:27.000Z",
    "updatedAt" => "2023-05-07T05:28:27.000Z"
  ],
  "code" => 200,
  "message" => "success",
]
```

### Delete Webhook

Pass the ID of the webhook that you want to delete.

```php
return Maya::webhook()->delete('98397531-e6cd-4c5c-ba6c-089546098989'); 
```

#### Response:
```php
[
  "data" => [
    "id" => "98397531-e6cd-4c5c-ba6c-089546098989",
    "name" => "PAYMENT_SUCCESS",
    "callbackUrl" => "http://www.merchantsite.com/success",
    "createdAt" => "2023-05-07T05:28:27.000Z",
    "updatedAt" => "2023-05-07T05:28:27.000Z"
  ],
  "code" => 200,
  "message" => "success",
]
```
## Customizations

Use the `MayaCustomization` by injecting the facade to your application.

```php
use Iss\LaravelMayaSdk\Facades\Maya;
```

### Set Customization

Set your `LogoUrl`, `IconUrl`, `AppleTouchIconUrl`, `CustomTitle` and `ColorScheme`. These are the required fields.

#### Helper functions:

- `hideReceipt()` or `showReceipt()` - Indicates if the merchant does not allow its payers to freely send transaction receipts.
- `skipResultPage()` or `doNotSkipResultPage()` - Indicates if the merchant does not want to show the payment result page.
  When skipped, the payment page redirects immediately to the merchant's redirect URL. 
- `showMerchantName()` or `hideMerchantName()` - Indicates if the merchant name on the result page is displayed.

```php
return Maya::customization()->setLogoUrl("https://www.merchantsite.com/icon-store.b575c975.svg")
        ->setIconUrl("https://www.merchantsite.com/favicon.ico")
        ->setAppleTouchIconUrl("https://www.merchantsite.com/touch-icon-ipad-retina.png")
        ->setCustomTitle("Merchant Store")
        ->setColorScheme("#85c133")
        ->showReceipt()
        ->skipResultPage()
        ->showMerchantName()
        ->setRedirectTimer(10)
        ->set();
```

#### Response:
```php
[
  "data" => [
    "logoUrl" => "https://www.merchantsite.com/icon-store.b575c975.svg",
    "iconUrl" => "https://www.merchantsite.com/favicon.ico",
    "appleTouchIconUrl" => "https://www.merchantsite.com/touch-icon-ipad-retina.png",
    "customTitle" => "Merchant Store",
    "colorScheme" => "#85c133",
    "redirectTimer" => 10,
    "hideReceiptInput" => false,
    "skipResultPage" => true,
    "showMerchantName" => true
],
  "code" => 200,
  "message" => "success",
]
```

### Get Customization

```php
return Maya::customization()->get();
```

#### Response:
```php
[
  "data" => [
    "logoUrl" => "https://www.merchantsite.com/icon-store.b575c975.svg",
    "iconUrl" => "https://www.merchantsite.com/favicon.ico",
    "appleTouchIconUrl" => "https://www.merchantsite.com/touch-icon-ipad-retina.png",
    "customTitle" => "Merchant Store",
    "colorScheme" => "#85c133",
    "redirectTimer" => 10,
    "hideReceiptInput" => false,
    "skipResultPage" => true,
    "showMerchantName" => true
],
  "code" => 200,
  "message" => "success",
]
```

### Delete Customization

```php
return Maya::customization()->delete();
```

#### Response:
```php
// Blank Response
```

## Roadmap

See the [open issues](https://github.com/innovativesprout/laravel-maya-sdk/issues) for a list of proposed features (and known issues).

## Contributing

Contributions are welcome and will be fully credited.

Please read and understand the contribution guide before creating an issue or pull request.

### Etiquette
This project is open source, and as such, the maintainers give their free time to build and maintain the source code
held within. They make the code freely available in the hope that it will be of use to other developers. It would be
extremely unfair for them to suffer abuse or anger for their hard work.

Please be considerate towards maintainers when raising issues or presenting pull requests. Let's show the
world that developers are civilized and selfless people.

It's the duty of the maintainer to ensure that all submissions to the project are of sufficient
quality to benefit the project. Many developers have different skillsets, strengths, and weaknesses. Respect the maintainer's decision, and do not be upset or abusive if your submission is not used.

### Viability

When requesting or submitting new features, first consider whether it might be useful to others. Open
source projects are used by many developers, who may have entirely different needs to your own. Think about
whether or not your feature is likely to be used by other users of the project.

### Procedure

Before filing an issue:

- Attempt to replicate the problem, to ensure that it wasn't a coincidental incident.
- Check to make sure your feature suggestion isn't already present within the project.
- Check the pull requests tab to ensure that the bug doesn't have a fix in progress.
- Check the pull requests tab to ensure that the feature isn't already in progress.

Before submitting a pull request:
- Check the codebase to ensure that your feature doesn't already exist.
- Check the pull requests to ensure that another person hasn't already submitted the feature or fix.

## Credits

- [Maya](https://developers.maya.ph/docs)
- [All Contributors](../../contributors)

## License

Distributed under the MIT License. See [LICENSE](https://github.com/innovativesprout/laravel-maya-sdk/blob/main/LICENSE.md) for more information.



