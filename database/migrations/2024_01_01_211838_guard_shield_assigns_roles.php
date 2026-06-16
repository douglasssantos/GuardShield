<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Larakeeps\GuardShield\Models\Table;

return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Table::AssignsRoles(), function (Blueprint $table) {

            if(config("guard-shield.provider.users.key_type") === "uuid"){

                $table->foreignUuid(config("guard-shield.provider.users.id"))
                ->constrained(Table::Users())
                ->onDelete('cascade');

            }else{

                $table->foreignId(config("guard-shield.provider.users.id"))
                ->constrained(Table::Users())
                ->onDelete('cascade');

            }

            $table->foreignId('role_id')->constrained(Table::Roles())->onDelete('cascade');

            $table->index([config("guard-shield.provider.users.id"), "role_id"]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Table::AssignsRoles());
    }
};
