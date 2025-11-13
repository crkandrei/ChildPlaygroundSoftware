@extends('layouts.app')

@section('title', 'Probleme - Anomalii')
@section('page-title', 'Probleme - Anomalii')

@section('content')
<div class="space-y-6">
    <!-- Header with Scan Button -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Detectare Anomalii</h2>
                    <p class="text-sm text-gray-600 mt-1">Scanare pentru ultimele 7 zile</p>
                </div>
            </div>
            <button id="scanButton" 
                    class="px-6 py-3 bg-sky-600 text-white rounded-lg font-medium hover:bg-sky-700 transition-colors flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fas fa-search" id="scanIcon"></i>
                <span id="scanText">Scanează Anomalii</span>
            </button>
        </div>
    </div>

    <!-- Anomalies Grid -->
    <div id="anomaliesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Widgets will be populated here -->
        <div class="col-span-full text-center py-12 text-gray-500">
            <i class="fas fa-info-circle text-4xl mb-4"></i>
            <p class="text-lg">Apasă butonul "Scanează Anomalii" pentru a detecta problemele din ultimele 7 zile</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const anomalyLabels = {
        'sesiuni_peste_5_ore': 'Sesiuni de peste 5 ore',
        'sesiuni_active_prea_vechi': 'Sesiuni active prea vechi',
        'sesiuni_pret_zero_negativ': 'Sesiuni cu preț zero sau negativ',
        'sesiuni_date_invalide': 'Sesiuni cu date invalide',
        'sesiuni_pret_necalculat': 'Sesiuni cu preț necalculat',
        'sesiuni_foarte_scurte': 'Sesiuni foarte scurte',
        'sesiuni_prea_multe_pauze': 'Sesiuni cu prea multe pauze',
        'sesiuni_intervale_deschise': 'Sesiuni cu intervale deschise',
        'sesiuni_multiple_active_copil': 'Sesiuni multiple active pentru același copil',
        'sesiuni_cod_bratara_invalid': 'Sesiuni cu cod brățară invalid',
        'sesiuni_discrepante_pret': 'Sesiuni cu discrepanțe de preț'
    };

    const anomalyIcons = {
        'sesiuni_peste_5_ore': 'fa-clock',
        'sesiuni_active_prea_vechi': 'fa-hourglass-half',
        'sesiuni_pret_zero_negativ': 'fa-dollar-sign',
        'sesiuni_date_invalide': 'fa-calendar-times',
        'sesiuni_pret_necalculat': 'fa-calculator',
        'sesiuni_foarte_scurte': 'fa-stopwatch',
        'sesiuni_prea_multe_pauze': 'fa-pause-circle',
        'sesiuni_intervale_deschise': 'fa-unlock',
        'sesiuni_multiple_active_copil': 'fa-users',
        'sesiuni_cod_bratara_invalid': 'fa-barcode',
        'sesiuni_discrepante_pret': 'fa-money-bill-wave'
    };

    const anomalyColors = {
        'sesiuni_peste_5_ore': { bg: 'bg-yellow-100', text: 'text-yellow-600', icon: 'text-yellow-600' },
        'sesiuni_active_prea_vechi': { bg: 'bg-orange-100', text: 'text-orange-600', icon: 'text-orange-600' },
        'sesiuni_pret_zero_negativ': { bg: 'bg-red-100', text: 'text-red-600', icon: 'text-red-600' },
        'sesiuni_date_invalide': { bg: 'bg-red-100', text: 'text-red-600', icon: 'text-red-600' },
        'sesiuni_pret_necalculat': { bg: 'bg-amber-100', text: 'text-amber-600', icon: 'text-amber-600' },
        'sesiuni_foarte_scurte': { bg: 'bg-blue-100', text: 'text-blue-600', icon: 'text-blue-600' },
        'sesiuni_prea_multe_pauze': { bg: 'bg-purple-100', text: 'text-purple-600', icon: 'text-purple-600' },
        'sesiuni_intervale_deschise': { bg: 'bg-pink-100', text: 'text-pink-600', icon: 'text-pink-600' },
        'sesiuni_multiple_active_copil': { bg: 'bg-indigo-100', text: 'text-indigo-600', icon: 'text-indigo-600' },
        'sesiuni_cod_bratara_invalid': { bg: 'bg-gray-100', text: 'text-gray-600', icon: 'text-gray-600' },
        'sesiuni_discrepante_pret': { bg: 'bg-green-100', text: 'text-green-600', icon: 'text-green-600' }
    };

    function renderAnomalies(data) {
        const grid = document.getElementById('anomaliesGrid');
        
        if (!data || Object.keys(data).length === 0) {
            grid.innerHTML = `
                <div class="col-span-full text-center py-12 text-gray-500">
                    <i class="fas fa-check-circle text-4xl mb-4 text-green-500"></i>
                    <p class="text-lg font-medium">Nu s-au găsit anomalii!</p>
                    <p class="text-sm mt-2">Toate sesiunile din ultimele 7 zile par să fie în regulă.</p>
                </div>
            `;
            return;
        }

        const widgets = Object.entries(data).map(([key, count]) => {
            const label = anomalyLabels[key] || key;
            const icon = anomalyIcons[key] || 'fa-exclamation-triangle';
            const colors = anomalyColors[key] || { bg: 'bg-gray-100', text: 'text-gray-600', icon: 'text-gray-600' };
            
            return `
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 mb-1">${label}</p>
                            <p class="text-3xl font-bold ${colors.text}">${count}</p>
                        </div>
                        <div class="w-12 h-12 ${colors.bg} rounded-xl flex items-center justify-center">
                            <i class="fas ${icon} ${colors.icon} text-xl"></i>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        grid.innerHTML = widgets;
    }

    document.getElementById('scanButton').addEventListener('click', function() {
        const button = this;
        const icon = document.getElementById('scanIcon');
        const text = document.getElementById('scanText');
        const grid = document.getElementById('anomaliesGrid');

        // Disable button and show loading
        button.disabled = true;
        icon.className = 'fas fa-spinner fa-spin';
        text.textContent = 'Se scanează...';
        grid.innerHTML = `
            <div class="col-span-full text-center py-12">
                <i class="fas fa-spinner fa-spin text-4xl text-sky-600 mb-4"></i>
                <p class="text-lg text-gray-600">Se scanează baza de date...</p>
            </div>
        `;

        // Make request
        fetch('/anomalies/scan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                renderAnomalies(data.data);
            } else {
                grid.innerHTML = `
                    <div class="col-span-full text-center py-12 text-red-500">
                        <i class="fas fa-exclamation-circle text-4xl mb-4"></i>
                        <p class="text-lg font-medium">Eroare la scanare</p>
                        <p class="text-sm mt-2">${data.message || 'Eroare necunoscută'}</p>
                    </div>
                `;
            }
        })
        .catch(err => {
            console.error('Error:', err);
            grid.innerHTML = `
                <div class="col-span-full text-center py-12 text-red-500">
                    <i class="fas fa-exclamation-circle text-4xl mb-4"></i>
                    <p class="text-lg font-medium">Eroare la scanare</p>
                    <p class="text-sm mt-2">A apărut o eroare. Te rugăm să încerci din nou.</p>
                </div>
            `;
        })
        .finally(() => {
            // Re-enable button
            button.disabled = false;
            icon.className = 'fas fa-search';
            text.textContent = 'Scanează Anomalii';
        });
    });
</script>
@endsection

