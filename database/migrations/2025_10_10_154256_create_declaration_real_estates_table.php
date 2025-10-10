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
        Schema::create('declaration_real_estates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('declaration_id')->constrained();
            $table->enum('owner', ['self', 'spouse', 'child']);
            $table->string('location');
            $table->string('real_estate_type');
            $table->unsignedInteger('area')->comment('square meters');
            $table->string('acquisition_type');
            $table->unsignedSmallInteger('acquisition_year');
            $table->unsignedBigInteger('acquisition_value')->default(0);
            $table->unsignedBigInteger('current_value')->default(0);
            $table->text('rights_encumbrances')->default('');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declaration_real_estate_assets');
    }
};
