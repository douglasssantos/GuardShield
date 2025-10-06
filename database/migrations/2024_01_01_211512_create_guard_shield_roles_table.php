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
        Schema::create('guard_shield_roles', function (Blueprint $table) {
            $table->id();
            $table->string("key")->nullable();
            $table->string('name');
            $table->string('description');
            $table->timestamps();

            $table->index(["key", "name"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guard_shield_roles');
    }
};
