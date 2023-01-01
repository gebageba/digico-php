<?php

/*
 * This file is part of DIGICO-PHP.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evolu\Digico;

interface DigicoParameterInterface
{
    public static function for(int $giftIdentifyCode, string $partnerCode): self;

    public function withTradeId(string $tradeId): self;

    public function withAmount(int $amount): self;

    public function withTimeStamp(int $timestamp): self;

    public function withResponseType(string $responseType): self;

    public function getData(): array;
}
