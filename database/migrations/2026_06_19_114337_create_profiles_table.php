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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('avatar')->nullable();       // foto profil
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();             // tentang penulis
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('address')->nullable();       // domisili
            $table->date('joined_honai')->nullable();    // tanggal gabung Honai
            $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
