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
        Schema::create('articles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');        // penulis artikel
        $table->foreignId('category_id')
              ->constrained()
              ->onDelete('cascade');        // kategori artikel
        $table->string('title');            // judul artikel
        $table->string('slug')->unique();   // URL artikel
        $table->text('excerpt')->nullable();// ringkasan artikel
        $table->longText('content');        // isi artikel
        $table->string('cover_image')->nullable(); // foto sampul
        $table->enum('status', ['draft', 'pending', 'published', 'rejected'])
              ->default('draft');           // status moderasi
        $table->timestamp('published_at')->nullable();
        $table->integer('views')->default(0); // jumlah pembaca
        $table->boolean('is_featured')->default(false); // artikel pilihan
        $table->timestamps();
        $table->softDeletes();              // hapus tidak permanen
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
