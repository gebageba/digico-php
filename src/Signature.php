<?php

/*
 * This file is part of DIGICO-PHP.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evolu\Digico;

final class Signature
{
    private string $signature;

    /**
     * @param DigicoParameter $digicoParameter
     * @param string $digicoCode
     */
    private function __construct(
        DigicoParameter $digicoParameter,
        string $digicoCode
    ) {
        $amount = $digicoParameter->amount;
        $giftIdentifyCode = $digicoParameter->giftIdentifyCode;
        $partnerCode = $digicoParameter->partnerCode;
        $timestamp = $digicoParameter->timestamp;
        $tradeId = $digicoParameter->tradeId;
        $responseType = $digicoParameter->responseType;

        $hashMessage = 'amount%3D'.$amount.'%26gift_identify_code%3D'.$giftIdentifyCode.'%26partner_code%3D'.$partnerCode.'%26response_type%3D'.$responseType.'%26timestamp%3D'.$timestamp.'%26trade_id%3D'.$tradeId;
        //TODO: http_build_query($this->getData()) これでできないか確認
        $this->signature = hash_hmac('sha1', $hashMessage, $digicoCode, false);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->signature;
    }

    /**
     * @param DigicoParameter $digicoParameter
     * @param string $digicoCode
     * @return static
     */
    public static function create(
        DigicoParameter $digicoParameter,
        string $digicoCode
    ): self {
        return new self($digicoParameter, $digicoCode);
    }
}
