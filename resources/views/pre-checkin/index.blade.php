<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre-Checkin – {{ $tenant->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-white border-b border-gray-200 px-4 py-4 flex items-center gap-3">
        <div class="w-9 h-9 bg-sky-600 rounded-lg flex items-center justify-center flex-shrink-0">
            <i class="fas fa-child text-white text-sm"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500 leading-none">Pre-Checkin</p>
            <p class="font-bold text-gray-900 leading-tight">{{ $tenant->name }}</p>
        </div>
    </header>

    <main class="flex-1 flex flex-col items-center px-4 py-8">
        <div class="w-full max-w-md space-y-6">

            {{-- ==================== STEP 1: Telefon ==================== --}}
            <div id="stepPhone">
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Bun venit!</h1>
                <p class="text-gray-500 mb-6">Introdu numărul tău de telefon pentru a continua.</p>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <div>
                        <label for="phoneInput" class="block text-sm font-medium text-gray-700 mb-1">
                            Număr de telefon
                        </label>
                        <input id="phoneInput" type="tel" autocomplete="tel" placeholder="07xx xxx xxx"
                            class="w-full h-12 px-4 text-lg border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    </div>

                    <div id="phoneError" class="hidden text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </div>

                    <button id="phoneContinueBtn"
                        class="w-full h-12 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-xl transition flex items-center justify-center gap-2">
                        <span>Continuă</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            {{-- ==================== STEP 2A: Client NOU ==================== --}}
            <div id="stepRegister" class="hidden">
                <button id="backToPhoneBtn" class="text-sm text-sky-600 hover:text-sky-800 flex items-center gap-1 mb-4">
                    <i class="fas fa-arrow-left text-xs"></i> Înapoi
                </button>

                <h2 class="text-xl font-bold text-gray-900 mb-1">Înregistrare</h2>
                <p class="text-gray-500 mb-6">Completează datele tale și ale copilului.</p>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-5">
                    {{-- Honeypot --}}
                    <input type="text" id="website" name="website" class="hidden" tabindex="-1" autocomplete="off">

                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Datele tale (părinte/tutore)</p>
                        <hr class="border-gray-100">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="guardianFirstName" class="block text-sm font-medium text-gray-700 mb-1">Prenume</label>
                            <input id="guardianFirstName" type="text" autocomplete="given-name" placeholder="Ion"
                                class="uppercase-input w-full h-11 px-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                        <div>
                            <label for="guardianLastName" class="block text-sm font-medium text-gray-700 mb-1">Nume</label>
                            <input id="guardianLastName" type="text" autocomplete="family-name" placeholder="Popescu"
                                class="uppercase-input w-full h-11 px-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telefon</label>
                        <input id="regPhone" type="tel" readonly
                            class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-gray-600 cursor-not-allowed">
                    </div>

                    <div class="space-y-1 pt-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Datele copilului</p>
                        <hr class="border-gray-100">
                    </div>

                    <div>
                        <label for="childName" class="block text-sm font-medium text-gray-700 mb-1">Prenumele copilului</label>
                        <input id="childName" type="text" placeholder="Maria"
                            class="uppercase-input w-full h-11 px-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>

                    {{-- Terms & GDPR --}}
                    <div class="space-y-3 pt-1">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input id="termsCheck" type="checkbox" class="mt-0.5 w-5 h-5 text-sky-600 border-gray-300 rounded focus:ring-sky-500 flex-shrink-0">
                            <span class="text-sm text-gray-600">
                                Am citit și accept
                                <a href="{{ route('legal.terms.public') }}" target="_blank" class="text-sky-600 underline">Termenii și Condițiile</a>
                            </span>
                        </label>
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input id="gdprCheck" type="checkbox" class="mt-0.5 w-5 h-5 text-sky-600 border-gray-300 rounded focus:ring-sky-500 flex-shrink-0">
                            <span class="text-sm text-gray-600">
                                Am citit și accept
                                <a href="{{ route('legal.gdpr.public') }}" target="_blank" class="text-sky-600 underline">Politica de Confidențialitate (GDPR)</a>
                            </span>
                        </label>
                    </div>

                    <div id="registerError" class="hidden text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </div>

                    <button id="registerBtn"
                        class="w-full h-12 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-xl transition flex items-center justify-center gap-2">
                        <i class="fas fa-qrcode"></i>
                        <span>Generează QR Code</span>
                    </button>
                </div>
            </div>

            {{-- ==================== STEP 2B: Client EXISTENT ==================== --}}
            <div id="stepExisting" class="hidden">
                <button id="backToPhoneBtn2" class="text-sm text-sky-600 hover:text-sky-800 flex items-center gap-1 mb-4">
                    <i class="fas fa-arrow-left text-xs"></i> Înapoi
                </button>

                <h2 class="text-xl font-bold text-gray-900 mb-1">Bun venit înapoi!</h2>
                <p id="existingGreeting" class="text-gray-500 mb-6"></p>

                {{-- Children list --}}
                <div id="childrenBlock" class="hidden space-y-3">
                    <p class="text-sm font-medium text-gray-700">Alege copilul pentru care vii:</p>
                    <div id="childrenList" class="space-y-2"></div>

                    {{-- Add new child --}}
                    <button id="showAddChildBtn"
                        class="w-full h-11 border-2 border-dashed border-gray-300 hover:border-sky-400 text-gray-500 hover:text-sky-600 rounded-xl transition text-sm font-medium flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i> Adaugă un copil nou
                    </button>
                </div>

                {{-- Add child form (initially hidden) --}}
                <div id="addChildForm" class="hidden bg-white rounded-2xl shadow-sm border border-gray-200 p-5 space-y-4 mt-4">
                    <p class="text-sm font-semibold text-gray-700">Date copil nou:</p>
                    <div>
                        <label for="newChildName" class="block text-sm font-medium text-gray-700 mb-1">Prenumele copilului</label>
                        <input id="newChildName" type="text" placeholder="Prenume"
                            class="uppercase-input w-full h-11 px-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                    <div id="addChildError" class="hidden text-sm text-red-600"></div>
                    <div class="flex gap-3">
                        <button id="cancelAddChildBtn"
                            class="flex-1 h-11 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition text-sm font-medium">
                            Anulează
                        </button>
                        <button id="saveAddChildBtn"
                            class="flex-1 h-11 bg-sky-600 hover:bg-sky-700 text-white rounded-xl transition text-sm font-semibold flex items-center justify-center gap-2">
                            <i class="fas fa-plus"></i> Adaugă
                        </button>
                    </div>
                </div>

                <div id="existingError" class="hidden text-sm text-red-600 mt-3 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i>
                    <span></span>
                </div>
            </div>

        </div>
    </main>

    {{-- ==================== QR Bottom Sheet ==================== --}}
    <div id="qrSheet" class="hidden fixed inset-0 z-50 flex flex-col justify-end">
        {{-- Backdrop --}}
        <div id="qrBackdrop" class="absolute inset-0 bg-black/60 transition-opacity duration-300"></div>

        {{-- Sheet --}}
        <div class="relative bg-white rounded-t-3xl shadow-2xl max-h-[92vh] overflow-y-auto transform transition-transform duration-300 translate-y-full" id="qrSheetPanel">
            {{-- Handle --}}
            <div class="flex justify-center pt-3 pb-1">
                <div class="w-10 h-1.5 bg-gray-300 rounded-full"></div>
            </div>

            <div class="px-6 pb-8 space-y-5">
                {{-- Header (always visible) --}}
                <div class="flex items-center justify-between pt-2">
                    <div>
                        <p id="qrSheetChildName" class="font-bold text-gray-900 text-xl leading-tight"></p>
                        <p id="qrSheetGuardianName" class="text-sm text-gray-500 mt-0.5"></p>
                    </div>
                    <button id="closeQrSheetX"
                        class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition flex-shrink-0 ml-4">
                        <i class="fas fa-times text-gray-600"></i>
                    </button>
                </div>

                {{-- ── PANOUL TERMENI (shown when needs_terms) ── --}}
                <div id="sheetTermsPanel" class="hidden space-y-4">
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                        <p class="text-sm font-semibold text-amber-800">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Termenii au fost actualizați
                        </p>
                        <p class="text-xs text-amber-700 mt-1">Te rugăm să îi accepți pentru a genera QR-ul.</p>
                    </div>

                    <label class="flex items-start gap-3 cursor-pointer bg-white border border-gray-200 rounded-xl p-4">
                        <input id="sheetTermsCheck" type="checkbox"
                            class="mt-0.5 w-5 h-5 text-sky-600 border-gray-300 rounded focus:ring-sky-500 flex-shrink-0">
                        <span class="text-sm text-gray-700">
                            Am citit și accept
                            <a href="{{ route('legal.terms.public') }}" target="_blank" class="text-sky-600 underline font-medium">Termenii și Condițiile</a>
                            <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <label class="flex items-start gap-3 cursor-pointer bg-white border border-gray-200 rounded-xl p-4">
                        <input id="sheetGdprCheck" type="checkbox"
                            class="mt-0.5 w-5 h-5 text-sky-600 border-gray-300 rounded focus:ring-sky-500 flex-shrink-0">
                        <span class="text-sm text-gray-700">
                            Am citit și accept
                            <a href="{{ route('legal.gdpr.public') }}" target="_blank" class="text-sky-600 underline font-medium">Politica de Confidențialitate (GDPR)</a>
                            <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <div id="sheetTermsError" class="hidden text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i><span></span>
                    </div>

                    <button id="sheetAcceptBtn"
                        class="w-full h-12 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-2xl transition flex items-center justify-center gap-2">
                        <i class="fas fa-check"></i> Acceptă și generează QR
                    </button>

                    <button id="closeQrSheetBtnTerms"
                        class="w-full h-11 border-2 border-gray-200 hover:bg-gray-50 text-gray-600 font-medium rounded-2xl transition flex items-center justify-center gap-2 text-sm">
                        <i class="fas fa-arrow-left text-xs"></i> Înapoi la copii
                    </button>
                </div>

                {{-- ── PANOUL QR ── --}}
                <div id="sheetQrPanel" class="hidden space-y-5">
                    {{-- Countdown --}}
                    <div id="sheetCountdownBar" class="space-y-1">
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>QR valid încă</span>
                            <span id="sheetCountdownText" class="font-semibold text-sky-700"></span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                            <div id="sheetCountdownProgress" class="bg-sky-500 h-1.5 rounded-full transition-all duration-1000"></div>
                        </div>
                    </div>

                    {{-- QR Code --}}
                    <div class="flex justify-center">
                        <img id="qrSheetImg" src="" alt="QR Code"
                            class="rounded-2xl border border-gray-200 w-[240px] h-[240px] shadow-sm">
                    </div>

                    {{-- Token --}}
                    <div class="bg-gray-50 rounded-2xl px-4 py-3 text-center">
                        <p class="text-xs text-gray-400 mb-1">Cod manual</p>
                        <p id="qrSheetToken" class="text-2xl font-mono font-bold tracking-widest text-gray-900"></p>
                    </div>

                    {{-- Expired notice --}}
                    <div id="sheetExpiredNotice" class="hidden bg-red-50 rounded-xl p-4 border border-red-200 text-center">
                        <p class="text-sm font-semibold text-red-700">
                            <i class="fas fa-clock mr-1"></i> QR Code expirat
                        </p>
                        <p class="text-xs text-red-600 mt-1">Apasă pe copil din nou pentru a genera unul nou.</p>
                    </div>

                    {{-- Instructions --}}
                    <div class="bg-sky-50 rounded-xl p-4">
                        <p class="text-xs font-semibold text-sky-800 mb-2">
                            <i class="fas fa-info-circle mr-1"></i> Cum funcționează
                        </p>
                        <ol class="text-xs text-sky-700 space-y-1 list-decimal list-inside">
                            <li>Arată acest QR code la recepție</li>
                            <li>Staff-ul scanează codul</li>
                            <li>Sesiunea pornește instant</li>
                        </ol>
                    </div>

                    {{-- Back button --}}
                    <button id="closeQrSheetBtn"
                        class="w-full h-12 border-2 border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold rounded-2xl transition flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left text-sm"></i> Înapoi la copii
                    </button>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center text-xs text-gray-400 py-4 px-4">
        Prin utilizarea acestui serviciu ești de acord cu
        <a href="{{ route('legal.terms.public') }}" class="underline">Termenii</a> și
        <a href="{{ route('legal.gdpr.public') }}" class="underline">Politica GDPR</a>.
    </footer>

<script>
const BASE_URL = '{{ url("/pre-checkin/" . $tenant->slug) }}';
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

let guardianId       = null;
let phone            = null;
let needsTerms       = false;
let pendingChild     = null; // { id, name } – child care așteaptă acceptarea termenilor
let guardianLastName = '';   // numele de familie al părintelui, pentru concatenare copil

function extractLastName(fullName) {
    const parts = fullName.trim().split(/\s+/);
    return parts.length > 1 ? parts[parts.length - 1] : fullName.trim();
}

function show(id) {
    ['stepPhone', 'stepRegister', 'stepExisting'].forEach(s => {
        document.getElementById(s).classList.add('hidden');
    });
    document.getElementById(id).classList.remove('hidden');
}

function setError(elId, msg) {
    const el = document.getElementById(elId);
    el.querySelector('span') ? el.querySelector('span').textContent = msg : el.textContent = msg;
    el.classList.remove('hidden');
}

function clearError(elId) {
    document.getElementById(elId).classList.add('hidden');
}

function setLoading(btn, loading) {
    btn.disabled = loading;
    btn.style.opacity = loading ? '0.6' : '';
}

async function post(url, data) {
    const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        body: JSON.stringify(data),
    });
    return res.json();
}

// ── STEP 1: Phone ────────────────────────────────────────────────────────────

document.getElementById('phoneContinueBtn').addEventListener('click', async function () {
    clearError('phoneError');
    phone = document.getElementById('phoneInput').value.trim();
    if (!phone) { setError('phoneError', 'Introdu numărul de telefon.'); return; }

    setLoading(this, true);
    try {
        const data = await post(BASE_URL + '/lookup', { phone });
        if (!data.success) { setError('phoneError', data.message || 'Eroare. Încearcă din nou.'); return; }

        if (!data.found) {
            // New client
            document.getElementById('regPhone').value = phone;
            show('stepRegister');
        } else {
            // Existing client
            guardianId       = data.guardian.id;
            needsTerms       = !!data.needs_terms;
            guardianLastName = extractLastName(data.guardian.name);
            document.getElementById('existingGreeting').textContent =
                'Bun venit, ' + data.guardian.name + '!';

            document.getElementById('childrenBlock').classList.remove('hidden');
            renderChildren(data.children);
            show('stepExisting');
        }
    } catch (e) {
        setError('phoneError', 'Eroare de rețea. Încearcă din nou.');
    } finally {
        setLoading(this, false);
    }
});

document.getElementById('phoneInput').addEventListener('keydown', e => {
    if (e.key === 'Enter') document.getElementById('phoneContinueBtn').click();
});

// Back buttons
['backToPhoneBtn', 'backToPhoneBtn2'].forEach(id => {
    document.getElementById(id).addEventListener('click', () => show('stepPhone'));
});

// ── STEP 2A: Register ────────────────────────────────────────────────────────

// Uppercase: toate literele mari indiferent ce scrie userul
document.querySelectorAll('.uppercase-input').forEach(input => {
    input.style.textTransform = 'uppercase';
    input.addEventListener('input', function () {
        const pos = this.selectionStart;
        this.value = this.value.toUpperCase();
        this.setSelectionRange(pos, pos);
    });
});

document.getElementById('registerBtn').addEventListener('click', async function () {
    clearError('registerError');

    const firstName = document.getElementById('guardianFirstName').value.trim();
    const lastName  = document.getElementById('guardianLastName').value.trim();
    const childName = document.getElementById('childName').value.trim();
    const terms     = document.getElementById('termsCheck').checked;
    const gdpr      = document.getElementById('gdprCheck').checked;
    const honeypot  = document.getElementById('website').value;

    if (!firstName) { setError('registerError', 'Introdu prenumele tău.'); return; }
    if (!lastName)  { setError('registerError', 'Introdu numele tău de familie.'); return; }
    if (!childName) { setError('registerError', 'Introdu prenumele copilului.'); return; }
    if (!terms || !gdpr) { setError('registerError', 'Trebuie să accepți termenii și politica GDPR.'); return; }

    const guardianName  = firstName + ' ' + lastName;
    const fullChildName = childName + ' ' + lastName.trim();

    setLoading(this, true);
    try {
        const data = await post(BASE_URL + '/register', {
            guardian_name: guardianName,
            phone,
            child_name: fullChildName,
            terms_accepted: terms ? '1' : '0',
            gdpr_accepted: gdpr ? '1' : '0',
            website: honeypot,
        });

        if (!data.success) { setError('registerError', data.message || 'Eroare. Încearcă din nou.'); return; }

        window.location.href = BASE_URL + '/qr/' + data.token;
    } catch (e) {
        setError('registerError', 'Eroare de rețea. Încearcă din nou.');
    } finally {
        setLoading(this, false);
    }
});

// ── STEP 2B: Existing ────────────────────────────────────────────────────────

function renderChildren(children) {
    const list = document.getElementById('childrenList');
    list.innerHTML = '';
    if (!children || children.length === 0) {
        list.innerHTML = '<p class="text-sm text-gray-500">Nu există copii înregistrați. Adaugă unul mai jos.</p>';
        return;
    }
    children.forEach(child => {
        const btn = document.createElement('button');
        btn.className = 'w-full flex items-center gap-4 bg-white border border-gray-200 hover:border-sky-400 hover:bg-sky-50 rounded-xl p-4 transition text-left';
        btn.innerHTML = `
            <div class="w-10 h-10 bg-sky-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-child text-sky-600"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-900">${child.name}</p>
                <p class="text-xs text-gray-400">Generează QR pentru această persoană</p>
            </div>
            <i class="fas fa-qrcode ml-auto text-gray-400"></i>
        `;
        btn.addEventListener('click', () => generateQrForChild(child.id, child.name));
        list.appendChild(btn);
    });
}

async function generateQrForChild(childId, childName) {
    clearError('existingError');

    // Dacă trebuie acceptați termenii, deschide sheet-ul în modul termeni
    if (needsTerms) {
        pendingChild = { id: childId, name: childName };
        openSheetTermsMode(childName);
        return;
    }

    try {
        const data = await post(BASE_URL + '/generate-qr', { guardian_id: guardianId, child_id: childId });
        if (!data.success) {
            if (data.needs_terms) {
                needsTerms = true;
                pendingChild = { id: childId, name: childName };
                openSheetTermsMode(childName);
            } else {
                setError('existingError', data.message || 'Eroare. Încearcă din nou.');
            }
            return;
        }
        openQrSheet(data.token, childName);
    } catch (e) {
        setError('existingError', 'Eroare de rețea. Încearcă din nou.');
    }
}

// ── QR Bottom Sheet ──────────────────────────────────────────────────────────
const QR_TTL_SECONDS = 30 * 60;
let sheetTimer = null;

function getGuardianName() {
    return document.getElementById('existingGreeting').textContent
        .replace('Bun venit, ', '').replace('!', '').trim();
}

function showSheetPanel(panelId) {
    ['sheetTermsPanel', 'sheetQrPanel'].forEach(id => {
        document.getElementById(id).classList.add('hidden');
    });
    document.getElementById(panelId).classList.remove('hidden');
}

function revealSheet(childName) {
    const sheet = document.getElementById('qrSheet');
    const panel = document.getElementById('qrSheetPanel');
    document.getElementById('qrSheetChildName').textContent    = childName;
    document.getElementById('qrSheetGuardianName').textContent = getGuardianName();
    sheet.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    requestAnimationFrame(() => requestAnimationFrame(() => {
        panel.classList.remove('translate-y-full');
    }));
}

function openSheetTermsMode(childName) {
    // Reset checkboxes & error
    document.getElementById('sheetTermsCheck').checked = false;
    document.getElementById('sheetGdprCheck').checked  = false;
    document.getElementById('sheetTermsError').classList.add('hidden');
    showSheetPanel('sheetTermsPanel');
    revealSheet(childName);
}

function openQrSheet(token, childName) {
    document.getElementById('qrSheetToken').textContent = token;
    document.getElementById('qrSheetImg').src =
        'https://api.qrserver.com/v1/create-qr-code/?size=240x240&data=' + encodeURIComponent(token);

    // Reset countdown state
    document.getElementById('sheetExpiredNotice').classList.add('hidden');
    document.getElementById('sheetCountdownBar').classList.remove('hidden');
    document.getElementById('qrSheetImg').style.opacity = '';
    const prog = document.getElementById('sheetCountdownProgress');
    const txt  = document.getElementById('sheetCountdownText');
    prog.classList.remove('bg-amber-500'); prog.classList.add('bg-sky-500');
    txt.classList.remove('text-amber-700'); txt.classList.add('text-sky-700');

    const expiresAt = new Date(Date.now() + QR_TTL_SECONDS * 1000);

    function tick() {
        const diff = Math.max(0, Math.floor((expiresAt - new Date()) / 1000));
        const mins = Math.floor(diff / 60);
        const secs = diff % 60;
        txt.textContent = mins + ':' + String(secs).padStart(2, '0');
        prog.style.width = (diff / QR_TTL_SECONDS * 100) + '%';
        if (diff < 300) {
            prog.classList.replace('bg-sky-500', 'bg-amber-500');
            txt.classList.replace('text-sky-700', 'text-amber-700');
        }
        if (diff === 0) {
            clearInterval(sheetTimer);
            document.getElementById('sheetCountdownBar').classList.add('hidden');
            document.getElementById('sheetExpiredNotice').classList.remove('hidden');
            document.getElementById('qrSheetImg').style.opacity = '0.2';
        }
    }
    tick();
    if (sheetTimer) clearInterval(sheetTimer);
    sheetTimer = setInterval(tick, 1000);

    showSheetPanel('sheetQrPanel');

    // Dacă sheet-ul e deja deschis (tranziție din termeni → qr), nu-l redeschide
    if (document.getElementById('qrSheet').classList.contains('hidden')) {
        revealSheet(childName);
    } else {
        document.getElementById('qrSheetChildName').textContent    = childName;
        document.getElementById('qrSheetGuardianName').textContent = getGuardianName();
    }
}

function closeQrSheet() {
    const panel = document.getElementById('qrSheetPanel');
    panel.classList.add('translate-y-full');
    if (sheetTimer) { clearInterval(sheetTimer); sheetTimer = null; }
    setTimeout(() => {
        document.getElementById('qrSheet').classList.add('hidden');
        document.body.style.overflow = '';
        document.getElementById('qrSheetImg').style.opacity = '';
        pendingChild = null;
    }, 300);
}

document.getElementById('closeQrSheetBtn').addEventListener('click', closeQrSheet);
document.getElementById('closeQrSheetBtnTerms').addEventListener('click', closeQrSheet);
document.getElementById('closeQrSheetX').addEventListener('click', closeQrSheet);
document.getElementById('qrBackdrop').addEventListener('click', closeQrSheet);

// Accept termeni în sheet → generează QR
document.getElementById('sheetAcceptBtn').addEventListener('click', async function () {
    const terms = document.getElementById('sheetTermsCheck').checked;
    const gdpr  = document.getElementById('sheetGdprCheck').checked;
    const errEl = document.getElementById('sheetTermsError');
    errEl.classList.add('hidden');

    if (!terms || !gdpr) {
        errEl.querySelector('span').textContent = 'Trebuie să accepți ambele documente.';
        errEl.classList.remove('hidden');
        return;
    }

    setLoading(this, true);
    try {
        const acceptData = await post(BASE_URL + '/accept-terms', {
            guardian_id: guardianId,
            terms_accepted: '1',
            gdpr_accepted: '1',
        });
        if (!acceptData.success) {
            errEl.querySelector('span').textContent = acceptData.message || 'Eroare.';
            errEl.classList.remove('hidden');
            return;
        }

        needsTerms = false;

        // Generează QR pentru copilul pending
        const qrData = await post(BASE_URL + '/generate-qr', {
            guardian_id: guardianId,
            child_id: pendingChild.id,
        });
        if (!qrData.success) {
            errEl.querySelector('span').textContent = qrData.message || 'Eroare la generare QR.';
            errEl.classList.remove('hidden');
            return;
        }

        // Treci la panoul QR (sheet-ul rămâne deschis)
        openQrSheet(qrData.token, pendingChild.name);
        pendingChild = null;
    } catch (e) {
        errEl.querySelector('span').textContent = 'Eroare de rețea.';
        errEl.classList.remove('hidden');
    } finally {
        setLoading(this, false);
    }
});

// Swipe down to close
(function () {
    const panel = document.getElementById('qrSheetPanel');
    let startY = 0, dragging = false;
    panel.addEventListener('touchstart', e => { startY = e.touches[0].clientY; dragging = true; }, { passive: true });
    panel.addEventListener('touchmove', e => {
        if (!dragging) return;
        const dy = e.touches[0].clientY - startY;
        if (dy > 0) panel.style.transform = `translateY(${dy}px)`;
    }, { passive: true });
    panel.addEventListener('touchend', e => {
        dragging = false;
        const dy = e.changedTouches[0].clientY - startY;
        panel.style.transform = '';
        if (dy > 100) closeQrSheet();
    });
})();

// Add child toggle
document.getElementById('showAddChildBtn').addEventListener('click', () => {
    document.getElementById('addChildForm').classList.remove('hidden');
    document.getElementById('showAddChildBtn').classList.add('hidden');
});

document.getElementById('cancelAddChildBtn').addEventListener('click', () => {
    document.getElementById('addChildForm').classList.add('hidden');
    document.getElementById('showAddChildBtn').classList.remove('hidden');
});

document.getElementById('saveAddChildBtn').addEventListener('click', async function () {
    const name = document.getElementById('newChildName').value.trim();
    const errEl = document.getElementById('addChildError');
    errEl.classList.add('hidden');

    if (!name) { errEl.textContent = 'Introdu prenumele copilului.'; errEl.classList.remove('hidden'); return; }

    const fullChildName = guardianLastName ? name + ' ' + guardianLastName : name;

    setLoading(this, true);
    try {
        const data = await post(BASE_URL + '/add-child', {
            guardian_id: guardianId,
            child_name: fullChildName,
        });
        if (!data.success) { errEl.textContent = data.message || 'Eroare.'; errEl.classList.remove('hidden'); return; }

        // Refresh lista de copii
        document.getElementById('newChildName').value = '';
        document.getElementById('addChildForm').classList.add('hidden');
        document.getElementById('showAddChildBtn').classList.remove('hidden');

        const lookup = await post(BASE_URL + '/lookup', { phone });
        if (lookup.success && lookup.found) {
            renderChildren(lookup.children || []);
        }
    } catch (e) {
        errEl.textContent = 'Eroare de rețea.'; errEl.classList.remove('hidden');
    } finally {
        setLoading(this, false);
    }
});
</script>
</body>
</html>
