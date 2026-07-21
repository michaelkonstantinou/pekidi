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
        Schema::create('declaration_debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('declaration_id')->constrained();
            $table->enum('owner', OwnerType::values());
            $table->string('creditor_name');
            $table->string('debt_type');
            $table->unsignedBigInteger('value')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declaration_debts');
    }
};
