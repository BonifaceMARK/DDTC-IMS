<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id('rec_id'); // Auto-incrementing primary key
            $table->string('brand', 50)->nullable();
            $table->string('model', 50)->nullable();
            $table->string('company', 20)->nullable();
            $table->string('dev_type', 50)->nullable();
            $table->string('sku', 50)->nullable();
            $table->string('categ', 50)->nullable();
            $table->string('desc', 100)->nullable();
            $table->string('ser_no', 50)->nullable();
            $table->string('area', 50)->nullable();
            $table->string('vendor_com', 50)->nullable();
            $table->string('allocation', 50)->nullable();
            $table->integer('qty')->nullable();
            $table->string('bundle_item', 50)->nullable();
            $table->text('remarks')->nullable();
            $table->string('prop_tag', 50)->nullable();
            $table->string('cust_po_ref', 50)->nullable();
            $table->string('stats', 50)->nullable();
            $table->string('location', 50)->nullable();
            $table->string('input_by', 30)->nullable();
            $table->string('unit_stat', 50)->nullable();
            $table->string('vendor_type', 50)->nullable();
            $table->string('pmg_stats', 50)->nullable();
            $table->string('sales_stats', 50)->nullable();
            $table->string('sales_remarks', 100)->nullable();
            $table->date('date_add')->nullable();
            $table->date('date_pull')->nullable();
            $table->string('age', 50)->nullable();
            $table->binary('file_att')->nullable(); // Binary for LONGBLOB
            $table->longText('audit_hist')->nullable();
            $table->timestamps(); // Includes created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
