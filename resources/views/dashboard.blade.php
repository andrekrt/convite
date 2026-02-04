<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel de Controle do Casamento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Total de Convidados</p>
                    <p class="text-2xl font-black text-gray-800">{{ $totalGuests }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Confirmados</p>
                    <p class="text-2xl font-black text-gray-800">{{ $confirmed }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-amber-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Arrecadado</p>
                    <p class="text-2xl font-black text-gray-800">R$ {{ number_format($receivedAmount, 2, ',', '.') }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-purple-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Presentes</p>
                    <p class="text-2xl font-black text-gray-800">{{ $totalGifts }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('guests.index') }}" class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 flex items-center justify-between group">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Gerenciar Convidados</h3>
                        <p class="text-gray-500 text-sm">Cadastre, envie links e veja quem confirmou presença.</p>
                    </div>
                    <span class="text-2xl group-hover:translate-x-2 transition">➜</span>
                </a>

                <a href="{{ route('gifts.index') }}" class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 flex items-center justify-between group">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Lista de Presentes</h3>
                        <p class="text-gray-500 text-sm">Adicione novos itens e acompanhe as contribuições via PIX.</p>
                    </div>
                    <span class="text-2xl group-hover:translate-x-2 transition">➜</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
