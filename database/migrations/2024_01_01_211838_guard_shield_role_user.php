<?php

use App\Models\GuardShieldRole;
use App\Models\User;
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
        Schema::create('guard_shield_role_user', function (Blueprint $table) {

            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onDelete('cascade');

            $table->unsignedBigInteger("guard_shield_role_id");
            $table->foreign("guard_shield_role_id")
                ->references("id")
                ->on("guard_shield_roles")
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guard_shield_role_user');
    }
};
