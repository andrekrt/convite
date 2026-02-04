<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-serif font-bold text-slate-800 tracking-tight">Painel de Convidados</h1>
                    <p class="text-sm text-slate-500 italic">Total: {{ $guests->count() }} famílias cadastradas</p>
                </div>
                <a href="{{ route('guests.create') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-slate-900 text-white text-sm font-bold rounded-lg hover:bg-slate-800 transition-all shadow-sm">
                    <i class="fa-solid fa-plus mr-2"></i> Novo Convidado
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400">Nome /
                                Família
                            </th>
                            <th
                                class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 text-center">
                                Qtd
                            </th>
                            <th
                                class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 text-center">
                                WhatsApp
                            </th>
                            <th
                                class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 text-center">
                                Status
                            </th>
                            <th
                                class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 text-center">
                                Enviado?
                            </th>
                            <th
                                class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 text-right">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($guests as $guest)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800 text-sm">{{ $guest->name }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono">{{ $guest->invite_code }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-1 rounded">{{ $guest->max_guests }}</span>
                                </td>
                                <td class="px-6 py-4 text-center text-xs text-slate-500">
                                    {{ $guest->phone }}
                                </td>
                                <td class="px-6 py-4 text-center text-xs text-slate-500">
                                    @if ($guest->is_confirmed)
                                        CONFIRMADO
                                    @else
                                        PENDENTE
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($guest->sent_at)
                                        <i class="fa-solid fa-check-double text-blue-500" title="Enviado"></i>
                                    @else
                                        <i class="fa-solid fa-clock text-slate-300" title="Pendente"></i>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-4 text-lg">
                                        <a href="" target="_blank" class="text-green-500 hover:text-green-600"
                                            title="Enviar Convite">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>

                                        <button
                                            onclick="copyLink('{{ route('invitation.show', $guest->invite_code) }}', this)"
                                            class="text-slate-400 hover:text-slate-600" title="Copiar Link">
                                            <i class="fa-regular fa-copy text-base"></i>
                                        </button>

                                        <a href="{{ route('guests.edit', $guest->id) }}"
                                            class="text-slate-400 hover:text-blue-600" title="Editar">
                                            <i class="fa-solid fa-pen-to-square text-base"></i>
                                        </a>

                                        <button type="button" onclick="confirmDelete({{ $guest->id }})"
                                            class="text-slate-300 hover:text-red-600" title="Excluir">
                                            <i class="fa-solid fa-trash-can text-base"></i>
                                        </button>

                                        <form action="{{ route('guests.destroy', $guest->id) }}" method="POST"
                                            id="delete-form-{{ $guest->id }}" class="hidden">
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
                title: 'Excluir convidado?',
                text: "Esta ação não pode ser desfeita e removerá o convidado da lista.",
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

        function copyLink(link, btn) {
            navigator.clipboard.writeText(link);
            const originalIcon = btn.innerHTML;
            btn.innerHTML = '<span class="text-[9px] font-black text-slate-900 uppercase">Copiado</span>';
            setTimeout(() => btn.innerHTML = originalIcon, 1500);
        }
    </script>
</x-app-layout>
