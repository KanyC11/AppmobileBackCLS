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
    Schema::table('sn_evenement', function (Blueprint $table) {
        $table->string('lien')->nullable()->after('lieu'); // nullable pour ne pas casser les anciens enregistrements
    });
}

public function down(): void
{
    Schema::table('sn_evenement', function (Blueprint $table) {
        $table->dropColumn('lien');
    });
}

  
};
