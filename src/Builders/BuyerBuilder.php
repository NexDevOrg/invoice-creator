<?php

namespace NexDev\InvoiceCreator\Builders;

use NexDev\InvoiceCreator\Models\Buyer;
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
class BuyerBuilder
{
    use HasDynamicAttributes;

    /** @var Buyer */
    public $model;

    public bool $savedToDatabase = false;

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

        /** @var class-string<Buyer>|null $modelClass */
        $modelClass  = config('invoices.models.buyer');
        $this->model = ($modelClass && class_exists($modelClass))
            ? new $modelClass
            : new Buyer;
    }

    public function saveToDatabase(): self
    {
        $this->validate();

        if (! $this->savedToDatabase) {
            /** @var Buyer $model */
            $model    = $this->model;
            $newModel = $model->newInstance()->forceFill($this->toArray());
            $newModel->save();
            $this->model = $newModel;
        } else {
            $this->model->update($this->toArray());
        }

        $this->savedToDatabase = true;

        return $this;
    }
}
