<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Marque;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\CommandeFour;
use App\Models\Operation;
use App\Models\Utilisateur;
use App\Models\User;
use App\Models\Livraison;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'articles' => Article::count(),
            'marques' => Marque::count(),
            'clients' => Client::count(),
            'fournisseurs' => Fournisseur::count(),
            'commandes' => CommandeFour::count(),
            'operations' => Operation::sum('montant_transaction'),
            'utilisateurs' => User::count(),
            'livraisons' => Livraison::count(),
        ];
        return view('dashboard', compact('stats'));
    }
}
