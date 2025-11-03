@extends('layouts.app')

@section('title', 'Părinți')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Părinți & Tutori</h1>
                <p class="text-gray-600">Gestionați părinții și tutorii copiilor</p>
            </div>
            @if(Auth::user()->isSuperAdmin() || Auth::user()->isCompanyAdmin())
            <button id="open-add-guardian-modal" 
               class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-6 py-3 rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 font-medium flex items-center shadow-md">
                <i class="fas fa-plus mr-2"></i>
                Adaugă Părinte Nou
            </button>
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Total Părinți</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalGuardians }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Cu Copii</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $guardiansWithChildren }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Fără Copii</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $guardiansWithoutChildren }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Guardians Table -->
    <div id="guardians-table-root" class="bg-white rounded-lg shadow overflow-hidden" data-guardians-data-url="{{ route('guardians.data') }}">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <h2 class="text-xl font-bold text-gray-900">Lista Părinților</h2>
                <div class="flex flex-wrap items-center gap-3">
                    <div>
                        <label class="text-sm text-gray-600 mr-2" for="guardiansPerPage">Afișează</label>
                        <select id="guardiansPerPage" class="px-3 py-2 border border-gray-300 rounded-md">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="relative">
                        <input id="guardiansSearchInput" type="text" placeholder="Caută (nume, telefon, note)" class="w-64 px-3 py-2 border border-gray-300 rounded-md pr-8">
                        <i class="fas fa-search absolute right-2 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="name">
                            Nume <span class="sort-ind" data-col="name"></span>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="phone">
                            Contact <span class="sort-ind" data-col="phone"></span>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="children_count">
                            Copii <span class="sort-ind" data-col="children_count"></span>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Note
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acțiuni
                        </th>
                    </tr>
                </thead>
                <tbody id="guardiansTableBody" class="bg-white divide-y divide-gray-200"></tbody>
            </table>
        </div>

        <div class="flex items-center justify-between px-6 py-4">
            <div class="text-sm text-gray-600" id="guardiansResultsInfo"></div>
            <div class="flex items-center gap-2">
                <button id="guardiansPrevPage" class="px-3 py-2 border rounded-md text-sm disabled:opacity-50">Înapoi</button>
                <span id="guardiansPageLabel" class="text-sm text-gray-700"></span>
                <button id="guardiansNextPage" class="px-3 py-2 border rounded-md text-sm disabled:opacity-50">Înainte</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
@if(Auth::user()->isSuperAdmin() || Auth::user()->isCompanyAdmin())
<!-- Add Guardian Modal -->
<div id="add-guardian-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
    <div id="add-guardian-overlay" class="fixed inset-0 bg-black bg-opacity-50"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Adaugă Părinte</h3>
                <button id="close-add-guardian-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('guardians.store') }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Numele Complet <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" maxlength="200" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror" placeholder="Ex: Maria Popescu" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Telefon
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('phone') border-red-500 @enderror" placeholder="Ex: 0712345678">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Format: 0712345678 (10 cifre)</p>
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Note (opțional)
                        </label>
                        <textarea id="notes" name="notes" rows="3" maxlength="1000" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('notes') border-red-500 @enderror" placeholder="Informații suplimentare despre părinte...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Maxim 1000 caractere</p>
                    </div>

                    <div class="flex items-center justify-end space-x-2">
                        <button type="button" id="cancel-add-guardian" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Anulează</button>
                        <button type="submit" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Salvează</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
<script>
    (function() {
        // State for AJAX table
        let guardiansState = {
            page: 1,
            per_page: 10,
            sort_by: 'name',
            sort_dir: 'asc',
            search: ''
        };

        const rootEl = document.getElementById('guardians-table-root');
        const guardiansDataUrl = rootEl ? rootEl.getAttribute('data-guardians-data-url') : '';

        async function fetchGuardians() {
            const url = new URL(guardiansDataUrl || window.location.pathname, window.location.origin);
            url.searchParams.set('page', guardiansState.page);
            url.searchParams.set('per_page', guardiansState.per_page);
            url.searchParams.set('sort_by', guardiansState.sort_by);
            url.searchParams.set('sort_dir', guardiansState.sort_dir);
            if (guardiansState.search) url.searchParams.set('search', guardiansState.search);

            const res = await fetch(url, { credentials: 'same-origin', headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            if (!data.success) return;
            renderGuardiansTable(data.data);
            renderGuardiansMeta(data.meta);
        }

        function renderGuardiansTable(rows) {
            const tbody = document.getElementById('guardiansTableBody');
            if (!tbody) return;
            
            if (rows.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Nu există părinți</h3>
                            <p class="mt-1 text-sm text-gray-500">Începeți prin a adăuga primul părinte.</p>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = rows.map(g => {
                const initials = g.name ? g.name.substring(0, 2).toUpperCase() : '??';
                const contactHtml = [];
                
                if (g.phone) {
                    contactHtml.push(`
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            ${g.phone}
                        </div>
                    `);
                }
                
                if (contactHtml.length === 0) {
                    contactHtml.push('<span class="text-gray-400 text-sm">Fără contact</span>');
                }

                const childrenBadgeClass = g.children_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';
                
                @if(Auth::user()->isSuperAdmin() || Auth::user()->isCompanyAdmin())
                const actionsHtml = `
                    <div class="flex space-x-2">
                        <a href="/guardians/${g.id}" class="text-indigo-600 hover:text-indigo-900">Vezi</a>
                        <a href="/guardians/${g.id}/edit" class="text-yellow-600 hover:text-yellow-900">Editează</a>
                        <form method="POST" action="/guardians/${g.id}" class="inline" onsubmit="return confirm('Sigur vrei să ștergi acest părinte?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Șterge</button>
                        </form>
                    </div>
                `;
                @else
                const actionsHtml = `
                    <div class="flex space-x-2">
                        <a href="/guardians/${g.id}" class="text-indigo-600 hover:text-indigo-900">Vezi</a>
                    </div>
                `;
                @endif

                return `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-sm font-medium text-indigo-600">${initials}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">${g.name || '-'}</div>
                                    <div class="text-sm text-gray-500">Adăugat ${g.created_at}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                ${contactHtml.join('')}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${childrenBadgeClass}">
                                    ${g.children_count} copii
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">
                                ${g.notes || '-'}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            ${actionsHtml}
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function renderGuardiansMeta(meta) {
            const info = document.getElementById('guardiansResultsInfo');
            const pageLabel = document.getElementById('guardiansPageLabel');
            const prev = document.getElementById('guardiansPrevPage');
            const next = document.getElementById('guardiansNextPage');
            const from = (meta.page - 1) * meta.per_page + 1;
            const to = Math.min(meta.page * meta.per_page, meta.total);
            info.textContent = meta.total ? `Afișate ${from}-${to} din ${meta.total}` : 'Nu există rezultate';
            pageLabel.textContent = `Pagina ${meta.page} / ${meta.total_pages || 1}`;
            prev.disabled = meta.page <= 1;
            next.disabled = meta.page >= (meta.total_pages || 1);

            document.querySelectorAll('.sort-ind').forEach(el => {
                const col = el.getAttribute('data-col');
                el.textContent = col === guardiansState.sort_by ? (guardiansState.sort_dir === 'asc' ? '▲' : '▼') : '';
            });
        }

        // Bind controls
        const perPageEl = document.getElementById('guardiansPerPage');
        if (perPageEl) {
            perPageEl.addEventListener('change', (e) => {
                guardiansState.per_page = parseInt(e.target.value, 10);
                guardiansState.page = 1;
                fetchGuardians();
            });
        }

        let guardiansSearchDebounce;
        const searchEl = document.getElementById('guardiansSearchInput');
        if (searchEl) {
            searchEl.addEventListener('input', (e) => {
                const v = e.target.value.trim();
                if (guardiansSearchDebounce) clearTimeout(guardiansSearchDebounce);
                guardiansSearchDebounce = setTimeout(() => {
                    guardiansState.search = v;
                    guardiansState.page = 1;
                    fetchGuardians();
                }, 300);
            });
        }

        const prevBtn = document.getElementById('guardiansPrevPage');
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                if (guardiansState.page > 1) {
                    guardiansState.page--;
                    fetchGuardians();
                }
            });
        }

        const nextBtn = document.getElementById('guardiansNextPage');
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                guardiansState.page++;
                fetchGuardians();
            });
        }

        // Sorting
        document.querySelectorAll('th[data-sort]').forEach(th => {
            th.addEventListener('click', () => {
                const sortBy = th.getAttribute('data-sort');
                if (guardiansState.sort_by === sortBy) {
                    guardiansState.sort_dir = guardiansState.sort_dir === 'asc' ? 'desc' : 'asc';
                } else {
                    guardiansState.sort_by = sortBy;
                    guardiansState.sort_dir = 'asc';
                }
                fetchGuardians();
            });
        });

        // Initial load
        fetchGuardians();

        @if(Auth::user()->isSuperAdmin() || Auth::user()->isCompanyAdmin())
        // Modal functionality
        const modal = document.getElementById('add-guardian-modal');
        const openBtn = document.getElementById('open-add-guardian-modal');
        const closeBtn = document.getElementById('close-add-guardian-modal');
        const cancelBtn = document.getElementById('cancel-add-guardian');
        const overlay = document.getElementById('add-guardian-overlay');
        const phoneInput = document.getElementById('phone');
        const notesTextarea = document.getElementById('notes');

        function openModal() { if (modal) modal.classList.remove('hidden'); }
        function closeModal() { if (modal) modal.classList.add('hidden'); }

        if (openBtn) openBtn.addEventListener('click', openModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
        if (overlay) overlay.addEventListener('click', closeModal);

        // Open via query param ?open=add-guardian
        const params = new URLSearchParams(window.location.search);
        if (params.get('open') === 'add-guardian') {
            openModal();
        }

        // Auto-open if validation errors exist
        @if ($errors->any())
            openModal();
        @endif

        // Phone number formatting
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    if (value.startsWith('0')) {
                        value = value.substring(0, 10);
                    } else {
                        value = '0' + value.substring(0, 9);
                    }
                }
                e.target.value = value;
            });
        }

        // Character counter for notes
        const maxLength = 1000;
        if (notesTextarea) {
            notesTextarea.addEventListener('input', function() {
                const remaining = maxLength - this.value.length;
                const counter = document.getElementById('notes-counter') || createCounter();
                counter.textContent = `${remaining} caractere rămase`;
                if (remaining < 50) {
                    counter.className = 'mt-1 text-sm text-red-500';
                } else {
                    counter.className = 'mt-1 text-sm text-gray-500';
                }
            });
        }

        function createCounter() {
            const counter = document.createElement('p');
            counter.id = 'notes-counter';
            counter.className = 'mt-1 text-sm text-gray-500';
            notesTextarea.parentNode.appendChild(counter);
            return counter;
        }
        @endif
    })();
</script>
@endsection

