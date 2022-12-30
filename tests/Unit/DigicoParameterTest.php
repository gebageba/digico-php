<?php

namespace Evolu\Digico\Test\Unit;

use Evolu\Digico\DigicoParameter;
use Evolu\Digico\TradeId;
use PHPUnit\Framework\TestCase;

class DigicoParameterTest extends TestCase
{
    public function testDigicoParameterDefault()
    {
        $digicoParameter = DigicoParameter::for($giftIdentifyCode = 500, $partnerCode = 'partner');
        $timestamp = $digicoParameter->timestamp;
        $tradeId = $digicoParameter->tradeId;
        $this->assertEquals([
            'gift_identify_code' => $giftIdentifyCode,
            'partner_code' => $partnerCode,
            'amount' => 1,
            'response_type' => 'json',
            'timestamp' => $timestamp,
            'trade_id' => $tradeId

        ], $digicoParameter->getData());
    }

    public function testDigicoParameter()
    {
        $digicoParameter = DigicoParameter::for($giftIdentifyCode = 500, $partnerCode = 'partner')
            ->withTradeId($tradeId = '1111111')
            ->withAmount($amount = 2)
            ->withTimeStamp($timestamp = '12345678')
            ->withResponseType($responseType = 'sample');

        $this->assertEquals([
            'gift_identify_code' => $giftIdentifyCode,
            'partner_code' => $partnerCode,
            'amount' => $amount,
            'response_type' => $responseType,
            'timestamp' => $timestamp,
            'trade_id' => $tradeId

        ], $digicoParameter->getData());
    }
}