<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the interview service orders table.
     */
    public function up(): void
    {
        Schema::create('interview_service_orders', function (Blueprint $table): void {
            $table->id();
            $table->string('order_id')->unique();
            $table->string('customer_name');
            $table->string('vehicle_id');
            $table->string('technician')->nullable();
            $table->string('status');
            $table->string('priority');
            $table->decimal('labor_hours', 8, 2);
            $table->decimal('parts_cost', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Drop the interview service orders table.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_service_orders');
    }
};
