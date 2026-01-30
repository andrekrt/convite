@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white min-h-screen shadow-xl pb-10">
        <div class="h-64 bg-slate-200 flex items-center justify-center relative">
            <span class="text-slate-400 font-serif italic text-xl">Nossa Foto</span>
        </div>

        <div class="p-6 text-center">
            <h1 class="text-3xl font-serif text-slate-800 mb-2">Olá, {{ $guest->name }}!</h1>
            <p class="text-slate-600 mb-6">Ficaremos muito felizes em ter você conosco em 17/04/2026.</p>

            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 mb-10">
                <h3 class="font-bold text-slate-800 mb-4 text-lg">Confirmar Presença</h3>
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('invitation.confirm', $guest->invite_code) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Quantas pessoas virão?</label>
                        <input type="number" name="confirmed_count" max="{{ $guest->max_guests }}" min="1"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            value="{{ $guest->max_guests }}">
                        <p class="text-xs text-slate-500 mt-1">Máximo de {{ $guest->max_guests }} pessoas.</p>
                    </div>
                    <button type="submit"
                        class="w-full bg-slate-900 text-white py-3 rounded-lg font-bold hover:bg-slate-800 transition">
                        Confirmar Agora
                    </button>
                </form>
            </div>

            <h2 class="text-2xl font-serif text-slate-800 mb-6">Lista de Presentes</h2>
            <div class="space-y-4 text-left">
                @foreach ($gifts as $gift)
                    <div class="flex items-center p-4 bg-white border border-slate-100 rounded-xl shadow-sm">
                        <div class="flex-1">
                            <h4 class="font-bold text-slate-800">{{ $gift->title }}</h4>
                            <p class="text-sm text-slate-500">{{ $gift->description }}</p>
                            <p class="text-blue-600 font-bold mt-1">R$ {{ number_format($gift->price, 2, ',', '.') }}</p>
                        </div>
                        <button onclick="generatePix({{ $gift->id }}, '{{ $guest->name }}')"
                            class="ml-4 bg-blue-50 text-blue-600 p-2 px-4 rounded-lg font-bold text-sm hover:bg-blue-100 transition">
                            Presentear
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="pix-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 text-center">
            <h3 class="text-xl font-bold mb-4">Seu presente simbólico</h3>
            <p class="text-sm text-slate-600 mb-4">Escaneie o QR Code ou copie o código abaixo:</p>
            <img id="pix-qr-code" src="" class="mx-auto" style="min-width: 200px; min-height: 200px;">

            <div id="qrcode-container" class="bg-slate-100 p-4 rounded-xl mb-4 flex justify-center">
                <p class="text-xs break-all font-mono border p-2 bg-white" id="pix-payload"></p>
            </div>

            <button onclick="copyPix()" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold mb-2">
                Copiar Código PIX
            </button>
            <button onclick="closeModal()" class="text-slate-500 text-sm">Fechar</button>
        </div>
    </div>

    <script>
        async function generatePix(giftId, guestName) {
            // 1. Captura o botão corretamente
            const button = event.currentTarget || event.target;
            button.disabled = true;
            button.innerText = 'Gerando...';

            try {
                const response = await fetch(`/pagamento/pix/${giftId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json', // Garante que o Laravel saiba que você quer JSON
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        guest_name: guestName
                    })
                });

                const data = await response.json();

                // 2. Verifica se a requisição foi bem sucedida (status 200-299)
                if (!response.ok) {
                    throw new Error(data.error || 'Erro no servidor');
                }

                if (data.pix_code) {
                    // Exibe o texto Copia e Cola
                    document.getElementById('pix-payload').innerText = data.pix_code;

                    // Exibe o Modal
                    const modal = document.getElementById('pix-modal');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');

                    // 3. Renderiza a imagem do QR Code
                    const qrCodeImg = document.getElementById('pix-qr-code');
                    if (qrCodeImg && data.qr_code_base64) {
                        qrCodeImg.src = `data:image/png;base64,${data.qr_code_base64}`;
                        qrCodeImg.style.display = 'block'; // Garante que não esteja escondida via CSS
                    }
                }
            } catch (error) {
                console.error('Erro detalhado:', error);
                alert('Não foi possível gerar o QR Code. Por favor, tente novamente.');
            } finally {
                button.disabled = false;
                button.innerText = 'Presentear';
            }
        }

        function copyPix() {
            const text = document.getElementById('pix-payload').innerText;
            navigator.clipboard.writeText(text);
            alert('Código copiado!');
        }

        function closeModal() {
            document.getElementById('pix-modal').classList.add('hidden');
            document.getElementById('pix-modal').classList.remove('flex');
        }
    </script>
@endsection
