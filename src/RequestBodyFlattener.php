<?php

/*
 * This file is part of DIGICO-PHP.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evolu\Digico;

final class RequestBodyFlattener
{
    private string $value;

    public function __construct(array $body)
    {
        $objBody = array_merge(array(), $body);
        $flatPair = [];     // we're going to convert objBody to flatPair

        foreach ($objBody as $key => $value) {
            if (is_int($value)) {
                $value = strval($value);
            }

            if (is_array($value)) {
                $allSubKeys = [];
                foreach ($value as $elem) {
                    $allSubKeys += array_keys($elem);
                }

                foreach ($value as $elem) {
                    foreach ($allSubKeys as $subKey) {
                        $flatKey = "{$key}.{$subKey}";
                        $flatRawValue = $elem[$subKey] ? $elem[$subKey] : "";
                        $prevFlatValue = $flatPair[$flatKey];
                        $flatPair[$flatKey] =
                            is_null($prevFlatValue) ? $flatRawValue : "{$prevFlatValue},{$flatRawValue}";
                    }
                }
            } else {
                $flatPair[$key] = $value;
            }
        }

        ksort($flatPair);

        $flattenBody = [];

        foreach ($flatPair as $key => $value) {
            array_push($flattenBody, "{$key}={$value}");
        }

        $this->value = join("&", $flattenBody);
    }

    public function value()
    {
        return $this->value;
    }
}
