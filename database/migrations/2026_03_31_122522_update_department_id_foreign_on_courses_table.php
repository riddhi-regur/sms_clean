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
        Schema::table('courses', function (Blueprint $table) {
              // drop existing foreign key
            $table->dropForeign(['department_id']);

            // add new foreign key with restrict on delete
            $table->foreign('department_id')
                  ->references('id')->on('departments')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
             $table->dropForeign(['department_id']);
            // restore previous behavior (if it was cascade)
            $table->foreign('department_id')
                  ->references('id')->on('departments')
                  ->onDelete('cascade');
        });
    }
};
