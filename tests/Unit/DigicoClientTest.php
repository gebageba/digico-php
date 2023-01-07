<?php

namespace Evolu\Digico\Test\Unit;

use Evolu\Digico\DigicoClient;
use Evolu\Digico\DigicoParameter;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Mockery;

class DigicoClientTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $client = Mockery::mock('overload:GuzzleHttp\Client');
        $client->shouldReceive('request')
            ->once()
            ->andReturn(
                new Response(
                    200,
                    ['Content-Type' => 'application/json'],
                    '{"detail_code":"00", "gifts":[{"gift_Identify_code": "500", "code": "ABCDEFGHIJ01234", "url": "https://example.com", "expire_date": "2015-11-01", "manage_code": "MNG_1234567890abcdef", "send_time": "2015-05-01 10:00:00"}]}'
                )
            );
    }

    public function testDigicoClient()
    {
        $digicoParameter = DigicoParameter::for($giftIdentifyCode = 500, $partnerCode = 'pertnerNmae');
        $digico = DigicoClient::createGiftCode(
            $digicoParameter,
            'ABCDEFGHIJ01234',
            '/api/test/v1/gift' //テスト
        );
        $giftCode = $digico->getFirstGiftCode();

        $this->assertEquals($giftCode['gift_Identify_code'], '500');
    }
}