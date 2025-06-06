<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('commande_four_id')->nullable()->constrained('commande_fours');
            $table->date('date_livraison');
            $table->string('company');
            $table->string('reference')->unique();
            $table->string('status')->default('pending'); // pending, in_transit, delivered, cancelled
            $table->text('notes')->nullable();
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->string('tracking_number')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('livraisons');
    }
}; 