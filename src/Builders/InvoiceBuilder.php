<?php

namespace NexDev\InvoiceCreator\Builders;

use Exception;
use Carbon\Carbon;
use NexDev\InvoiceCreator\Classes\Buyer;
use NexDev\InvoiceCreator\Classes\Seller;
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

    public ?string $sellerId = null;

    public ?int $buyerId = null;

    public string $currency;

    public float $vatPercentage;

    /** @var array<InvoiceItemBuilder> */
    public array $items = [];

    public ?int $dbId = null;

    public string $date;

    public function __construct(string $type, ?Invoice $invoice = null)
    {
        if (! in_array($type, ['incoming', 'outgoing'])) {
            throw new Exception('Invalid invoice type');
        }

        $this->type          = $type;
        $this->id            = $invoice ? $invoice->invoice_id : $this->generateId();
        $this->vatPercentage = config('invoices.vat');
        $this->currency      = $invoice ? $invoice->currency : config('invoices.currency');
        $this->date          = $invoice ? (new Carbon($invoice->date))->format('Y-m-d') : now()->format('Y-m-d');

        if ($invoice && $invoice->buyer) {
            $this->buyerId = $invoice->buyer->id;
        } else {
            $this->buyer = Buyer::make()
                ->setName(config('invoices.buyer.name'))
                ->setEmail(config('invoices.buyer.email'))
                ->setPhone(config('invoices.buyer.phone'))
                ->setAddress(config('invoices.buyer.address'))
                ->setCity(config('invoices.buyer.city'))
                ->setZip(config('invoices.buyer.zip'))
                ->setCountry(config('invoices.buyer.country'));
            $this->buyerId = null;
        }

        $this->seller = Seller::make()
            ->setName(config('invoices.seller.name'))
            ->setEmail(config('invoices.seller.email'))
            ->setPhone(config('invoices.seller.phone'))
            ->setAddress(config('invoices.seller.address'))
            ->setCity(config('invoices.seller.city'))
            ->setZip(config('invoices.seller.zip'))
            ->setCountry(config('invoices.seller.country'))
            ->setVat(config('invoices.seller.vat'))
            ->setKvk(config('invoices.seller.kvk'));
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
        $array      = ['type' => $this->type, 'currency' => $this->currency];

        if ($this->seller->savedToDatabase) {
            $array['seller_id'] = $this->seller->model->id;
        }

        if ($this->buyer->savedToDatabase) {
            $array['buyer_id'] = $this->buyer->model->id;
        }

        if ($this->sellerId) {
            $array['seller_id'] = $this->sellerId;
        }

        if ($this->buyerId) {
            $array['buyer_id'] = $this->buyerId;
        }

        $totalAmount    = $this->getTotal();
        $taxAmount      = $totalAmount * $this->vatPercentage / 100;
        $totalTaxAmount = $totalAmount + $taxAmount;

        $array['total_amount']     = $totalAmount;
        $array['tax_amount']       = $taxAmount;
        $array['total_tax_amount'] = $totalTaxAmount;

        $this->dbId = $modelClass::updateOrCreate(
            ['invoice_id' => $this->id],
            $array
        )->id;

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

    public function setSellerId(string $sellerId): self
    {
        $this->sellerId = $sellerId;

        return $this;
    }

    public function setBuyerId(int $buyerId): self
    {
        $this->buyerId = $buyerId;

        return $this;
    }

    public function getSellerId(): ?string
    {
        return $this->sellerId;
    }

    public function getBuyerId(): ?int
    {
        return $this->buyerId;
    }

    public function addItem(InvoiceItemBuilder $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getPaymentDetails(): array
    {
        /** @var array<string, string> $paymentDetails */
        $paymentDetails = config('invoices.payment_details');

        return $paymentDetails;
    }

    public function getVatPercentage(): float
    {
        return $this->vatPercentage;
    }

    public function setVatPercentage(float $vatPercentage): self
    {
        $this->vatPercentage = $vatPercentage;

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

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}
