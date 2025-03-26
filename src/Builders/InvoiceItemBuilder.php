<?php

namespace NexDev\InvoiceCreator\Builders;

use NexDev\InvoiceCreator\Models\InvoiceItem;
use NexDev\InvoiceCreator\Traits\HasDynamicAttributes;

/**
 * @method string getName()
 * @method float getUnit_price()
 * @method int getQuantity()
 * @method self setName(string $name)
 * @method self setUnit_price(float $unit_price)
 * @method self setQuantity(int $quantity)
 */
class InvoiceItemBuilder
{
    use HasDynamicAttributes;

    public function __construct()
    {
        $this->setAllowedAttributes([
            'name',
            'unit_price',
            'quantity',
            'invoice_id',
        ]);
    }

    public function getTotal(): float
    {
        return $this->getUnit_price() * $this->getQuantity();
    }

    public function saveToDatabase(): self
    {
        /** @var class-string<InvoiceItem> $invoiceItemClass */
        $invoiceItemClass = config('invoices.models.invoice_item');
        (new $invoiceItemClass)
            ->create($this->toArray());

        return $this;
    }
}
