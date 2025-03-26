<?php

namespace NexDev\InvoiceCreator\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $invoice_id
 * @property string $name
 * @property float $unit_price
 * @property int $quantity
 * @property float $total
 *
 * @method self create(array<string, mixed> $attributes)
 */
class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'name',
        'unit_price',
        'quantity',
        'total',
    ];

    /**
     * @return BelongsTo<Invoice, InvoiceItem>
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
