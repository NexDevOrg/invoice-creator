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
                    $table->foreignId('buyer_id')->nullable();
                    $table->foreignId('seller_id')->nullable();
                    $table->string('currency')->default('EUR');
                    $table->date('date')->default(now());
                    $table->decimal('total_amount', 10, 2)->default(0);
                    $table->decimal('tax_amount', 10, 2)->default(0);
                    $table->decimal('total_tax_amount', 10, 2)->default(0);
                    $table->timestamps();
                });
        }

        if (config('invoices.database.tables.invoice_items.isActive')) {
            Schema::connection($connection)
                ->create(config('invoices.database.tables.invoice_items.name', 'invoice_items'), static function (Blueprint $table): void {
                    $table->id();
                    $table->foreignId('invoice_id')->nullable()->constrained(config('invoices.database.tables.invoices.name', 'invoices'));
                    $table->string('name')->nullable();
                    $table->decimal('unit_price', 10, 2)->nullable();
                    $table->integer('quantity')->nullable();
                    $table->decimal('total', 10, 2)->nullable();
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
