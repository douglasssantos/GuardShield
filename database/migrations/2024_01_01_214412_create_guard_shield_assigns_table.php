<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Larakeeps\GuardShield\Models\GuardShieldPermission;
use Larakeeps\GuardShield\Models\GuardShieldRole;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guard_shield_assigns', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(GuardShieldRole::class);
            $table->foreignIdFor(GuardShieldPermission::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guard_shield_assigns');
    }
};
