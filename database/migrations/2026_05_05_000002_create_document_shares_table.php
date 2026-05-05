<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete();

            $table->foreignId('shared_by_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('shared_with_user_id')->constrained('users')->cascadeOnDelete();

            $table->string('permission', 16); // 'view' | 'edit'
            $table->timestamps();

            $table->unique(['document_id', 'shared_with_user_id']);
            $table->index(['shared_with_user_id', 'permission']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_shares');
    }
};

