<?php

namespace App\Services\Yuque;

use Illuminate\Support\Facades\Http;

class YuqueClient
{

    private  $secretId;
    private  $secretKey;

    private  $timestamp;

    private  $timeout = 120;


    public function __construct()
    {
        $this->setSecretId();
        $this->setSecretKey();
        $this->setTimestamp();
    }

    /**
     * @return void
     */
    private function setSecretId(): void
    {
        $this->secretId = config('yuque.secret_id');
    }

    /**
     * @return void
     */
    private function setSecretKey(): void
    {
        $this->secretKey = config('yuque.secret_key');
    }

    /**
     * @return void
     */
    private function setTimestamp(): void
    {
        $this->timestamp = time();
    }



    /**
     * @return
     */
    private function getSecretId(): string
    {
        return $this->secretId;
    }

    /**
     * @return string
     */
    private function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * @return string
     */
    private function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @param array $body
     * @return array
     */
    private function getHeaders(array $body = []): array
    {
        return [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Secret-Id'     => $this->secretId,
            'Signature'     => $this->generateSignature($body),
        ];
    }

    private function generateSignature(array $body = []): string
    {
        $bodyJson = json_encode($body);
        $signStr  = $this->getSecretId() . $bodyJson;

        return hash_hmac('sha256', $signStr, $this->getSecretKey());
    }



    /**
     * @param string $url
     * @param array $body
     * @return mixed
     */
    public function postHttpRequest(string $url, array $body = [])
    {
        $body['timestamp'] = $this->getTimestamp();

        $response = Http::withHeaders($this->getHeaders($body))
            ->timeout($this->timeout)
            ->post($url, $body);

        return json_decode($response->getBody()->getContents(), true);
    }
}
