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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category')->unsigned();
            $table->foreign('category')->references('id')->on('categories');
            $table->string('title');
            $table->text('description');
            $table->string('image', 255);
            $table->bigInteger('author')->unsigned();
            $table->foreign('author')->references('id')->on('users');
            $table->unsignedInteger('student_count')->default(0)->nullable(false);
            $table->json('test')->nullable();
            $table->json('answers')->nullable();
            $table->enum('appl', ['0', '1'])->default('0');
            $table->enum('access', ['0','1'])->default('0');//1=>доступен
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
