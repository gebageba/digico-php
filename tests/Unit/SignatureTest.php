<?php

/*
 * This file is part of DIGICO-PHP.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evolu\Digico\Test\Unit;

use Evolu\Digico\DigicoParameter;
use Evolu\Digico\Signature;
use PHPUnit\Framework\TestCase;

class SignatureTest extends TestCase
{
    /**
     * Signatureが作成できること
     */
    public function testDigicoParameter()
    {
        $digicoParameter = DigicoParameter::for($giftIdentifyCode = 500, $partnerCode = 'partner')
            ->withTradeId($tradeId = '1111111')
            ->withTimeStamp($timestamp = '12345678');

        $this->assertEquals([
            'gift_identify_code' => $giftIdentifyCode,
            'partner_code' => $partnerCode,
            'amount' => 1,
            'response_type' => 'json',
            'timestamp' => $timestamp,
            'trade_id' => $tradeId
        ], $digicoParameter->getData());

        $digicoCode = 'aaaa';
        $signature = Signature::create($digicoParameter, $digicoCode);
        $this->assertEquals('86d569226c4cb1d395851d175102e1f7cbfe95c5', $signature->value());
    }
}
