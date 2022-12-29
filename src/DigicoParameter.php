<?php

namespace Evolu\Digico;

class DigicoParameter extends BaseBuilder
{
    public int $giftIdentifyCode;
    public string $partnerCode;
    public int $amount;
    public string $timestamp;
    public int $tradeId;

    protected function __construct(
        int $gift_identify_code,
        string $partner_code,
        int $amount,
        string $timestamp,
        TradeId $trade_id
    )
    {
        parent::__construct(compact('gift_identify_code', 'partner_code', 'amount', 'timestamp', 'trade_id'));

        $this->giftIdentifyCode = $gift_identify_code;
        $this->partnerCode = $partner_code;
        $this->amount = $amount;
        $this->timestamp = $timestamp;
        $this->tradeId = $trade_id->value();
    }

    public static function for(int $giftIdentifyCode, string $partnerCode): self
    {
        return new self(
            $giftIdentifyCode,
            $partnerCode,
            1,
            time(),
            new TradeId()
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

    public function withTimeStamp(int $timestamp):self
    {
        $this->timestamp = $timestamp;
        return $this->with('timestamp', $timestamp);
    }

    public function getData(): array
    {
        return parent::getData();
    }
}
