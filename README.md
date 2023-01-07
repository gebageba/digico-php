# digico-php

## Installation
`composer.json` に

```
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:gebageba/digico-php.git"
    }
],
```
を追加する。

```
$ composer require evolu/digico-php
```

でインストールする。


## Usage
```php

use Evolu\Digico\DigicoClient;
use Evolu\Digico\DigicoParameter;

$giftIdentifyCode = 500;
$partnerCode = 'name;'
$parameter = DigicoParameter::for($giftIdentifyCode, $partnerCode);
$digicoClient = DigicoClient::createGiftCode(
    $parameter,
    $dicicoCode = 'xxxxxxxxxxxxx',
    $sendUrl = '/api/test/v1/gift',
    $basUrl = 'https://sample' //デフォルト'https://user.digi-co.net'
);

$response = $digicoClient->response();
or
$response = $digicoClient->getFirstGiftCode(); //最初の配列のみ取得できる
