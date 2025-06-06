<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('livraisons', function (Blueprint $table) {
            // First drop the foreign key constraint if it exists
            if (Schema::hasColumn('livraisons', 'commande_four_id')) {
                $table->dropForeign(['commande_four_id']);
                $table->dropColumn('commande_four_id');
            }
            
            // Drop columns we don't need if they exist
            $columnsToDrop = ['notes', 'shipping_cost', 'tracking_number'];
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('livraisons', $column)) {
                    $table->dropColumn($column);
                }
            }

            // Add new columns if they don't exist
            if (!Schema::hasColumn('livraisons', 'client_id')) {
                $table->foreignId('client_id')->after('id')->constrained('clients');
            }
            
            if (!Schema::hasColumn('livraisons', 'prix_livraison')) {
                $table->decimal('prix_livraison', 10, 2)->default(0)->after('company');
            }
            
            if (!Schema::hasColumn('livraisons', 'prix_total')) {
                $table->decimal('prix_total', 10, 2)->default(0)->after('prix_livraison');
            }
        });
    }

    public function down()
    {
        Schema::table('livraisons', function (Blueprint $table) {
            // Drop new columns if they exist
            if (Schema::hasColumn('livraisons', 'client_id')) {
                $table->dropForeign(['client_id']);
                $table->dropColumn('client_id');
            }
            
            if (Schema::hasColumn('livraisons', 'prix_livraison')) {
                $table->dropColumn('prix_livraison');
            }
            
            if (Schema::hasColumn('livraisons', 'prix_total')) {
                $table->dropColumn('prix_total');
            }

            // Restore original columns if they don't exist
            if (!Schema::hasColumn('livraisons', 'commande_four_id')) {
                $table->foreignId('commande_four_id')->constrained('commande_fours');
            }
            
            if (!Schema::hasColumn('livraisons', 'notes')) {
                $table->text('notes')->nullable();
            }
            
            if (!Schema::hasColumn('livraisons', 'shipping_cost')) {
                $table->decimal('shipping_cost', 10, 2)->default(0);
            }
            
            if (!Schema::hasColumn('livraisons', 'tracking_number')) {
                $table->string('tracking_number')->nullable();
            }
        });
    }
}; 