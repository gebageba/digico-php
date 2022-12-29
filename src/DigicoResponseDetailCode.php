<?php

namespace Evolu\Digico;

use MyCLabs\Enum\Enum;

class DigicoResponseDetailCode extends Enum
{
    public const SUCCESS = '00';
    public const NOW_MAINTENANCE = '01';
    public const DUPLICATE_TRAN = '03';
    public const EMPTY_GIFT_STOCK = '04';
    public const DAILY_CAPACITY_OVER = '05';
    public const MONTHLY_CAPACITY_OVER = '06';
    public const RESPONSE_TIME_OUT= '09';
    public const INVALID_FORMAT = '21';
    public const INVALID_RESPONSE_TYPE = '23';
    public const INVALID_GIFT_IDENTIFY_CODE = '24';
    public const INVALID_TRADE_ID = '25';
    public const INVALID_TIMESTAMP = '27';
    public const INVALID_SIGNATURE = '28';
    public const INTERNAL_ERROR = '99';
}
