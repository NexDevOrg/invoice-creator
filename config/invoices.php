<?php

return [
    /**
     * The prefix of the invoice number.
     */
    'prefix' => env('INVOICE_PREFIX', 'INV'),

    /**
     * The number of the invoice. Will be used to generate the first invoice number, after that it will be automatically incremented.
     */
    'number' => env('INVOICE_NUMBER', 1),
    /**
     * The format of the invoice number. '00000' will be 00001, 00002, 00003, etc.
     */
    'number_format' => env('INVOICE_NUMBER_FORMAT', '00000'),

    /**
     * The view of the invoice.
     */
    'view' => 'invoices::templates.default',

    /**
     * The storage disk and path of the invoices.
     */
    'storage' => [
        'incoming' => [
            'disk' => env('INVOICE_INCOMING_DISK', 'incoming_invoices'),
            'path' => env('INVOICE_INCOMING_PATH', 'invoices/incoming'),
        ],
        'outgoing' => [
            'disk' => env('INVOICE_OUTGOING_DISK', 'outgoing_invoices'),
            'path' => env('INVOICE_OUTGOING_PATH', 'invoices/outgoing'),
        ],
    ],

    'models' => [
        'invoice' => \NexDev\InvoiceCreator\Models\Invoice::class,
        'buyer'   => \NexDev\InvoiceCreator\Models\Buyer::class,
        'seller'  => \NexDev\InvoiceCreator\Models\Seller::class,
    ],

    /**
     * The database connection and table name of the invoices.
     *
     * warning: Changing the table name will not rename the existing tables
     */
    'database' => [
        'connection' => env('INVOICE_DB_CONNECTION'),

        'tables' => [
            'invoices' => [
                'isActive' => true, // Whether the table is being created or not
                'name'     => 'invoices', // The name of the table
            ],
            'buyers' => [
                'isActive' => true, // Whether the table is being created or not
                'name'     => 'buyers', // The name of the table
            ],
            'sellers' => [
                'isActive' => true, // Whether the table is being created or not
                'name'     => 'sellers', // The name of the table
            ],
        ],
    ],

    /**
     * The seller information, that can be overridden in the invoice data.
     *
     * warning: Changing the seller information will not update the existing invoices
     */
    'seller' => [
        'name'    => env('INVOICE_SELLER_NAME'),
        'email'   => env('INVOICE_SELLER_EMAIL'),
        'phone'   => env('INVOICE_SELLER_PHONE'),
        'address' => env('INVOICE_SELLER_ADDRESS'),
        'city'    => env('INVOICE_SELLER_CITY'),
        'state'   => env('INVOICE_SELLER_STATE'),
        'zip'     => env('INVOICE_SELLER_ZIP'),
        'country' => env('INVOICE_SELLER_COUNTRY'),
        'vat'     => env('INVOICE_SELLER_VAT'),
        'code'    => env('INVOICE_SELLER_CODE'),
    ],
];
