<?php

namespace NexDev\InvoiceCreator\Classes;

use NexDev\InvoiceCreator\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;
use NexDev\InvoiceCreator\Builders\InvoiceBuilder;

class IncommingInvoice
{
    public static function make(): InvoiceBuilder
    {
        return new InvoiceBuilder('incoming');
    }

    public static function find(string $id): InvoiceBuilder
    {
        /** @var Invoice $invoice */
        $invoice = Invoice::where('invoice_id', $id)
            ->where('type', 'incoming')
            ->firstOrFail();

        return new InvoiceBuilder('incoming', $invoice);
    }

    /**
     * @return Collection<int, Invoice>
     */
    public static function index(): Collection
    {
        return Invoice::where('type', 'incoming')
            ->with('seller')
            ->get();
    }
}
