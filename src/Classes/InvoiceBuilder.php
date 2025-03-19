<?php

namespace NexDev\InvoiceCreator\Classes;

use Exception;
use NexDev\InvoiceCreator\Models\Invoice;
use NexDev\InvoiceCreator\Traits\InvoicePDF;
use NexDev\InvoiceCreator\Builders\BuyerBuilder;
use NexDev\InvoiceCreator\Traits\InvoiceHelpers;
use NexDev\InvoiceCreator\Builders\SellerBuilder;

class InvoiceBuilder
{
    use InvoiceHelpers;
    use InvoicePDF;

    public string $type;

    public string $id;

    public SellerBuilder $seller;

    public BuyerBuilder $buyer;

    public function __construct(string $type, ?Invoice $invoice = null)
    {
        if (! in_array($type, ['incoming', 'outgoing'])) {
            throw new Exception('Invalid invoice type');
        }

        $this->type = $type;
        $this->id   = $invoice ? $invoice->invoice_id : $this->generateId();
    }

    public function getSerialNumber(): string
    {
        /** @var string $prefix */
        $prefix = config('invoices.prefix', 'INV');
        /** @var string $number */
        $number = config('invoices.number', '1');

        return "{$prefix} {$number}";
    }

    public function saveToDatabase(): self
    {
        /** @var class-string<Invoice> $modelClass */
        $modelClass = Invoice::class;
        $modelClass::updateOrCreate(
            ['invoice_id' => $this->id],
            ['type' => $this->type]
        );

        return $this;
    }

    public function setSeller(SellerBuilder $seller): self
    {
        $this->seller = $seller;

        return $this;
    }

    public function getSeller(): SellerBuilder
    {
        return $this->seller;
    }

    public function setBuyer(BuyerBuilder $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function getBuyer(): BuyerBuilder
    {
        return $this->buyer;
    }
}
