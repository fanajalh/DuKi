@extends('layouts.auth')

@section('title', 'Tarik Dana')

@section('content')

{{-- 🐷 PIG LOADING OVERLAY --}}
<div id="pig-loading" class="fixed inset-0 z-[9999] bg-slate-900/70 backdrop-blur-sm flex flex-col items-center justify-center hidden">
    <div class="flex flex-col items-center gap-4">
        <div class="pig-bounce">
            <div class="pig-body">
                <div class="pig-ear pig-ear-left"></div>
                <div class="pig-ear pig-ear-right"></div>
                <div class="pig-head">
                    <div class="pig-eye pig-eye-left"></div>
                    <div class="pig-eye pig-eye-right"></div>
                    <div class="pig-snout">
                        <div class="pig-nostril pig-nostril-left"></div>
                        <div class="pig-nostril pig-nostril-right"></div>
                    </div>
                    <div class="pig-blush pig-blush-left"></div>
                    <div class="pig-blush pig-blush-right"></div>
                </div>
            </div>
        </div>
        <div class="coin-container">
            <div class="coin coin-1">💰</div>
            <div class="coin coin-2">🪙</div>
            <div class="coin coin-3">💰</div>
        </div>
        <p class="text-white font-black text-xl tracking-wide">Mengirim Permintaan...</p>
        <div class="flex gap-1.5">
            <div class="dot dot-1"></div>
            <div class="dot dot-2"></div>
            <div class="dot dot-3"></div>
        </div>
    </div>
</div>

<style>
    .pig-bounce { animation: pigBounce 0.8s ease-in-out infinite alternate; }
    .pig-body { position: relative; width: 120px; height: 120px; }
    .pig-ear { position: absolute; width: 36px; height: 36px; background: #f9a8d4; border: 4px solid #1e293b; border-radius: 50% 50% 50% 20% / 50% 50% 20% 50%; top: 4px; z-index: 0; }
    .pig-ear-left  { left: 4px;  transform: rotate(-30deg); }
    .pig-ear-right { right: 4px; transform: rotate(30deg) scaleX(-1); }
    .pig-head { position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 110px; height: 100px; background: #fda4af; border: 4px solid #1e293b; border-radius: 55% 55% 50% 50% / 60% 60% 50% 50%; z-index: 1; }
    .pig-eye { position: absolute; top: 28px; width: 14px; height: 17px; background: #1e293b; border-radius: 50%; animation: pigBlink 3s ease-in-out infinite; }
    .pig-eye-left  { left: 22px; }
    .pig-eye-right { right: 22px; }
    .pig-eye::after { content: ''; position: absolute; top: 3px; left: 3px; width: 5px; height: 5px; background: white; border-radius: 50%; }
    .pig-snout { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); width: 44px; height: 32px; background: #fb7185; border: 3px solid #1e293b; border-radius: 50%; display: flex; align-items: center; justify-content: center; gap: 6px; }
    .pig-nostril { width: 9px; height: 11px; background: #be123c; border-radius: 50%; border: 2px solid #1e293b; }
    .pig-blush { position: absolute; bottom: 32px; width: 18px; height: 10px; background: #fb7185; border-radius: 50%; opacity: 0.6; }
    .pig-blush-left  { left: 10px; }
    .pig-blush-right { right: 10px; }
    .dot { width: 10px; height: 10px; background: white; border-radius: 50%; animation: dotPulse 1.2s ease-in-out infinite; }
    .dot-1 { animation-delay: 0s; } .dot-2 { animation-delay: 0.2s; } .dot-3 { animation-delay: 0.4s; }
    .coin-container { position: relative; height: 30px; display: flex; gap: 12px; }
    .coin { font-size: 20px; animation: coinFall 1.5s ease-in-out infinite; }
    .coin-1 { animation-delay: 0s; } .coin-2 { animation-delay: 0.3s; } .coin-3 { animation-delay: 0.6s; }
    @keyframes pigBounce { from { transform: translateY(0px); } to { transform: translateY(-12px); } }
    @keyframes pigBlink { 0%, 92%, 100% { transform: scaleY(1); } 96% { transform: scaleY(0.05); } }
    @keyframes dotPulse { 0%, 100% { opacity: 0.3; transform: scale(0.8); } 50% { opacity: 1; transform: scale(1.2); } }
    @keyframes coinFall { 0% { transform: translateY(-20px); opacity: 0; } 30% { opacity: 1; } 70% { opacity: 1; } 100% { transform: translateY(20px); opacity: 0; } }
</style>
<div class="flex flex-col min-h-screen bg-slate-900/60 justify-end items-center backdrop-blur-sm relative">
    
    <a href="{{ url('/dashboard') }}" class="absolute top-6 right-6 w-12 h-12 bg-white border-4 border-slate-800 rounded-full flex items-center justify-center text-xl shadow-cartoon hover:bg-slate-100 text-slate-800">
        <i class="ph-bold ph-x"></i>
    </a>

    <div class="w-full md:max-w-[400px] bg-orange-50 md:border-x-4 border-t-4 border-slate-800 rounded-t-[2.5rem] p-6 shadow-[0px_-8px_0px_0px_rgba(30,41,59,1)] animate-[slideUp_0.3s_ease-out]">
        <div class="w-16 h-2 bg-slate-800 rounded-full mx-auto mb-6"></div>
        <h2 class="text-2xl font-black text-slate-800 mb-6 text-center flex items-center justify-center gap-2">Tarik Dana <i class="ph-duotone ph-hand-coins text-yellow-500"></i></h2>

        {{-- Validation Errors --}}
        @if($errors->any())
        <div class="mb-4 bg-pink-200 border-4 border-slate-800 rounded-2xl p-4">
            @foreach($errors->all() as $error)
                <p class="text-sm font-bold text-red-700 flex items-center gap-2">
                    <i class="ph-bold ph-warning-circle flex-shrink-0"></i> {{ $error }}
                </p>
            @endforeach
        </div>
        @endif

        <form action="{{ url('/withdraw/request') }}" method="POST">
            @csrf

            {{-- Amount --}}
            <div class="mb-6">
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Jumlah (Rp)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl font-black text-slate-800">Rp</span>
                    <input 
                        type="number" 
                        name="amount"
                        id="amount_input"
                        value="{{ old('amount') }}"
                        placeholder="0" 
                        class="w-full bg-white border-4 {{ $errors->has('amount') ? 'border-red-500' : 'border-slate-800' }} rounded-2xl py-4 pl-14 pr-4 text-2xl font-black text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-4 focus:ring-yellow-300 transition-all shadow-cartoon-sm"
                        required
                        min="1"
                    >
                </div>
                {{-- Live balance warning --}}
                <p id="balance_warning" class="text-xs font-bold mt-2 hidden text-red-600">
                    <i class="ph-bold ph-warning-circle"></i> <span id="balance_warning_text"></span>
                </p>
            </div>

            {{-- Pocket Select --}}
            <div class="mb-6">
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Dari Kantong</label>
                <select id="pocket_select" name="pocket_id" class="w-full bg-white border-4 border-slate-800 rounded-2xl p-4 text-lg font-black text-slate-800 focus:outline-none focus:ring-4 focus:ring-yellow-300 shadow-cartoon-sm appearance-none">
                    @foreach($pockets as $pocket)
                        <option 
                            value="{{ $pocket->id }}" 
                            data-balance="{{ $pocket->totalSaved() }}"
                            {{ (old('pocket_id', $pocket_id) == $pocket->id) ? 'selected' : '' }}
                        >{{ $pocket->name }}</option>
                    @endforeach
                </select>
                <p id="balance_info" class="text-xs font-bold mt-2 text-slate-600"></p>
            </div>

            {{-- Message --}}
            <div class="mb-8">
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Untuk Apa? (Wajib Diisi)</label>
                <input 
                    type="text" 
                    name="message"
                    value="{{ old('message') }}"
                    placeholder="contoh: Beli kado ulang tahun" 
                    class="w-full bg-white border-4 {{ $errors->has('message') ? 'border-red-500' : 'border-slate-800' }} rounded-2xl p-3 text-md font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-yellow-300 transition-all shadow-cartoon-sm"
                    required
                >
                <p class="text-xs text-slate-500 font-bold mt-2">Pasanganmu akan menerima notifikasi untuk menyetujui penarikan ini.</p>
            </div>

            <button type="submit" class="w-full bg-yellow-300 border-4 border-slate-800 rounded-2xl p-5 text-xl font-black text-slate-800 shadow-cartoon hover:bg-yellow-400 active:translate-y-1 active:shadow-none transition-all flex justify-center items-center gap-2">
                Ajukan Penarikan! <i class="ph-bold ph-paper-plane-tilt"></i>
            </button>
        </form>

<script>
document.querySelector('form[action*="/withdraw/request"]').addEventListener('submit', function(e) {
    document.getElementById('pig-loading').classList.remove('hidden');
});
</script>
    </div>
</div>

<script>
(function() {
    var select  = document.getElementById('pocket_select');
    var info    = document.getElementById('balance_info');
    var amtInput = document.getElementById('amount_input');
    var warning = document.getElementById('balance_warning');
    var warnTxt = document.getElementById('balance_warning_text');

    function formatRp(val) {
        return 'Rp ' + Math.floor(val).toLocaleString('id-ID');
    }

    function getBalance() {
        var opt = select.options[select.selectedIndex];
        return parseFloat(opt ? (opt.dataset.balance || 0) : 0);
    }

    function updateBalance() {
        var bal = getBalance();
        info.textContent = 'Saldo tersedia: ' + formatRp(bal);
        info.className = bal > 0 ? 'text-xs font-bold mt-2 text-green-700' : 'text-xs font-bold mt-2 text-red-600';
        checkAmount();
    }

    function checkAmount() {
        var bal = getBalance();
        var amt = parseFloat(amtInput.value || 0);
        if (amt > 0 && amt > bal) {
            warnTxt.textContent = 'Jumlah melebihi saldo tersedia (' + formatRp(bal) + ')';
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }
    }

    select.addEventListener('change', updateBalance);
    amtInput.addEventListener('input', checkAmount);
    updateBalance();
})();
</script>
@endsection
