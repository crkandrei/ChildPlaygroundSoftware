@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section (compact) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Bun venit, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-gray-600 text-sm md:text-base">
                    @if(Auth::user()->tenant)
                        <i class="fas fa-building mr-2 text-indigo-600"></i>{{ Auth::user()->tenant->name }}
                    @else
                        <i class="fas fa-globe mr-2 text-indigo-600"></i>Acces global
                    @endif
                    <span class="text-gray-400 mx-2">|</span>
                    <span id="currentDateTime" class="text-gray-500"></span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                @if(Auth::user()->tenant)
                <button onclick="openPreCheckinModal()"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-sm font-medium rounded-lg transition">
                    <i class="fas fa-qrcode"></i>
                    <span class="hidden sm:inline">Link Pre-Checkin</span>
                </button>
                @endif
                <div class="hidden md:block">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-baby text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->tenant)
    <!-- Pre-Checkin Modal -->
    <div id="preCheckinModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="document.getElementById('preCheckinModal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 space-y-5">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                    <i class="fas fa-qrcode text-sky-600"></i> Pre-Checkin
                </h3>
                <button onclick="document.getElementById('preCheckinModal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <p class="text-sm text-gray-500">
                Trimite acest link clienților să se înregistreze de acasă.
            </p>

            <!-- QR Code -->
            <div class="flex justify-center">
                <img id="preCheckinQr" src="" alt="QR Code" class="rounded-xl border border-gray-200 w-[220px] h-[220px]" crossorigin="anonymous">
            </div>

            <!-- URL -->
            <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2">
                <code id="preCheckinUrl" class="text-xs text-sky-700 flex-1 break-all"></code>
                <button onclick="copyPreCheckinUrl()" title="Copiază"
                    class="flex-shrink-0 text-gray-400 hover:text-sky-600 transition">
                    <i class="fas fa-copy"></i>
                </button>
            </div>

            <p id="copiedMsg" class="hidden text-xs text-green-600 text-center">
                <i class="fas fa-check mr-1"></i> Link copiat!
            </p>

            <div class="flex gap-3">
                <a id="preCheckinOpenBtn" href="#" target="_blank"
                    class="flex-1 h-10 bg-sky-600 hover:bg-sky-700 text-white text-sm font-medium rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-external-link-alt"></i> Deschide
                </a>
                <button onclick="copyPreCheckinUrl()"
                    class="flex-1 h-10 border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-copy"></i> Copiază
                </button>
            </div>

            <button onclick="downloadPreCheckinQr()"
                class="w-full h-10 border border-sky-300 hover:bg-sky-50 text-sky-700 text-sm font-medium rounded-lg transition flex items-center justify-center gap-2">
                <i class="fas fa-download"></i> Descarcă QR (PNG)
            </button>
        </div>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">

        <!-- Intrări Copii Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6 card-hover">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-medium text-gray-600">Intrări Copii</p>
                <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-child text-yellow-600 text-lg"></i>
                </div>
            </div>
            <div class="flex items-baseline space-x-4 mb-2">
                <div>
                    <p class="text-xs text-gray-500">Total</p>
                    <p id="sessionsToday" class="text-2xl md:text-3xl font-bold text-yellow-600">-</p>
                </div>
                <div class="h-8 border-l border-gray-200"></div>
                <div>
                    <p class="text-xs text-gray-500">Înăuntru</p>
                    <p id="sessionsTodayInProgress" class="text-2xl md:text-3xl font-bold text-green-600">-</p>
                </div>
            </div>
            <!-- Comparison with last week same day -->
            <div id="sessionsComparison" class="text-xs text-gray-500 mb-2 hidden">
                <span id="sessionsComparisonIcon"></span>
                <span id="sessionsComparisonText"></span>
            </div>
            <!-- Session type breakdown -->
            <div id="sessionsBreakdown" class="text-xs text-gray-500 mt-2 hidden">
                <span class="inline-flex items-center px-1.5 py-0.5 rounded bg-gray-100 text-gray-600 mr-1">
                    <span id="sessionsNormal">0</span>n
                </span>
                <span class="inline-flex items-center px-1.5 py-0.5 rounded bg-pink-100 text-pink-600 mr-1">
                    <span id="sessionsBirthday">0</span>b
                </span>
                <span class="inline-flex items-center px-1.5 py-0.5 rounded bg-green-100 text-green-600">
                    <span id="sessionsJungle">0</span>j
                </span>
            </div>
        </div>

        <!-- Media Azi Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6 card-hover">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-medium text-gray-600">Media Azi</p>
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-purple-600 text-lg"></i>
                </div>
            </div>
            <p id="avgToday" class="text-2xl md:text-3xl font-bold text-purple-600">-</p>
            <p class="text-xs text-gray-500 mt-1">Durata medie sesiune</p>
        </div>

        <!-- Media Totală Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6 card-hover">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-medium text-gray-600">Media Totală</p>
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-indigo-600 text-lg"></i>
                </div>
            </div>
            <p id="avgTotal" class="text-2xl md:text-3xl font-bold text-indigo-600">-</p>
            <p class="text-xs text-gray-500 mt-1">Ultimele 30 zile</p>
        </div>

        <!-- Total Încasări Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6 card-hover">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-medium text-gray-600">Încasări Azi</p>
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-emerald-600 text-lg"></i>
                </div>
            </div>
            <p id="totalIncomeToday" class="text-2xl md:text-3xl font-bold text-emerald-600">-</p>
            <!-- Comparison with last week same day -->
            <div id="incomeComparison" class="text-xs text-gray-500 mt-1 hidden">
                <span id="incomeComparisonIcon"></span>
                <span id="incomeComparisonText"></span>
            </div>
            <!-- Payment breakdown -->
            <div id="incomeBreakdown" class="text-xs text-gray-500 mt-2 space-y-0.5 hidden">
                <div>Cash: <span id="cashTotal">0</span> RON</div>
                <div>Card: <span id="cardTotal">0</span> RON</div>
                <div>Voucher: <span id="voucherTotal">0</span> RON</div>
            </div>
        </div>
    </div>

    <!-- Alerts Section (conditionally shown) -->
    <div id="alertsSection" class="hidden">
        <div class="bg-amber-50 rounded-xl shadow-sm border border-amber-200 p-4 md:p-6">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-exclamation-triangle text-amber-600"></i>
                </div>
                <h2 class="text-lg font-bold text-amber-800">Atenție</h2>
            </div>
            <div id="alertsList" class="space-y-3">
                <!-- Alerts will be inserted here -->
            </div>
        </div>
    </div>

    <!-- Active Sessions (full width) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-play-circle text-green-600"></i>
                </div>
                <h2 class="text-lg md:text-xl font-bold text-gray-900">Sesiuni Active</h2>
            </div>
            <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full" id="activeSessionsCount">0</span>
        </div>
        <div id="activeSessionsList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-96 overflow-y-auto">
            <div class="col-span-full text-center py-8">
                <i class="fas fa-spinner fa-spin text-gray-400 text-2xl mb-2"></i>
                <p class="text-gray-500">Se încarcă sesiunile...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    @if(Auth::user()->tenant)
    const PRECHECKIN_URL = '{{ url("/pre-checkin/" . Auth::user()->tenant->slug) }}';

    function openPreCheckinModal() {
        document.getElementById('preCheckinUrl').textContent = PRECHECKIN_URL;
        document.getElementById('preCheckinOpenBtn').href = PRECHECKIN_URL;
        document.getElementById('preCheckinModal').classList.remove('hidden');

        const qrImg = document.getElementById('preCheckinQr');
        if (!qrImg.src || qrImg.src === window.location.href) {
            qrImg.src = 'https://api.qrserver.com/v1/create-qr-code/?size=400x400&color=0369a1&data=' + encodeURIComponent(PRECHECKIN_URL);
        }
    }

    function downloadPreCheckinQr() {
        const tenantName = '{{ Auth::user()->tenant->name ?? "Pre-Checkin" }}';
        const qrImg = document.getElementById('preCheckinQr');

        const doDownload = () => {
            const padding   = 40;
            const qrSize    = 400;
            const lineH     = 28;
            const lines     = ['Scanează pentru', 'Pre-Checkin – ' + tenantName];
            const canvasH   = padding + qrSize + 16 + lines.length * lineH + padding;

            const canvas  = document.createElement('canvas');
            canvas.width  = qrSize + padding * 2;
            canvas.height = canvasH;
            const ctx = canvas.getContext('2d');

            // Fundal alb
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // QR
            ctx.drawImage(qrImg, padding, padding, qrSize, qrSize);

            // Text
            ctx.fillStyle = '#0369a1';
            ctx.textAlign = 'center';
            let y = padding + qrSize + 20;
            lines.forEach((line, i) => {
                ctx.font = i === 0
                    ? '500 18px system-ui, sans-serif'
                    : 'bold 22px system-ui, sans-serif';
                ctx.fillText(line, canvas.width / 2, y);
                y += lineH;
            });

            const a = document.createElement('a');
            a.download = 'pre-checkin-qr-' + tenantName.toLowerCase().replace(/\s+/g, '-') + '.png';
            a.href = canvas.toDataURL('image/png');
            a.click();
        };

        if (qrImg.complete && qrImg.naturalWidth > 0) {
            doDownload();
        } else {
            qrImg.onload = doDownload;
        }
    }
    @endif

    function copyPreCheckinUrl() {
        const url = document.getElementById('preCheckinUrl').textContent;
        navigator.clipboard.writeText(url).then(() => {
            const msg = document.getElementById('copiedMsg');
            msg.classList.remove('hidden');
            setTimeout(() => msg.classList.add('hidden'), 2500);
        });
    }

    // API helper
    async function apiCall(url, options = {}) {
        const response = await fetch(url, {
            ...options,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                ...options.headers
            },
            credentials: 'same-origin'
        });
        return response.json();
    }

    function formatMinutesHuman(mins) {
        const total = parseInt(mins || 0, 10);
        const hours = Math.floor(total / 60);
        const remaining = total % 60;
        return hours > 0 ? `${hours}h ${remaining}m` : `${remaining}m`;
    }

    function updateDateTime() {
        const now = new Date();
        const options = { 
            weekday: 'long', 
            day: 'numeric', 
            month: 'long', 
            hour: '2-digit', 
            minute: '2-digit' 
        };
        document.getElementById('currentDateTime').textContent = now.toLocaleDateString('ro-RO', options);
    }

    // Load dashboard stats
    async function loadDashboardStats() {
        try {
            // Load basic stats
            const statsData = await apiCall('/dashboard-api/stats');
            if (statsData.success) {
                const stats = statsData.stats;
                
                // Sessions today
                document.getElementById('sessionsToday').textContent = stats.sessions_today || 0;
                document.getElementById('sessionsTodayInProgress').textContent = stats.sessions_today_in_progress || 0;
                
                // Duration averages
                document.getElementById('avgToday').textContent = formatMinutesHuman(stats.avg_session_today_minutes);
                document.getElementById('avgTotal').textContent = formatMinutesHuman(stats.avg_session_total_minutes);
                
                // Session type breakdown
                if (stats.sessions_today > 0) {
                    document.getElementById('sessionsBreakdown').classList.remove('hidden');
                    document.getElementById('sessionsNormal').textContent = stats.sessions_normal || 0;
                    document.getElementById('sessionsBirthday').textContent = stats.sessions_birthday || 0;
                    document.getElementById('sessionsJungle').textContent = stats.sessions_jungle || 0;
                }
                
                // Sessions comparison with same day last week
                if (stats.sessions_comparison) {
                    const comp = stats.sessions_comparison;
                    const compEl = document.getElementById('sessionsComparison');
                    const iconEl = document.getElementById('sessionsComparisonIcon');
                    const textEl = document.getElementById('sessionsComparisonText');
                    
                    compEl.classList.remove('hidden');
                    
                    if (comp.direction === 'up') {
                        iconEl.innerHTML = '<i class="fas fa-arrow-up text-green-500 mr-1"></i>';
                        textEl.innerHTML = `<span class="text-green-600">+${comp.percent}%</span> vs ${stats.comparison_day_name} trecut`;
                    } else if (comp.direction === 'down') {
                        iconEl.innerHTML = '<i class="fas fa-arrow-down text-red-500 mr-1"></i>';
                        textEl.innerHTML = `<span class="text-red-600">-${comp.percent}%</span> vs ${stats.comparison_day_name} trecut`;
                    } else {
                        iconEl.innerHTML = '<i class="fas fa-minus text-gray-400 mr-1"></i>';
                        textEl.innerHTML = `<span class="text-gray-500">= vs ${stats.comparison_day_name} trecut</span>`;
                    }
                }
                
                // Income today
                const income = stats.total_income_today || 0;
                document.getElementById('totalIncomeToday').textContent = income.toFixed(2) + ' RON';
                
                // Income breakdown
                if (income > 0) {
                    document.getElementById('incomeBreakdown').classList.remove('hidden');
                    document.getElementById('cashTotal').textContent = (stats.cash_total || 0).toFixed(2);
                    document.getElementById('cardTotal').textContent = (stats.card_total || 0).toFixed(2);
                    document.getElementById('voucherTotal').textContent = (stats.voucher_total || 0).toFixed(2);
                }
                
                // Income comparison with same day last week
                if (stats.income_comparison) {
                    const comp = stats.income_comparison;
                    const compEl = document.getElementById('incomeComparison');
                    const iconEl = document.getElementById('incomeComparisonIcon');
                    const textEl = document.getElementById('incomeComparisonText');
                    
                    compEl.classList.remove('hidden');
                    
                    if (comp.direction === 'up') {
                        iconEl.innerHTML = '<i class="fas fa-arrow-up text-green-500 mr-1"></i>';
                        textEl.innerHTML = `<span class="text-green-600">+${comp.percent}%</span> vs ${stats.comparison_day_name} trecut`;
                    } else if (comp.direction === 'down') {
                        iconEl.innerHTML = '<i class="fas fa-arrow-down text-red-500 mr-1"></i>';
                        textEl.innerHTML = `<span class="text-red-600">-${comp.percent}%</span> vs ${stats.comparison_day_name} trecut`;
                    } else {
                        iconEl.innerHTML = '<i class="fas fa-minus text-gray-400 mr-1"></i>';
                        textEl.innerHTML = `<span class="text-gray-500">= vs ${stats.comparison_day_name} trecut</span>`;
                    }
                }
            }

            // Load alerts
            const alertsData = await apiCall('/dashboard-api/alerts');
            if (alertsData.success && alertsData.alerts && alertsData.alerts.length > 0) {
                const alertsSection = document.getElementById('alertsSection');
                const alertsList = document.getElementById('alertsList');
                
                alertsSection.classList.remove('hidden');
                alertsList.innerHTML = alertsData.alerts.map(alert => `
                    <div class="flex items-start p-3 bg-white rounded-lg border border-amber-100">
                        <i class="fas ${alert.icon} text-amber-500 mt-0.5 mr-3"></i>
                        <div class="flex-1">
                            <p class="font-medium text-amber-800">${alert.title}</p>
                            <p class="text-sm text-amber-600">${alert.message}</p>
                            ${alert.details && alert.details.length > 0 ? `
                                <div class="mt-2 text-sm text-amber-700">
                                    ${alert.details.slice(0, 3).map(d => `
                                        <div class="flex items-center">
                                            <i class="fas fa-user text-xs mr-2 opacity-50"></i>
                                            ${d.child_name}
                                            ${d.price ? ` - ${parseFloat(d.price).toFixed(2)} RON` : ''}
                                            ${d.duration ? ` - ${d.duration}` : ''}
                                        </div>
                                    `).join('')}
                                    ${alert.details.length > 3 ? `<div class="text-xs opacity-75 mt-1">+ ${alert.details.length - 3} altele...</div>` : ''}
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `).join('');
            }

            // Load active sessions
            const sessionsData = await apiCall('/dashboard-api/active-sessions');
            const container = document.getElementById('activeSessionsList');
            const badge = document.getElementById('activeSessionsCount');
            
            if (!sessionsData.success) {
                badge.textContent = '0';
                container.innerHTML = '<p class="col-span-full text-red-600 text-center py-4">Nu s-au putut încărca sesiunile active</p>';
            } else {
                const list = sessionsData.sessions || [];
                badge.textContent = String(list.length);
                
                if (list.length === 0) {
                    container.innerHTML = '<p class="col-span-full text-gray-500 text-center py-8">Nu există sesiuni active</p>';
                } else {
                    // Build grid items with live duration
                    container.innerHTML = list.map(session => {
                        // Session type badge
                        let typeBadge = '';
                        if (session.session_type === 'birthday') {
                            typeBadge = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-pink-100 text-pink-700"><i class="fas fa-birthday-cake mr-1"></i>Birthday</span>';
                        } else if (session.session_type === 'jungle') {
                            typeBadge = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700"><i class="fas fa-tree mr-1"></i>Jungle</span>';
                        }
                        
                        // Pause badge
                        let pauseBadge = session.is_paused ? '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-700 ml-1"><i class="fas fa-pause mr-1"></i>Pauză</span>' : '';
                        
                        // Long session warning (> 3 hours)
                        let longWarning = session.duration_minutes > 180 ? '<i class="fas fa-clock text-amber-500 ml-2" title="Sesiune lungă"></i>' : '';
                        
                        return `
                            <div class="flex flex-col p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-gray-200 transition-colors">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-gray-900">${session.child_name}</span>
                                    <span class="text-lg font-bold text-indigo-600" id="duration-${session.id}">${session.duration || '-'}</span>
                                    ${longWarning}
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">
                                        <i class="fas fa-qrcode mr-1 text-gray-400"></i>
                                        <span class="font-mono">${session.bracelet_code || '-'}</span>
                                    </span>
                                    <div>${typeBadge}${pauseBadge}</div>
                                </div>
                            </div>
                        `;
                    }).join('');

                    // Prepare live duration updates
                    window.__activeSessionStarts = {};
                    for (const s of list) {
                        if (s.started_at) {
                            window.__activeSessionStarts[s.id] = s.started_at;
                        }
                    }
                    if (window.__durationTimer) {
                        clearInterval(window.__durationTimer);
                    }
                    window.__durationTimer = setInterval(updateActiveDurations, 1000);
                    updateActiveDurations();
                }
            }
        } catch (error) {
            console.error('Error loading dashboard data:', error);
        }
    }

    function updateActiveDurations() {
        if (!window.__activeSessionStarts) return;
        const now = Date.now();
        for (const [id, iso] of Object.entries(window.__activeSessionStarts)) {
            const el = document.getElementById(`duration-${id}`);
            if (!el) continue;
            const startMs = Date.parse(iso);
            if (!isNaN(startMs)) {
                const diffMs = now - startMs;
                const mins = Math.floor(diffMs / 60000);
                const hrs = Math.floor(mins / 60);
                const rem = mins % 60;
                el.textContent = hrs > 0 ? `${hrs}h ${rem}m` : `${rem}m`;
            }
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateDateTime();
        setInterval(updateDateTime, 60000); // Update every minute
        loadDashboardStats();
        
        // Refresh dashboard stats every 30 seconds
        setInterval(loadDashboardStats, 30000);
    });
</script>
@endsection
