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
        Schema::create('declaration_businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('declaration_id')->constrained();
            $table->enum('owner', ['self', 'spouse', 'child']);
            $table->string('name');
            $table->string('business_type');
            $table->string('involvement_type');
            $table->unsignedBigInteger('value')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declaration_businesses');
    }
};
