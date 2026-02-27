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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->foreignId('cargo_id')->nullable()->constrained('cargos')->nullOnDelete();
            $table->foreignId('ship_id')->nullable()->constrained('ships')->nullOnDelete();
            $table->foreignId('origin_port_id')->nullable()->constrained('ports')->nullOnDelete();
            $table->foreignId('destination_port_id')->nullable()->constrained('ports')->nullOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('crew_id')->nullable()->constrained('crews')->nullOnDelete();

            // Shipment dates
            $table->date('departure_date')->nullable();
            $table->date('arrival_estimate')->nullable();
            $table->dateTime('actual_arrival_date')->nullable();

            // Status + flags
            $table->enum('status', ['pending', 'in_transit', 'delivered', 'delayed', 'cancelled'])->default('pending');
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
