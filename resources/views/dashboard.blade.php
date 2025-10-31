@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Bun venit, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-gray-600 text-lg">
                    @if(Auth::user()->tenant)
                        <i class="fas fa-building mr-2 text-indigo-600"></i>{{ Auth::user()->tenant->name }} - {{ Auth::user()->role->display_name }}
                    @else
                        <i class="fas fa-globe mr-2 text-indigo-600"></i>{{ Auth::user()->role->display_name }} - Acces global
                    @endif
                </p>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-baby text-white text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Intrări Copii</p>
                    <div class="flex items-baseline space-x-3">
                        <div>
                            <p class="text-xs text-gray-500">Total</p>
                            <p id="sessionsToday" class="text-3xl font-bold text-yellow-600">-</p>
                        </div>
                        <div class="h-10 border-l border-gray-200"></div>
                        <div>
                            <p class="text-xs text-gray-500">Inauntru</p>
                            <p id="sessionsTodayInProgress" class="text-3xl font-bold text-green-600">-</p>
                        </div>
                    </div>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-day text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Media Azi</p>
                    <p id="avgToday" class="text-3xl font-bold text-purple-600">-</p>
                    <p class="text-xs text-gray-500 mt-1">Durata medie (azi)</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Media Totală</p>
                    <p id="avgTotal" class="text-3xl font-bold text-indigo-600">-</p>
                    <p class="text-xs text-gray-500 mt-1">Durata medie (30 zile)</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-indigo-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-bolt text-indigo-600"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Acțiuni Rapide</h2>
            </div>
            <div class="space-y-3">
                <a href="{{ route('scan') }}" class="flex items-center w-full bg-gradient-to-r from-indigo-600 to-indigo-700 text-white py-3 px-4 rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 font-medium">
                    <i class="fas fa-qrcode mr-3"></i>
                    Scanare Brățară
                </a>
                <a href="{{ route('children.index') }}" class="flex items-center w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-3 px-4 rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium">
                    <i class="fas fa-child mr-3"></i>
                    Vezi Copii & Sesiuni
                </a>
                @if(Auth::user()->isSuperAdmin() || Auth::user()->isCompanyAdmin() || Auth::user()->isStaff())
                <a href="{{ route('children.index', ['open' => 'add-child']) }}" class="flex items-center w-full bg-gradient-to-r from-yellow-600 to-yellow-700 text-white py-3 px-4 rounded-lg hover:from-yellow-700 hover:to-yellow-800 transition-all duration-200 font-medium">
                    <i class="fas fa-plus mr-3"></i>
                    Adaugă Copil Nou
                </a>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-play-circle text-green-600"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">Sesiuni Active</h2>
                </div>
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full" id="activeSessionsCount">0</span>
            </div>
            <div id="activeSessionsList" class="space-y-3 max-h-64 overflow-y-auto">
                <div class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-gray-400 text-2xl mb-2"></i>
                    <p class="text-gray-500">Se încarcă sesiunile...</p>
                </div>
            </div>
        </div>
    </div>

    
</div>
@endsection

@section('scripts')
<script>
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

    // Load dashboard stats
    async function loadDashboardStats() {
        try {
            // Load basic stats
            const statsData = await apiCall('/dashboard-api/stats');
            if (statsData.success) {
                console.log(statsData.stats);
                document.getElementById('sessionsToday').textContent = statsData.stats.sessions_today || 0;
                document.getElementById('sessionsTodayInProgress').textContent = statsData.stats.sessions_today_in_progress || 0;
                document.getElementById('avgToday').textContent = formatMinutesHuman(statsData.stats.avg_session_today_minutes);
                document.getElementById('avgTotal').textContent = formatMinutesHuman(statsData.stats.avg_session_total_minutes);
                const totalEl = document.getElementById('totalTimeToday');
                if (totalEl) totalEl.textContent = statsData.stats.total_time_today || '0h 0m';
            }

            // Load active sessions
            const sessionsData = await apiCall('/dashboard-api/active-sessions');
            const container = document.getElementById('activeSessionsList');
            const badge = document.getElementById('activeSessionsCount');
            if (!sessionsData.success) {
                badge.textContent = '0';
                container.innerHTML = '<p class="text-red-600 text-center">Nu s-au putut încărca sesiunile active</p>';
            } else {
                const list = sessionsData.sessions || [];
                badge.textContent = String(list.length);
                if (list.length === 0) {
                    container.innerHTML = '<p class="text-gray-500 text-center">Nu există sesiuni active</p>';
                } else {
                    // Build list items with live duration
                    container.innerHTML = list.map(session => `
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                            <div>
                                <div class="font-medium">${session.child_name}</div>
                                <div class="text-xs text-gray-500">Brățară: <span class="font-mono">${session.bracelet_code || '-'}</span></div>
                            </div>
                            <div class="text-right">
                                <span class="text-sm text-gray-700" id="duration-${session.id}">${session.duration || '-'}</span>
                            </div>
                        </div>
                    `).join('');

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

            // Recent activity & reports moved to Rapoarte page
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

    // Load initial data
    loadDashboardStats();
</script>
@endsection
