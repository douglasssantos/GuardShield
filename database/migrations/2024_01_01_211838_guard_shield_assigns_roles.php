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
        Schema::create('guard_shield_assigns_roles', function (Blueprint $table) {
            $table
                ->foreignId(config("guard-shield.provider.users.id"))
                ->constrained(config("guard-shield.provider.users.database"))
                ->onDelete('cascade');
            $table->foreignId('role_id')->constrained("guard_shield_roles")->onDelete('cascade');

            $table->index([config("guard-shield.provider.users.id"), "role_id"]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guard_shield_assigns_roles');
    }
};
