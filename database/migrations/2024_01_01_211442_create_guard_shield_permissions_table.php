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

        Schema::create(Table::Modules(), function (Blueprint $table) {
            $table->id();
            $table->string("key")->nullable();
            $table->string("name");
            $table->string('description')->nullable();
            $table->timestamps();
            $table->index(["key", "name"]);
        });

        Schema::create(Table::Permissions(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->nullable()->constrained(Table::Modules())->nullOnDelete('cascade');
            $table->string("key")->nullable();
            $table->string("name");
            $table->string('description')->nullable();
            $table->json("params")->nullable();
            $table->boolean("active")->default(true);
            $table->timestamps();

            $table->index(["module_id", "key", "name", "active"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Table::Permissions());
        Schema::dropIfExists(Table::Modules());
    }
};
