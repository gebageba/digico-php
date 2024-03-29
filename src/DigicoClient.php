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

final class DigicoClient implements DigicoClientInterface
{
    private Client $httpClient;
    private string $signature;
    private ResponseInterface $response;

    /**
     * @param DigicoParameter $digicoParameter
     * @param string $sendPath
     * @param string $baseUrl
     */
    private function __construct(
        private readonly DigicoParameter $digicoParameter,
        private readonly string $sendPath,
        private readonly string $baseUrl
    ) {
        $this->httpClient = new Client();
    }


    /**
     * @param DigicoParameter $digicoParameter
     * @param string $digicoCode
     * @param string $sendPath
     * @param string $baseUrl
     * @return static
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function createGiftCode(
        DigicoParameter $digicoParameter,
        string $digicoCode,
        string $sendPath,
        string $baseUrl = 'https://user.digi-co.net'
    ): self {
        $digicoClient = new self(
            $digicoParameter,
            $sendPath,
            $baseUrl
        );
        $digicoClient->signature = Signature::create($digicoParameter, $digicoCode)->value();
        $digicoClient->response = $digicoClient->requestGiftCode();
        return $digicoClient;
    }

    /**
     * @return array
     */
    public function getFirstGiftCode(): array
    {
        $decodedResponse = json_decode($this->response->getBody()->getContents(), true);
        $detailCode = DigicoResponseDetailCode::from($decodedResponse['detail_code']);

        if ($detailCode === DigicoResponseDetailCode::SUCCESS) {
            return $decodedResponse['gifts'][0];
        }
        if ($detailCode === DigicoResponseDetailCode::NOW_MAINTENANCE) {
            throw new DigicoException('発券システムのメンテナンス中です。時間を空けて再度お試しください', 400);
        }
        if ($detailCode === DigicoResponseDetailCode::DAILY_CAPACITY_OVER) {
            throw new DigicoException('日毎の交換上限を超過しています', 400);
        }
        if ($detailCode === DigicoResponseDetailCode::MONTHLY_CAPACITY_OVER) {
            throw new DigicoException('月毎の交換上限を超過しています', 400);
        }

        throw new DigicoException("{$decodedResponse['detail_code']}", 500);
    }

    /**
     * @return ResponseInterface
     */
    public function response(): ResponseInterface
    {
        return $this->response();
    }

    /**
     * @return string
     */
    public function signature(): string
    {
        return $this->signature;
    }

    /**
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function requestGiftCode(): ResponseInterface
    {
        try {
            return $this->httpClient->request('POST', $this->baseUrl.$this->sendPath, $this->params());
        } catch (ClientException $exception) {
            throw new GuzzleException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @return array
     */
    private function params(): array
    {
        $params = $this->digicoParameter->getData();
        $params['signature'] = $this->signature;

        return [
            'form_params' => $params,
        ];
    }
}
