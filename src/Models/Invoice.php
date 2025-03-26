<?php

namespace NexDev\InvoiceCreator\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $invoice_id
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 * @property int $buyer_id
 * @property int $seller_id
 * @property string $currency
 * @property string $date
 * @property float $total_amount
 * @property float $tax_amount
 * @property float $total_tax_amount
 * @property ?Buyer $buyer
 *
 * @method static Builder<self> where(string $column, mixed $operator, mixed $value = null)
 * @method static self updateOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 */
class Invoice extends Model
{
    protected $fillable = [
        'invoice_id',
        'type',
        'buyer_id',
        'seller_id',
        'currency',
        'date',
        'total_amount',
        'tax_amount',
        'total_tax_amount',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'date'             => 'date',
        'total_amount'     => 'decimal:2',
        'tax_amount'       => 'decimal:2',
        'total_tax_amount' => 'decimal:2',
    ];

    /**
     * Get the buyer associated with the invoice.
     *
     * @phpstan-return BelongsTo<Model, Invoice>
     */
    public function buyer(): BelongsTo
    {
        /** @var class-string<Model> $buyerClass */
        $buyerClass = config('invoices.models.buyer');

        return $this->belongsTo($buyerClass);
    }

    /**
     * @return BelongsTo<Seller, Invoice>
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * @return HasMany<InvoiceItem, Invoice>
     */
    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
