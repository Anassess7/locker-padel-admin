@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Ajouter Commande Fournisseur</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('commande-fours.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="fournisseur_id" class="block mb-2 font-semibold">Fournisseur</label>
                <select name="fournisseur_id" id="fournisseur_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Sélectionner un fournisseur</option>
                    @foreach($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                            {{ $fournisseur->nom_fournisseur }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="date_commande" class="block mb-2 font-semibold">Date Commande</label>
                <input type="date" name="date_commande" id="date_commande" value="{{ old('date_commande', date('Y-m-d')) }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label for="date_arrive" class="block mb-2 font-semibold">Date Arrivée (Optionnel)</label>
                <input type="date" name="date_arrive" id="date_arrive" value="{{ old('date_arrive') }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label for="montant_livraison" class="block mb-2 font-semibold">Montant Livraison (Optionnel)</label>
                <input type="number" step="0.01" name="montant_livraison" id="montant_livraison" value="{{ old('montant_livraison', 0) }}" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="mb-6">
            <label for="observation" class="block mb-2 font-semibold">Observation (Optionnel)</label>
            <textarea name="observation" id="observation" class="w-full border rounded px-3 py-2">{{ old('observation') }}</textarea>
        </div>

        <h2 class="text-xl font-bold mb-4">Articles de la Commande</h2>

        <div id="ligne-commande-container" class="space-y-4">
            @if(old('ligne_commande_fours'))
                @foreach(old('ligne_commande_fours') as $index => $item)
                    @include('commande-four.partials.ligne-commande-item', ['index' => $index, 'item' => (object)$item, 'articles' => $articles])
                @endforeach
            @endif
        </div>

        <button type="button" id="add-ligne-commande" class="mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-6">
            Ajouter un Article
        </button>

        <div class="text-right font-bold text-xl mb-6">
            Montant Total Estimé: <span id="estimated-total">0.00</span> Dhs
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('commande-fours.index') }}" class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100">Annuler</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Créer Commande</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('ligne-commande-container');
        const addButton = document.getElementById('add-ligne-commande');
        const estimatedTotalSpan = document.getElementById('estimated-total');
        const montantLivraisonInput = document.getElementById('montant_livraison');
        let itemIndex = {{ old('ligne_commande_fours') ? count(old('ligne_commande_fours')) : 0 }};

        function updateEstimatedTotal() {
            let total = 0;
            container.querySelectorAll('.ligne-commande-item').forEach(function(itemDiv) {
                const qte = parseFloat(itemDiv.querySelector('input[name$="[qte]"]').value) || 0;
                const prixUnitaire = parseFloat(itemDiv.querySelector('input[name$="[prix_unitaire]"]').value) || 0;
                total += qte * prixUnitaire;
            });
            const montantLivraison = parseFloat(montantLivraisonInput.value) || 0;
            total += montantLivraison;
            estimatedTotalSpan.textContent = total.toFixed(2).replace('.', ',');
        }

        function attachEventListeners(itemDiv) {
            const articleSelect = itemDiv.querySelector('.article-select');
            const descriptionInput = itemDiv.querySelector('.description-input');
            const qteInput = itemDiv.querySelector('input[name$="[qte]"]');
            const prixUnitaireInput = itemDiv.querySelector('input[name$="[prix_unitaire]"]');
            const removeButton = itemDiv.querySelector('.remove-ligne-commande');

            function toggleRequired() {
                if (articleSelect.value) {
                    descriptionInput.removeAttribute('required');
                } else {
                    descriptionInput.setAttribute('required', '');
                }
            }

            articleSelect.addEventListener('change', function() {
                if (this.value) {
                    descriptionInput.value = '';
                }
                toggleRequired();
                updateEstimatedTotal();
            });

            descriptionInput.addEventListener('input', function() {
                if (this.value) {
                    articleSelect.value = '';
                }
                toggleRequired();
                updateEstimatedTotal();
            });

            qteInput.addEventListener('input', updateEstimatedTotal);
            prixUnitaireInput.addEventListener('input', updateEstimatedTotal);

            removeButton.addEventListener('click', function() {
                itemDiv.remove();
                updateEstimatedTotal();
            });

            toggleRequired();
            updateEstimatedTotal();
        }

        function addLigneCommandeItem() {
            const div = document.createElement('div');
            div.classList.add('ligne-commande-item', 'grid', 'grid-cols-1', 'md:grid-cols-4', 'gap-4', 'p-4', 'border', 'rounded', 'bg-gray-50');
            div.innerHTML = `
                <input type="hidden" name="ligne_commande_fours[${itemIndex}][id]" value="">
                <div>
                    <label for="article_select_${itemIndex}" class="block mb-2 font-semibold">Article</label>
                    <select name="ligne_commande_fours[${itemIndex}][article_id]" id="article_select_${itemIndex}" class="w-full border rounded px-3 py-2 article-select">
                        <option value="">Sélectionner un article (Optionnel)</option>
                        @foreach($articles as $article)
                            <option value="{{ $article->id }}" {{ ($item->article_id ?? '') == $article->id ? 'selected' : '' }}>{{ $article->nom_article }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="description_${itemIndex}" class="block mb-2 font-semibold">Description</label>
                    <input type="text" name="ligne_commande_fours[${itemIndex}][description]" id="description_${itemIndex}" value="{{ $item->description ?? '' }}" class="w-full border rounded px-3 py-2 description-input">
                </div>
                <div>
                    <label for="qte_${itemIndex}" class="block mb-2 font-semibold">Quantité</label>
                    <input type="number" name="ligne_commande_fours[${itemIndex}][qte]" id="qte_${itemIndex}" value="{{ $item->qte ?? '' }}" class="w-full border rounded px-3 py-2" required min="1">
                </div>
                <div>
                    <label for="prix_unitaire_${itemIndex}" class="block mb-2 font-semibold">Prix Unitaire</label>
                    <input type="number" step="0.01" name="ligne_commande_fours[${itemIndex}][prix_unitaire]" id="prix_unitaire_${itemIndex}" value="{{ $item->prix_unitaire ?? '' }}" class="w-full border rounded px-3 py-2" required min="0">
                </div>
                <div class="flex items-end">
                    <button type="button" class="remove-ligne-commande bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Supprimer</button>
                </div>
            `;
            container.appendChild(div);
            attachEventListeners(div);
            itemIndex++;
        }

        container.querySelectorAll('.ligne-commande-item').forEach(attachEventListeners);
        addButton.addEventListener('click', addLigneCommandeItem);
        montantLivraisonInput.addEventListener('input', updateEstimatedTotal);
        updateEstimatedTotal();
    });
</script>
@endsection