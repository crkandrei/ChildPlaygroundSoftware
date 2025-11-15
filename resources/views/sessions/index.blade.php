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
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Plată</th>
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

<!-- Fiscal Receipt Modal -->
<div id="fiscal-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">Bon Fiscal</h3>
            <button onclick="closeFiscalModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="px-6 py-4">
            <!-- Step 1: Payment Type Selection -->
            <div id="fiscal-modal-step-1">
                <p class="text-gray-700 mb-4">Cum se plătește?</p>
                <div class="flex gap-4 mb-6">
                    <button 
                        data-payment-btn="CASH"
                        onclick="selectPaymentType('CASH')"
                        class="flex-1 px-6 py-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        <i class="fas fa-money-bill-wave mr-2"></i>
                        Cash
                    </button>
                    <button 
                        data-payment-btn="CARD"
                        onclick="selectPaymentType('CARD')"
                        class="flex-1 px-6 py-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        <i class="fas fa-credit-card mr-2"></i>
                        Card
                    </button>
                </div>
                
                <!-- Voucher Toggle -->
                <div class="mb-6 pt-4 border-t border-gray-200">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                               id="voucher-toggle"
                               onchange="toggleVoucherInput()"
                               class="mr-3 w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <span class="text-gray-700 font-medium">Folosește Voucher</span>
                    </label>
                    
                    <!-- Voucher Hours Input (hidden by default) -->
                    <div id="voucher-input-container" class="hidden mt-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Ore Voucher <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="voucher-hours-input"
                               min="0"
                               step="0.5"
                               value="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Ex: 1">
                        <p class="mt-1 text-xs text-gray-500">Introduceți numărul de ore de pe voucher</p>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button onclick="closeFiscalModal()" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        Anulează
                    </button>
                    <button 
                        id="fiscal-continue-btn"
                        onclick="goToConfirmStep()"
                        disabled
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        Continuă
                    </button>
                </div>
            </div>

            <!-- Step 2: Confirmation -->
            <div id="fiscal-modal-step-2" class="hidden">
                <p class="text-gray-700 mb-4 font-medium">Se va scoate bonul fiscal pentru:</p>
                
                <!-- Virtual Receipt Preview -->
                <div id="fiscal-receipt-preview" class="bg-white border-2 border-gray-300 rounded-lg p-4 mb-6 shadow-sm max-h-96 overflow-y-auto">
                    <!-- Receipt Header -->
                    <div class="text-center border-b border-gray-300 pb-2 mb-3">
                        <h4 id="receipt-tenant-name" class="font-bold text-lg text-gray-900">-</h4>
                        <p class="text-xs text-gray-500 mt-1">Bon Fiscal</p>
                    </div>
                    
                    <!-- Receipt Items -->
                    <div id="receipt-items" class="space-y-2 mb-3">
                        <!-- Time item will be inserted here -->
                    </div>
                    
                    <!-- Receipt Totals -->
                    <div class="border-t border-gray-300 pt-2 mt-2">
                        <div class="flex justify-between text-base font-bold">
                            <span class="text-gray-900">TOTAL:</span>
                            <span id="receipt-total-price" class="text-indigo-600">-</span>
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="mt-3 pt-3 border-t border-gray-300">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Plată:</span>
                            <span id="receipt-payment-method" class="font-semibold text-gray-900">-</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button onclick="closeFiscalModal()" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        Anulează
                    </button>
                    <button 
                        onclick="confirmAndPrint()"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-check mr-2"></i>
                        Confirmă și Emite
                    </button>
                </div>
            </div>

            <!-- Step 3: Loading -->
            <div id="fiscal-modal-step-3" class="hidden">
                <div class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-4xl text-indigo-600 mb-4"></i>
                    <p class="text-gray-700 text-lg">Se emite bonul fiscal...</p>
                    <p class="text-gray-500 text-sm mt-2">Vă rugăm să așteptați</p>
                </div>
            </div>

            <!-- Step 4: Result (Success/Error) -->
            <div id="fiscal-modal-step-4" class="hidden">
                <div id="fiscal-result-content" class="text-center py-6">
                    <!-- Success or Error icon and message will be inserted here -->
                </div>
                <div class="flex justify-end gap-3 mt-4">
                    <button 
                        onclick="closeFiscalModal()"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Închide
                    </button>
                </div>
            </div>
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
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                    ${row.child_name || '-'}
                    ${row.is_birthday ? `<span class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full bg-pink-100 text-pink-800"><i class="fas fa-birthday-cake mr-1"></i>Birthday</span>` : ''}
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm font-mono" id="timer-${row.id}">--:--:--</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm">
                    ${row.formatted_price ? `
                        <span class="font-semibold ${row.ended_at ? 'text-green-600' : 'text-amber-600'}">${row.formatted_price}</span>
                        ${row.products_formatted_price ? `<span class="font-semibold text-purple-600 ml-1">+ ${row.products_formatted_price}</span>` : ''}
                    ` : '-'}
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm">
                    ${row.ended_at && !row.is_birthday ? `
                        ${row.is_paid ? `
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800 inline-flex items-center w-fit">
                                <i class="fas fa-check-circle mr-1"></i>${row.payment_status === 'paid_voucher' ? 'Plătit (Voucher)' : 'Plătit'}
                            </span>
                        ` : `
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-800 inline-flex items-center w-fit">
                                <i class="fas fa-clock mr-1"></i>Neplătit
                            </span>
                        `}
                    ` : '-'}
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm">
                    <div class="flex items-center gap-2">
                        <a href="/sessions/${row.id}/show" class="px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs transition-colors">
                            <i class="fas fa-eye mr-1"></i>Detalii
                        </a>
                        ${!row.is_paid ? `
                            <button onclick="toggleBirthdayQuick(${row.id}, ${row.is_birthday})" 
                                class="px-2 py-1 ${row.is_birthday ? 'bg-pink-600 hover:bg-pink-700' : 'bg-gray-400 hover:bg-gray-500'} text-white rounded text-xs transition-colors"
                                title="${row.is_birthday ? 'Demarchează Birthday' : 'Marchează ca Birthday'}">
                                <i class="fas fa-birthday-cake mr-1"></i>${row.is_birthday ? 'ON' : 'OFF'}
                            </button>
                        ` : ''}
                        ${row.ended_at && !row.is_birthday && !row.is_paid ? `
                            <button onclick="openFiscalModal(${row.id})" class="px-2 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs transition-colors">
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
    
    // ===== FISCAL RECEIPT MODAL =====

    let fiscalModalCurrentStep = 1;
    let fiscalModalSessionId = null;
    let fiscalModalPaymentType = null;
    let fiscalModalData = null;
    let fiscalModalReceiptData = null;

    function openFiscalModal(sessionId) {
        fiscalModalSessionId = sessionId;
        fiscalModalCurrentStep = 1;
        fiscalModalPaymentType = null;
        fiscalModalData = null;
        fiscalModalReceiptData = null;
        
        // Reset modal state
        document.getElementById('fiscal-modal-step-1').classList.remove('hidden');
        document.getElementById('fiscal-modal-step-2').classList.add('hidden');
        document.getElementById('fiscal-modal-step-3').classList.add('hidden');
        document.getElementById('fiscal-modal-step-4').classList.add('hidden');
        
        // Reset continue button state
        const continueBtn = document.getElementById('fiscal-continue-btn');
        if (continueBtn) {
            continueBtn.disabled = true;
            continueBtn.innerHTML = 'Continuă';
        }
        
        // Reset payment buttons selection
        document.querySelectorAll('[data-payment-btn]').forEach(btn => {
            btn.classList.remove('bg-indigo-600', 'ring-2', 'ring-indigo-500');
            btn.classList.add('bg-gray-200', 'hover:bg-gray-300');
        });
        
        // Reset voucher toggle and input
        const voucherToggle = document.getElementById('voucher-toggle');
        const voucherInput = document.getElementById('voucher-hours-input');
        const voucherContainer = document.getElementById('voucher-input-container');
        if (voucherToggle) {
            voucherToggle.checked = false;
        }
        if (voucherInput) {
            voucherInput.value = '0';
        }
        if (voucherContainer) {
            voucherContainer.classList.add('hidden');
        }
        
        // Show modal
        document.getElementById('fiscal-modal').classList.remove('hidden');
    }

    function closeFiscalModal() {
        document.getElementById('fiscal-modal').classList.add('hidden');
        fiscalModalCurrentStep = 1;
        fiscalModalSessionId = null;
        fiscalModalPaymentType = null;
        fiscalModalData = null;
        fiscalModalReceiptData = null;
        
        // Reset continue button state
        const continueBtn = document.getElementById('fiscal-continue-btn');
        if (continueBtn) {
            continueBtn.disabled = true;
            continueBtn.innerHTML = 'Continuă';
        }
    }

    function toggleVoucherInput() {
        const voucherToggle = document.getElementById('voucher-toggle');
        const voucherContainer = document.getElementById('voucher-input-container');
        const voucherInput = document.getElementById('voucher-hours-input');
        
        if (voucherToggle && voucherContainer) {
            if (voucherToggle.checked) {
                voucherContainer.classList.remove('hidden');
                if (voucherInput) {
                    voucherInput.focus();
                }
            } else {
                voucherContainer.classList.add('hidden');
                if (voucherInput) {
                    voucherInput.value = '0';
                }
            }
        }
    }

    function selectPaymentType(type) {
        fiscalModalPaymentType = type;
        
        // Update UI
        document.querySelectorAll('[data-payment-btn]').forEach(btn => {
            btn.classList.remove('bg-indigo-600', 'ring-2', 'ring-indigo-500');
            btn.classList.add('bg-gray-200', 'hover:bg-gray-300');
        });
        
        const selectedBtn = document.querySelector(`[data-payment-btn="${type}"]`);
        if (selectedBtn) {
            selectedBtn.classList.remove('bg-gray-200', 'hover:bg-gray-300');
            selectedBtn.classList.add('bg-indigo-600', 'ring-2', 'ring-indigo-500');
        }
        
        // Enable continue button
        document.getElementById('fiscal-continue-btn').disabled = false;
    }

    async function goToConfirmStep() {
        if (!fiscalModalPaymentType) {
            alert('Selectați o metodă de plată');
            return;
        }
        
        if (!fiscalModalSessionId) {
            alert('Sesiune invalidă');
            return;
        }
        
        // Get voucher hours if voucher is enabled
        const voucherToggle = document.getElementById('voucher-toggle');
        const voucherInput = document.getElementById('voucher-hours-input');
        let voucherHours = 0;
        
        if (voucherToggle && voucherToggle.checked && voucherInput) {
            voucherHours = parseFloat(voucherInput.value) || 0;
            if (voucherHours < 0) {
                alert('Orele de voucher trebuie să fie pozitive');
                return;
            }
        }
        
        // Show loading state
        const continueBtn = document.getElementById('fiscal-continue-btn');
        const originalBtnText = continueBtn.innerHTML;
        continueBtn.disabled = true;
        continueBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Se încarcă...';
        
        try {
            // Get prepared data from server
            const prepareResponse = await fetch(`/sessions/${fiscalModalSessionId}/prepare-fiscal-print`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    paymentType: fiscalModalPaymentType,
                    voucherHours: voucherHours > 0 ? voucherHours : null
                })
            });

            if (!prepareResponse.ok) {
                const errorData = await prepareResponse.json();
                throw new Error(errorData.message || 'Eroare la pregătirea datelor');
            }

            const prepareData = await prepareResponse.json();
            
            if (!prepareData.success || !prepareData.data) {
                throw new Error('Date invalide de la server');
            }

            fiscalModalData = prepareData.data;
            fiscalModalReceiptData = prepareData.receipt || {};

            // Check if no receipt is needed (voucher covers everything)
            if (fiscalModalReceiptData.noReceiptNeeded) {
                // Mark as paid with voucher directly
                await markPaidWithVoucherDirectly(voucherHours);
                return;
            }

            // Update receipt preview with data
            const receipt = fiscalModalReceiptData;
            
            // Tenant name
            document.getElementById('receipt-tenant-name').textContent = receipt.tenantName || '-';
            
            // Receipt items
            const receiptItems = document.getElementById('receipt-items');
            receiptItems.innerHTML = '';
            
            // Time item - ALWAYS show original price (timePrice) with original duration (durationFiscalized) in preview
            // This is the price BEFORE voucher discount
            // Even if voucher covers all time, show it in preview (but it won't appear on actual receipt)
            if (receipt.timePrice > 0) {
                const timeItem = document.createElement('div');
                timeItem.className = 'flex justify-between text-sm';
                timeItem.innerHTML = `
                    <div>
                        <span class="font-medium text-gray-900">${prepareData.data.productName}</span>
                        <span class="text-gray-500 ml-2">${receipt.durationFiscalized || prepareData.data.duration}</span>
                    </div>
                    <span class="font-semibold text-gray-900">${parseFloat(receipt.timePrice || 0).toFixed(2)} RON</span>
                `;
                receiptItems.appendChild(timeItem);
            }
            
            // Products items
            if (receipt.products && receipt.products.length > 0) {
                receipt.products.forEach(product => {
                    const productItem = document.createElement('div');
                    productItem.className = 'flex justify-between text-sm';
                    productItem.innerHTML = `
                        <div>
                            <span class="font-medium text-gray-900">${product.name}</span>
                            <span class="text-gray-500 ml-2">×${product.quantity}</span>
                        </div>
                        <span class="font-semibold text-gray-900">${parseFloat(product.total_price).toFixed(2)} RON</span>
                    `;
                    receiptItems.appendChild(productItem);
                });
            }
            
            // Voucher discount line (if voucher was used)
            if (receipt.voucherHours > 0 && receipt.voucherPrice > 0) {
                const voucherItem = document.createElement('div');
                voucherItem.className = 'flex justify-between text-sm text-green-600 border-t border-gray-300 pt-2 mt-2';
                voucherItem.innerHTML = `
                    <div>
                        <span class="font-medium">Voucher (${receipt.voucherHours}h)</span>
                    </div>
                    <span class="font-semibold">-${parseFloat(receipt.voucherPrice).toFixed(2)} RON</span>
                `;
                receiptItems.appendChild(voucherItem);
            }
            
            // Total price (final price after voucher) - this is what will be on the receipt
            document.getElementById('receipt-total-price').textContent = `${parseFloat(receipt.finalPrice || prepareData.data.price || 0).toFixed(2)} RON`;
            
            // Payment method
            document.getElementById('receipt-payment-method').textContent = fiscalModalPaymentType === 'CASH' ? 'Cash' : 'Card';
            
            // Go to confirmation step
            fiscalModalCurrentStep = 2;
            document.getElementById('fiscal-modal-step-1').classList.add('hidden');
            document.getElementById('fiscal-modal-step-2').classList.remove('hidden');
        } catch (error) {
            console.error('Error:', error);
            // Show error in modal instead of alert
            showFiscalResult('error', error.message, null);
            continueBtn.disabled = false;
            continueBtn.innerHTML = originalBtnText;
        }
    }

    async function markPaidWithVoucherDirectly(voucherHours) {
        try {
            const response = await fetch(`/sessions/${fiscalModalSessionId}/mark-paid-with-voucher`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    voucher_hours: voucherHours
                })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Eroare la marcarea sesiunii ca plătită');
            }

            const result = await response.json();
            
            if (result.success) {
                showFiscalResult('success', 'Valoarea orelor a fost acoperită de voucher. Sesiunea va fi trecută plătită fără a mai scoate bon fiscal.', null);
                setTimeout(() => {
                    fetchData();
                    closeFiscalModal();
                }, 5000); // 5 seconds to allow operator to read the message
            } else {
                throw new Error(result.message || 'Eroare necunoscută');
            }
        } catch (error) {
            console.error('Error:', error);
            showFiscalResult('error', error.message, null);
        }
    }

    async function confirmAndPrint() {
        if (!fiscalModalSessionId || !fiscalModalPaymentType || !fiscalModalData) {
            alert('Date incomplete');
            return;
        }
        
        // Go to loading step
        fiscalModalCurrentStep = 3;
        document.getElementById('fiscal-modal-step-2').classList.add('hidden');
        document.getElementById('fiscal-modal-step-3').classList.remove('hidden');
        
        try {
            // Use already prepared data from goToConfirmStep
            const prepareData = {
                success: true,
                data: fiscalModalData
            };

            // Step 2: Send directly to local bridge from browser
            const bridgeUrl = '{{ config("services.fiscal_bridge.url", "http://localhost:9000") }}';
            const bridgeResponse = await fetch(`${bridgeUrl}/print`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(prepareData.data)
            });

            if (!bridgeResponse.ok) {
                const errorText = await bridgeResponse.text();
                let errorData;
                try {
                    errorData = JSON.parse(errorText);
                } catch {
                    throw new Error(`Eroare HTTP ${bridgeResponse.status}: ${errorText.substring(0, 100)}`);
                }
                throw new Error(errorData.message || errorData.details || 'Eroare de la bridge-ul fiscal');
            }

            const bridgeData = await bridgeResponse.json();

            // Save log to database
            try {
                const voucherHours = fiscalModalData.voucherHours || 0;
                await saveFiscalReceiptLog({
                    play_session_id: fiscalModalSessionId,
                    filename: bridgeData.file || null,
                    status: bridgeData.status === 'success' ? 'success' : 'error',
                    error_message: bridgeData.status === 'success' ? null : (bridgeData.message || bridgeData.details || 'Eroare necunoscută'),
                    voucher_hours: voucherHours > 0 ? voucherHours : null,
                    payment_status: voucherHours > 0 ? 'paid_voucher' : 'paid',
                    payment_method: fiscalModalPaymentType,
                });
            } catch (logError) {
                console.error('Error saving log:', logError);
                // Don't block the UI if log saving fails
            }

            // Show result in modal
            if (bridgeData.status === 'success') {
                showFiscalResult('success', 'Bon fiscal emis cu succes!', bridgeData.file || null);
                // Refresh table to reflect payment status changes
                fetchData();
            } else {
                const errorMessage = bridgeData.message || bridgeData.details || 'Eroare necunoscută';
                showFiscalResult('error', errorMessage, null);
                // Refresh table even on error to ensure consistency
                fetchData();
            }
        } catch (error) {
            console.error('Error:', error);
            
            // Save error log to database
            try {
                const voucherHours = fiscalModalData?.voucherHours || 0;
                await saveFiscalReceiptLog({
                    play_session_id: fiscalModalSessionId,
                    filename: null,
                    status: 'error',
                    error_message: error.message.includes('Failed to fetch') || error.message.includes('NetworkError')
                        ? 'Nu s-a putut conecta la bridge-ul fiscal local. Verifică că serviciul Node.js rulează pe calculatorul tău.'
                        : error.message,
                    voucher_hours: voucherHours > 0 ? voucherHours : null,
                    payment_status: voucherHours > 0 ? 'paid_voucher' : 'paid',
                    payment_method: fiscalModalPaymentType,
                });
            } catch (logError) {
                console.error('Error saving log:', logError);
                // Don't block the UI if log saving fails
            }
            
            // Show error in modal
            const errorMessage = error.message.includes('Failed to fetch') || error.message.includes('NetworkError')
                ? 'Nu s-a putut conecta la bridge-ul fiscal local. Verifică că serviciul Node.js rulează pe calculatorul tău.'
                : error.message;
            
            showFiscalResult('error', errorMessage, null);
            // Refresh table even on error to ensure consistency
            fetchData();
        }
    }

    async function saveFiscalReceiptLog(data) {
        try {
            const response = await fetch('{{ route("sessions.save-fiscal-receipt-log") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Eroare la salvarea logului');
            }

            const result = await response.json();
            return result;
        } catch (error) {
            console.error('Error saving fiscal receipt log:', error);
            throw error;
        }
    }

function showFiscalResult(type, message, file) {
    fiscalModalCurrentStep = 4;
    
    // Hide all steps
    document.getElementById('fiscal-modal-step-1').classList.add('hidden');
    document.getElementById('fiscal-modal-step-2').classList.add('hidden');
    document.getElementById('fiscal-modal-step-3').classList.add('hidden');
    document.getElementById('fiscal-modal-step-4').classList.remove('hidden');
    
    // Build result content
    const resultContent = document.getElementById('fiscal-result-content');
    
    if (type === 'success') {
        resultContent.innerHTML = `
            <div class="mb-4">
                <i class="fas fa-check-circle text-5xl text-green-500 mb-4"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Bon fiscal emis cu succes!</h3>
            <p class="text-gray-700 mb-2">${message}</p>
            ${file ? `<p class="text-sm text-gray-500">Fișier: ${file}</p>` : ''}
        `;
    } else {
        resultContent.innerHTML = `
            <div class="mb-4">
                <i class="fas fa-exclamation-circle text-5xl text-red-500 mb-4"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Eroare</h3>
            <p class="text-gray-700">${message}</p>
        `;
    }
}

// Quick toggle birthday status from list
async function toggleBirthdayQuick(sessionId, currentStatus) {
    const newStatus = !currentStatus;
    
    try {
        const response = await fetch(`/sessions/${sessionId}/update-birthday-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                is_birthday: newStatus
            })
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Eroare la actualizarea statusului');
        }

        // Reload table data
        fetchData();
    } catch (error) {
        console.error('Error toggling birthday status:', error);
        alert('Eroare: ' + error.message);
    }
}
</script>
@endsection




