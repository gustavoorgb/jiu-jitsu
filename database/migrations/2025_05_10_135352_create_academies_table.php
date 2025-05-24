<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('academies', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('parent_academy_id')->nullable()->constrained('academies')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
            $table->string('name');
            $table->string('confederation')->nullable();
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        if (!Schema::hasTable('academy_owners')) {
            Schema::table('academies', function(Blueprint $table){
                 $table->dropForeign(['parent_academy_id']);
                 $table->dropColumn('parent_academy_id');
            });
            Schema::dropIfExists('academies');
        }
    }
};
