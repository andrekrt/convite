<x-app-layout>
    {{-- Mantemos a limpeza total removendo menus administrativos --}}
    <x-slot name="header"></x-slot>
    <style>
        nav,
        header {
            display: none !important;
        }
    </style>

    <div class="max-w-md mx-auto bg-slate-50 min-h-screen pb-20 font-sans">

        <div class="bg-white p-6 pt-10 border-b border-slate-100 sticky top-0 z-10">
            <div class="flex items-center justify-between mb-2">
                <h1 class="text-2xl font-serif font-bold text-slate-900 tracking-tight">Lista de Mimos</h1>
                <a href="{{ route('invitation.show', $guest->invite_code) }}"
                    class="text-slate-400 hover:text-slate-900 transition">
                    <i class="fa-solid fa-circle-xmark text-2xl"></i>
                </a>
            </div>
            <p class="text-xs text-slate-500 italic">Escolha um item para nos presentear</p>
        </div>

        <div class="p-6 grid grid-cols-1 gap-8">
            @foreach ($gifts as $gift)
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm border border-slate-100 group">

                    <div class="h-64 w-full relative overflow-hidden">
                        <img src="{{ asset('storage/' . $gift->image) }}" alt="{{ $gift->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                        <div
                            class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-sm border border-slate-100">
                            <span class="text-slate-900 font-black text-sm italic">R$
                                {{ number_format($gift->price, 2, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="p-8 text-center">
                        <h3 class="text-xl font-bold text-slate-800 mb-3 tracking-tight">{{ $gift->name }}</h3>
                        <p class="text-xs text-slate-400 leading-relaxed mb-8 px-2">
                            {{ $gift->description ?? 'Um item escolhido com carinho para o nosso novo lar.' }}
                        </p>

                        <button onclick="generatePix({{ $gift->id }}, '{{ $guest->name }}')"
                            class="w-full bg-slate-900 text-white py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-slate-200 active:scale-95 transition-all">
                            <i class="fa-solid fa-qrcode mr-2 opacity-40"></i> Presentear via PIX
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center py-10 opacity-20">
            <i class="fa-solid fa-heart text-slate-400"></i>
        </div>
    </div>

    {{-- Reutilizamos o Modal de PIX que já configuramos antes --}}
    @include('guest.partials.pix-modal')

    <script>
        async function generatePix(giftId, guestName) {
            // Feedback visual imediato no botão
            const button = event.currentTarget;
            const originalContent = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> GERANDO...';

            try {
                // Usamos uma string genérica 'GIFT_ID' que será substituída pelo ID real no JS
                const url = "{{ route('payment.pix', 'GIFT_ID') }}".replace('GIFT_ID', giftId);

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        guest_name: guestName
                    })
                });

                const data = await response.json();

                if (!response.ok) throw new Error(data.error || 'Erro ao processar PIX');

                if (data.pix_code) {
                    // Preenche e abre o modal (use o SweetAlert ou o modal HTML que criamos)
                    document.getElementById('pix-payload').innerText = data.pix_code;
                    document.getElementById('pix-qr-code').src = `data:image/png;base64,${data.qr_code_base64}`;

                    const modal = document.getElementById('pix-modal');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ops!',
                    text: 'Não conseguimos gerar o código PIX agora. Tente novamente em instantes.',
                    confirmButtonColor: '#0f172a'
                });
            } finally {
                button.disabled = false;
                button.innerHTML = originalContent;
            }
        }
    </script>
</x-app-layout>
