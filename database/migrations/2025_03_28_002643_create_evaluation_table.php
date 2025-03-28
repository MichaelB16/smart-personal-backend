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
        Schema::create('evaluation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->decimal('height');
            $table->integer('weight');
            $table->integer('percent_weight');
            $table->integer('arm');
            $table->integer('leg');
            $table->integer('waist');
            $table->integer('breastplate');
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('evaluation', function (Blueprint $table) {
            $table->dropForeign(['user_id', 'student_id']);
            $table->dropColumn('student_id');
            $table->dropColumn('user_id');
        });
        Schema::dropIfExists('evaluation');
    }
};
