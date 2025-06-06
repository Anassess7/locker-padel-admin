<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('commande_fours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fournisseur_id')->constrained('fournisseurs');
            $table->date('date_commande');
            $table->date('date_arrive')->nullable();
            $table->decimal('montant_commande', 10, 2);
            $table->decimal('montant_livraison', 10, 2)->nullable();
            $table->decimal('montant_total', 10, 2);
            $table->text('observation')->nullable();
            $table->boolean('validation')->default(false);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('commande_fours');
    }
}; 