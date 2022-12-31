<?php

/*
 * This file is part of DIGICO-PHP.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
