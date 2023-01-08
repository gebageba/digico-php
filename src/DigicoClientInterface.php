<?php

/*
 * This file is part of DIGICO-PHP.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evolu\Digico;

use Psr\Http\Message\ResponseInterface;

interface DigicoClientInterface
{
    public static function createGiftCode(
        DigicoParameter $digicoParameter,
        string $digicoCode,
        string $sendPath,
        string $baseUrl
    ): self;

    public function getFirstGiftCode(): array;

    public function response(): ResponseInterface;

    public function signature(): string;
}
