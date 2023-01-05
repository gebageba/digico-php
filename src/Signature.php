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
        $flattedParameter = (new RequestBodyFlattener($digicoParameter->getData()))->value();
        $this->signature = hash_hmac('sha1', urlencode($flattedParameter), $digicoCode, false);
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
