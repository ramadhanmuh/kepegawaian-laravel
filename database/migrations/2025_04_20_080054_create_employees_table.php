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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('number')->unique();
            $table->unsignedBigInteger('designation_id');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();
            $table->enum('gender', ['pria', 'wanita']);
            $table->enum('religion', [
                'islam', 'kristen_protestan', 'kristen_katolik',
                'hindu', 'buddha', 'konghucu'
            ]);
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->date('date_of_joining');
            $table->enum('marital_status', [
                'belum_menikah', 'sudah_menikah'
            ]);
            $table->text('photo');
            $table->text('address');
            $table->timestamps();

            $table->foreign('designation_id')
                ->references('id')
                ->on('designations')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
