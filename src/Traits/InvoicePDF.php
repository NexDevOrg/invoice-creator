<?php

namespace NexDev\InvoiceCreator\Traits;

use Exception;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf as PdfFacade;

trait InvoicePDF
{
    public ?Pdf $pdf = null;

    public string $disk;

    private bool $isLoaded = false;

    private string $output;

    public function getPDF(): Pdf
    {
        if (! $this->pdf) {
            throw new Exception('PDF not loaded');
        }

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

        $viewPath = config('invoices.view');
        if (! is_string($viewPath)) {
            throw new Exception('Invalid view path configuration');
        }

        $view     = View::make($viewPath, ['invoice' => $this]);
        $html     = mb_convert_encoding($view->render(), 'HTML-ENTITIES', 'UTF-8');

        $this->pdf      = PdfFacade::loadHTML($html);
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
