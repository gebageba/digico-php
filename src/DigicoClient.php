<?php

/*
 * This file is part of DIGICO-PHP.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evolu\Digico;

use Evolu\Digico\Exception\DigicoException;
use Evolu\Digico\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

class DigicoClient
{
    private Client $httpClient;
    private string $signature;

    private function __construct(
        private readonly DigicoParameter $digicoParameter,
        private readonly string $sendPath,
        private readonly string $baseUrl
    ) {
        $this->httpClient = new Client([
            'base_url' => $baseUrl,
        ]);
    }

    public static function createGiftCode(
        DigicoParameter $digicoParameter,
        string $digicoCode,
        string $sendPath,
        string $baseUrl = 'https://user.digi-co.net'
    ): ResponseInterface
    {
        $digicoClient = new self(
            $digicoParameter,
            $sendPath,
            $baseUrl
        );
        $digicoClient->signature = Signature::create($digicoParameter, $digicoCode)->value();
        return $digicoClient->requestGiftCode();
    }

    public function signature(): string
    {
        return $this->signature;
    }

    private function requestGiftCode(): ResponseInterface
    {
        try {
            return $this->httpClient->request('POST', $this->baseUrl.$this->sendPath, $this->params());
        } catch (ClientException $exception) {
            throw new GuzzleException($exception->getMessage(), $exception->getCode());
        }
    }

    private function params(): array
    {
        $params = $this->digicoParameter->getData();
        $params['signature'] = $this->signature;

        return [
            'form_params' => $params,
        ];
    }
}
