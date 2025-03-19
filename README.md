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
