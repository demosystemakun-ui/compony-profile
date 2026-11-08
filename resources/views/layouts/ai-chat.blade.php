{{-- ═══════════════════════════════════════════════════════════════
     GLOBAL FLOATING AI CHATBOT WIDGET (COLLAPSIBLE TO EDGE)
══════════════════════════════════════════════════════════════ --}}
<div id="ai-chat-widget"
     class="fixed left-0 bottom-24 z-50 flex items-center transition-transform duration-300 -translate-x-[calc(100%-24px)]"
     data-minimized="true"
     role="complementary"
     aria-label="PICT AI Assistant">

    {{-- ═══ CHAT BOX ═══ --}}
    <div id="ai-chat-box"
         class="w-[calc(100vw-2rem)] sm:w-96 max-w-sm bg-white border border-slate-200 rounded-r-2xl shadow-2xl flex flex-col overflow-hidden h-[500px]">

        {{-- Header --}}
        <div class="bg-slate-900 text-white px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="relative">
                    <span class="block w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span class="absolute inset-0 w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping opacity-75"></span>
                </div>
                <div>
                    <h4 class="font-bold text-sm leading-tight">PICT AI Assistant</h4>
                </div>
            </div>
            <button id="ai-chat-close"
                    type="button"
                    aria-label="Close chat"
                    class="text-slate-400 hover:text-white transition-colors p-1 rounded hover:bg-white/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Messages --}}
        <div id="ai-chat-messages"
             class="flex-1 p-4 overflow-y-auto space-y-3 text-xs bg-slate-50 scroll-smooth"
             role="log"
             aria-live="polite">
            <div class="flex justify-start">
                <div class="bg-white border border-slate-200 text-slate-800 p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[85%] leading-relaxed">
                    Hello! How can I help you with terminal services or information about Patimban International Car Terminal? You can select a topic below or type your question.
                </div>
            </div>

            {{-- Quick questions --}}
            @php
                $quickQuestions = [
                    'What are your main services?',
                    'What is the annual capacity?',
                    'How to book a berth?',
                    'Contact commercial team',
                ];
            @endphp
            <div id="suggested-questions" class="flex flex-wrap gap-1.5 pt-1">
                @foreach($quickQuestions as $q)
                    <button type="button"
                            class="quick-question-btn bg-blue-50 hover:bg-blue-100 active:bg-blue-200 text-blue-700 border border-blue-200 px-3 py-1.5 rounded-full text-[11px] font-medium transition cursor-pointer">
                        {{ $q }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Input --}}
        <div class="p-3 bg-white border-t border-slate-200 flex gap-2">
            <input type="text"
                   id="ai-chat-input"
                   placeholder="Type a message..."
                   aria-label="Chat message"
                   autocomplete="off"
                   class="flex-1 px-3 py-2 border border-slate-300 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent bg-slate-50">
            <button id="ai-chat-send"
                    type="button"
                    aria-label="Send message"
                    class="bg-red-600 hover:bg-red-500 disabled:bg-slate-300 disabled:cursor-not-allowed text-white px-4 py-2 rounded-xl text-xs font-bold transition inline-flex items-center gap-1.5">
                <span>Send</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- ═══ TOGGLE TAB ═══ --}}
    <button id="ai-chat-toggle"
            type="button"
            aria-label="Open AI Assistant"
            aria-expanded="false"
            class="relative -ml-3 rounded-r-full shadow-lg flex items-center justify-center transition-all bg-white border border-l-0 border-slate-200 w-12 h-14 hover:w-14 cursor-pointer group">
        <div class="flex items-center">
            <div class="w-9 h-9 rounded-full overflow-hidden border border-slate-200 flex-shrink-0">
                <img src="{{ asset('assets/images/maskot-ai.png') }}"
                     alt=""
                     aria-hidden="true"
                     class="w-full h-full object-cover">
            </div>
            <svg id="toggle-arrow"
                 class="w-4 h-4 text-slate-600 group-hover:text-red-600 transition-transform duration-300 ml-0.5"
                 fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    /* ═══════════════════════════════════════════════════════════════
       ELEMENT REFERENCES
    ═══════════════════════════════════════════════════════════════ */
    const toggleBtn   = document.getElementById('ai-chat-toggle');
    const closeBtn    = document.getElementById('ai-chat-close');
    const chatWidget  = document.getElementById('ai-chat-widget');
    const toggleArrow = document.getElementById('toggle-arrow');
    const sendBtn     = document.getElementById('ai-chat-send');
    const inputField  = document.getElementById('ai-chat-input');
    const messagesEl  = document.getElementById('ai-chat-messages');

    if (!chatWidget) return; // guard

    /* ═══════════════════════════════════════════════════════════════
       STATE
    ═══════════════════════════════════════════════════════════════ */
    const csrfToken   = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const MINIMIZED_CLASS = '-translate-x-[calc(100%-24px)]';
    const MAX_HISTORY = 20;

    let conversationHistory = [];
    let messageCounter      = 0;
    let isSending           = false;

    /* Simpan HTML awal untuk reset */
    const initialMessagesHTML = messagesEl ? messagesEl.innerHTML : '';

    /* ═══════════════════════════════════════════════════════════════
       OPEN / CLOSE WIDGET
    ═══════════════════════════════════════════════════════════════ */
    function setExpanded(expanded) {
        if (expanded) {
            chatWidget.classList.remove(MINIMIZED_CLASS);
            chatWidget.classList.add('translate-x-0');
            chatWidget.setAttribute('data-minimized', 'false');
            toggleArrow.style.transform = 'rotate(180deg)';
            toggleBtn.setAttribute('aria-expanded', 'true');
            toggleBtn.setAttribute('aria-label', 'Close AI Assistant');
            setTimeout(() => inputField?.focus(), 300);
        } else {
            chatWidget.classList.remove('translate-x-0');
            chatWidget.classList.add(MINIMIZED_CLASS);
            chatWidget.setAttribute('data-minimized', 'true');
            toggleArrow.style.transform = 'rotate(0deg)';
            toggleBtn.setAttribute('aria-expanded', 'false');
            toggleBtn.setAttribute('aria-label', 'Open AI Assistant');
            setTimeout(resetChatState, 350);
        }
    }

    function toggleChatWidget() {
        const isMinimized = chatWidget.getAttribute('data-minimized') === 'true';
        setExpanded(isMinimized);
    }

    function resetChatState() {
        conversationHistory = [];
        if (inputField) inputField.value = '';
        if (messagesEl) messagesEl.innerHTML = initialMessagesHTML;
        setSendingState(false);
    }

    toggleBtn?.addEventListener('click', toggleChatWidget);
    closeBtn?.addEventListener('click', toggleChatWidget);

    /* ═══════════════════════════════════════════════════════════════
       QUICK QUESTIONS
    ═══════════════════════════════════════════════════════════════ */
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.quick-question-btn');
        if (!btn) return;

        if (inputField) inputField.value = btn.textContent.trim();
        hideQuickQuestions();
        handleSendMessage();
    });

    function hideQuickQuestions() {
        const el = document.getElementById('suggested-questions');
        if (el) el.style.display = 'none';
    }

    /* ═══════════════════════════════════════════════════════════════
       SEND / RECEIVE
    ═══════════════════════════════════════════════════════════════ */
    function setSendingState(sending) {
        isSending = sending;
        if (sendBtn) sendBtn.disabled = sending;
        if (inputField) inputField.disabled = sending;
    }

    async function handleSendMessage() {
        if (isSending || !inputField) return;

        const text = inputField.value.trim();
        if (!text) return;

        hideQuickQuestions();
        appendMessage(text, 'user');
        inputField.value = '';
        scrollToBottom();

        setSendingState(true);
        const loadingId = appendMessage('Typing…', 'bot', { isLoading: true });

        try {
            const response = await fetch('/api/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    message: text,
                    history: conversationHistory,
                }),
            });

            const data = await response.json();
            document.getElementById(loadingId)?.remove();

            if (data.reply) {
                appendMessage(data.reply, 'bot');
                conversationHistory.push({ role: 'user', content: text });
                conversationHistory.push({ role: 'assistant', content: data.reply });
                if (conversationHistory.length > MAX_HISTORY) {
                    conversationHistory = conversationHistory.slice(-MAX_HISTORY);
                }
            } else if (data.error) {
                appendMessage('AI Error: ' + data.error, 'bot');
            } else {
                appendMessage('Sorry, there was an error in the server response.', 'bot');
            }
        } catch (err) {
            document.getElementById(loadingId)?.remove();
            appendMessage('Failed to connect to the server. Please check your connection.', 'bot');
        } finally {
            setSendingState(false);
            scrollToBottom();
            inputField?.focus();
        }
    }

    sendBtn?.addEventListener('click', handleSendMessage);
    inputField?.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') handleSendMessage();
    });

    function scrollToBottom() {
        if (messagesEl) messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    /* ═══════════════════════════════════════════════════════════════
       MESSAGE RENDERING
    ═══════════════════════════════════════════════════════════════ */
    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    function linkifyContactEmail(safeHtml) {
        const emailRegex = /info@pict\.co\.id/gi;
        return safeHtml.replace(
            emailRegex,
            '<a href="/contact" class="underline font-semibold text-red-600 hover:text-red-700">info@pict.co.id</a>'
        );
    }

    function appendMessage(text, sender, options = {}) {
        const { isLoading = false } = options;
        const container = document.getElementById('ai-chat-messages');
        if (!container) return '';

        messageCounter++;
        const uniqueId = `msg-${Date.now()}-${messageCounter}-${Math.random().toString(36).slice(2, 7)}`;

        const msgDiv = document.createElement('div');
        msgDiv.id = uniqueId;
        msgDiv.className = `flex ${sender === 'user' ? 'justify-end' : 'justify-start'} animate-[fadeInUp_0.25s_ease-out]`;

        const bubble = document.createElement('div');
        bubble.className = sender === 'user'
            ? 'bg-red-600 text-white p-3 rounded-2xl rounded-tr-none shadow-sm max-w-[85%] leading-relaxed'
            : 'bg-white border border-slate-200 text-slate-800 p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[85%] leading-relaxed';

        if (isLoading) {
            bubble.classList.add('italic', 'text-slate-400');
        }

        if (sender === 'bot' && !isLoading) {
            const safe = escapeHtml(text);
            bubble.innerHTML = linkifyContactEmail(safe).replace(/\n/g, '<br>');
        } else {
            bubble.textContent = text;
        }

        msgDiv.appendChild(bubble);
        container.appendChild(msgDiv);
        return uniqueId;
    }
});
</script>

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush