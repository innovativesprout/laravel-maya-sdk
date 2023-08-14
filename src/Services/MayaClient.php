<?php namespace Iss\LaravelMayaSdk\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Http;

class MayaClient{

    protected string $api_url = '';
    protected array $service = [];
    protected ?string $requestMethod = null;

    protected function getApiUrl()
    {
        if (config('maya.environment') === 'sandbox'){
            $this->api_url = config('maya.sandbox_api_url');
        }else{
            $this->api_url = config('maya.api_url');
        }

        return $this->api_url;
    }


    public function setService($service = null)
    {
        $services = config('maya.services');
        if (is_null($service) || !isset($services[$service])){
            throw new \Exception('Service not found.');
        }

        $this->service = $services[$service];
        return $this;
    }

    public function setRequestMethod(?string $requestMethod = null)
    {
        $this->requestMethod = $requestMethod;
        return $this;
    }

    protected function getRequestMethod(): ?string
    {
        return $this->requestMethod;
    }

    protected function getApiService(): array
    {
        return $this->service;
    }

    protected function getPublicKey(): string
    {
        if (config('maya.environment') === 'sandbox'){
            $public_key = config('maya.sandbox_public_key');
        }else{
            $public_key = config('maya.public_key');
        }
        return base64_encode($public_key);
    }

    protected function getPrivateKey(): string
    {
        if (config('maya.environment') === 'sandbox'){
            $private_key = config('maya.sandbox_private_key');
        }else{
            $private_key = config('maya.private_key');
        }
        return base64_encode($private_key);
    }

    protected function getAuthorizationKey(): string
    {
        if ($this->getApiService()['auth_type'] == 'public_key'){
            $token = $this->getPublicKey();
        }else{
            $token = $this->getPrivateKey();
        }

        return $token;
    }

    public function send(array $body_params = [], array $path_params = [], $headers = [])
    {
        $client = new Http();
        $full_api_url = $this->getApiUrl() . $this->getApiService()['url'];

        if (is_null($this->getRequestMethod())){
            throw new \Exception('Invalid request method.');
        }

        try {

            $request_content = [
                'headers' => array_merge([
                    'accept' => 'application/json',
                    'authorization' => 'Basic ' . $this->getAuthorizationKey(),
                    'content-type' => 'application/json',
                ], $headers),
            ];

            if (!empty($body_params)){
                $request_content['body'] = json_encode($body_params);
            }

            if (!empty($path_params)){
                $index = 0;
                foreach ($path_params as $key => $path_param) {

                    if (is_integer($key)) {
                        $full_api_url .= "/";
                    }else{
                        if ($index == 0) {
                            $full_api_url .= "?";
                        } else {
                            $full_api_url .= "&";
                        }
                    }

                    if (is_integer($key)){
                        $full_api_url .= "{$path_param}";
                    }else{
                        $full_api_url .= "{$key}={$path_param}";
                    }

                    $index += 1;
                }
            }

            $response = $client::send($this->getRequestMethod(), $full_api_url, $request_content);
            $data = $response->object();
            if ($response->ok()){
                return [
                    "data" => (array) $data,
                    "code" => $response->status(),
                    "message" => $response->ok()
                ];
            }else{
                return [
                    "data" => isset($data->parameters) ? (array) $data->parameters : $data,
                    "code" => $data->code ?? $response->status(),
                    "message" => isset($data->message) ?? $response->ok()
                ];
            }



        } catch (\Exception $e){
            return [
                "data" => [],
                "code" => "500",
                "message" => $e->getMessage()
            ];
        }
    }
}
