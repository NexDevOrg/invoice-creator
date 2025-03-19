<?php

namespace NexDev\InvoiceCreator\Classes;

class OutgoingInvoice
{
    public static function make(): InvoiceBuilder
    {
        return new InvoiceBuilder('outgoing');
    }
}
