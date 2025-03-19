<?php

namespace NexDev\InvoiceCreator\Traits;

use Symfony\Component\HttpFoundation\File\File;

trait InvoiceHelpers
{
    public string $logo = '';

    public function setLogo(string $logo): self
    {
        $file       = new File($logo);
        $this->logo = 'data:' . $file->getMimeType() . ';base64,' . base64_encode($file->getContent());

        return $this;
    }
}
