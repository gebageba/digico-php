<?php

/*
 * This file is part of DIGICO-PHP.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evolu\Digico;

use Evolu\Digico\Exception\DigicoException;
use GuzzleHttp\Client;

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
    ): array {
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

    private function requestGiftCode(): array
    {
        $response = $this->httpClient->request('POST', $this->baseUrl.$this->sendPath, $this->params());
        $decodedResponse = json_decode($response->getBody()->getContents(), true);
        $detailCode = DigicoResponseDetailCode::from($decodedResponse['detail_code']);
        if ($detailCode === DigicoResponseDetailCode::SUCCESS) {
            return $decodedResponse['gifts'][0];//TODO:0でいいのか？
        }

//        if ($detailCode === DigicoResponseDetailCode::NOW_MAINTENANCE) {
//            throw new DigicoException('発券システムのメンテナンス中です。時間を空けて再度お試しください', 400);
//        }
//        if ($detailCode === DigicoResponseDetailCode::DAILY_CAPACITY_OVER) {
//            throw new DigicoException('日毎の交換上限を超過しています', 400);
//        }
//        if ($detailCode === DigicoResponseDetailCode::MONTHLY_CAPACITY_OVER) {
//            throw new DigicoException('月毎の交換上限を超過しています', 400);
//        }
//
        throw new DigicoException("{$detailCode}", 500);
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
