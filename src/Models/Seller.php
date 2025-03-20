<?php

namespace NexDev\InvoiceCreator\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $vat
 * @property string $kvk
 * @property string $country
 * @property string $created_at
 * @property string $updated_at
 */
class Seller extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'vat',
        'kvk',
        'country',
    ];

    /**
     * @return HasMany<Invoice, Seller>
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
