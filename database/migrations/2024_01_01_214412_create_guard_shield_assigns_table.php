<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Larakeeps\GuardShield\Models\Permission;
use Larakeeps\GuardShield\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guard_shield_assigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained("guard_shield_roles")->onDelete('cascade');
            $table->foreignId('permission_id')->constrained("guard_shield_permissions")->onDelete('cascade');
            $table->index(['role_id', 'permission_id']);
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
