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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_commande')->unique();
            $table->foreignId('utilisateur_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('montant_total', 10, 2)->default(0);
            $table->timestamp('date')->useCurrent();
            $table->enum('statut', ['en_attente', 'validee', 'en_livraison', 'livree', 'annulee'])->default('en_attente');
            $table->enum('mode_paiement', ['livraison', 'carte', 'virement', 'cheque', 'paypal'])->default('carte');
            $table->text('adresse_livraison');
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
