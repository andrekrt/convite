<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-serif font-bold text-slate-800">Lista de Presentes</h1>
                    <p class="text-sm text-slate-500 italic">Vitrine de itens para os convidados escolherem.</p>
                </div>
                <a href="{{ route('gifts.create') }}"
                    class="bg-slate-900 text-white px-5 py-2.5 rounded-lg font-bold text-sm hover:bg-slate-800 transition">
                    <i class="fa-solid fa-plus mr-2"></i> Adicionar Presente
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-[11px] font-black uppercase text-slate-400">Presente</th>
                            <th class="px-6 py-4 text-[11px] font-black uppercase text-slate-400 text-center">Valor</th>
                            <th class="px-6 py-4 text-[11px] font-black uppercase text-slate-400">Foto</th>
                            <th class="px-6 py-4 text-[11px] font-black uppercase text-slate-400 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($gifts as $gift)
                            <tr class="hover:bg-slate-50/50 transition-colors">

                                <td class="px-6 py-4 font-bold text-slate-800 text-sm">{{ $gift->title }}</td>
                                <td class="px-6 py-4 text-center font-bold text-slate-600">R$
                                    {{ number_format($gift->price, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 w-20">
                                    @if ($gift->image)
                                        <img src="{{ asset('storage/' . $gift->image) }}"
                                            class="w-12 h-12 object-cover rounded-lg bg-slate-100 border border-slate-200 cursor-zoom-in hover:scale-110 transition-transform shadow-sm"
                                            onclick="previewImage('{{ asset('storage/' . $gift->image) }}', '{{ $gift->title }}')">
                                    @else
                                        <div
                                            class="w-12 h-12 flex items-center justify-center bg-slate-100 rounded-lg text-slate-300">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-end gap-3 text-lg">
                                        <a href="{{ route('gifts.edit', $gift->id) }}"
                                            class="text-slate-400 hover:text-blue-600"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <button onclick="confirmDelete({{ $gift->id }})"
                                            class="text-slate-300 hover:text-red-600"><i
                                                class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <form action="{{ route('gifts.destroy', $gift->id) }}"
                                            id="delete-form-{{ $gift->id }}" method="POST" class="hidden">
                                            @csrf @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Excluir presente?',
                text: "Esta ação não pode ser desfeita e removerá o presente da lista.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0f172a', // Slate-900
                cancelButtonColor: '#f1f5f9', // Slate-100
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Envia o formulário específico do convidado
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        function previewImage(url, title) {
            Swal.fire({
                title: title,
                imageUrl: url,
                imageAlt: title,
                showCloseButton: true,
                showConfirmButton: false, // Remove o botão de OK para ficar mais limpo
                closeButtonHtml: '&times;',
                customClass: {
                    popup: 'rounded-2xl',
                    image: 'rounded-lg shadow-lg'
                }
            });
        }
    </script>
</x-app-layout>
