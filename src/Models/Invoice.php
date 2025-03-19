<?php

namespace NexDev\InvoiceCreator\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property string $invoice_id
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static Builder<self> where(string $column, mixed $operator, mixed $value = null)
 * @method static self updateOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 */
class Invoice extends Model
{
    protected $fillable = [
        'invoice_id',
        'type',
    ];
}
