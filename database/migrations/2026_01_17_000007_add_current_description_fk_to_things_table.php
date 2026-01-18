<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('things', function (Blueprint $table) {
            $table->foreign('current_description_id')
                ->references('id')
                ->on('thing_descriptions')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('things', function (Blueprint $table) {
            $table->dropForeign(['current_description_id']);
        });
    }
};
