<?php

namespace NexDev\InvoiceCreator\Facades;

use Illuminate\Support\Facades\Facade;

class OutgoingInvoice extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'outgoing-invoice';
    }
}
