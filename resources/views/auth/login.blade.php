<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-50">
        <div class="w-full sm:max-w-md mt-6 px-10 py-12 bg-white shadow-2xl shadow-slate-200 rounded-3xl border border-slate-100">

            <div class="text-center mb-10">
                <h2 class="text-3xl font-serif font-bold text-slate-900">Bem-vindo</h2>
                <p class="text-slate-400 text-sm italic">Acesse o painel da InnovaKode</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2">E-mail</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus
                           class="w-full border-slate-200 rounded-xl focus:border-slate-900 focus:ring-slate-900 text-slate-700">
                </div>

                <div>
                    <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2">Senha</label>
                    <input id="password" type="password" name="password" required
                           class="w-full border-slate-200 rounded-xl focus:border-slate-900 focus:ring-slate-900 text-slate-700">
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                        <span class="ml-2 text-xs text-slate-500">Lembrar de mim</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 uppercase tracking-widest text-xs">
                    Entrar no Sistema
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
