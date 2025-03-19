<?php

namespace NexDev\InvoiceCreator\Traits;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\File;

trait InvoiceHelpers
{
    private string $logo = '';

    public function setLogo(string $logo): self
    {
        $file       = new File($logo);
        $this->logo = 'data:' . $file->getMimeType() . ';base64,' . base64_encode($file->getContent());

        return $this;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function generateId(): string
    {
        /** @var string $prefix */
        $prefix = config('invoices.prefix') ?? '';
        /** @var int $startNumber */
        $startNumber = config('invoices.number') ?? 1;
        /** @var string $numberFormat */
        $numberFormat = config('invoices.number_format') ?? '00000';
        /** @var string $table */
        $table = config('invoices.table', 'invoices');

        /** @var string|null $latestInvoiceId */
        $latestInvoiceId = DB::table($table)
            ->where('invoice_id', 'like', "{$prefix}%")
            ->orderBy('invoice_id', 'desc')
            ->value('invoice_id');

        if ($latestInvoiceId) {
            $latestNumber = (int) substr($latestInvoiceId, strlen($prefix));
            $nextNumber   = $latestNumber + 1;
        } else {
            $nextNumber = $startNumber;
        }

        return $prefix . str_pad((string) $nextNumber, strlen($numberFormat), '0', STR_PAD_LEFT);
    }
}
