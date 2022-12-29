<?php

namespace Evolu\Digico;

class TradeId
{
    private string $tradeId;

    public function __construct()
    {
        $this->tradeId = uniqid(rand(10000, 99999));
    }

    public function value(): string
    {
        return $this->tradeId;
    }
}
