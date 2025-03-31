<?php

namespace NexDev\InvoiceCreator\Classes;

use Illuminate\Database\Eloquent\Model;
use NexDev\InvoiceCreator\Builders\BuyerBuilder;

class Buyer
{
    public static function make(?Model $model = null): BuyerBuilder
    {
        return new BuyerBuilder($model);
    }
}
