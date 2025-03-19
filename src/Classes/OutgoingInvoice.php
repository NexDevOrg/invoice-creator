<?php

namespace NexDev\InvoiceCreator\Classes;

use NexDev\InvoiceCreator\Models\Invoice;
use NexDev\InvoiceCreator\Builders\InvoiceBuilder;

class OutgoingInvoice
{
    public static function make(): InvoiceBuilder
    {
        return new InvoiceBuilder('outgoing');
    }

    public static function find(string $id): InvoiceBuilder
    {
        /** @var Invoice $invoice */
        $invoice = Invoice::where('invoice_id', $id)
            ->where('type', 'outgoing')
            ->firstOrFail();

        return new InvoiceBuilder('outgoing', $invoice);
    }
}
