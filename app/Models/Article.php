<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = ['reference', 'ref_local', 'nom', 'marque_id', 'prix_ach', 'prix_vente'];

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }

    public function ligneCommandeFours()
    {
        return $this->hasMany(LigneCommandeFour::class);
    }
} 