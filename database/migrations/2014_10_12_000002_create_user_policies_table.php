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
        Schema::create('user_policies', function (Blueprint $table) {
            $table->uuid('user_id', 36);
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->unsignedTinyInteger('policy_id');
            $table->foreign('policy_id')
                ->references('id')
                ->on('policies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_policies');
    }
};
