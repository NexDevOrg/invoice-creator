# Laravel Invoice Creator

A Laravel package for creating and managing invoices in your Laravel application.

## Installation

### 1. Install the package with Composer

Run the following command in your Laravel project:

```bash
composer require nexdev/invoice-creator
```

### 2. Setup the package

Run the following artisan command to install the package:

```bash
php artisan invoice:install
```

During the installation, you'll be prompted with two questions:

1. **Install views?** (yes/no) [no]
   - This will publish the Invoice template, allowing you to customize the appearance of your invoices.

2. **Install config?** (yes/no) [no]
   - This will publish the configuration file.

### 3. Configure Storage (Optional)

If you want to store the invoices in storage, add the following storage disks to your `config/filesystems.php` file:

```php
'disks' => [
    // ... other disks ...

    'incoming_invoices' => [
        'driver' => 'local',
        'root' => storage_path('app/incoming_invoices'),
        'url' => env('APP_URL').'/storage/incoming_invoices',
        'visibility' => 'public',
        'throw' => false,
        'report' => false,
    ],

    'outgoing_invoices' => [
        'driver' => 'local',
        'root' => storage_path('app/outgoing_invoices'),
        'url' => env('APP_URL').'/storage/outgoing_invoices',
        'visibility' => 'public',
        'throw' => false,
        'report' => false,
    ],
],
```

> **Note**: The disk names should match those in the `invoices.php` config file. You can configure the drivers as needed, but maintain the same names.

## Usage

### Creating an Invoice

The package provides a fluent interface for creating invoices. Here's an example of how to create an outgoing invoice:

```php
use NexDev\InvoiceCreator\Models\Seller;
use NexDev\InvoiceCreator\Models\Buyer;
use NexDev\InvoiceCreator\Models\OutgoingInvoice;

// Create the seller information
$seller = Seller::make()
    ->setName('Acme Corporation')
    ->setEmail('contact@acme.com')
    ->setPhone('+1 (555) 123-4567')
    ->setAddress('123 Business Street')
    ->setZip('10001')
    ->setCity('New York')
    ->setCountry('United States')
    ->setKvk('12345678')
    ->setVat('US12345678901');

// Create the buyer information
$buyer = Buyer::make()
    ->setName('Tech Solutions Ltd')
    ->setAddress('456 Innovation Drive')
    ->setZip('EC2A 4PB')
    ->setCity('London')
    ->setCountry('United Kingdom');

// Create and process the invoice
return OutgoingInvoice::make()
    ->setLogo('images/logo.png')
    ->setSeller($seller)
    ->setBuyer($buyer)
    ->setId('INV-2025-001')
    ->saveToDatabase()
    ->saveToStorage()
    ->stream();
```

### Available Methods

#### Seller
fields:
- `setName(string $name)`
- `setAddress(string $address)`
- `setZip(string $zip)`
- `setCity(string $city)`
- `setCountry(string $country)`
- `setEmail(string $email)`
- `setPhone(string $phone)`
- `setKvk(string $kvk)`
- `setVat(string $vat)`

#### Buyer
fields:
- `setName(string $name)`
- `setAddress(string $address)`
- `setZip(string $zip)`
- `setCity(string $city)`
- `setCountry(string $country)`
- `setEmail(string $email)`
- `setPhone(string $phone)`
- `setKvk(string $kvk)`
- `setVat(string $vat)`

#### Invoice
- `setLogo(string $path)`
- `setSeller(Seller $seller)`
- `setBuyer(Buyer $buyer)`
- `setId(string $id)`
- `saveToDatabase()`
- `saveToStorage()`
- `stream()`

### Features

- **Fluent Interface**: Easy-to-use method chaining for creating invoices
- **Database Storage**: Save invoice data to the database
- **File Storage**: Save generated invoices to storage
- **Streaming**: Stream the generated invoice directly to the browser
- **Customizable**: Modify the invoice template to match your brand
