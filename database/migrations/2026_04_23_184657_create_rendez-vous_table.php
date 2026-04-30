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
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            // Le docteur peut être optionnel pour les rendez-vous d'urgence
            $table->foreignId('medecin_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->constrained();
            $table->date('date_rdv');
            $table->time('heure_rdv');
            $table->string('motif');
            $table->enum('statut', ['planifie', 'termine', 'annule'])->default('planifie');
            $table->text('observations')->nullable();
            $table->decimal('prix', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vous');
    }
};
