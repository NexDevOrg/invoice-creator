<?php

namespace NexDev\InvoiceCreator\Console;

use Illuminate\Console\Command;

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

        $this->info('Invoice creator installed successfully.');
    }
}
