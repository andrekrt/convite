<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="mb-8">
                <h1 class="text-3xl font-serif font-bold text-slate-900 tracking-tight">Configurações de Perfil</h1>
                <p class="text-slate-500 italic">Gerencie suas informações de acesso ao painel.</p>
            </div>

            <div class="p-8 bg-white shadow-sm border border-slate-100 rounded-3xl">
                <div class="flex items-center mb-6 text-slate-900">
                    <i class="fa-solid fa-id-card text-xl mr-3 opacity-20"></i>
                    <h2 class="text-lg font-bold uppercase tracking-widest text-[11px]">Informações Pessoais</h2>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-8 bg-white shadow-sm border border-slate-100 rounded-3xl">
                <div class="flex items-center mb-6 text-slate-900">
                    <i class="fa-solid fa-shield-halved text-xl mr-3 opacity-20"></i>
                    <h2 class="text-lg font-bold uppercase tracking-widest text-[11px]">Segurança da Conta</h2>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-8 bg-white shadow-sm border border-red-100 rounded-3xl border-dashed">
                <div class="flex items-center mb-6 text-red-600">
                    <i class="fa-solid fa-triangle-exclamation text-xl mr-3 opacity-40"></i>
                    <h2 class="text-lg font-bold uppercase tracking-widest text-[11px]">Zona de Perigo</h2>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
