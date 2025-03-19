<?php

namespace NexDev\InvoiceCreator\Classes;

use Exception;
use NexDev\InvoiceCreator\Traits\InvoicePDF;
use NexDev\InvoiceCreator\Traits\InvoiceHelpers;

class InvoiceBuilder
{
    use InvoiceHelpers;
    use InvoicePDF;

    public string $type;

    public function __construct(string $type)
    {
        if (! in_array($type, ['incoming', 'outgoing'])) {
            throw new Exception('Invalid invoice type');
        }

        $this->type = $type;
    }

    public function getSerialNumber(): string
    {
        /** @var string $prefix */
        $prefix = config('invoices.prefix', 'INV');
        /** @var string $number */
        $number = config('invoices.number', '1');

        return "{$prefix} {$number}";
    }
}
