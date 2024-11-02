<?php

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
        Schema::create('file_share', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->nullable()->constrained('files')->onDelete('cascade');
            $table->foreignId('folder_id')->nullable()->constrained('folders')->onDelete('cascade');
            $table->foreignId('shared_with_id')->constrained('users')->onDelete('cascade');
            $table->enum('permission', ['view', 'edit'])->default('view');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_share');
    }
};
