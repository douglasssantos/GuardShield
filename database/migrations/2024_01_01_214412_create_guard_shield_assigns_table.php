<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Larakeeps\GuardShield\Models\Permission;
use Larakeeps\GuardShield\Models\Role;
use Larakeeps\GuardShield\Models\Table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Table::AssignsPermissions(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained(Table::Roles())->onDelete('cascade');
            $table->foreignId('permission_id')->constrained(Table::Permissions())->onDelete('cascade');
            $table->index(['role_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Table::AssignsPermissions());
    }
};
