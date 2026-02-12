<x-app-layout>
    {{-- Limpamos o Header para foco total no convite --}}
    <x-slot name="header"></x-slot>
    <style> nav, header { display: none !important; } </style>

    <div class="max-w-md mx-auto bg-white min-h-screen shadow-2xl pb-12 font-sans selection:bg-slate-100">

        {{-- Foto de Capa (Hero Section) --}}
        <div class="h-[450px] bg-slate-200 relative overflow-hidden">
            {{-- Aqui você pode usar a imagem do casal que definimos nas configurações --}}
            <img src="{{ asset('storage/casa.jpeg') }}" class="w-full h-full object-cover">

            {{-- Overlay para dar leitura ao texto --}}
            <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent"></div>

            <div class="absolute bottom-8 left-0 right-0 text-center px-6">
                <span class="text-[10px] font-black uppercase tracking-[0.4em] text-slate-800 mb-2 block">Save the Date</span>
                <h1 class="text-4xl font-serif text-slate-900 leading-tight">André & Noiva</h1>
                <div class="h-px w-12 bg-slate-300 mx-auto mt-4"></div>
            </div>
        </div>

        {{-- Conteúdo do Convite --}}
        <div class="p-10 text-center">
            <div class="mb-12">
                <h2 class="text-xl font-serif text-slate-800 italic mb-4">Olá, {{ $guest->name }}!</h2>
                <p class="text-slate-500 leading-relaxed text-sm">
                    Preparamos tudo com muito carinho e será uma honra ter você celebrando conosco o início da nossa nova história.
                </p>
            </div>

            {{-- Informações do Evento --}}
            <div class="grid grid-cols-2 gap-4 mb-12 border-y border-slate-50 py-8">
                <div class="text-center border-r border-slate-100">
                    <p class="text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1">Data</p>
                    <p class="text-sm font-bold text-slate-800">17 de Abril, 2026</p>
                </div>
                <div class="text-center">
                    <p class="text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1">Local</p>
                    <p class="text-sm font-bold text-slate-800">Bacabal - MA</p>
                </div>
            </div>

            {{-- Ações Principais --}}
            <div class="space-y-6">

                {{-- Botão Principal para o Catálogo de Presentes --}}
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-slate-100 to-slate-200 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                    <a
                    href="{{ route('invitation.gifts', $guest->invite_code) }}"
                       class="relative flex items-center justify-center w-full bg-slate-900 text-white py-5 rounded-2xl font-bold shadow-xl hover:bg-slate-800 transition-all active:scale-95">
                        <i class="fa-solid fa-gift mr-3 opacity-50"></i> Ver Lista de Presentes
                    </a>
                </div>

                {{-- Seção de Confirmação --}}
                <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-100">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Confirmar Presença</h3>

                    <form action="{{ route('invitation.confirm', $guest->invite_code) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="flex items-center justify-center space-x-4 bg-white p-2 rounded-xl border border-slate-100">
                            <label class="text-xs font-bold text-slate-500 ml-4">Quantas pessoas?</label>
                            <input type="number" name="confirmed_count" max="{{ $guest->max_guests }}" min="1"
                                   class="w-20 border-none bg-transparent text-center font-bold text-slate-900 focus:ring-0"
                                   value="{{ $guest->max_guests }}">
                        </div>

                        <button type="submit" class="w-full text-slate-900 font-black text-[11px] uppercase tracking-widest border-b-2 border-slate-900 pb-1 inline-block mt-4 hover:text-slate-600 hover:border-slate-600 transition">
                            {{ $guest->is_confirmed ? 'Atualizar Confirmação' : 'Confirmar Presença Agora' }}
                        </button>
                    </form>
                </div>

            </div>

            {{-- Rodapé do Convite --}}
            <div class="mt-16 opacity-30">
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">InnovaKode Systems</p>
            </div>
        </div>
    </div>
</x-app-layout>
