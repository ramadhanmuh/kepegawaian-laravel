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
        Schema::create('terminations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('termination_type_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('subject');
            $table->date('notice_date');
            $table->date('termination_date');
            $table->text('description');
            $table->timestamps();

            $table->foreign('termination_type_id')
                ->references('id')
                ->on('termination_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terminations');
    }
};
