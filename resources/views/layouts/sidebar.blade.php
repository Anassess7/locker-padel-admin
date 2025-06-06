<aside class="w-64 bg-white shadow-md h-screen">
    <div class="p-6 font-bold text-xl border-b">Locker Padel Admin</div>
    <nav class="mt-6">
        <a href="/dashboard" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-100">Dashboard</a>
        <x-responsive-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">
            {{ __('Articles') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('marques.index')" :active="request()->routeIs('marques.*')">
            {{ __('Marques') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.*')">
            {{ __('Clients') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('fournisseurs.index')" :active="request()->routeIs('fournisseurs.*')">
            {{ __('Fournisseurs') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('operations.index')" :active="request()->routeIs('operations.*')">
            {{ __('Opérations') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('commande-fours.index')" :active="request()->routeIs('commande-fours.*')">
            {{ __('Commandes Fournisseur') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('livraisons.index')" :active="request()->routeIs('livraisons.*')">
            {{ __('Livraisons') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
            {{ __('Utilisateurs') }}
        </x-responsive-nav-link>
        <a href="/livraisons" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-100">Livraisons</a>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="w-full text-left py-2.5 px-4 rounded transition duration-200 hover:bg-red-100 text-red-600">Logout</button>
        </form>
    </nav>
</aside> 