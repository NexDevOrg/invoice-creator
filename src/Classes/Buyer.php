<?php

namespace NexDev\InvoiceCreator\Classes;

use NexDev\InvoiceCreator\Builders\BuyerBuilder;

class Buyer
{
    public static function make(): BuyerBuilder
    {
        return new BuyerBuilder;
    }
}
