@extends('layouts.auth')

@section('title', 'Tarik Dana')

@section('content')
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
