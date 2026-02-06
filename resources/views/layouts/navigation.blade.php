<nav class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="font-serif text-xl font-bold text-slate-900 tracking-tighter">
                    Casamento<span class="text-slate-400">.site</span>
                </a>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-xs uppercase font-black tracking-widest">
                        Painel
                    </x-nav-link>
                    <x-nav-link :href="route('guests.index')" :active="request()->routeIs('guests.*')" class="text-xs uppercase font-black tracking-widest">
                        Convidados
                    </x-nav-link>
                    <x-nav-link :href="route('gifts.index')" :active="request()->routeIs('gifts.*')"
                        class="text-xs uppercase font-black tracking-widest">
                        Presentes
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-bold text-slate-500 hover:text-slate-700 transition">
                                <div>{{ Auth::user()->name }}</div>
                                <i class="fa-solid fa-chevron-down ml-2 text-[10px]"></i>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Perfil</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Sair
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-500 hover:text-slate-900 transition">
                        Entrar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
