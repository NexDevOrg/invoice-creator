<?php

namespace NexDev\InvoiceCreator\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $invoice_id
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 * @property int $buyer_id
 * @property int $seller_id
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
        // 'date',
        // 'due_date',
        // 'total_amount',
        // 'tax_amount',
    ];

    /**
     * @return BelongsTo<Buyer, Invoice>
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class);
    }

    /**
     * @return BelongsTo<Seller, Invoice>
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
}
