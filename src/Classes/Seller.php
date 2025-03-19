<?php

namespace NexDev\InvoiceCreator\Classes;

use NexDev\InvoiceCreator\Builders\SellerBuilder;

class Seller
{
    public static function make(): SellerBuilder
    {
        return new SellerBuilder;
    }
}
