<?php

namespace NexDev\InvoiceCreator\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use NexDev\InvoiceCreator\Models\Invoice as InvoiceModel;

class InstallCommand extends Command
{
    protected $signature = 'invoice:install';

    protected $description = 'Install the invoice creator';

    public function handle()
    {
        $this->info('Installing invoice creator...');

        if ($this->confirm('Do you want to install the views?')) {
            $this->callSilent('vendor:publish', [
                '--tag' => 'invoices.views',
            ]);
        }

        if ($this->confirm('Do you want to install the config?')) {
            $shouldOverwrite = file_exists(config_path('invoices.php'))
                ? $this->confirm('Config already exists, do you want to overwrite it?')
                : true;

            if ($shouldOverwrite) {
                $this->callSilent('vendor:publish', [
                    '--tag'   => 'invoices.config',
                    '--force' => $shouldOverwrite,
                ]);
            }
        }

        if ($this->confirm('Do you want to create the InvoicePolicy in your application?')) {
            $policyPath = app_path('Policies/InvoicePolicy.php');

            if (File::exists($policyPath)) {
                if ($this->confirm('InvoicePolicy already exists, do you want to overwrite it?')) {
                    $this->callSilent('make:policy', [
                        'name'    => 'InvoicePolicy',
                        '--model' => InvoiceModel::class,
                        '--force' => true,
                    ]);
                    $this->info('InvoicePolicy overwritten successfully.');
                }
            } else {
                $this->callSilent('make:policy', [
                    'name'    => 'InvoicePolicy',
                    '--model' => InvoiceModel::class,
                ]);
                $this->info('InvoicePolicy created successfully.');
            }
        }

        $this->info('Invoice creator installed successfully.');
    }
}
