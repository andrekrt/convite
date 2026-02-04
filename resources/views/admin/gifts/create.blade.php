@if ($errors->any())
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
        <ul class="list-disc list-inside text-sm font-bold uppercase">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-xl mx-auto px-4">

            <a href="{{ route('gifts.index') }}"
                class="inline-flex items-center text-xs font-bold text-slate-400 hover:text-slate-900 transition mb-6 uppercase tracking-widest">
                <i class="fa-solid fa-arrow-left mr-2"></i> Voltar para a lista
            </a>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-8">
                    <h1 class="text-2xl font-serif font-bold text-slate-800 mb-1">Novo Presente</h1>
                    <p class="text-sm text-slate-500 mb-8 italic">Adicione um item à vitrine de presentes.</p>

                    <form action="{{ route('gifts.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <div>
                            <label
                                class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2">Nome
                                do Presente</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                placeholder="Ex: Jogo de Panelas" required
                                class="w-full border-slate-200 rounded-xl focus:border-slate-900 focus:ring-slate-900 text-slate-700">
                        </div>

                        <div>
                            <label
                                class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2">Descrição
                            </label>
                            <textarea name="description" rows="3"
                                placeholder="Conte-nos por que este presente é especial ou dê detalhes sobre o modelo..."
                                class="w-full border-slate-200 rounded-xl focus:border-slate-900 focus:ring-slate-900 text-slate-700">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label
                                class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2">Valor
                                (R$)</label>
                            <input type="text" name="price" step="0.01" value="{{ old('price') }}"
                                placeholder="0,00" required
                                class="w-full border-slate-200 rounded-xl focus:border-slate-900 focus:ring-slate-900 text-slate-700">
                        </div>

                        <div>
                            <label
                                class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2">Imagem
                                do Presente</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-slate-400 transition-colors cursor-pointer relative">
                                <div class="space-y-1 text-center">
                                    <i class="fa-solid fa-image text-slate-300 text-3xl mb-2"></i>
                                    <div class="flex text-sm text-slate-600">
                                        <span class="relative font-medium text-slate-900">Carregar ficheiro</span>
                                    </div>
                                    <p class="text-xs text-slate-500 font-mono">PNG, JPG até 2MB</p>
                                </div>
                                <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer"
                                    onchange="previewImage(this)">
                            </div>
                            <div id="image-preview" class="mt-4 hidden">
                                <img src="" class="w-full h-48 object-cover rounded-xl border border-slate-200">
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-slate-900 text-white font-bold py-4 rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">
                            <i class="fa-solid fa-check mr-2"></i> Confirmar Cadastro
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const img = preview.querySelector('img');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        const priceInput = document.querySelector('input[name="price"]');

        priceInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ""); // Remove tudo que não é número

            // Formata para o padrão decimal
            value = (value / 100).toFixed(2) + "";
            value = value.replace(".", ",");

            // Adiciona os pontos de milhar
            value = value.replace(/(\d)(\d{3}),/g, "$1.$2,");

            e.target.value = value;
        });

        // Se estiver no Editar, já dispara a formatação ao carregar a página
        window.addEventListener('load', () => {
            if (priceInput.value) {
                priceInput.dispatchEvent(new Event('input'));
            }
        });
    </script>
</x-app-layout>
