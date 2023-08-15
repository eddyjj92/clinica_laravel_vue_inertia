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
        Schema::create('permiso_user', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('permiso_id');
            $table->foreign('permiso_id')->references('id')->on('permisos')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permiso_usuario');
    }
};
