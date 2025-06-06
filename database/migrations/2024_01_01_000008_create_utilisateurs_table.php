<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom_utilisateur')->unique();
            $table->string('mdp');
            $table->boolean('admin')->default(false);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('utilisateurs');
    }
}; 