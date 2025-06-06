<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeFour extends Model
{
    use HasFactory;
    protected $fillable = [
        'fournisseur_id', 'date_commande', 'date_arrive', 'montant_commande',
        'montant_livraison', 'montant_total', 'observation', 'validation'
    ];

    protected $casts = [
        'date_commande' => 'date',
        'date_arrive' => 'date',
        'validation' => 'boolean',
        'montant_commande' => 'decimal:2',
        'montant_livraison' => 'decimal:2',
        'montant_total' => 'decimal:2'
    ];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function ligneCommandeFours()
    {
        return $this->hasMany(LigneCommandeFour::class);
    }

    public function livraison()
    {
        return $this->hasOne(Livraison::class);
    }
} 