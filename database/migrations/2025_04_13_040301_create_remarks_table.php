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
        Schema::create('unit_remarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id'); // Foreign key to Units
            $table->text('remark')->nullable(); // Content of the remark
            $table->timestamps();
    
            // Set up the foreign key relationship
            $table->foreign('unit_id')->references('rec_id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_remarks');
    }
};
