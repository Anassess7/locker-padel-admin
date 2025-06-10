<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('livraisons', function (Blueprint $table) {
            // Drop existing columns
            $table->dropForeign(['commande_four_id']);
            $table->dropColumn([
                'commande_four_id',
                'notes',
                'tracking_number'
            ]);
            
            // Add new columns
            $table->decimal('prix_livraison', 10, 2)->default(0)->after('company');
            $table->decimal('prix_total', 10, 2)->default(0)->after('prix_livraison');
        });
    }

    public function down()
    {
        Schema::table('livraisons', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn([
                'prix_livraison',
                'prix_total'
            ]);
            
            // Restore original columns
            $table->foreignId('commande_four_id')->constrained('commande_fours');
            $table->text('notes')->nullable();
            $table->string('tracking_number')->nullable();
        });
    }
}; 