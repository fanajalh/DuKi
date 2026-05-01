<!-- DukiBot Widget -->
<div id="dukibot-container" class="fixed bottom-24 right-4 z-50 flex flex-col items-end hidden md:flex" style="max-width: 400px; display: flex;">
    
    <!-- Chat Window -->
    <div id="dukibot-window" class="hidden mb-4 w-72 bg-white border-4 border-slate-800 rounded-3xl shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] overflow-hidden transition-all origin-bottom-right transform scale-0">
        <!-- Header -->
        <div class="bg-pink-400 border-b-4 border-slate-800 p-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-yellow-300 border-2 border-slate-800 rounded-full flex items-center justify-center text-xl shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]">
                    <i class="ph-duotone ph-robot"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-800 text-sm leading-tight">DukiBot</h3>
                    <span class="text-[10px] font-bold text-slate-800 bg-lime-300 px-2 py-0.5 rounded-full border-2 border-slate-800">Online</span>
                </div>
            </div>
            <button onclick="toggleDukiBot()" class="text-slate-800 hover:text-white transition-colors">
                <i class="ph-bold ph-x"></i>
            </button>
        </div>

        <!-- Messages Area -->
        <div id="dukibot-messages" class="p-4 h-64 overflow-y-auto bg-slate-50 flex flex-col gap-3">
            <!-- Initial Message -->
            <div class="flex gap-2">
                <div class="w-6 h-6 flex-shrink-0 bg-yellow-300 border-2 border-slate-800 rounded-full flex items-center justify-center text-xs mt-1">
                    <i class="ph-fill ph-robot"></i>
                </div>
                <div class="bg-white border-2 border-slate-800 rounded-2xl rounded-tl-none p-2 text-sm font-bold text-slate-700 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]">
                    Halo kakak! Aku DukiBot! 🤖 Udah nabung belum hari ini? Ayo semangat nabungnya biar celengannya cepet penuh! 💖
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-3 border-t-4 border-slate-800 bg-white">
            <form id="dukibot-form" class="flex gap-2" onsubmit="handleDukiBotSubmit(event)">
                <input type="text" id="dukibot-input" class="flex-1 bg-slate-100 border-2 border-slate-800 rounded-xl px-3 py-2 text-sm font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-lime-300" placeholder="Ketik pesan lucu..." autocomplete="off">
                <button type="submit" class="w-10 h-10 bg-lime-400 border-2 border-slate-800 rounded-xl flex items-center justify-center text-slate-800 hover:bg-lime-300 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] active:translate-y-0.5 active:shadow-none transition-all">
                    <i class="ph-bold ph-paper-plane-right"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Toggle Button -->
    <button onclick="toggleDukiBot()" id="dukibot-toggle" class="w-16 h-16 bg-pink-400 border-4 border-slate-800 rounded-full flex items-center justify-center text-3xl text-slate-800 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:-translate-y-1 hover:shadow-[4px_6px_0px_0px_rgba(30,41,59,1)] active:translate-y-1 active:shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] transition-all z-50 animate-bounce" style="animation-duration: 3s;">
        <i class="ph-duotone ph-robot"></i>
        <!-- Notification dot -->
        <span class="absolute top-0 right-0 w-4 h-4 bg-lime-400 border-2 border-slate-800 rounded-full animate-ping"></span>
        <span class="absolute top-0 right-0 w-4 h-4 bg-lime-400 border-2 border-slate-800 rounded-full"></span>
    </button>
</div>

<!-- Only show on mobile if they are in webview/max-w-[400px] -->
<style>
    @media (max-width: 450px) {
        #dukibot-container {
            bottom: 80px; /* Above nav bar */
            right: 16px;
        }
    }
</style>

<script>
    let dukiBotOpen = false;
    const botWindow = document.getElementById('dukibot-window');
    const toggleBtn = document.getElementById('dukibot-toggle');
    const messagesArea = document.getElementById('dukibot-messages');
    


    function toggleDukiBot() {
        dukiBotOpen = !dukiBotOpen;
        
        if(dukiBotOpen) {
            botWindow.classList.remove('hidden');
            // small delay for transition
            setTimeout(() => {
                botWindow.classList.remove('scale-0');
                botWindow.classList.add('scale-100');
            }, 10);
            toggleBtn.classList.remove('animate-bounce');
        } else {
            botWindow.classList.remove('scale-100');
            botWindow.classList.add('scale-0');
            setTimeout(() => {
                botWindow.classList.add('hidden');
            }, 300);
        }
    }

    async function handleDukiBotSubmit(e) {
        e.preventDefault();
        const input = document.getElementById('dukibot-input');
        const text = input.value.trim();
        const submitBtn = input.nextElementSibling;
        
        if(!text) return;
        
        // Add user message
        appendMessage('user', text);
        input.value = '';
        input.disabled = true;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="ph-duotone ph-spinner animate-spin"></i>';
        
        // Scroll to bottom
        messagesArea.scrollTop = messagesArea.scrollHeight;
        
        try {
            const response = await fetch('{{ url("/api/chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: text })
            });

            const data = await response.json();
            
            if(data.success) {
                appendMessage('bot', data.reply);
            } else {
                appendMessage('bot', data.reply || 'DukiBot lagi pusing nih... 😵‍💫');
            }
        } catch (error) {
            appendMessage('bot', 'Yah, koneksi DukiBot putus... 📶 Nanti coba lagi ya!');
        } finally {
            input.disabled = false;
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="ph-bold ph-paper-plane-right"></i>';
            input.focus();
            messagesArea.scrollTop = messagesArea.scrollHeight;
        }
    }

    function appendMessage(sender, text) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `flex gap-2 ${sender === 'user' ? 'flex-row-reverse' : ''}`;
        
        if(sender === 'bot') {
            msgDiv.innerHTML = `
                <div class="w-6 h-6 flex-shrink-0 bg-yellow-300 border-2 border-slate-800 rounded-full flex items-center justify-center text-xs mt-1">
                    <i class="ph-fill ph-robot"></i>
                </div>
                <div class="bg-white border-2 border-slate-800 rounded-2xl rounded-tl-none p-2 text-sm font-bold text-slate-700 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]">
                    ${text}
                </div>
            `;
        } else {
            msgDiv.innerHTML = `
                <div class="bg-lime-200 border-2 border-slate-800 rounded-2xl rounded-tr-none p-2 text-sm font-bold text-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]">
                    ${text}
                </div>
            `;
        }
        
        messagesArea.appendChild(msgDiv);
    }
</script>
