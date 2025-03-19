<?php

namespace NexDev\InvoiceCreator\Classes;

use NexDev\InvoiceCreator\Builders\InvoiceItemBuilder;

class InvoiceItem
{
    public static function make(): InvoiceItemBuilder
    {
        return new InvoiceItemBuilder;
    }
}
