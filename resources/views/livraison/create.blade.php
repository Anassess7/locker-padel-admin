@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Nouvelle Livraison</h1>
        <a href="{{ route('livraisons.index') }}" class="text-gray-600 hover:text-gray-800">Retour à la liste</a>
    </div>

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('livraisons.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">Client</label>
                <select name="client_id" id="client_id" class="w-full rounded-md border-gray-300" required>
                    <option value="">Sélectionner un client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                            {{ $client->nom_client }}
                        </option>
                    @endforeach
                </select>
                @error('client_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="date_livraison" class="block text-sm font-medium text-gray-700 mb-1">Date de Livraison</label>
                <input type="date" name="date_livraison" id="date_livraison" value="{{ old('date_livraison') }}" 
                    class="w-full rounded-md border-gray-300" required>
                @error('date_livraison')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Société de Livraison</label>
                <input type="text" name="company" id="company" value="{{ old('company') }}" 
                    class="w-full rounded-md border-gray-300" required>
                @error('company')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="reference" class="block text-sm font-medium text-gray-700 mb-1">Référence</label>
                <input type="text" name="reference" id="reference" value="{{ old('reference') }}" 
                    class="w-full rounded-md border-gray-300" required>
                @error('reference')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="prix_livraison" class="block text-sm font-medium text-gray-700 mb-1">Prix de Livraison</label>
                <input type="number" step="0.01" name="prix_livraison" id="prix_livraison" value="{{ old('prix_livraison', 0) }}" 
                    class="w-full rounded-md border-gray-300" required>
                @error('prix_livraison')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Articles</h2>
            <div id="articles-container">
                <div class="article-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-4 border rounded">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Article</label>
                        <select name="articles[0][id]" class="w-full rounded-md border-gray-300 article-select" required>
                            <option value="">Sélectionner un article</option>
                            @foreach($articles as $article)
                                <option value="{{ $article->id }}" data-prix="{{ $article->prix_vente }}">
                                    {{ $article->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                        <input type="number" name="articles[0][quantite]" class="w-full rounded-md border-gray-300 quantite-input" 
                            min="1" value="1" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prix Unitaire</label>
                        <input type="number" step="0.01" name="articles[0][prix_unitaire]" class="w-full rounded-md border-gray-300 prix-input" 
                            value="0" required>
                    </div>
                    <div class="flex items-end">
                        <button type="button" class="remove-article text-red-600 hover:text-red-800 px-2 py-1 rounded">Supprimer</button>
                    </div>
                </div>
            </div>
            <button type="button" id="add-article" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Ajouter un article
            </button>
        </div>

        <div class="mb-6 p-4 bg-gray-50 rounded">
            <div class="flex justify-between items-center">
                <span class="text-lg font-medium">Prix Total:</span>
                <span id="total-price" class="text-xl font-bold">0.00 Dhs</span>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Créer la Livraison
            </button>
        </div>
    </form>
</div>

<!-- Hidden template for cloning -->
<div id="article-row-template" style="display: none;">
    <div class="article-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-4 border rounded">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Article</label>
            <select name="articles[INDEX][id]" class="w-full rounded-md border-gray-300 article-select" required>
                <option value="">Sélectionner un article</option>
                @foreach($articles as $article)
                    <option value="{{ $article->id }}" data-prix="{{ $article->prix_vente }}">
                        {{ $article->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
            <input type="number" name="articles[INDEX][quantite]" class="w-full rounded-md border-gray-300 quantite-input" 
                min="1" value="1" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Prix Unitaire</label>
            <input type="number" step="0.01" name="articles[INDEX][prix_unitaire]" class="w-full rounded-md border-gray-300 prix-input" 
                value="0" required>
        </div>
        <div class="flex items-end">
            <button type="button" class="remove-article text-red-600 hover:text-red-800 px-2 py-1 rounded">Supprimer</button>
        </div>
    </div>
</div>

<script>
// Pass articles data to JavaScript
window.articlesData = @json($articles);

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing...');
    
    const container = document.getElementById('articles-container');
    const addButton = document.getElementById('add-article');
    const prixLivraisonInput = document.getElementById('prix_livraison');
    const totalPriceElement = document.getElementById('total-price');
    const template = document.getElementById('article-row-template');

    if (!container || !addButton || !prixLivraisonInput || !totalPriceElement || !template) {
        console.error('Required elements not found');
        return;
    }

    console.log('All elements found, setting up event listeners...');

    // Add new article row
    addButton.addEventListener('click', function() {
        console.log('Add button clicked');
        
        const rows = container.querySelectorAll('.article-item');
        const newIndex = rows.length;
        
        // Clone the template
        const newRow = template.firstElementChild.cloneNode(true);
        
        // Update the index in names
        newRow.innerHTML = newRow.innerHTML.replace(/INDEX/g, newIndex);
        
        container.appendChild(newRow);
        attachEventListeners(newRow);
        calculateTotal();
        
        console.log('New row added with index:', newIndex);
    });

    // Event delegation for remove buttons
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-article')) {
            console.log('Remove button clicked');
            removeArticle(e.target);
        }
    });

    // Remove article row
    function removeArticle(button) {
        const rows = container.querySelectorAll('.article-item');
        if (rows.length > 1) {
            const row = button.closest('.article-item');
            row.remove();
            updateIndexes();
            calculateTotal();
            console.log('Row removed');
        } else {
            alert('Vous devez avoir au moins un article.');
        }
    }

    // Update indexes after removal
    function updateIndexes() {
        container.querySelectorAll('.article-item').forEach((row, index) => {
            row.querySelectorAll('[name^="articles["]').forEach(input => {
                const currentName = input.name;
                input.name = currentName.replace(/articles\[\d+\]/, `articles[${index}]`);
            });
        });
        console.log('Indexes updated');
    }

    // Calculate total price
    function calculateTotal() {
        let total = 0;
        
        // Sum up all articles
        container.querySelectorAll('.article-item').forEach(row => {
            const quantite = parseFloat(row.querySelector('.quantite-input').value) || 0;
            const prixUnitaire = parseFloat(row.querySelector('.prix-input').value) || 0;
            total += quantite * prixUnitaire;
        });
        
        // Add delivery price
        const prixLivraison = parseFloat(prixLivraisonInput.value) || 0;
        total += prixLivraison;
        
        // Update display
        totalPriceElement.textContent = total.toFixed(2) + ' Dhs';
        
        console.log('Total calculated:', total);
    }

    // Attach event listeners to a row
    function attachEventListeners(row) {
        const select = row.querySelector('.article-select');
        const quantiteInput = row.querySelector('.quantite-input');
        const prixInput = row.querySelector('.prix-input');

        if (select) {
            select.addEventListener('change', function() {
                console.log('Article selected:', this.value);
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.dataset.prix) {
                    prixInput.value = selectedOption.dataset.prix;
                } else {
                    prixInput.value = 0;
                }
                calculateTotal();
            });
        }

        if (quantiteInput) {
            quantiteInput.addEventListener('input', function() {
                console.log('Quantity changed:', this.value);
                calculateTotal();
            });
        }

        if (prixInput) {
            prixInput.addEventListener('input', function() {
                console.log('Price changed:', this.value);
                calculateTotal();
            });
        }
    }

    // Initialize event listeners for existing rows
    container.querySelectorAll('.article-item').forEach(row => {
        attachEventListeners(row);
    });

    // Listen for delivery price changes
    prixLivraisonInput.addEventListener('input', function() {
        console.log('Delivery price changed:', this.value);
        calculateTotal();
    });

    // Calculate initial total
    calculateTotal();
    
    console.log('Initialization complete');
});
</script>
@endsection