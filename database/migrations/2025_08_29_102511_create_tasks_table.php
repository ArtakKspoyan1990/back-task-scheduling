<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['todo','in_progress','done'])->default('todo')->index();
            $table->date('due_at')->index();
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->nullOnDelete()->index();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();


            $table->index(['status','assigned_user_id']);
        });

        DB::statement('ALTER TABLE tasks ADD FULLTEXT fulltext_title_desc (title, description)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
