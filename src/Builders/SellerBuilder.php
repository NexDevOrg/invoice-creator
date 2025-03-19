<?php

namespace NexDev\InvoiceCreator\Builders;

use NexDev\InvoiceCreator\Traits\HasDynamicAttributes;

/**
 * @method self setName(string $name)
 * @method self setEmail(string $email)
 * @method self setPhone(string $phone)
 * @method self setAddress(string $address)
 * @method self setCity(string $city)
 * @method self setState(string $state)
 * @method self setZip(string $zip)
 * @method self setVat(string $vat)
 * @method self setKvk(string $kvk)
 * @method string getName()
 * @method string getEmail()
 * @method string getPhone()
 * @method string getAddress()
 * @method string getCity()
 * @method string getState()
 * @method string getZip()
 * @method string getVat()
 * @method string getKvk()
 */
class SellerBuilder
{
    use HasDynamicAttributes;

    public function __construct()
    {
        $this->setAllowedAttributes([
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
        ]);

        $this->setRequiredAttributes([
            'name',
            'email',
            'address',
        ]);
    }
}
