<?php

namespace NexDev\InvoiceCreator\Traits;

use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf as PdfFacade;

trait InvoicePDF
{
    public $pdf;

    public string $disk;

    private bool $isLoaded = false;

    private string $output;

    public function getPDF(): Pdf
    {
        return $this->pdf;
    }

    public function getFileName(): string
    {
        return "{$this->type}-{$this->getSerialNumber()}.pdf";
    }

    public function saveToStorage(): self
    {
        $this->load();

        // TODO: Implement the storage saving

        return $this;
    }

    public function load(): self
    {
        if ($this->isLoaded) {
            return $this;
        }

        $view     = View::make(config('invoices.view'), ['invoice' => $this]);
        $html     = mb_convert_encoding($view, 'HTML-ENTITIES', 'UTF-8');

        $this->pdf      = PdfFacade::loadHtml($html);
        $this->isLoaded = true;
        $this->output   = $this->pdf->output();

        return $this;
    }

    public function stream(): Response
    {
        $this->load();

        return new Response($this->output, \Symfony\Component\HttpFoundation\Response::HTTP_OK, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $this->getFileName() . '"',
        ]);
    }

    public function download(): Response
    {
        $this->load();

        return new Response($this->output, \Symfony\Component\HttpFoundation\Response::HTTP_OK, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $this->getFileName() . '"',
            'Content-Length'      => strlen($this->output),
        ]);
    }
}
