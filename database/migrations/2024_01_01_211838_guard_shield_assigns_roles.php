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
            $table->foreignIdFor(config("guard-shield.provider.users.model"));
            $table->foreignIdFor(\Larakeeps\GuardShield\Models\Role::class);

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
