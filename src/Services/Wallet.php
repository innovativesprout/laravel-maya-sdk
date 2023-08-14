<?php namespace Iss\LaravelMayaSdk\Services;


class Wallet{

    public function createSinglePayment($parameters = [])
    {
        return (new MayaClient)->setRequestMethod('POST')->setService('singlePayment')->send($parameters);
    }

}
