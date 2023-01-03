<?php

/*
 * This file is part of DIGICO-PHP.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evolu\Digico\Test\Unit;

use Evolu\Digico\DigicoParameter;
use PHPUnit\Framework\TestCase;

class DigicoParameterTest extends TestCase
{
    /**
     * Digi-coのパラメーターがデフォルトで作成されること
     */
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

    /**
     * Digi-coのパラメーターは変更できること
     */
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
