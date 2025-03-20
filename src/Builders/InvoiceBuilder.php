<?php

namespace NexDev\InvoiceCreator\Builders;

use Exception;
use NexDev\InvoiceCreator\Models\Invoice;
use NexDev\InvoiceCreator\Traits\InvoicePDF;
use NexDev\InvoiceCreator\Traits\InvoiceHelpers;

class InvoiceBuilder
{
    use InvoiceHelpers;
    use InvoicePDF;

    public string $type;

    public string $id;

    public SellerBuilder $seller;

    public BuyerBuilder $buyer;

    /** @var array<InvoiceItemBuilder> */
    public array $items = [];

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
        $array      = ['type' => $this->type];

        if ($this->seller->savedToDatabase) {
            $array['seller_id'] = $this->seller->model->id;
        }

        if ($this->buyer->savedToDatabase) {
            $array['buyer_id'] = $this->buyer->model->id;
        }

        $modelClass::updateOrCreate(
            ['invoice_id' => $this->id],
            $array
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

    public function addItem(InvoiceItemBuilder $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Add multiple items to the invoice.
     *
     * @param array<InvoiceItemBuilder> $items
     */
    public function addItems(array $items): self
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    /**
     * Get all items from the invoice.
     *
     * @return array<InvoiceItemBuilder>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): float
    {
        return array_sum(array_map(fn (InvoiceItemBuilder $item) => $item->getTotal(), $this->items));
    }
}
