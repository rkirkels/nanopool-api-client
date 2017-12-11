<?php
namespace RutgerKirkels\NanoPool_API_Client;

class Client
{
    protected $walletAddress;
    protected $currency;
    protected $prices = [];
    protected $connector;
    protected static $instance;

    public static function init(string $walletAddress = '', string $currency = 'eth') {
        if (self::$instance === null) {
            self::$instance = new Client($walletAddress, $currency);
        }
        return self::$instance;
    }

    public static function getInstance() {
        if (self::$instance === null) {
            return false;
        }
        return self::$instance;
    }

    /**
     * Client constructor.
     * @param string $walletAddress
     * @param string $currency
     */
    public function __construct(string $walletAddress = '', string $currency = 'eth') {
        $this->walletAddress = $walletAddress;
        $this->currency = strtolower($currency);
        $this->connector = Connector::getInstance($currency);
    }

    /**
     * Get the balance from the configured wallet
     * @return mixed
     */
    public function getBalance() {
        $data = $this->connector->execute('balance', $this->walletAddress);
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
        $data = $this->connector->execute('balance_hashrate', $this->walletAddress);
        if ($data) {
            if ($data->status === true) {
                return $data->data;
            }
        }
    }

    /**
     * Get payments sent to the configured wallet
     * @return array|bool
     */
    public function getPayments() {
        $data = $this->connector->execute('payments', $this->walletAddress);
        if ($data) {
            $payments = [];
            foreach ($data->data as $paymentData) {
                $payments[] = new Payment($paymentData->date, $paymentData->txHash, $paymentData->amount, $this->currency, $paymentData->confirmed);
            }
            return $payments;
        }
        return false;
    }

    public function getPrices() {
        if (count($this->prices) === 0) {
            $data = $this->connector->execute('prices');
            if ($data) {
                foreach ($data->data as $currency => $price) {
                    $this->prices[substr($currency, 6)] = $price;
                }
            }
        }
        return $this->prices;

    }

    public function getShareHistory() {
        $data = $this->connector->execute('shareratehistory', $this->walletAddress);
        if ($data) {
            $history = [];
            foreach ($data->data as $part) {
                $timestamp = new \DateTime();
                $timestamp->setTimestamp($part->date);
                $historyPart = new \stdClass();
                $historyPart->timestamp = $timestamp;
                $historyPart->shares = $part->shares;
                $history[] = $historyPart;
            }
            return $history;
        }
        return false;
    }

}