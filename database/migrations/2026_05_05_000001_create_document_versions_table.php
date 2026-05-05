<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete();

            $table->string('storage_disk')->default('local');
            $table->string('file_path');
            $table->string('original_filename');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size_bytes')->nullable();

            $table->unsignedInteger('version_number');
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->text('change_summary')->nullable();

            $table->boolean('is_current')->default(false);
            $table->timestamps();

            $table->unique(['document_id', 'version_number']);
            $table->index(['document_id', 'created_at']);
        });

        // Enforce: only one "current" version per document (PostgreSQL partial unique index).
        DB::statement("CREATE UNIQUE INDEX document_versions_one_current_per_document ON document_versions (document_id) WHERE is_current = true");
    }

    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS document_versions_one_current_per_document');
        Schema::dropIfExists('document_versions');
    }
};

