<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('document_uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Assuming authentication
            $table->integer('speed')->default(0);
            $table->integer('strength')->default(0);
            $table->integer('agility')->default(0);
            $table->integer('endurance')->default(0);
            $table->integer('flexibility')->default(0);
            $table->string('document_path')->nullable(); // Stores the uploaded document path
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_uploads');
    }
};
