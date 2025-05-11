<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('academy_addresses', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->timestamps();
            $table->softDeletes();
            $table->string('street');
            $table->string('complement')->nullable();
            $table->string('cep');
            $table->string('number');
            $table->foreignId('academy_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('city_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('academy_addresses');
    }
};
