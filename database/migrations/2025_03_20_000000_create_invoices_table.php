<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $connection = config('invoices.database.connection') ?: config('database.default');

        if (config('invoices.database.tables.buyers.isActive')) {
            Schema::connection($connection)
                ->create(config('invoices.database.tables.buyers.name', 'buyers'), static function (Blueprint $table): void {
                    $table->id();
                    $table->string('name')->nullable();
                    $table->string('email')->nullable();
                    $table->string('phone')->nullable();
                    $table->string('address')->nullable();
                    $table->string('city')->nullable();
                    $table->string('state')->nullable();
                    $table->string('zip')->nullable();
                    $table->string('vat')->nullable();
                    $table->string('kvk')->nullable();
                    $table->string('country')->nullable();
                    $table->timestamps();
                });
        }

        if (config('invoices.database.tables.sellers.isActive')) {
            Schema::connection($connection)
                ->create(config('invoices.database.tables.sellers.name', 'sellers'), static function (Blueprint $table): void {
                    $table->id();
                    $table->string('name')->nullable();
                    $table->string('email')->nullable();
                    $table->string('phone')->nullable();
                    $table->string('address')->nullable();
                    $table->string('city')->nullable();
                    $table->string('state')->nullable();
                    $table->string('zip')->nullable();
                    $table->string('vat')->nullable();
                    $table->string('kvk')->nullable();
                    $table->string('country')->nullable();
                    $table->timestamps();
                });
        }

        if (config('invoices.database.tables.invoices.isActive')) {
            Schema::connection($connection)
                ->create(config('invoices.database.tables.invoices.name', 'invoices'), static function (Blueprint $table): void {
                    $table->id();
                    $table->string('invoice_id')->unique();
                    $table->string('type');
                    $table->foreignId('buyer_id')->nullable()->constrained(config('invoices.database.tables.buyers.name', 'buyers'))->nullable();
                    $table->foreignId('seller_id')->nullable()->constrained(config('invoices.database.tables.sellers.name', 'sellers'))->nullable();
                    // $table->date('date');
                    // $table->date('due_date');
                    // $table->decimal('total_amount', 10, 2);
                    // $table->decimal('tax_amount', 10, 2);
                    // $table->decimal('total_tax_amount', 10, 2);
                    // $table->decimal('total_am ount_with_tax', 10, 2);
                    // $table->string('status');
                    $table->timestamps();
                });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('invoices.database.tables.invoices.name', 'invoices'));
        Schema::dropIfExists(config('invoices.database.tables.buyers.name', 'buyers'));
        Schema::dropIfExists(config('invoices.database.tables.sellers.name', 'sellers'));
    }
};
