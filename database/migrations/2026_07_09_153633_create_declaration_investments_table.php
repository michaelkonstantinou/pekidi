<?php

use App\Types\OwnerType;
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
        Schema::create('declaration_investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('declaration_id')->constrained();
            $table->enum('owner', OwnerType::values());
            $table->string('name');
            $table->string('registration_number')->nullable();
            $table->string('country')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->string('acquisition_type')->nullable();
            $table->unsignedSmallInteger('acquisition_year')->nullable();
            $table->unsignedBigInteger('value')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declaration_investments');
    }
};
