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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('prix', 10, 2);
            $table->integer('quantite')->default(0);
            $table->string('taille')->nullable();
            $table->string('couleur')->nullable();
            $table->string('compression')->nullable();
            $table->boolean('visibilite')->default(true);
            $table->foreignId('categorie_id')->constrained('categories')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
