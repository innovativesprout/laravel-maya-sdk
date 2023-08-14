<?php namespace Iss\LaravelMayaSdk\Services;


use Illuminate\Support\Str;

class Webhook{

    protected array $supported_events = ["AUTHORIZED", "PAYMENT_SUCCESS", "PAYMENT_FAILED", "PAYMENT_EXPIRED",
        "PAYMENT_CANCELLED", "3DS_PAYMENT_SUCCESS", "3DS_PAYMENT_FAILURE", "3DS_PAYMENT_DROPOUT", "RECURRING_PAYMENT_SUCCESS",
        "RECURRING_PAYMENT_FAILURE", "CHECKOUT_SUCCESS", "CHECKOUT_FAILURE", "CHECKOUT_DROPOUT", "CHECKOUT_CANCELLED"
    ];

    protected ?string $event_name = null;

    public function for(?string $event_name = null): Webhook
    {

        if (is_null($event_name)){
            throw new \Exception('Event name is required.');
        }

        $event_name = Str::upper($event_name);

        if (!in_array($event_name, $this->supported_events)){
            throw new \Exception('This event ' . $event_name . ' is not supported.');
        }

        $this->event_name = $event_name;
        return $this;
    }

    private function getEventName(): ?string
    {
        return $this->event_name;
    }

    public function create(?string $callbackUrl = null)
    {

        $parameters = [
            'name' => $this->getEventName(),
            'callbackUrl' => $callbackUrl
        ];

        return (new MayaClient)->setRequestMethod('POST')->setService('webhook')->send($parameters);
    }

    public function get()
    {
        return (new MayaClient)->setRequestMethod('GET')->setService('webhook')->send();
    }

    public function getById(?string $id = null)
    {
        $path_parameters = [$id];
        return (new MayaClient)->setRequestMethod('GET')->setService('webhook')->send([], $path_parameters);
    }

    public function update(?string $id = null, ?string $callbackUrl = null)
    {
        $path_parameters = [$id];
        $parameters = [
            "callbackUrl" => $callbackUrl
        ];

        return (new MayaClient)->setRequestMethod('PUT')->setService('webhook')->send($parameters, $path_parameters);
    }

    public function delete(?string $id = null)
    {
        $path_parameters = [$id];
        return (new MayaClient)->setRequestMethod('DELETE')->setService('webhook')->send([], $path_parameters);
    }
}
