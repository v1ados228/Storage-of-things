<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archived_things', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description_text')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('last_user_name')->nullable();
            $table->string('place_name')->nullable();
            $table->timestamp('restored_at')->nullable();
            $table->foreignId('restored_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archived_things');
    }
};
