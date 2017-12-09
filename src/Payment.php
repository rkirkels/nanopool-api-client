<?php

namespace RutgerKirkels\NanoPool_API_Client;


class Payment
{
    protected $timestamp;
    protected $txHash;
    protected $amount;
    protected $confirmed;

    public function __construct(int $timestamp, string $txHash, float $amount, bool $confirmed) {
        $this->timestamp = new \DateTime();
        $this->timestamp->setTimestamp($timestamp);
        $this->txHash = $txHash;
        $this->amount = $amount;
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


}