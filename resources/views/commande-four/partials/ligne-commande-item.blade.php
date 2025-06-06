<div class="ligne-commande-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-4 border rounded bg-gray-50">
    <input type="hidden" name="ligne_commande_fours[{{ $index ?? '' }}][id]" value="{{ $item->id ?? '' }}">
    <div>
        <label for="article_select_{{ $index ?? '' }}" class="block mb-2 font-semibold">Article</label>
        <select name="ligne_commande_fours[{{ $index ?? '' }}][article_id]" id="article_select_{{ $index ?? '' }}" class="w-full border rounded px-3 py-2 article-select">
            <option value="">Sélectionner un article (Optionnel)</option>
            @foreach($articles as $article)
                <option value="{{ $article->id }}" {{ ($item->article_id ?? '') == $article->id ? 'selected' : '' }}>{{ $article->nom_article }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="description_{{ $index ?? '' }}" class="block mb-2 font-semibold">Description</label>
        <input type="text" name="ligne_commande_fours[{{ $index ?? '' }}][description]" id="description_{{ $index ?? '' }}" value="{{ $item->description ?? '' }}" class="w-full border rounded px-3 py-2 description-input">
    </div>
    <div>
        <label for="qte_{{ $index ?? '' }}" class="block mb-2 font-semibold">Quantité</label>
        <input type="number" name="ligne_commande_fours[{{ $index ?? '' }}][qte]" id="qte_{{ $index ?? '' }}" value="{{ $item->qte ?? '' }}" class="w-full border rounded px-3 py-2" required min="1">
    </div>
    <div>
        <label for="prix_unitaire_{{ $index ?? '' }}" class="block mb-2 font-semibold">Prix Unitaire</label>
        <input type="number" step="0.01" name="ligne_commande_fours[{{ $index ?? '' }}][prix_unitaire]" id="prix_unitaire_{{ $index ?? '' }}" value="{{ $item->prix_unitaire ?? '' }}" class="w-full border rounded px-3 py-2" required min="0">
    </div>
    <div class="flex items-end">
        <button type="button" class="remove-ligne-commande bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Supprimer</button>
    </div>
</div> 