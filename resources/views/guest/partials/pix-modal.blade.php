<div id="pix-modal" class="fixed inset-0 bg-slate-900/80 hidden items-center justify-center p-4 z-[100] backdrop-blur-sm">
    <div class="bg-white rounded-3xl max-w-sm w-full p-8 text-center shadow-2xl">
        <div class="w-16 h-16 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-qrcode text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Seu presente simbólico</h3>
        <p class="text-sm text-slate-500 mb-6">Escaneie o QR Code para enviar seu presente via PIX.</p>

        <div class="bg-slate-50 p-4 rounded-2xl mb-6 border border-slate-100">
            <img id="pix-qr-code" src="" class="mx-auto rounded-lg mb-4" style="max-width: 200px; display: none;" onload="this.style.display='block'">
            <p class="text-[10px] break-all font-mono text-slate-400 bg-white p-3 rounded-xl border border-slate-100 select-all" id="pix-payload">Carregando código...</p>
        </div>

        <button onclick="copyPix()" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold mb-3 shadow-lg shadow-slate-200 active:scale-95 transition">
            Copiar Código PIX
        </button>
        <button onclick="closeModal()" class="text-slate-400 text-sm font-bold hover:text-slate-800 transition">Fechar</button>
    </div>
</div>
