<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            🤖 Assistant IA — Créer une formation par conversation
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @unless($hasApiKey)
                <div class="bg-red-50 border border-red-300 text-red-800 rounded-lg p-4 mb-6">
                    <p class="font-semibold">⚠️ Clé API Gemini manquante</p>
                    <p class="text-sm mt-1">Ajoutez <code class="bg-red-100 px-1 rounded">GEMINI_API_KEY=votre_clé</code> dans le fichier <code>.env</code> puis redémarrez le serveur.</p>
                </div>
            @endunless

            {{-- ══ Zone de chat ══════════════════════════════════════════ --}}
            <div class="bg-white shadow-sm rounded-xl overflow-hidden flex flex-col" style="height: 70vh;">

                {{-- Messages --}}
                <div id="chat-messages" class="flex-1 overflow-y-auto p-6 space-y-4">
                    {{-- Message d'accueil --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-sm shrink-0">🤖</div>
                        <div class="bg-slate-50 rounded-2xl rounded-tl-sm px-4 py-3 max-w-[80%]">
                            <p class="text-gray-700 text-sm">
                                Bonjour ! Je suis votre assistant pédagogique. Décrivez-moi la formation que vous souhaitez créer et je la génère avec chapitres, cours et quiz.
                            </p>
                            <p class="text-gray-400 text-xs mt-2">
                                <strong>Exemples :</strong><br>
                                • « Crée une formation sur les verbes irréguliers en anglais »<br>
                                • « Génère un cours de mathématiques sur les fractions niveau CM2 »<br>
                                • « Formation Python pour débutants : variables et boucles »
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Input bar --}}
                <div class="border-t bg-slate-50 px-4 py-3">
                    <form id="chat-form" class="flex items-center gap-3">
                        @csrf
                        <input
                            type="text"
                            id="chat-input"
                            placeholder="Décrivez la formation à créer..."
                            class="flex-1 border border-slate-300 rounded-full px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent"
                            autocomplete="off"
                            {{ $hasApiKey ? '' : 'disabled' }}
                        >
                        <button
                            type="submit"
                            id="send-btn"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-full px-6 py-3 text-sm font-semibold transition disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ $hasApiKey ? '' : 'disabled' }}
                        >
                            Envoyer ➤
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const messagesEl  = document.getElementById('chat-messages');
        const form        = document.getElementById('chat-form');
        const input       = document.getElementById('chat-input');
        const sendBtn     = document.getElementById('send-btn');
        const csrfToken   = document.querySelector('input[name="_token"]').value;

        let lastJsonData  = null; // Stocke le dernier JSON généré

        // ── Ajouter un message dans le chat ────────────────────────
        function addMessage(type, html) {
            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-start gap-3' + (type === 'user' ? ' justify-end' : '');

            if (type === 'user') {
                wrapper.innerHTML = `
                    <div class="bg-indigo-600 text-white rounded-2xl rounded-tr-sm px-4 py-3 max-w-[80%]">
                        <p class="text-sm">${escapeHtml(html)}</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm shrink-0">👤</div>
                `;
            } else if (type === 'ai') {
                wrapper.innerHTML = `
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-sm shrink-0">🤖</div>
                    <div class="bg-slate-50 rounded-2xl rounded-tl-sm px-4 py-3 max-w-[80%]">${html}</div>
                `;
            } else if (type === 'error') {
                wrapper.innerHTML = `
                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-sm shrink-0">⚠️</div>
                    <div class="bg-red-50 border border-red-200 rounded-2xl rounded-tl-sm px-4 py-3 max-w-[80%]">
                        <p class="text-red-700 text-sm">${html}</p>
                    </div>
                `;
            } else if (type === 'success') {
                wrapper.innerHTML = `
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-sm shrink-0">✅</div>
                    <div class="bg-green-50 border border-green-200 rounded-2xl rounded-tl-sm px-4 py-3 max-w-[80%]">${html}</div>
                `;
            }

            messagesEl.appendChild(wrapper);
            messagesEl.scrollTop = messagesEl.scrollHeight;
            return wrapper;
        }

        function addLoader() {
            const wrapper = document.createElement('div');
            wrapper.id = 'ai-loader';
            wrapper.className = 'flex items-start gap-3';
            wrapper.innerHTML = `
                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-sm shrink-0">🤖</div>
                <div class="bg-slate-50 rounded-2xl rounded-tl-sm px-4 py-3">
                    <div class="flex items-center gap-2">
                        <div class="flex gap-1">
                            <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                            <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                            <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay:300ms"></span>
                        </div>
                        <span class="text-gray-400 text-sm">L'IA réfléchit... (Patience, la génération a des tentatives automatiques et peut prendre 1 à 2 minutes)</span>
                    </div>
                </div>
            `;
            messagesEl.appendChild(wrapper);
            messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        function removeLoader() {
            const loader = document.getElementById('ai-loader');
            if (loader) loader.remove();
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // ── Construire le HTML de preview ──────────────────────────
        function buildPreviewHtml(preview, jsonData) {
            let chHtml = '';
            preview.chapitres.forEach((chap, c) => {
                chHtml += `<div class="mb-4">
                    <p class="text-sm font-bold text-slate-700 mb-2">📁 ${escapeHtml(chap.titre)}</p>
                `;
                chap.sous_chapitres.forEach((sc, i) => {
                    chHtml += `
                        <div class="border-l-2 border-indigo-200 pl-3 mb-2 ml-2">
                            <p class="text-sm font-semibold text-gray-700">${i + 1}. ${escapeHtml(sc.titre)}</p>
                            <p class="text-xs text-gray-400">${sc.nb_questions} question(s) de quiz • ${escapeHtml(sc.contenu_preview)}</p>
                        </div>
                    `;
                });
                chHtml += `</div>`;
            });

            return `
                <p class="text-sm text-gray-700 mb-3">Voici la formation que j'ai générée :</p>
                <div class="bg-white border rounded-lg p-4 mb-3">
                    <p class="text-base font-bold text-indigo-700 mb-3">📚 ${escapeHtml(preview.formation)}</p>
                    ${chHtml}
                    <hr class="my-2">
                    <p class="text-xs text-indigo-500 mt-2">🎯 ${preview.total_questions} questions de quiz au total</p>
                </div>
                <div class="flex gap-2 flex-wrap">
                    <button onclick="createFormation()" class="btn-accent transition">
                        ✅ Créer la formation
                    </button>
                    <button onclick="document.getElementById('chat-input').focus()" class="bg-slate-200 hover:bg-slate-300 text-gray-700 text-sm font-bold py-2 px-5 rounded-lg transition">
                        🔄 Autre demande
                    </button>
                </div>
            `;
        }

        // ── Envoyer le prompt ──────────────────────────────────────
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            const prompt = input.value.trim();
            if (!prompt) return;

            // Afficher le message utilisateur
            addMessage('user', prompt);
            input.value = '';
            input.disabled = true;
            sendBtn.disabled = true;

            // Afficher le loader
            addLoader();

            try {
                const resp = await fetch(`{{ route('assistant.ia.generate') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ prompt: prompt }),
                });

                removeLoader();

                const result = await resp.json();

                if (!result.success) {
                    addMessage('error', result.error || 'Erreur inconnue.');
                } else {
                    lastJsonData = result.raw;
                    addMessage('ai', buildPreviewHtml(result.preview, result.raw));
                }
            } catch (err) {
                removeLoader();
                addMessage('error', 'Erreur réseau. Vérifiez que le serveur est en marche.');
            }

            input.disabled = false;
            sendBtn.disabled = false;
            input.focus();
        });

        // ── Créer la formation en base ─────────────────────────────
        window.createFormation = async function () {
            if (!lastJsonData) {
                addMessage('error', 'Aucune donnée à enregistrer. Générez d\'abord un contenu.');
                return;
            }

            // Désactiver tous les boutons "Créer"
            document.querySelectorAll('button[onclick="createFormation()"]').forEach(btn => {
                btn.disabled = true;
                btn.textContent = '⏳ Création en cours…';
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            });

            try {
                const resp = await fetch(`{{ route('assistant.ia.create') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ json_data: lastJsonData }),
                });

                const result = await resp.json();

                if (!result.success) {
                    addMessage('error', result.error || 'Erreur lors de la création.');
                } else {
                    const s = result.summary;
                    const formationUrl = `/admin/formations/${s.formation_id}/chapitres`;
                    addMessage('success', `
                        <p class="text-green-800 font-bold text-sm mb-2">🎉 Formation créée avec succès !</p>
                        <div class="text-sm text-green-700 space-y-1">
                            <p>📚 Formation : <strong>${escapeHtml(s.formation_nom)}</strong> ${s.formations > 0 ? '(nouvelle)' : '(existante)'}</p>
                            <p>📖 <strong>${s.chapitres}</strong> chapitre(s) créé(s)</p>
                            <p>📄 <strong>${s.sous_chapitres}</strong> sous-chapitre(s)</p>
                            <p>📝 <strong>${s.contenus}</strong> contenu(s) pédagogique(s)</p>
                            <p>🎯 <strong>${s.quizzes}</strong> quiz avec <strong>${s.questions}</strong> question(s)</p>
                        </div>
                        <a href="${formationUrl}" class="inline-block mt-3 bg-green-600 hover:bg-green-700 text-white text-sm font-bold py-2 px-4 rounded-lg transition">
                            → Voir les chapitres créés
                        </a>
                    `);
                    lastJsonData = null;
                }
            } catch (err) {
                addMessage('error', 'Erreur réseau lors de la création.');
            }
        };

        // Focus auto
        input.focus();
    });
    </script>

    <style>
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        .animate-bounce { animation: bounce 0.6s infinite; }
    </style>
</x-admin-layout>
