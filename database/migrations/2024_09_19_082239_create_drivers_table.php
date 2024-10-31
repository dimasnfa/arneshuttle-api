<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nrp')->unique();
            $table->string('contact')->unique(); // Nomor telepon
            $table->unsignedBigInteger('regency_id');
            $table->string('licence_number')->unique();
            $table->boolean('licence_active');
            $table->string('licence_type');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes(); // Menambahkan kolom deleted_at untuk soft deletes
        });
    }

    public function down()
    {
        Schema::dropIfExists('drivers');
    }
}
