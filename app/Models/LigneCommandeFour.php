<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneCommandeFour extends Model
{
    use HasFactory;
    protected $fillable = [
        'commande_four_id', 'article_id', 'description', 'prix_unitaire', 'qte', 'prix_tot'
    ];

    public function commandeFour()
    {
        return $this->belongsTo(CommandeFour::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
} 