<?php

namespace RutgerKirkels\NanoPool_API_Client;

define('NANOPOOL_API_HOST', 'https://api.nanopool.org/v1');

class Connector
{
    protected $currency;
    protected static $instance = null;

    public static function getInstance($currency) {
        if (self::$instance === null) {
            self::$instance = new Connector($currency);
        }
        return self::$instance;
    }

    public function __construct(string $currency) {
        $this->currency = strtolower($currency);
    }

    /**
     * @param $endPoint
     * @return mixed
     */
    public function execute($endPoint, $walletAddress = null, array $params = []) {
        $client = new \GuzzleHttp\Client();
        $url = NANOPOOL_API_HOST . '/' . $this->currency . '/' . $endPoint;
        if (!is_null($walletAddress)) {
            $url .= '/' . $walletAddress;
        }
        $res = $client->request('GET', $url);
        if ($res->getStatusCode() === 200) {
            return json_decode($res->getBody());
        }
        return false;
    }
}