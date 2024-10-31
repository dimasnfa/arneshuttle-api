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
        Schema::create('schedule_plans', function (Blueprint $table) {
            $table->id();
            $table->string('manifest_code');
            $table->string('trip_code');
            $table->string('depart');
            $table->integer('schedule_id');
            $table->integer('schedule_extra_id');
            $table->date('date');
            $table->time('etd');
            $table->integer('vehicle_list_id');
            $table->json('vehicle_data');
            $table->json('driver_data');
            $table->integer('driver_id');
            $table->decimal('fuel', 10, 2);
            $table->decimal('tol', 10, 2);
            $table->decimal('driver_funds', 10, 2);
            $table->decimal('additional_funds', 10, 2);
            $table->string('additional_note')->nullable();
            $table->decimal('total_funds', 10, 2);
            $table->string('admin_id');
            $table->integer('lateness')->nullable();
            $table->string('status');
            $table->boolean('print');
            $table->timestamps();
            $table->integer('total_ticket')->default(0);
            $table->integer('total_package')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_plans');
    }
};
