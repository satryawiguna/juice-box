<?php

use App\Enums\EntitySchema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->uuid('user_id', 36);
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->unsignedTinyInteger('permission_id');
            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
    }
};
