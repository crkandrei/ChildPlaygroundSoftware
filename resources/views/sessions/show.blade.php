@extends('layouts.app')

@section('title', 'Detalii Sesiune')
@section('page-title', 'Detalii Sesiune')

@section('content')
<div class="space-y-6">
    <!-- Back button -->
    <div>
        <a href="{{ route('scan') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>
            Înapoi la scanare
        </a>
    </div>

    <!-- Session Overview -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 card-hover">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-stopwatch text-indigo-600"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">Informații Sesiune</h2>
                </div>
                <div class="flex items-center gap-3">
                    @if($session->ended_at)
                    <button onclick="printReceipt({{ $session->id }})" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-receipt mr-2"></i>
                        Printează Bon
                    </button>
                    @endif
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $session->ended_at ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $session->ended_at ? 'Închisă' : 'Activă' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <div class="text-sm text-gray-600 mb-1">Copil</div>
                    <div class="text-lg font-semibold text-gray-900">
                        {{ $session->child ? $session->child->first_name . ' ' . $session->child->last_name : '-' }}
                    </div>
                </div>
                <div>
                    <div class="text-sm text-gray-600 mb-1">Părinte/Tutor</div>
                    <div class="text-lg font-semibold text-gray-900">
                        {{ $session->child && $session->child->guardian ? $session->child->guardian->name : '-' }}
                    </div>
                </div>
                <div>
                    <div class="text-sm text-gray-600 mb-1">Brățară</div>
                    <div class="text-lg font-semibold text-gray-900 font-mono">
                        {{ $session->bracelet_code ?: '-' }}
                    </div>
                </div>
                <div>
                    <div class="text-sm text-gray-600 mb-1">Început</div>
                    <div class="text-lg font-semibold text-gray-900">
                        {{ $session->started_at ? $session->started_at->format('d.m.Y H:i') : '-' }}
                    </div>
                </div>
                <div>
                    <div class="text-sm text-gray-600 mb-1">Sfârșit</div>
                    <div class="text-lg font-semibold text-gray-900">
                        {{ $session->ended_at ? $session->ended_at->format('d.m.Y H:i') : '-' }}
                    </div>
                </div>
                <div>
                    <div class="text-sm text-gray-600 mb-1">Durata totală</div>
                    <div class="text-lg font-semibold text-indigo-600">
                        {{ $session->getFormattedDuration() }}
                    </div>
                </div>
                @if($session->ended_at)
                <div>
                    <div class="text-sm text-gray-600 mb-1">Preț</div>
                    <div class="text-lg font-semibold text-green-600">
                        {{ $session->getFormattedPrice() }}
                    </div>
                    @if($session->price_per_hour_at_calculation)
                    <div class="text-xs text-gray-500 mt-1">
                        Preț/ora: {{ number_format($session->price_per_hour_at_calculation, 2, '.', '') }} RON
                    </div>
                    @endif
                </div>
                @else
                <div>
                    <div class="text-sm text-gray-600 mb-1">Preț estimat</div>
                    <div class="text-lg font-semibold text-amber-600">
                        {{ $session->getFormattedPrice() }}
                    </div>
                </div>
                @endif
                @if($session->products && $session->products->count() > 0)
                <div class="col-span-full">
                    <div class="text-sm text-gray-600 mb-1">Total Produse</div>
                    <div class="text-lg font-semibold text-purple-600">
                        {{ number_format($session->getProductsTotalPrice(), 2, '.', '') }} RON
                    </div>
                </div>
                @endif
                @if($session->ended_at && $session->products && $session->products->count() > 0)
                <div class="col-span-full">
                    <div class="text-sm text-gray-600 mb-1">Total General</div>
                    <div class="text-lg font-semibold text-green-600">
                        {{ $session->getFormattedTotalPrice() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 card-hover">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-box text-purple-600"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">Produse</h2>
                </div>
                @if(!$session->ended_at)
                <button id="addProductsBtn" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Adaugă Produse
                </button>
                @endif
            </div>
        </div>
        <div class="p-6">
            @if($session->products && $session->products->count() > 0)
                <div class="space-y-3">
                    @foreach($session->products as $sessionProduct)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <div class="font-medium text-gray-900">{{ $sessionProduct->product->name ?? 'Produs' }}</div>
                            <div class="text-sm text-gray-500 mt-1">
                                {{ $sessionProduct->quantity }} buc × {{ number_format($sessionProduct->unit_price, 2, '.', '') }} RON
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold text-gray-900">{{ number_format($sessionProduct->total_price, 2, '.', '') }} RON</div>
                        </div>
                    </div>
                    @endforeach
                    <div class="pt-3 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="font-semibold text-gray-900">Subtotal Produse:</div>
                            <div class="font-semibold text-gray-900">{{ number_format($session->getProductsTotalPrice(), 2, '.', '') }} RON</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-box text-4xl mb-3"></i>
                    <p>Nu sunt produse adăugate la această sesiune.</p>
                    @if(!$session->ended_at)
                    <p class="text-sm mt-2">Click pe "Adaugă Produse" pentru a adăuga produse.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Activity Log -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 card-hover">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-list-ul text-emerald-600"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Log Activitate</h2>
            </div>
        </div>
        <div class="p-6">
            @php
                $events = [];
                
                // Adaugă evenimentele din intervale (Start joc și Pauză)
                if ($session->intervals && $session->intervals->count() > 0) {
                    foreach ($session->intervals as $interval) {
                        // Start interval
                        if ($interval->started_at) {
                            $events[] = [
                                'type' => 'start',
                                'time' => $interval->started_at,
                                'label' => 'Start'
                            ];
                        }
                        
                        // Stop interval (pauză)
                        if ($interval->ended_at) {
                            $events[] = [
                                'type' => 'pause',
                                'time' => $interval->ended_at,
                                'label' => 'Pauză',
                                'duration' => $interval->duration_seconds
                            ];
                        }
                    }
                }
                
                // Sortează evenimentele cronologic
                usort($events, function($a, $b) {
                    return $a['time']->timestamp <=> $b['time']->timestamp;
                });
            @endphp
            
            @if(count($events) > 0)
                <div class="space-y-3">
                    @foreach($events as $event)
                        <div class="flex items-center gap-4 py-3 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                            <!-- Icon -->
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 
                                {{ $event['type'] === 'start' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' }}">
                                <i class="fas {{ $event['type'] === 'start' ? 'fa-play' : 'fa-pause' }}"></i>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-gray-900">
                                        {{ $event['label'] }}: {{ $event['time']->format('H:i:s') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-info-circle text-4xl mb-3"></i>
                    <p>Nu există evenimente înregistrate pentru această sesiune.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Products Modal -->
<div id="addProductsModal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
    <div id="addProductsOverlay" class="fixed inset-0 bg-black bg-opacity-50"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Adaugă Produs la Sesiune</h3>
                <button id="closeAddProductsModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <label for="productsSelect" class="block text-sm font-medium text-gray-700 mb-2">
                            Selectează Produs <span class="text-red-500">*</span>
                        </label>
                        <select id="productsSelect" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Selectează produs...</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="productQuantity" class="block text-sm font-medium text-gray-700 mb-2">
                            Cantitate (bucăți) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="productQuantity" 
                               min="1" 
                               value="1" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                
                <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                    <button type="button" id="cancelAddProducts" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">
                        Anulează
                    </button>
                    <button type="button" id="saveAddProducts" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                        <i class="fas fa-plus mr-2"></i>
                        Adaugă
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@php
$sessionProductsJson = $session->products->map(function($sp) {
    return [
        'id' => $sp->id,
        'product_id' => $sp->product_id,
        'product_name' => $sp->product->name ?? 'Produs',
        'quantity' => $sp->quantity,
        'unit_price' => $sp->unit_price,
        'total_price' => $sp->total_price,
    ];
})->values();
@endphp
<script>
let printInProgress = false;
const sessionId = {{ $session->id }};
let availableProducts = [];
let sessionProducts = @json($sessionProductsJson);

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

// ===== PRODUCTS MANAGEMENT =====

async function apiCall(url, options = {}) {
    const response = await fetch(url, {
        ...options,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            ...options.headers
        },
        credentials: 'same-origin'
    });
    
    const contentType = response.headers.get('content-type');
    let data;
    
    const responseText = await response.text();
    
    if (contentType && contentType.includes('application/json')) {
        try {
            data = JSON.parse(responseText);
        } catch (e) {
            const error = new Error('Răspuns invalid de la server');
            error.data = { message: 'Serverul a returnat un răspuns invalid.' };
            error.status = response.status;
            throw error;
        }
    } else {
        data = { success: response.ok, message: responseText };
    }
    
    if (!response.ok) {
        const error = new Error(data.message || 'Eroare de la server');
        error.status = response.status;
        error.data = data;
        throw error;
    }
    
    return data;
}

// Load available products
async function loadAvailableProducts() {
    try {
        const result = await apiCall('/scan-api/available-products');
        if (result.success && result.products) {
            availableProducts = result.products;
        }
    } catch (e) {
        console.error('Error loading products:', e);
    }
}

// Render products list
function renderProductsList() {
    const productsSection = document.querySelector('#productsSection .p-6');
    if (!productsSection) return;

    if (sessionProducts.length === 0) {
        productsSection.innerHTML = `
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-box text-4xl mb-3"></i>
                <p>Nu sunt produse adăugate la această sesiune.</p>
                @if(!$session->ended_at)
                <p class="text-sm mt-2">Click pe "Adaugă Produse" pentru a adăuga produse.</p>
                @endif
            </div>
        `;
        return;
    }

    let html = '<div class="space-y-3">';
    sessionProducts.forEach(product => {
        html += `
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <div class="font-medium text-gray-900">${product.product_name}</div>
                    <div class="text-sm text-gray-500 mt-1">
                        ${product.quantity} buc × ${parseFloat(product.unit_price).toFixed(2)} RON
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-gray-900">${parseFloat(product.total_price).toFixed(2)} RON</div>
                </div>
            </div>
        `;
    });
    
    const subtotal = sessionProducts.reduce((sum, p) => sum + parseFloat(p.total_price), 0);
    html += `
        <div class="pt-3 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="font-semibold text-gray-900">Subtotal Produse:</div>
                <div class="font-semibold text-gray-900">${subtotal.toFixed(2)} RON</div>
            </div>
        </div>
    </div>
    `;
    
    productsSection.innerHTML = html;
}

// Open add products modal
function openAddProductsModal() {
    const modal = document.getElementById('addProductsModal');
    if (!modal) return;

    // Populate products dropdown
    const productsSelect = document.getElementById('productsSelect');
    if (productsSelect && availableProducts.length > 0) {
        productsSelect.innerHTML = '<option value="">Selectează produs...</option>' +
            availableProducts.map(p => `<option value="${p.id}" data-price="${p.price}">${p.name} - ${parseFloat(p.price).toFixed(2)} RON</option>`).join('');
    }

    // Reset form
    document.getElementById('productQuantity').value = '1';
    productsSelect.value = '';

    modal.classList.remove('hidden');
}

// Close add products modal
function closeAddProductsModal() {
    const modal = document.getElementById('addProductsModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Add product to session
async function addProductToSession() {
    const productsSelect = document.getElementById('productsSelect');
    const quantityInput = document.getElementById('productQuantity');
    
    if (!productsSelect || !quantityInput) {
        return;
    }

    const productId = productsSelect.value;
    const quantity = parseInt(quantityInput.value);

    if (!productId || quantity < 1) {
        alert('Te rog selectează un produs și introdu o cantitate validă');
        return;
    }

    try {
        const result = await apiCall('/scan-api/add-products', {
            method: 'POST',
            body: JSON.stringify({
                session_id: sessionId,
                products: [{
                    product_id: parseInt(productId),
                    quantity: quantity
                }]
            })
        });

        if (result.success) {
            // Add to local list
            if (result.products && result.products.length > 0) {
                sessionProducts.push(...result.products);
                renderProductsList();
                
                // Reload page to update totals
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
            closeAddProductsModal();
        } else {
            alert('Eroare: ' + (result.message || 'Nu s-a putut adăuga produsul'));
        }
    } catch (e) {
        console.error('Error adding product:', e);
        alert('Eroare la adăugarea produsului: ' + (e.data?.message || e.message || 'Eroare necunoscută'));
    }
}

// Bind events
@if(!$session->ended_at)
const addProductsBtn = document.getElementById('addProductsBtn');
if (addProductsBtn) {
    addProductsBtn.addEventListener('click', openAddProductsModal);
}

const closeAddProductsModalBtn = document.getElementById('closeAddProductsModal');
const cancelAddProductsBtn = document.getElementById('cancelAddProducts');
const saveAddProductsBtn = document.getElementById('saveAddProducts');
const addProductsOverlay = document.getElementById('addProductsOverlay');

if (closeAddProductsModalBtn) {
    closeAddProductsModalBtn.addEventListener('click', closeAddProductsModal);
}
if (cancelAddProductsBtn) {
    cancelAddProductsBtn.addEventListener('click', closeAddProductsModal);
}
if (saveAddProductsBtn) {
    saveAddProductsBtn.addEventListener('click', addProductToSession);
}
if (addProductsOverlay) {
    addProductsOverlay.addEventListener('click', closeAddProductsModal);
}
@endif

// Load products on page load
loadAvailableProducts();
</script>
@endsection

