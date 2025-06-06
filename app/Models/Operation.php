<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle', 'type_transaction', 'montant_transaction', 'date', 'date_ech',
        'num_chq', 'tireur', 'telephone', 'banque', 'agence', 'ville', 'observation', 'validation'
    ];
} 