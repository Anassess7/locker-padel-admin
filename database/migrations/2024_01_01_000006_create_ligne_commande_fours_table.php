<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('ligne_commande_fours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_four_id')->constrained('commande_fours');
            $table->foreignId('article_id')->nullable();
            $table->string('description');
            $table->decimal('prix_unitaire', 10, 2);
            $table->integer('qte');
            $table->decimal('prix_tot', 10, 2);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('ligne_commande_fours');
    }
}; 