<?php

namespace RutgerKirkels\NanoPool_API_Client;


class Payment
{
    protected $currency;
    protected $timestamp;
    protected $txHash;
    protected $amount;
    protected $confirmed;

    public function __construct(int $timestamp, string $txHash, float $amount, string $currency, bool $confirmed) {
        $this->timestamp = new \DateTime();
        $this->timestamp->setTimestamp($timestamp);
        $this->txHash = $txHash;
        $this->amount = $amount;
        $this->currency = strtolower($currency);
        $this->confirmed = $confirmed;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getTxHash(): string
    {
        return $this->txHash;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return bool
     */
    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    /**
     * Converts amount to BTC, USD, EUR, RUR or CNY
     * @param $currency
     * @return bool
     */
    public function convertTo($currency) {
        $client = Client::getInstance();
        $prices = $client->getPrices();
        if (key_exists(strtolower($currency), $prices)) {
            return $this->amount * $prices[strtolower($currency)];
        }
        return false;
    }
}