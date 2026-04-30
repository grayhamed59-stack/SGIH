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
        Schema::create('hospitalisations', function (Blueprint $table) {
            $table->id();

            // Relation avec le patient
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');

            // Relation avec la chambre
            $table->foreignId('chambre_id')->constrained()->onDelete('cascade');

            // Détails du séjour
            $table->dateTime('date_entree');
            $table->dateTime('date_sortie')->nullable(); // Nullable car on ne connaît pas toujours la date de sortie à l'entrée
        
            $table->text('motif_admission')->nullable();
            $table->decimal('frais_avance', 10, 2)->default(0);
        
            // Statut de l'hospitalisation (ex: en cours, terminé, annulé)
            $table->string('statut')->default('en cours');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalisations');
    }
};
