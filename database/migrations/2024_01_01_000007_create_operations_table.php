<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('type_transaction');
            $table->decimal('montant_transaction', 10, 2);
            $table->date('date');
            $table->date('date_ech')->nullable();
            $table->string('num_chq')->nullable();
            $table->string('tireur')->nullable();
            $table->string('telephone')->nullable();
            $table->string('banque')->nullable();
            $table->string('agence')->nullable();
            $table->string('ville')->nullable();
            $table->text('observation')->nullable();
            $table->boolean('validation')->default(false);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('operations');
    }
}; 