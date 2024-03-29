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
        Schema::create('guard_shield_permissions', function (Blueprint $table) {
            $table->id();
            $table->string("key")->nullable();
            $table->string("name");
            $table->string('description')->nullable();
            $table->json("params")->nullable();
            $table->boolean("active")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guard_shield_permissions');
    }
};
