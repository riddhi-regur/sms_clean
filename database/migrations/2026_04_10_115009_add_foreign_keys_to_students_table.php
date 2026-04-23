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
        Schema::table('students', function (Blueprint $table) {
            $table->foreign(['classroom_id'])->references(['id'])->on('classrooms')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['course_id'])->references(['id'])->on('courses')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign('students_classroom_id_foreign');
            $table->dropForeign('students_course_id_foreign');
            $table->dropForeign('students_user_id_foreign');
        });
    }
};
