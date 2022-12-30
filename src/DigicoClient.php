<?php

namespace Evolu\Digico;

use Evolu\Digico\Exception\DigicoException;
use GuzzleHttp\Client;

class DigicoClient
{
    private Client $httpClient;
    private string $signature;

    private function __construct(
        private readonly DigicoParameter $digicoParameter,
        private readonly string $sendUrl,
        string $baseUrl
    )
    {
        $this->httpClient = new Client([
            'base_url' => $baseUrl,
        ]);
    }

    public static function createGiftCode(
        DigicoParameter $digicoParameter,
        string $digicoCode,
        string $sendUrl,
        string $baseUrl = 'https://user.digi-co.net'
    )
    {
        $digicoClient = new self(
            $digicoParameter,
            $sendUrl,
            $baseUrl
        );
        $digicoClient->signature = Signature::create($digicoParameter, $digicoCode)->value();
        $digicoClient->requestGiftCode();
    }

    public function signature(): string
    {
        return $this->signature;
    }

    private function requestGiftCode(): array
    {
        $response = $this->httpClient->request('POST', $this->sendUrl, $this->params());
        $decodedResponse = json_decode($response->getBody()->getContents(), true);
        $detailCode = DigicoResponseDetailCode::from($decodedResponse['detail_code']);
        if ($detailCode === DigicoResponseDetailCode::SUCCESS) {
            return $decodedResponse['gifts'][0];
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
