<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;
    protected $fillable = ['nom_fournisseur', 'telephone', 'adresse'];

    public function commandeFours()
    {
        return $this->hasMany(CommandeFour::class);
    }
} 