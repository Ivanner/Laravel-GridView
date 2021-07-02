<?php

namespace Woo\GridView\Formatters;

class CurrencyFormatter implements IFormatter
{
    public function format($value): string
    {
        return '$' . number_format(floatval($value), 2);
    }
}
