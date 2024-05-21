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
        Schema::create('hour_segments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->integer('amount', false, true);
            $table->date('date');
            $table->string('payment_status')->default('Created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hour_segments');
    }
};
