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
        Schema::create('ships', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('registration_number', 200)->unique();
            $table->decimal('capacity_in_tonnes', 10, 2)->nullable();
            $table->enum('type', [
                'cargo ship',
                'passenger ship',
                'military ship',
                'icebreaker',
                'fishing vessel',
                'barge ship'
            ])->default('cargo ship');
            $table->enum('status', [
                'active',
                'under maintenance',
                'decommissioned'
            ])->default('active');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ships');
    }
};
