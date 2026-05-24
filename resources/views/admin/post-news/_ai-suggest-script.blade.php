<style>
.ai-suggest-bar {
    display: flex;
    align-items: center;
    margin: 18px 0 20px;
    padding: 14px 16px;
    background: linear-gradient(135deg, rgba(220,20,60,0.06) 0%, rgba(220,20,60,0.02) 100%);
    border: 1.5px dashed rgba(220,20,60,0.3);
    border-radius: 10px;
    gap: 10px;
}

.btn-ai-suggest {
    background: linear-gradient(135deg, #DC143C 0%, #a50f2e 100%);
    color: #fff;
    border: none;
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.2s, transform 0.15s;
    white-space: nowrap;
}

.btn-ai-suggest:hover:not(:disabled) {
    opacity: 0.88;
    transform: translateY(-1px);
    color: #fff;
}

.btn-ai-suggest:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}

@keyframes ai-field-flash {
    0%   { background: rgba(220,20,60,0.12); }
    100% { background: transparent; }
}

.ai-filled {
    animation: ai-field-flash 1.2s ease forwards;
    border-color: #DC143C !important;
}
</style>

<script>
(function () {
    const btn       = document.getElementById('aiSuggestBtn');
    const idleLabel = document.getElementById('aiSuggestIdle');
    const loadLabel = document.getElementById('aiSuggestLoading');
    const banner    = document.getElementById('aiSuggestBanner');
    const errorBox  = document.getElementById('aiSuggestError');
    const csrf      = document.querySelector('meta[name="csrf-token"]')?.content || '';

    function flash(el) {
        el.classList.remove('ai-filled');
        void el.offsetWidth; // reflow to restart animation
        el.classList.add('ai-filled');
    }

    btn.addEventListener('click', async function () {
        const headline = document.getElementById('headline')?.value?.trim() || '';
        const content  = document.getElementById('content')?.value?.trim() || '';

        if (!headline && !content) {
            errorBox.textContent = 'Please add a headline or some content before using AI Suggest.';
            errorBox.classList.remove('d-none');
            banner.classList.add('d-none');
            return;
        }

        btn.disabled = true;
        idleLabel.classList.add('d-none');
        loadLabel.classList.remove('d-none');
        banner.classList.add('d-none');
        errorBox.classList.add('d-none');

        try {
            const res  = await fetch('{{ route("admin.ai-suggest") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ headline, content }),
            });

            const data = await res.json();

            if (!res.ok) {
                throw new Error(data.error || 'Something went wrong.');
            }

            // Fill category
            if (data.category_id) {
                const sel = document.getElementById('category_id');
                if (sel) {
                    sel.value = data.category_id;
                    flash(sel);
                }
            }

            // Fill meta fields
            ['meta_title', 'meta_description', 'meta_keywords'].forEach(function (field) {
                if (data[field]) {
                    const el = document.getElementById(field);
                    if (el) {
                        el.value = data[field];
                        flash(el);
                    }
                }
            });

            banner.classList.remove('d-none');

        } catch (err) {
            errorBox.textContent = err.message || 'AI Suggest failed — please try again.';
            errorBox.classList.remove('d-none');
        } finally {
            btn.disabled = false;
            idleLabel.classList.remove('d-none');
            loadLabel.classList.add('d-none');
        }
    });
})();
</script>
