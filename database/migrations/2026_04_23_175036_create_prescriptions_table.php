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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            // Clés étrangères
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('medecins')->onDelete('cascade');
        
            // Liste des médicaments
            $table->text('medicaments');
            // Posologie
            $table->text('instructions')->nullable();
            $table->date('date_prescription');
            $table->timestamps();
            });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription');
    }
};
