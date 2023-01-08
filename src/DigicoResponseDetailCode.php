<?php

/*
 * This file is part of DIGICO-PHP.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evolu\Digico;

enum DigicoResponseDetailCode: string
{
    case SUCCESS = '00';
    case NOW_MAINTENANCE = '01';
    case DUPLICATE_TRAN = '03';
    case EMPTY_GIFT_STOCK = '04';
    case DAILY_CAPACITY_OVER = '05';
    case MONTHLY_CAPACITY_OVER = '06';
    case RESPONSE_TIME_OUT= '09';
    case INVALID_FORMAT = '21';
    case INVALID_RESPONSE_TYPE = '23';
    case INVALID_GIFT_IDENTIFY_CODE = '24';
    case INVALID_TRADE_ID = '25';
    case INVALID_TIMESTAMP = '27';
    case INVALID_SIGNATURE = '28';
    case INTERNAL_ERROR = '99';
}
