<?php

/*
 * This file is part of DIGICO-PHP.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evolu\Digico;

enum DigicoResponseDetailCode
{
    const SUCCESS = '00';
    const NOW_MAINTENANCE = '01';
    const DUPLICATE_TRAN = '03';
    const EMPTY_GIFT_STOCK = '04';
    const DAILY_CAPACITY_OVER = '05';
    const MONTHLY_CAPACITY_OVER = '06';
    const RESPONSE_TIME_OUT= '09';
    const INVALID_FORMAT = '21';
    const INVALID_RESPONSE_TYPE = '23';
    const INVALID_GIFT_IDENTIFY_CODE = '24';
    const INVALID_TRADE_ID = '25';
    const INVALID_TIMESTAMP = '27';
    const INVALID_SIGNATURE = '28';
    const INTERNAL_ERROR = '99';
}
