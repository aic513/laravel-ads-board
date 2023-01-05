<?php

namespace App\Services\Sms;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SmsRu implements SmsSender
{
    private $appId;
    private $url;
    private Client $client;

    public function __construct($appId, $url = 'https://sms.ru/sms/send')
    {
        if (empty($appId)) {
            throw new \InvalidArgumentException('Sms appId must be set.');
        }

        $this->appId = $appId;
        $this->url = $url;
        $this->client = new Client();
    }

    /**
     * @throws GuzzleException
     */
    public function send($number, $text): void
    {
        $this->client->post($this->url, [
            'form_params' => [
                'api_id' => $this->appId,
                'to' => '+' . trim($number, '+'),
                'text' => $text
            ],
        ]);
    }
}