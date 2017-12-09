<?php
namespace RutgerKirkels\NanoPool_API_Client;

define('NANOPOOL_API_HOST', 'https://api.nanopool.org/v1');

class Client
{
    protected $walletAddress;
    protected $currency;

    /**
     * Client constructor.
     * @param string $walletAddress
     * @param string $currency
     */
    public function __construct(string $walletAddress, string $currency) {
        $this->walletAddress = $walletAddress;
        $this->currency = strtolower($currency);
    }

    /**
     * Get the balance from the configured wallet
     * @return mixed
     */
    public function getBalance() {
        $data = $this->execute('balance');
        if ($data) {
            if ($data->status === true) {
                return $data->data;
            }
        }
        return false;
    }

    /**
     * Get the balance and hashrate from the configured wallet
     * @return mixed
     */
    public function getBalanceAndHashrate() {
        $data = $this->execute('balance_hashrate');
        if ($data) {
            if ($data->status === true) {
                return $data->data;
            }
        }
    }

    /**
     * @param $endPoint
     * @return mixed
     */
    protected function execute($endPoint) {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', NANOPOOL_API_HOST . '/' . $this->currency . '/' . $endPoint . '/' . $this->walletAddress);
        if ($res->getStatusCode() === 200) {
            return json_decode($res->getBody());
        }
        return false;
    }
}