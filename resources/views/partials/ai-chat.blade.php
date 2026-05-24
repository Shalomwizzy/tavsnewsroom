@php
    $siteName    = \App\Models\WebsiteSetting::getValue('site_name', config('app.name'));
    $aiChatName  = \App\Models\WebsiteSetting::getValue('ai_chat_name', 'Ask Tavs');
@endphp

<!-- AI Chat Widget -->
<div id="aiChatWidget" aria-label="Ask Tavs">

    <!-- Chat Window -->
    <div id="aiChatWindow" role="dialog" aria-modal="true" aria-label="Ask Tavs chat">
        <div id="aiChatHeader">
            <div class="ai-chat-header-info">
                <div class="ai-chat-avatar" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z" fill="currentColor" opacity="0.3"/>
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <path d="M8 9a1 1 0 100 2 1 1 0 000-2zM16 9a1 1 0 100 2 1 1 0 000-2z" fill="currentColor"/>
                        <path d="M8.5 14.5s1 1.5 3.5 1.5 3.5-1.5 3.5-1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <div class="ai-chat-name">{{ $aiChatName }}</div>
                    <div class="ai-chat-status"><span class="ai-status-dot"></span> Online now</div>
                </div>
            </div>
            <button id="aiChatClose" aria-label="Close chat">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div id="aiChatMessages" role="log" aria-live="polite" aria-label="Chat messages">
            <!-- Welcome message -->
            <div class="ai-msg ai-msg-bot">
                <div class="ai-msg-bubble">
                    Hey! I'm {{ $aiChatName }}, your {{ $siteName }} news assistant. Ask me about any story, topic, or just say "latest news" to see what's happening. 👋
                </div>
            </div>
        </div>

        <!-- Typing indicator -->
        <div id="aiTypingIndicator" hidden>
            <div class="ai-msg ai-msg-bot">
                <div class="ai-msg-bubble ai-typing">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>

        <div id="aiChatInputArea">
            <input
                type="text"
                id="aiChatInput"
                placeholder="Ask about any news topic…"
                autocomplete="off"
                maxlength="500"
                aria-label="Type your question"
            >
            <button id="aiChatSend" aria-label="Send message">
                <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Trigger Button -->
    <button id="aiChatToggle" aria-label="Open {{ $aiChatName }}" title="{{ $aiChatName }}">
        <span class="ai-chat-icon" id="aiIconChat">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM9 11H7V9h2v2zm4 0h-2V9h2v2zm4 0h-2V9h2v2z"/>
            </svg>
        </span>
        <span class="ai-chat-icon ai-close-icon" id="aiIconClose" hidden>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="22" height="22">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </span>
        <span class="ai-chat-badge" id="aiChatBadge" hidden>1</span>
    </button>
</div>

<script>
(function () {
    const widget    = document.getElementById('aiChatWidget');
    const window_   = document.getElementById('aiChatWindow');
    const toggle    = document.getElementById('aiChatToggle');
    const closeBtn  = document.getElementById('aiChatClose');
    const input     = document.getElementById('aiChatInput');
    const sendBtn   = document.getElementById('aiChatSend');
    const messages  = document.getElementById('aiChatMessages');
    const typing    = document.getElementById('aiTypingIndicator');
    const iconChat  = document.getElementById('aiIconChat');
    const iconClose = document.getElementById('aiIconClose');
    const badge     = document.getElementById('aiChatBadge');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    let isOpen      = false;
    let hasUnread   = false;
    let isWaiting   = false;

    function openChat() {
        isOpen = true;
        window_.classList.add('ai-chat-open');
        toggle.setAttribute('aria-expanded', 'true');
        iconChat.hidden  = true;
        iconClose.hidden = false;
        badge.hidden     = true;
        hasUnread        = false;
        input.focus();
        scrollToBottom();
    }

    function closeChat() {
        isOpen = false;
        window_.classList.remove('ai-chat-open');
        toggle.setAttribute('aria-expanded', 'false');
        iconChat.hidden  = false;
        iconClose.hidden = true;
    }

    toggle.addEventListener('click', () => isOpen ? closeChat() : openChat());
    closeBtn.addEventListener('click', closeChat);

    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isOpen) closeChat();
    });

    function scrollToBottom() {
        messages.scrollTop = messages.scrollHeight;
    }

    function addMessage(text, role, articles) {
        const wrap = document.createElement('div');
        wrap.className = `ai-msg ai-msg-${role}`;

        const bubble = document.createElement('div');
        bubble.className = 'ai-msg-bubble';
        bubble.textContent = text;
        wrap.appendChild(bubble);

        if (articles && articles.length > 0) {
            const chips = document.createElement('div');
            chips.className = 'ai-article-chips';
            articles.forEach(a => {
                const chip = document.createElement('a');
                chip.href = a.url;
                chip.className = 'ai-article-chip';
                chip.textContent = a.headline;
                chips.appendChild(chip);
            });
            wrap.appendChild(chips);
        }

        messages.appendChild(wrap);
        scrollToBottom();

        if (!isOpen && role === 'bot') {
            hasUnread    = true;
            badge.hidden = false;
        }
    }

    function showTyping() {
        typing.hidden = false;
        messages.appendChild(typing);
        scrollToBottom();
    }

    function hideTyping() {
        typing.hidden = true;
    }

    async function sendMessage() {
        const text = input.value.trim();
        if (!text || isWaiting) return;

        addMessage(text, 'user', []);
        input.value  = '';
        isWaiting    = true;
        sendBtn.disabled = true;
        showTyping();

        try {
            const res  = await fetch('/ai-chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message: text }),
            });
            const data = await res.json();
            hideTyping();
            addMessage(data.reply || 'Sorry, I couldn\'t get a response. Try again!', 'bot', data.articles || []);
        } catch {
            hideTyping();
            addMessage('Connection error — please try again in a moment.', 'bot', []);
        } finally {
            isWaiting        = false;
            sendBtn.disabled = false;
            input.focus();
        }
    }

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
    });

    // Show badge after 8 seconds if chat not yet opened
    setTimeout(() => {
        if (!isOpen) {
            badge.hidden = false;
            badge.textContent = '!';
        }
    }, 8000);
})();
</script>
