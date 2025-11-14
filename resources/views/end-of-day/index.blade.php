@extends('layouts.app')

@section('title', 'Final de Zi')
@section('page-title', 'Final de Zi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Final de Zi 📊</h1>
                <p class="text-gray-600 text-lg">Statistici și rapoarte pentru ziua de astăzi</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Sesiuni</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalSessions }}</p>
                    <p class="text-xs text-gray-500 mt-1">Astăzi</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-stopwatch text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Sesiuni Birthday</p>
                    <p class="text-3xl font-bold text-pink-600">{{ $birthdaySessions }}</p>
                    <p class="text-xs text-gray-500 mt-1">Din total</p>
                </div>
                <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-birthday-cake text-pink-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Bani</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ number_format($totalMoney, 2, '.', '') }} RON</p>
                    <p class="text-xs text-gray-500 mt-1">Încasări astăzi</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-emerald-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Rapoarte</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <button id="print-z-report-btn" 
                    class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-6 py-4 rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 font-medium flex items-center justify-center shadow-md">
                <i class="fas fa-file-alt mr-2"></i>
                Raport Z
            </button>
            
            <button id="print-non-fiscal-btn" 
                    class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-4 rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium flex items-center justify-center shadow-md">
                <i class="fas fa-print mr-2"></i>
                Raport Nefiscal
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Print Z Report button
    const printZReportBtn = document.getElementById('print-z-report-btn');
    if (printZReportBtn) {
        printZReportBtn.addEventListener('click', async function() {
            const originalBtnText = printZReportBtn.innerHTML;
            printZReportBtn.disabled = true;
            printZReportBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Se procesează...';

            try {
                const response = await fetch('{{ route("end-of-day.print-z") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Eroare la generarea raportului Z');
                }

                const data = await response.json();

                if (data.success) {
                    const fileInfo = data.file ? `\nFișier: ${data.file}` : '';
                    alert((data.message || 'Raportul Z a fost generat cu succes') + fileInfo);
                } else {
                    alert('Eroare: ' + (data.message || 'Eroare necunoscută'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Eroare la procesarea raportului Z: ' + error.message);
            } finally {
                printZReportBtn.disabled = false;
                printZReportBtn.innerHTML = originalBtnText;
            }
        });
    }

    // Print Non-Fiscal Report button
    const printNonFiscalBtn = document.getElementById('print-non-fiscal-btn');
    if (printNonFiscalBtn) {
        printNonFiscalBtn.addEventListener('click', function() {
            // Open print page in new window
            const printUrl = '{{ route("end-of-day.print-non-fiscal") }}';
            window.open(printUrl, '_blank', 'width=400,height=600');
        });
    }
});
</script>
@endsection

