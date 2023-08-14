<?php namespace Iss\LaravelMayaSdk\Services;
class MayaCheckout{

    public function checkout($parameters = [])
    {
        return (new MayaClient)->setRequestMethod('POST')->setService('checkout')->send($parameters);
    }
}
