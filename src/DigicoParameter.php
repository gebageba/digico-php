<?php

/*
 * This file is part of DIGICO-PHP.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evolu\Digico;

final class DigicoParameter extends BaseBuilder implements DigicoParameterInterface
{
    public int $giftIdentifyCode;
    public string $partnerCode;
    public int $amount;
    public string $timestamp;
    public string $tradeId;
    public string $responseType;

    public const AMOUNT = 1;

    protected function __construct(
        int $gift_identify_code,
        string $partner_code,
        int $amount,
        string $timestamp,
        string $trade_id,
        string $response_type
    ) {
        parent::__construct(compact('gift_identify_code', 'partner_code', 'amount', 'timestamp', 'trade_id', 'response_type'));

        $this->giftIdentifyCode = $gift_identify_code;
        $this->partnerCode = $partner_code;
        $this->amount = $amount;
        $this->timestamp = $timestamp;
        $this->tradeId = $trade_id;
        $this->responseType = $response_type;
    }

    public static function for(int $giftIdentifyCode, string $partnerCode): self
    {
        return new self(
            $giftIdentifyCode,
            $partnerCode,
            self::AMOUNT,
            time(),
            (new TradeId())->value(),
            'json'
        );
    }

    public function withTradeId(string $tradeId): self
    {
        $this->tradeId = $tradeId;
        return $this->with('trade_id', $tradeId);
    }

    public function withAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this->with('amount', $amount);
    }

    public function withTimeStamp(int $timestamp): self
    {
        $this->timestamp = $timestamp;
        return $this->with('timestamp', $timestamp);
    }

    public function withResponseType(string $responseType): self
    {
        $this->responseType = $responseType;
        return $this->with('response_type', $responseType);
    }

    public function getData(): array
    {
        return parent::getData();
    }
}
