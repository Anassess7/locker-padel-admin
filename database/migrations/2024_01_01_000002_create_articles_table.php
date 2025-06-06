<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('ref_local');
            $table->string('nom');
            $table->foreignId('marque_id')->constrained('marques');
            $table->decimal('prix_ach', 10, 2);
            $table->decimal('prix_vente', 10, 2);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('articles');
    }
}; 