<x-app-layout>
    {{-- Removemos o Header do Layout para o convite ficar focado no conteúdo --}}
    <x-slot name="header"></x-slot>

    <div class="max-w-md mx-auto bg-white min-h-screen shadow-xl pb-10">
        {{-- Área da Foto --}}
        <div class="h-64 bg-slate-200 flex items-center justify-center relative overflow-hidden">
            @if(isset($settings) && $settings->couple_photo)
                <img src="{{ asset('storage/' . $settings->couple_photo) }}" class="w-full h-full object-cover">
            @else
                <span class="text-slate-400 font-serif italic text-xl">Nossa Foto</span>
            @endif
        </div>

        <div class="p-6 text-center">
            <h1 class="text-3xl font-serif text-slate-800 mb-2">Olá, {{ $guest->name }}!</h1>
            <p class="text-slate-600 mb-6">Ficaremos muito felizes em ter você conosco em 17/04/2026.</p>

            {{-- Card de Confirmação --}}
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 mb-10">
                <h3 class="font-bold text-slate-800 mb-4 text-lg">Confirmar Presença</h3>

                <form action="{{ route('invitation.confirm', $guest->invite_code) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Quantas pessoas virão?</label>
                        <input type="number" name="confirmed_count" max="{{ $guest->max_guests }}" min="1"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-slate-900 focus:border-slate-900"
                            value="{{ $guest->max_guests }}">
                        <p class="text-xs text-slate-500 mt-1">Máximo de {{ $guest->max_guests }} pessoas.</p>
                    </div>

                    @if($guest->is_confirmed)
                        <div class="bg-green-100 text-green-700 p-3 rounded-lg text-sm font-bold">
                            ✓ Presença já confirmada!
                        </div>
                    @endif

                    <button type="submit"
                        class="w-full bg-slate-900 text-white py-3 rounded-lg font-bold hover:bg-slate-800 transition">
                        {{ $guest->is_confirmed ? 'Atualizar Confirmação' : 'Confirmar Agora' }}
                    </button>
                </form>
            </div>

            <h2 class="text-2xl font-serif text-slate-800 mb-6 tracking-tight">Lista de Presentes</h2>
            <div class="space-y-4 text-left">
                @foreach ($gifts as $gift)
                    <div class="flex items-center p-4 bg-white border border-slate-100 rounded-xl shadow-sm hover:shadow-md transition">
                        {{-- Foto do Presente --}}
                        <div class="w-16 h-16 bg-slate-50 rounded-lg overflow-hidden mr-4 flex-shrink-0 border border-slate-100">
                            @if($gift->image)
                                <img src="{{ asset('storage/' . $gift->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i class="fa-solid fa-gift"></i>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <h4 class="font-bold text-slate-800 leading-tight">{{ $gift->name }}</h4> {{-- Alterado de title para name --}}
                            <p class="text-xs text-slate-500 line-clamp-1">{{ $gift->description }}</p>
                            <p class="text-slate-900 font-black mt-1 text-sm italic">R$ {{ number_format($gift->price, 2, ',', '.') }}</p>
                        </div>
                        <button onclick="generatePix({{ $gift->id }}, '{{ $guest->name }}')"
                            class="ml-2 bg-slate-100 text-slate-900 p-2 px-4 rounded-lg font-bold text-xs hover:bg-slate-900 hover:text-white transition">
                            Presentear
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Modal do PIX --}}
    <div id="pix-modal" class="fixed inset-0 bg-slate-900/80 hidden items-center justify-center p-4 z-[100] backdrop-blur-sm">
        <div class="bg-white rounded-3xl max-w-sm w-full p-8 text-center shadow-2xl">
            <div class="w-16 h-16 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-qrcode text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Quase lá!</h3>
            <p class="text-sm text-slate-500 mb-6">Escaneie o QR Code para enviar seu presente via PIX.</p>

            <div class="bg-slate-50 p-4 rounded-2xl mb-6 border border-slate-100">
                <img id="pix-qr-code" src="" class="mx-auto rounded-lg mb-4" style="max-width: 200px;">
                <p class="text-[10px] break-all font-mono text-slate-400 bg-white p-3 rounded-xl border border-slate-100 select-all" id="pix-payload"></p>
            </div>

            <button onclick="copyPix()" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold mb-3 shadow-lg shadow-slate-200 active:scale-95 transition">
                Copiar Código PIX
            </button>
            <button onclick="closeModal()" class="text-slate-400 text-sm font-bold hover:text-slate-800 transition">Fechar</button>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        // Mantive sua lógica original, apenas ajustei seletores e melhorei o feedback
        async function generatePix(giftId, guestName) {
            const button = event.currentTarget;
            const originalText = button.innerText;
            button.disabled = true;
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

            try {
                const response = await fetch(`/pagamento/pix/${giftId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ guest_name: guestName })
                });

                const data = await response.json();

                if (!response.ok) throw new Error(data.error || 'Erro no servidor');

                if (data.pix_code) {
                    document.getElementById('pix-payload').innerText = data.pix_code;
                    const modal = document.getElementById('pix-modal');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');

                    const qrCodeImg = document.getElementById('pix-qr-code');
                    if (data.qr_code_base64) {
                        qrCodeImg.src = `data:image/png;base64,${data.qr_code_base64}`;
                    }
                }
            } catch (error) {
                Swal.fire('Ops!', 'Não foi possível gerar o PIX. Tente novamente.', 'error');
            } finally {
                button.disabled = false;
                button.innerText = originalText;
            }
        }

        function copyPix() {
            const text = document.getElementById('pix-payload').innerText;
            navigator.clipboard.writeText(text);
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Código PIX copiado!',
                showConfirmButton: false,
                timer: 2000
            });
        }

        function closeModal() {
            document.getElementById('pix-modal').classList.add('hidden');
            document.getElementById('pix-modal').classList.remove('flex');
        }
    </script>
</x-app-layout>
