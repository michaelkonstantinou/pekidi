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
        Schema::create('declaration_family_members', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('national_id');
            $table->string('profession');
            $table->enum('relationship', ['spouse', 'child'])->default('child');
            $table->timestamp('born_at');
            $table->timestamps();
            $table->foreignId('declaration_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declaration_family_members');
    }
};
