{{-- Global assistant widget. Collapses to a tab at the left edge. --}}
<div id="ai-chat-widget"
     class="chat-widget"
     data-minimized="true"
     role="complementary"
     aria-label="PICT assistant">

    <div id="ai-chat-box" class="chat-widget__panel" inert aria-hidden="true">
        <div class="chat-widget__head">
            <div>
                <h2>PICT assistant</h2>
                <p>Terminal information</p>
            </div>
            <button id="ai-chat-close" class="chat-widget__close" type="button" aria-label="Close assistant">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div id="ai-chat-messages"
             class="chat-widget__log"
             role="log"
             aria-live="polite"
             aria-label="Conversation">
            <div class="chat-widget__msg">
                <div class="chat-widget__bubble">
                    Hello. Ask about terminal services, shipping routes, or how to reach the commercial team.
                </div>
            </div>

            @php
                $quickQuestions = [
                    'What services do you handle?',
                    'How do I request a berth?',
                    'Where is the terminal?',
                    'Contact the commercial team',
                ];
            @endphp

            <div id="suggested-questions" class="chat-widget__suggestions">
                @foreach ($quickQuestions as $question)
                    <button class="chat-widget__suggestion" type="button">{{ $question }}</button>
                @endforeach
            </div>
        </div>

        <form id="ai-chat-form" class="chat-widget__form">
            <label class="sr-only" for="ai-chat-input">Message</label>
            <input id="ai-chat-input"
                   type="text"
                   placeholder="Ask a question"
                   autocomplete="off">
            <button id="ai-chat-send" class="chat-widget__send" type="submit">Send</button>
        </form>
    </div>

    <button id="ai-chat-toggle"
            class="chat-widget__toggle"
            type="button"
            aria-label="Open assistant"
            aria-controls="ai-chat-box"
            aria-expanded="false">
        <img src="{{ asset('assets/images/maskot-ai.png') }}"
             alt=""
             aria-hidden="true"
             width="30"
             height="30">
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const widget = document.getElementById('ai-chat-widget');
    const panel = document.getElementById('ai-chat-box');
    const toggleBtn = document.getElementById('ai-chat-toggle');
    const closeBtn = document.getElementById('ai-chat-close');
    const form = document.getElementById('ai-chat-form');
    const sendBtn = document.getElementById('ai-chat-send');
    const inputField = document.getElementById('ai-chat-input');
    const messagesEl = document.getElementById('ai-chat-messages');

    if (!widget || !form || !messagesEl) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const MAX_HISTORY = 20;

    let conversationHistory = [];
    let messageCounter = 0;
    let isSending = false;

    const initialMessagesHTML = messagesEl.innerHTML;

    function setExpanded(expanded) {
        widget.setAttribute('data-minimized', expanded ? 'false' : 'true');
        toggleBtn?.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        toggleBtn?.setAttribute('aria-label', expanded ? 'Close assistant' : 'Open assistant');

        if (panel) {
            panel.inert = !expanded;
            panel.setAttribute('aria-hidden', expanded ? 'false' : 'true');
        }

        if (expanded) {
            window.setTimeout(() => inputField?.focus(), 260);
        } else {
            window.setTimeout(resetChatState, 280);
            toggleBtn?.focus();
        }
    }

    function toggleChatWidget() {
        setExpanded(widget.getAttribute('data-minimized') === 'true');
    }

    function resetChatState() {
        conversationHistory = [];
        if (inputField) inputField.value = '';
        messagesEl.innerHTML = initialMessagesHTML;
        setSendingState(false);
    }

    toggleBtn?.addEventListener('click', toggleChatWidget);
    closeBtn?.addEventListener('click', () => setExpanded(false));

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && widget.getAttribute('data-minimized') === 'false') {
            setExpanded(false);
        }
    });

    function hideQuickQuestions() {
        const suggestions = document.getElementById('suggested-questions');
        if (suggestions) suggestions.style.display = 'none';
    }

    messagesEl.addEventListener('click', event => {
        const button = event.target.closest('.chat-widget__suggestion');
        if (!button || !inputField) return;

        inputField.value = button.textContent.trim();
        hideQuickQuestions();
        handleSendMessage();
    });

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
        const loadingId = appendMessage('Thinking...', 'bot', { isLoading: true });

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
                appendMessage('The assistant could not answer that question. Please try again or write to info@pict.co.id.', 'bot');
            } else {
                appendMessage('The assistant returned an empty response. Please try again.', 'bot');
            }
        } catch (error) {
            document.getElementById(loadingId)?.remove();
            appendMessage('The assistant is unreachable right now. Please try again or write to info@pict.co.id.', 'bot');
        } finally {
            setSendingState(false);
            scrollToBottom();
            inputField?.focus();
        }
    }

    form.addEventListener('submit', event => {
        event.preventDefault();
        handleSendMessage();
    });

    function scrollToBottom() {
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    function escapeHtml(value) {
        const element = document.createElement('div');
        element.textContent = value;
        return element.innerHTML;
    }

    function linkifyContactEmail(safeHtml) {
        return safeHtml.replace(
            /info@pict\.co\.id/gi,
            '<a href="/contact">info@pict.co.id</a>'
        );
    }

    function appendMessage(text, sender, options = {}) {
        const { isLoading = false } = options;

        messageCounter++;
        const uniqueId = `msg-${Date.now()}-${messageCounter}-${Math.random().toString(36).slice(2, 7)}`;

        const message = document.createElement('div');
        message.id = uniqueId;
        message.className = 'chat-widget__msg' + (sender === 'user' ? ' chat-widget__msg--user' : '');

        const bubble = document.createElement('div');
        bubble.className = 'chat-widget__bubble' + (isLoading ? ' is-loading' : '');

        if (sender === 'bot' && !isLoading) {
            const safe = escapeHtml(text);
            bubble.innerHTML = linkifyContactEmail(safe).replace(/\n/g, '<br>');
        } else {
            bubble.textContent = text;
        }

        message.appendChild(bubble);
        messagesEl.appendChild(message);
        return uniqueId;
    }
});
</script>
