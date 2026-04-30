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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospitalisation_id')->constrained()->onDelete('cascade');
            $table->decimal('montant_chambre', 10, 2);
            $table->decimal('montant_soins', 10, 2)->default(0);
            $table->decimal('montant_total', 10, 2);
            $table->string('statut_paiement')->default('en attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
