<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Pre-Checkin – {{ $tenant->name }}</title>
    @vite(['resources/css/app.css'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <header class="bg-white border-b border-gray-200 px-4 py-4 flex items-center gap-3">
        <div class="w-9 h-9 bg-sky-600 rounded-lg flex items-center justify-center flex-shrink-0">
            <i class="fas fa-child text-white text-sm"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500 leading-none">Pre-Checkin</p>
            <p class="font-bold text-gray-900 leading-tight">{{ $tenant->name }}</p>
        </div>
    </header>

    <main class="flex-1 flex flex-col items-center justify-center px-4 py-8">
        <div class="w-full max-w-sm">

            @if($error)
            {{-- Error state --}}
            <div class="bg-white rounded-2xl shadow-sm border border-red-200 p-8 text-center space-y-4">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto">
                    <i class="fas fa-times text-red-500 text-2xl"></i>
                </div>
                <p class="font-semibold text-gray-900">QR Code invalid</p>
                <p class="text-sm text-gray-500">{{ $error }}</p>
                <a href="{{ url('/pre-checkin/' . $tenant->slug) }}"
                    class="block w-full h-11 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-left"></i> Generează QR nou
                </a>
            </div>

            @else
            {{-- Valid QR state --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 text-center space-y-5">

                {{-- Countdown --}}
                <div id="countdownBar" class="space-y-1">
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span>QR valid încă</span>
                        <span id="countdownText" class="font-semibold text-sky-700"></span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div id="countdownProgress" class="bg-sky-500 h-1.5 rounded-full transition-all duration-1000"></div>
                    </div>
                </div>

                {{-- QR Code --}}
                <div class="flex justify-center">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($preCheckin->token) }}"
                         alt="QR Code"
                         class="rounded-xl border border-gray-200 w-[220px] h-[220px]">
                </div>

                {{-- Token text (for manual entry) --}}
                <div class="bg-gray-50 rounded-xl px-4 py-3">
                    <p class="text-xs text-gray-500 mb-1">Cod QR</p>
                    <p class="text-2xl font-mono font-bold tracking-widest text-gray-900">
                        {{ $preCheckin->token }}
                    </p>
                </div>

                {{-- Child & Guardian info --}}
                <div class="text-left space-y-2 border-t border-gray-100 pt-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Copil</span>
                        <span class="font-semibold text-gray-900">{{ $preCheckin->child->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Părinte</span>
                        <span class="font-medium text-gray-700">{{ $preCheckin->guardian->name }}</span>
                    </div>
                </div>

                {{-- Instructions --}}
                <div class="bg-sky-50 rounded-xl p-4 text-left">
                    <p class="text-xs font-semibold text-sky-800 mb-2">
                        <i class="fas fa-info-circle mr-1"></i> Cum funcționează
                    </p>
                    <ol class="text-xs text-sky-700 space-y-1 list-decimal list-inside">
                        <li>Arată acest QR code la recepție</li>
                        <li>Staff-ul scanează codul</li>
                        <li>Sesiunea pornește instant</li>
                    </ol>
                </div>

                {{-- Expired state (shown by JS when timer hits 0) --}}
                <div id="expiredNotice" class="hidden bg-red-50 rounded-xl p-4 border border-red-200">
                    <p class="text-sm font-semibold text-red-700">
                        <i class="fas fa-clock mr-1"></i> QR Code expirat
                    </p>
                    <p class="text-xs text-red-600 mt-1">Generează unul nou apăsând butonul de mai jos.</p>
                </div>

                <a href="{{ url('/pre-checkin/' . $tenant->slug) }}"
                    class="block w-full h-11 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-xl transition flex items-center justify-center gap-2 text-sm">
                    <i class="fas fa-redo text-xs"></i> Generează QR nou
                </a>
            </div>
            @endif

        </div>
    </main>

@if(!$error)
<script>
const TOKEN = '{{ $preCheckin->token }}';
const EXPIRES_AT = new Date('{{ $preCheckin->expires_at->toISOString() }}');
const TOTAL_SECONDS = {{ $preCheckin->secondsUntilExpiry() }};

// Countdown
const countdownText = document.getElementById('countdownText');
const countdownProgress = document.getElementById('countdownProgress');
const expiredNotice = document.getElementById('expiredNotice');
const countdownBar = document.getElementById('countdownBar');
const qrCanvas = document.getElementById('qrCanvas');

function updateCountdown() {
    const now = new Date();
    const diff = Math.max(0, Math.floor((EXPIRES_AT - now) / 1000));
    const mins = Math.floor(diff / 60);
    const secs = diff % 60;

    countdownText.textContent = mins + ':' + String(secs).padStart(2, '0');

    const pct = TOTAL_SECONDS > 0 ? (diff / TOTAL_SECONDS) * 100 : 0;
    countdownProgress.style.width = pct + '%';

    // Warn when < 5 minutes
    if (diff < 300) {
        countdownProgress.classList.replace('bg-sky-500', 'bg-amber-500');
        countdownText.classList.replace('text-sky-700', 'text-amber-700');
    }
    // Expired
    if (diff === 0) {
        countdownBar.classList.add('hidden');
        expiredNotice.classList.remove('hidden');
        qrCanvas.classList.add('opacity-20');
        clearInterval(timer);
    }
}

updateCountdown();
const timer = setInterval(updateCountdown, 1000);
</script>
@endif
</body>
</html>
