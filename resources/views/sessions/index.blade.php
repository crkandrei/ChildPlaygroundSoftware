@extends('layouts.app')

@section('title', 'Sesiuni')
@section('page-title', 'Sesiuni')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-stopwatch text-purple-600"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-900">Lista sesiunilor</h2>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <div>
                <label class="text-sm text-gray-600 mr-2" for="perPage">Afișează</label>
                <select id="perPage" class="px-3 py-2 border border-gray-300 rounded-md">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="relative">
                <input id="searchInput" type="text" placeholder="Caută copil" class="w-64 px-3 py-2 border border-gray-300 rounded-md pr-8">
                <i class="fas fa-search absolute right-2 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="child_name">Copil <span class="sort-ind" data-col="child_name"></span></th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durată live</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preț</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acțiuni</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="bg-white divide-y divide-gray-200"></tbody>
        </table>
    </div>

    <div class="flex items-center justify-between mt-4">
        <div class="text-sm text-gray-600" id="resultsInfo"></div>
        <div class="flex items-center gap-2">
            <button id="prevPage" class="px-3 py-2 border rounded-md text-sm disabled:opacity-50">Înapoi</button>
            <span id="pageLabel" class="text-sm text-gray-700"></span>
            <button id="nextPage" class="px-3 py-2 border rounded-md text-sm disabled:opacity-50">Înainte</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let state = {
        page: 1,
        per_page: 10,
        sort_by: 'started_at',
        sort_dir: 'desc',
        search: ''
    };
    let timerIntervals = new Map();

    function clearAllTimers() {
        timerIntervals.forEach((intv) => clearInterval(intv));
        timerIntervals.clear();
    }

    function formatDateTime(iso) {
        if (!iso) return '-';
        const d = new Date(iso);
        const y = d.getFullYear();
        const m = String(d.getMonth()+1).padStart(2,'0');
        const day = String(d.getDate()).padStart(2,'0');
        const hh = String(d.getHours()).padStart(2,'0');
        const mm = String(d.getMinutes()).padStart(2,'0');
        return `${day}.${m}.${y} ${hh}:${mm}`;
    }

    function formatHms(totalSeconds) {
        const hours = Math.floor(totalSeconds / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const seconds = totalSeconds % 60;
        const hh = String(hours).padStart(2, '0');
        const mm = String(minutes).padStart(2, '0');
        const ss = String(seconds).padStart(2, '0');
        return `${hh}:${mm}:${ss}`;
    }

    function startLiveTimer(row) {
        const el = document.getElementById(`timer-${row.id}`);
        if (!el) return;
        // If ended -> show fixed effective seconds (server already computed excluding pauses)
        if (row.ended_at) {
            const secs = Math.max(0, parseInt(row.effective_seconds || 0, 10));
            el.textContent = formatHms(secs);
            return;
        }
        // If paused -> show static effective time
        if (row.is_paused) {
            const secs = Math.max(0, parseInt(row.effective_seconds || 0, 10));
            el.textContent = formatHms(secs);
            return;
        }
        // Running -> base + live accumulation
        const base = Math.max(0, parseInt(row.effective_seconds || 0, 10));
        const startMs = row.current_interval_started_at ? Date.parse(row.current_interval_started_at) : null;
        const tick = () => {
            if (!startMs) { el.textContent = formatHms(base); return; }
            const now = Date.now();
            const secs = base + Math.max(0, Math.floor((now - startMs) / 1000));
            el.textContent = formatHms(secs);
        };
        tick();
        const intv = setInterval(tick, 1000);
        timerIntervals.set(row.id, intv);
    }

    async function fetchData() {
        const url = new URL(`{{ route('sessions.data') }}`, window.location.origin);
        url.searchParams.set('page', state.page);
        url.searchParams.set('per_page', state.per_page);
        url.searchParams.set('sort_by', state.sort_by);
        url.searchParams.set('sort_dir', state.sort_dir);
        if (state.search) url.searchParams.set('search', state.search);

        const res = await fetch(url, { credentials: 'same-origin', headers: { 'Accept': 'application/json' } });
        const data = await res.json();
        if (!data.success) return;
        renderTable(data.data);
        renderMeta(data.meta);
    }

    function renderTable(rows) {
        clearAllTimers();
        const tbody = document.getElementById('tableBody');
        tbody.innerHTML = '';
        rows.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${row.child_name || '-'}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm font-mono" id="timer-${row.id}">--:--:--</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm">
                    ${row.formatted_price ? `<span class="font-semibold ${row.ended_at ? 'text-green-600' : 'text-amber-600'}">${row.formatted_price}</span>` : '-'}
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm">
                    <div class="flex items-center gap-2">
                        <a href="/sessions/${row.id}/show" class="px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs transition-colors">
                            <i class="fas fa-eye mr-1"></i>Detalii
                        </a>
                        ${row.ended_at ? `
                            <button onclick="printReceipt(${row.id})" class="px-2 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs transition-colors">
                                <i class="fas fa-receipt mr-1"></i>Bon
                            </button>
                        ` : ''}
                        ${row.ended_at ? '' : `
                            ${row.is_paused ? `
                                <button data-resume="${row.id}" class="px-2 py-1 bg-green-600 text-white rounded text-xs">Reia</button>
                            ` : `
                                <button data-pause="${row.id}" class="px-2 py-1 bg-yellow-600 text-white rounded text-xs">Pauză</button>
                            `}
                            <button data-stop="${row.id}" class="px-2 py-1 bg-red-600 text-white rounded text-xs">Oprește</button>
                        `}
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
            startLiveTimer(row);

            const pauseBtn = tr.querySelector(`[data-pause="${row.id}"]`);
            if (pauseBtn) pauseBtn.addEventListener('click', async () => {
                await fetch(`/dashboard-api/sessions/${row.id}/pause`, { method: 'POST', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }, credentials: 'same-origin' });
                fetchData();
            });
            const resumeBtn = tr.querySelector(`[data-resume="${row.id}"]`);
            if (resumeBtn) resumeBtn.addEventListener('click', async () => {
                await fetch(`/dashboard-api/sessions/${row.id}/resume`, { method: 'POST', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }, credentials: 'same-origin' });
                fetchData();
            });
            const stopBtn = tr.querySelector(`[data-stop="${row.id}"]`);
            if (stopBtn) stopBtn.addEventListener('click', async () => {
                await fetch(`/dashboard-api/sessions/${row.id}/stop`, { method: 'POST', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }, credentials: 'same-origin' });
                fetchData();
            });
        });
    }

    function renderMeta(meta) {
        const info = document.getElementById('resultsInfo');
        const pageLabel = document.getElementById('pageLabel');
        const prev = document.getElementById('prevPage');
        const next = document.getElementById('nextPage');

        const from = (meta.page - 1) * meta.per_page + 1;
        const to = Math.min(meta.page * meta.per_page, meta.total);
        info.textContent = meta.total ? `Afișate ${from}-${to} din ${meta.total}` : 'Nu există rezultate';
        pageLabel.textContent = `Pagina ${meta.page} / ${meta.total_pages || 1}`;
        prev.disabled = meta.page <= 1;
        next.disabled = meta.page >= (meta.total_pages || 1);

        // Update sort indicators
        document.querySelectorAll('.sort-ind').forEach(el => {
            const col = el.getAttribute('data-col');
            el.textContent = col === state.sort_by ? (state.sort_dir === 'asc' ? '▲' : '▼') : '';
        });
    }

    // Events
    document.getElementById('perPage').addEventListener('change', (e) => {
        state.per_page = parseInt(e.target.value, 10);
        state.page = 1;
        fetchData();
    });

    let searchDebounce;
    document.getElementById('searchInput').addEventListener('input', (e) => {
        const v = e.target.value.trim();
        if (searchDebounce) clearTimeout(searchDebounce);
        searchDebounce = setTimeout(() => {
            state.search = v;
            state.page = 1;
            fetchData();
        }, 300);
    });

    document.getElementById('prevPage').addEventListener('click', () => {
        if (state.page > 1) {
            state.page -= 1;
            fetchData();
        }
    });
    document.getElementById('nextPage').addEventListener('click', () => {
        state.page += 1;
        fetchData();
    });

    document.querySelectorAll('th[data-sort]').forEach(th => {
        th.addEventListener('click', () => {
            const col = th.getAttribute('data-sort');
            if (state.sort_by === col) {
                state.sort_dir = state.sort_dir === 'asc' ? 'desc' : 'asc';
            } else {
                state.sort_by = col;
                state.sort_dir = 'asc';
            }
            state.page = 1;
            fetchData();
        });
    });

    // Initial load
    fetchData();
    
    // Function to print receipt directly
    let printInProgress = false;
    
    function printReceipt(sessionId) {
        // Previne declanșarea multiplă
        if (printInProgress) {
            return;
        }
        
        printInProgress = true;
        const url = `/sessions/${sessionId}/receipt`;
        
        // Creează un iframe invizibil
        const iframe = document.createElement('iframe');
        iframe.style.position = 'fixed';
        iframe.style.right = '0';
        iframe.style.bottom = '0';
        iframe.style.width = '0';
        iframe.style.height = '0';
        iframe.style.border = 'none';
        iframe.src = url;
        
        document.body.appendChild(iframe);
        
        // Funcție pentru resetarea flag-ului și ștergerea iframe-ului
        const cleanup = function() {
            printInProgress = false;
            if (iframe.parentNode) {
                document.body.removeChild(iframe);
            }
        };
        
        iframe.onload = function() {
            // Redus la 100ms pentru răspuns mai rapid
            setTimeout(function() {
                try {
                    // Detectează când dialogul de print se închide (fie prin print, fie prin cancel)
                    const mediaQueryList = iframe.contentWindow.matchMedia('print');
                    
                    const handlePrintChange = function(mql) {
                        if (!mql.matches) {
                            // Dialogul s-a închis
                            cleanup();
                            mediaQueryList.removeListener(handlePrintChange);
                        }
                    };
                    
                    // Adaugă listener pentru schimbări
                    if (mediaQueryList.addEventListener) {
                        mediaQueryList.addEventListener('change', handlePrintChange);
                    } else {
                        // Fallback pentru browsere mai vechi
                        mediaQueryList.addListener(handlePrintChange);
                    }
                    
                    // Declanșează print-ul
                    iframe.contentWindow.print();
                    
                    // Fallback: resetează flag-ul după un timp dacă matchMedia nu funcționează
                    setTimeout(function() {
                        if (printInProgress) {
                            cleanup();
                        }
                    }, 1500);
                } catch (e) {
                    console.error('Eroare la print:', e);
                    cleanup();
                }
            }, 100);
        };
        
        // Resetează flag-ul în caz de eroare
        iframe.onerror = function() {
            cleanup();
        };
    }
</script>
@endsection




