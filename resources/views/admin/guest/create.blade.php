<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-xl mx-auto px-4">

            <a href="{{ route('guests.index') }}" class="inline-flex items-center text-xs font-bold text-slate-400 hover:text-slate-900 transition mb-6 uppercase tracking-widest">
                ← Voltar para a lista
            </a>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-8">
                    <h1 class="text-2xl font-serif font-bold text-slate-800 mb-1">Novo Convidado</h1>
                    <p class="text-sm text-slate-500 mb-8 italic">Cadastre a família ou o convidado individual para o dia 17/04/2026.</p>

                    <form action="{{ route('guests.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2">Nome / Família</label>
                            <input type="text" name="name" required placeholder="Ex: João e Maria"
                                   class="w-full border-slate-200 rounded-xl focus:border-slate-900 focus:ring-slate-900 text-slate-700 placeholder-slate-300">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2">WhatsApp</label>
                                <input type="text" name="phone" required placeholder="99988887777"
                                       class="w-full border-slate-200 rounded-xl focus:border-slate-900 focus:ring-slate-900 text-slate-700 placeholder-slate-300">
                            </div>

                            <div>
                                <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2">Máximo de Pessoas</label>
                                <input type="number" name="max_guests" value="1" min="1" required
                                       class="w-full border-slate-200 rounded-xl focus:border-slate-900 focus:ring-slate-900 text-slate-700">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">
                            Cadastrar e Gerar Link
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
