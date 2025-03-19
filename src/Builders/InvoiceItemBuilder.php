<?php

namespace NexDev\InvoiceCreator\Builders;

use NexDev\InvoiceCreator\Traits\HasDynamicAttributes;

/**
 * @method string getName()
 * @method float getUnitPrice()
 * @method int getQuantity()
 * @method self setName(string $name)
 * @method self setUnitPrice(float $unitPrice)
 * @method self setQuantity(int $quantity)
 */
class InvoiceItemBuilder
{
    use HasDynamicAttributes;

    public function __construct()
    {
        $this->setAllowedAttributes([
            'name',
            'unitPrice',
            'quantity',
        ]);
    }

    public function getTotal(): float
    {
        return $this->getUnitPrice() * $this->getQuantity();
    }
}
