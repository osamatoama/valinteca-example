<?php

namespace App\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class SallaWebhookService
{

    private $api_key;

    private $client;

    private $base_url = 'https://api.salla.dev/admin/v2/';

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
        $this->client = $this->getClient();
    }

    private function getHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->api_key,
        ];
    }

    private function getClient(): Client
    {
        return new Client([
            RequestOptions::VERIFY => false,
            'headers'              => $this->getHeaders(),
        ]);
    }

    public function getOrder($order_id)
    {
        $response = $this->client->get($this->base_url . 'orders/' . $order_id, [
            'json' => [
                'expanded' => true,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);

    }

    public function getOrderHistories($order_id)
    {

        $response = $this->client->get($this->base_url . 'orders/' . $order_id . '/histories');

        return json_decode($response->getBody()->getContents(), true);

    }

    public function getOrders($page = 1)
    {
        $response = $this->client->get($this->base_url . 'orders', [
            'json' => [
                'page'     => $page,
                'expanded' => true,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);

    }

    public function getProducts($page = 1)
    {
        $response = $this->client->get($this->base_url . 'products', [
            'json' => [
                'page'     => $page
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);

    }

    public function getOrdersForAbaya($page = 1)
    {
        $response = $this->client->get($this->base_url . 'orders', [
            'json' => [
                'page'     => $page,
                'expanded' => true,
                'status'   => [697708569, 1808341331],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);

    }

    public function getOrdersDateRange($page = 1)
    {
        $response = $this->client->get($this->base_url . 'orders', [
            'json' => [
                'page'      => $page,
                'expanded'  => true,
                'from_date' => '20-11-2021',
                'to_date'   => '02-01-2022',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);

    }

    public function registerWebhooks(Store $store)
    {


        $store_headers = [
            [
                'key'   => 'X-API-KEY',
                'value' => env('SALLA_WEBHOOK_API_KEY'),
            ],
            [
                'key'   => 'X-STORE-ID',
                'value' => $store->id,
            ],
            [
                'key'   => 'X-STORE-KEY',
                'value' => $store->encrypt_key,
            ],
        ];


        $response = $this->client->POST($this->base_url . 'webhooks/subscribe', [
            'json' => [
                'name'    => 'order.created',
                'event'   => 'order.created',
                'url'     => route('api.webhooks.salla.webhooks.order.created'),
                'headers' => $store_headers,
            ],
        ]);

        $response = $this->client->POST($this->base_url . 'webhooks/subscribe', [
            'json' => [
                'name'    => 'order.updated',
                'event'   => 'order.updated',
                'url'     => route('api.webhooks.salla.webhooks.order.updated'),
                'headers' => $store_headers,
            ],
        ]);

        return $response;


    }

    public function activeWebhooks()
    {


        $response = $this->client->get($this->base_url . 'webhooks');

        return json_decode($response->getBody()->getContents(), true)['data'];

    }

    public function removeWebhook($id)
    {


        try {
            $response = $this->client->delete($this->base_url . 'webhooks/unsubscribe', [
                'json' => [
                    'id' => $id,
                ],
            ]);

            return $response;
        } catch (GuzzleException $e) {
            return $e;
        }

    }

    public function orderStatuses()
    {

        try {
            $response = $this->client->get($this->base_url . 'orders/statuses');
            $data = json_decode($response->getBody()->getContents(), true);

            return $data['data'];

        } catch (GuzzleException $e) {
            return $e;
        }

    }

    public function abandonedCarts($page = 1)
    {

        try {
            $response = $this->client->get($this->base_url . 'carts/abandoned', [
                'json' => [
                    'page' => $page,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);


        } catch (GuzzleException $e) {
            return $e;
        }
    }

    public function customers($page = 1)
    {

        try {
            $response = $this->client->get($this->base_url . 'customers', [
                'json' => [
                    'page' => $page,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);


        } catch (GuzzleException $e) {
            return $e;
        }
    }

}
