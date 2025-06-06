@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Modifier Commande Fournisseur</h1>

@if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('commande-fours.update', $commandeFour) }}" method="POST" class="bg-white p-6 rounded shadow">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label for="fournisseur_id" class="block mb-2 font-semibold">Fournisseur</label>
            <select name="fournisseur_id" id="fournisseur_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Sélectionner un fournisseur</option>
                @foreach($fournisseurs as $fournisseur)
                    <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id', $commandeFour->fournisseur_id) == $fournisseur->id ? 'selected' : '' }}>
                        {{ $fournisseur->nom_fournisseur }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="date_commande" class="block mb-2 font-semibold">Date Commande</label>
            <input type="date" name="date_commande" id="date_commande" value="{{ old('date_commande', $commandeFour->date_commande->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label for="date_arrive" class="block mb-2 font-semibold">Date Arrivée (Optionnel)</label>
            <input type="date" name="date_arrive" id="date_arrive" value="{{ old('date_arrive', $commandeFour->date_arrive ? $commandeFour->date_arrive->format('Y-m-d') : '') }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label for="montant_livraison" class="block mb-2 font-semibold">Montant Livraison (Optionnel)</label>
            <input type="number" step="0.01" name="montant_livraison" id="montant_livraison" value="{{ old('montant_livraison', $commandeFour->montant_livraison) }}" class="w-full border rounded px-3 py-2">
        </div>
         <div>
            <label for="validation" class="block mb-2 font-semibold">Validation</label>
            <select name="validation" id="validation" class="w-full border rounded px-3 py-2">
                <option value="0" {{ old('validation', $commandeFour->validation) == 0 ? 'selected' : '' }}>En attente</option>
                <option value="1" {{ old('validation', $commandeFour->validation) == 1 ? 'selected' : '' }}>Validée</option>
            </select>
        </div>
    </div>

    <div class="mb-6">
        <label for="observation" class="block mb-2 font-semibold">Observation (Optionnel)</label>
        <textarea name="observation" id="observation" class="w-full border rounded px-3 py-2">{{ old('observation', $commandeFour->observation) }}</textarea>
    </div>

    <h2 class="text-xl font-bold mb-4">Articles de la Commande</h2>

    <div id="ligne-commande-container">
        <!-- Existing Ligne Commande items -->
        @foreach($commandeFour->ligneCommandeFours as $index => $item)
            @include('commande-four.partials.ligne-commande-item', ['index' => $index, 'item' => $item, 'articles' => $articles])
        @endforeach

        <!-- Old Ligne Commande items (if validation fails) -->
         @if(old('ligne_commande_fours'))
            @foreach(old('ligne_commande_fours') as $index => $item)
                @if(!isset($item['id']) || empty($item['id'])) {{-- Only include if it's a new item from old data --}}
                    {{-- Pass item as object for consistency with JS add function --}}
                    @include('commande-four.partials.ligne-commande-item', ['index' => $index + count($commandeFour->ligneCommandeFours), 'item' => (object)$item, 'articles' => $articles])
                @endif
            @endforeach
        @endif
    </div>

    <button type="button" id="add-ligne-commande" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-6">Ajouter un Article</button>

     <div class="text-right font-bold text-xl mb-6">
        Montant Total Estimé: <span id="estimated-total">0.00</span> Dhs
    </div>

    <div class="flex justify-end">
        <a href="{{ route('commande-fours.index') }}" class="mr-4 text-gray-600 hover:underline">Annuler</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('ligne-commande-container');
        const addButton = document.getElementById('add-ligne-commande');
        const estimatedTotalSpan = document.getElementById('estimated-total');
        const montantLivraisonInput = document.getElementById('montant_livraison');
        // Start item index after existing items and old data items
        let itemIndex = {{ count($commandeFour->ligneCommandeFours) + (old('ligne_commande_fours') ? count(old('ligne_commande_fours')) : 0) }};

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

            // Function to toggle required attribute
            function toggleRequired() {
                 if (articleSelect.value || descriptionInput.value) {
                     descriptionInput.removeAttribute('required');
                 } else {
                      descriptionInput.setAttribute('required', '');
                 }
            }

            articleSelect.addEventListener('change', function() {
                 if (this.value) {
                     descriptionInput.value = ''; // Clear description if article is selected
                 }
                 toggleRequired();
                 updateEstimatedTotal(); // Recalculate total on article change
             });

             descriptionInput.addEventListener('input', function() {
                  if (this.value) {
                      articleSelect.value = ''; // Clear selected article if description is typed
                  }
                  toggleRequired();
                  updateEstimatedTotal(); // Recalculate total on description input
             });

            qteInput.addEventListener('input', updateEstimatedTotal);
            prixUnitaireInput.addEventListener('input', updateEstimatedTotal);

            removeButton.addEventListener('click', function() {
                itemDiv.remove();
                updateEstimatedTotal(); // Recalculate total after removing item
            });

             // Initial required state on load
             toggleRequired();
        }

        function addLigneCommandeItem(item = null) {
            const div = document.createElement('div');
            div.classList.add('ligne-commande-item', 'grid', 'grid-cols-1', 'md:grid-cols-4', 'gap-4', 'mb-4', 'p-4', 'border', 'rounded', 'bg-gray-50');

            // Use a template string for the new item's HTML
             div.innerHTML = `
                 <input type="hidden" name="ligne_commande_fours[${itemIndex}][id]" value="">
                 <div>
                     <label for="article_select_${itemIndex}" class="block mb-2 font-semibold">Article</label>
                     <select name="ligne_commande_fours[${itemIndex}][article_id]" id="article_select_${itemIndex}" class="w-full border rounded px-3 py-2 article-select">
                         <option value="">Sélectionner un article (Optionnel)</option>
                         @foreach($articles as $article)
                             <option value="{{ $article->id }}">{{ $article->nom_article }}</option>
                         @endforeach
                     </select>
                 </div>
                  <div>
                     <label for="description_${itemIndex}" class="block mb-2 font-semibold">Description</label>
                     <input type="text" name="ligne_commande_fours[${itemIndex}][description]" id="description_${itemIndex}" value="" class="w-full border rounded px-3 py-2 description-input">
                  </div>
                 <div>
                     <label for="qte_${itemIndex}" class="block mb-2 font-semibold">Quantité</label>
                     <input type="number" name="ligne_commande_fours[${itemIndex}][qte]" id="qte_${itemIndex}" value="" class="w-full border rounded px-3 py-2" required min="1">
                 </div>
                 <div>
                     <label for="prix_unitaire_${itemIndex}" class="block mb-2 font-semibold">Prix Unitaire</label>
                     <input type="number" step="0.01" name="ligne_commande_fours[${itemIndex}][prix_unitaire]" id="prix_unitaire_${itemIndex}" value="" class="w-full border rounded px-3 py-2" required min="0">
                 </div>
                  <div class="flex items-end">
                     <button type="button" class="remove-ligne-commande bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Supprimer</button>
                 </div>
             `;
            container.appendChild(div);

            attachEventListeners(div); // Attach event listeners to the newly added item

            itemIndex++;
        }

        // Attach event listeners to existing items rendered from $commandeFour->ligneCommandeFours
        container.querySelectorAll('.ligne-commande-item').forEach(function(itemDiv) {
             attachEventListeners(itemDiv);
        });

        // Attach event listeners to new items added from old data (if validation failed)
        @if(old('ligne_commande_fours'))
             container.querySelectorAll('.ligne-commande-item').forEach(function(itemDiv) {
                // Check if the item was originally from old data (doesn't have an ID from the database)
                const itemIdInput = itemDiv.querySelector('input[name$="[id]"]');
                if (itemIdInput && itemIdInput.value === '') {
                    attachEventListeners(itemDiv);
                }
            });
        @endif


        addButton.addEventListener('click', function () {
            addLigneCommandeItem();
        });

        montantLivraisonInput.addEventListener('input', updateEstimatedTotal);

        // Initial total calculation for the form
        updateEstimatedTotal();
    });
</script>

</code_block_to_apply_changes_from> 