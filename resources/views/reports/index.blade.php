@extends('layouts.app')

@section('title', 'Rapoarte')
@section('page-title', 'Rapoarte')

@section('content')
<div class="space-y-6">
    <!-- Global Date Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 card-hover sticky top-4 z-10">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-end md:space-x-3 space-y-3 md:space-y-0">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Data start</label>
                    <input type="date" id="reportStart" class="px-3 py-2 border border-gray-300 rounded-md" />
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Data stop</label>
                    <input type="date" id="reportEnd" class="px-3 py-2 border border-gray-300 rounded-md" />
                </div>
                <div class="md:flex-1">
                    <label class="block text-sm text-gray-600 mb-1">Zile săptămână</label>
                    <div class="flex flex-wrap gap-2">
                        <label class="flex items-center px-3 py-1.5 bg-gray-50 rounded-md cursor-pointer hover:bg-gray-100 border border-gray-300">
                            <input type="checkbox" name="weekdays" value="1" class="mr-2" checked>
                            <span class="text-sm">Luni</span>
                        </label>
                        <label class="flex items-center px-3 py-1.5 bg-gray-50 rounded-md cursor-pointer hover:bg-gray-100 border border-gray-300">
                            <input type="checkbox" name="weekdays" value="2" class="mr-2" checked>
                            <span class="text-sm">Marți</span>
                        </label>
                        <label class="flex items-center px-3 py-1.5 bg-gray-50 rounded-md cursor-pointer hover:bg-gray-100 border border-gray-300">
                            <input type="checkbox" name="weekdays" value="3" class="mr-2" checked>
                            <span class="text-sm">Miercuri</span>
                        </label>
                        <label class="flex items-center px-3 py-1.5 bg-gray-50 rounded-md cursor-pointer hover:bg-gray-100 border border-gray-300">
                            <input type="checkbox" name="weekdays" value="4" class="mr-2" checked>
                            <span class="text-sm">Joi</span>
                        </label>
                        <label class="flex items-center px-3 py-1.5 bg-gray-50 rounded-md cursor-pointer hover:bg-gray-100 border border-gray-300">
                            <input type="checkbox" name="weekdays" value="5" class="mr-2" checked>
                            <span class="text-sm">Vineri</span>
                        </label>
                        <label class="flex items-center px-3 py-1.5 bg-gray-50 rounded-md cursor-pointer hover:bg-gray-100 border border-gray-300">
                            <input type="checkbox" name="weekdays" value="6" class="mr-2" checked>
                            <span class="text-sm">Sâmbătă</span>
                        </label>
                        <label class="flex items-center px-3 py-1.5 bg-gray-50 rounded-md cursor-pointer hover:bg-gray-100 border border-gray-300">
                            <input type="checkbox" name="weekdays" value="0" class="mr-2" checked>
                            <span class="text-sm">Duminică</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Selectează zilele săptămânii pentru filtrare</p>
                </div>
                <div>
                    <label class="block text-sm text-transparent mb-1">&nbsp;</label>
                    <button id="reloadReports" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Reîncarcă</button>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 card-hover">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-chart-pie text-indigo-600"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Rapoarte</h2>
            </div>
        </div>
        <div class="p-6">
            <div id="reports" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gray-50 rounded p-4 text-center">
                    <div class="text-sm text-gray-600">% sesiuni < 1h</div>
                    <div id="bucket_lt1h" class="text-2xl font-bold">-</div>
                </div>
                <div class="bg-gray-50 rounded p-4 text-center">
                    <div class="text-sm text-gray-600">% sesiuni 1-2h</div>
                    <div id="bucket_1_2" class="text-2xl font-bold">-</div>
                </div>
                <div class="bg-gray-50 rounded p-4 text-center">
                    <div class="text-sm text-gray-600">% sesiuni 2-3h</div>
                    <div id="bucket_2_3" class="text-2xl font-bold">-</div>
                </div>
                <div class="bg-gray-50 rounded p-4 text-center">
                    <div class="text-sm text-gray-600">% sesiuni > 3h</div>
                    <div id="bucket_gt3h" class="text-2xl font-bold">-</div>
                </div>
            </div>
            <div class="mt-4 bg-gray-50 rounded p-4 text-center">
                <div class="text-sm text-gray-600">Vârsta medie a copiilor</div>
                <div id="avg_age" class="text-2xl font-bold">-</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 card-hover">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-chart-bar text-emerald-600"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Trafic pe Ore</h2>
            </div>
        </div>
        <div class="p-6">
            <div class="w-full">
                <canvas id="hourlyTrafficChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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

    function getDateParam(dateInput) {
        const v = dateInput.value;
        if (!v) return null;
        return v;
    }

    async function loadReports() {
        try {
            const start = getDateParam(document.getElementById('reportStart'));
            const end = getDateParam(document.getElementById('reportEnd'));
            
            // Get selected weekdays
            const weekdayCheckboxes = document.querySelectorAll('input[name="weekdays"]:checked');
            const selectedWeekdays = Array.from(weekdayCheckboxes).map(cb => parseInt(cb.value));
            
            const qs = new URLSearchParams();
            if (start) qs.append('start', start);
            if (end) qs.append('end', end);
            // Only add weekdays filter if at least one is selected and not all are selected
            if (selectedWeekdays.length > 0 && selectedWeekdays.length < 7) {
                selectedWeekdays.forEach(day => qs.append('weekdays[]', day));
            }

            const reportsData = await apiCall('/reports-api/reports' + (qs.toString() ? ('?' + qs.toString()) : ''));
            const setReports = (r) => {
                document.getElementById('bucket_lt1h').textContent = (r.buckets_today.lt_1h.percent || 0) + '%';
                document.getElementById('bucket_1_2').textContent = (r.buckets_today.h1_2.percent || 0) + '%';
                document.getElementById('bucket_2_3').textContent = (r.buckets_today.h2_3.percent || 0) + '%';
                document.getElementById('bucket_gt3h').textContent = (r.buckets_today.gt_3h.percent || 0) + '%';
                
                // Format age as "X ani și Y luni"
                const years = r.avg_child_age_years || 0;
                const months = r.avg_child_age_months || 0;
                let ageText = '';
                if (years > 0 && months > 0) {
                    ageText = years + ' ani și ' + months + ' luni';
                } else if (years > 0) {
                    ageText = years + ' ani';
                } else if (months > 0) {
                    ageText = months + ' luni';
                } else {
                    ageText = '0 ani';
                }
                document.getElementById('avg_age').textContent = ageText;
                
                renderHourlyTrafficChart(r.hourly_traffic || Array(24).fill(0));
            };
            if (reportsData.success) {
                setReports(reportsData.reports);
            } else {
                setReports({
                    buckets_today: { lt_1h: { percent: 0 }, h1_2: { percent: 0 }, h2_3: { percent: 0 }, gt_3h: { percent: 0 } },
                    avg_child_age_years: 0,
                    avg_child_age_months: 0,
                    hourly_traffic: Array(24).fill(0)
                });
            }
        } catch (e) {
            console.error(e);
        }
    }

    let hourlyTrafficChart;
    function renderHourlyTrafficChart(hourlyData) {
        const ctx = document.getElementById('hourlyTrafficChart').getContext('2d');
        
        // Create labels for hour intervals (0-1, 1-2, ..., 23-0)
        const labels = [];
        for (let i = 0; i < 24; i++) {
            const nextHour = (i + 1) % 24;
            labels.push(`${i}-${nextHour}`);
        }
        
        const data = {
            labels: labels,
            datasets: [{
                label: 'Număr sesiuni',
                data: hourlyData,
                backgroundColor: 'rgba(99, 102, 241, 0.8)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        };
        
        if (hourlyTrafficChart) {
            hourlyTrafficChart.data = data;
            hourlyTrafficChart.update();
        } else {
            hourlyTrafficChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    return 'Interval: ' + context[0].label;
                                },
                                label: function(context) {
                                    return 'Sesiuni: ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            },
                            title: {
                                display: true,
                                text: 'Număr sesiuni'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Interval orar'
                            },
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    }
                }
            });
        }
    }

    // Prefill inputs with today range
    (function initDateDefaults(){
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth()+1).padStart(2,'0');
        const dd = String(today.getDate()).padStart(2,'0');
        const iso = `${yyyy}-${mm}-${dd}`;
        const s = document.getElementById('reportStart');
        const e = document.getElementById('reportEnd');
        if (s && !s.value) s.value = iso;
        if (e && !e.value) e.value = iso;
    })();

    document.getElementById('reloadReports').addEventListener('click', function(){
        loadReports();
    });

    loadReports();
</script>
@endsection


