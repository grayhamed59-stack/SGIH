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
            $table->string('reference')->unique();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->decimal('montant_total', 10, 2);
            $table->decimal('montant_patient', 10, 2);
            $table->decimal('montant_assurance', 10, 2)->default(0);
            $table->string('statut')->default('en_attente');
            $table->date('date_facture');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturations');
    }
};
