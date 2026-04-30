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
        Schema::create('chambres', function (Blueprint $table) {
        $table->id();
        $table->string('numero_chambre')->unique();
        $table->enum('type', ['Standard', 'VIP', 'Urgence']);
        $table->decimal('prix_journalier', 8, 2);
        $table->boolean('est_occupee')->default(false);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chambre');
    }
};
