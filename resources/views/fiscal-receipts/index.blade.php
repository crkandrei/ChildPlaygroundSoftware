@extends('layouts.app')

@section('title', 'Bon Fiscal')
@section('page-title', 'Bon Fiscal')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Bon Fiscal 🧾</h1>
                <p class="text-gray-600 text-lg">Generează bon fiscal pentru ora de joacă</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form id="fiscal-receipt-form" method="POST" action="{{ route('fiscal-receipts.print') }}">
            @csrf

            <!-- Tenant Selection -->
            <div class="mb-6">
                <label for="tenant_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Tenant <span class="text-red-500">*</span>
                </label>
                <select name="tenant_id" id="tenant_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Selectați tenant --</option>
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                    @endforeach
                </select>
                @error('tenant_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Duration Input -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <!-- Hours -->
                <div>
                    <label for="hours" class="block text-sm font-medium text-gray-700 mb-2">
                        Ore <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="hours" 
                           id="hours" 
                           min="0" 
                           max="24" 
                           value="0" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('hours')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Minutes -->
                <div>
                    <label for="minutes" class="block text-sm font-medium text-gray-700 mb-2">
                        Minute <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="minutes" 
                           id="minutes" 
                           min="0" 
                           max="59" 
                           value="0" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('minutes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Calculated Price Display -->
            <div id="price-display" class="mb-6 hidden">
                <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Durată calculată:</p>
                            <p id="calculated-duration" class="text-lg font-semibold text-gray-900"></p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Preț calculat:</p>
                            <p id="calculated-price" class="text-2xl font-bold text-indigo-600"></p>
                        </div>
                    </div>
                    <div class="mt-2 pt-2 border-t border-indigo-200">
                        <p class="text-xs text-gray-500">
                            Tarif pe oră: <span id="hourly-rate" class="font-medium"></span> RON
                            | Ore rotunjite: <span id="rounded-hours" class="font-medium"></span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Payment Type -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tip plată <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-4">
                    <label class="flex items-center">
                        <input type="radio" 
                               name="paymentType" 
                               value="CASH" 
                               checked
                               required
                               class="mr-2 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-gray-700">Cash</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" 
                               name="paymentType" 
                               value="CARD" 
                               required
                               class="mr-2 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-gray-700">Card</span>
                    </label>
                </div>
                @error('paymentType')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4">
                <button type="button" 
                        onclick="calculatePrice()" 
                        class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-calculator mr-2"></i>
                    Calculează Preț
                </button>
                <button type="submit" 
                        id="submit-btn"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-print mr-2"></i>
                    Emite Bon Fiscal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Calculate price when tenant or duration changes
    function calculatePrice() {
        const tenantId = document.getElementById('tenant_id').value;
        const hours = parseInt(document.getElementById('hours').value) || 0;
        const minutes = parseInt(document.getElementById('minutes').value) || 0;

        // Validate tenant is selected
        if (!tenantId) {
            alert('Selectați un tenant');
            return;
        }

        // Validate inputs
        if (hours < 0 || hours > 24) {
            alert('Orele trebuie să fie între 0 și 24');
            return;
        }
        if (minutes < 0 || minutes > 59) {
            alert('Minutele trebuie să fie între 0 și 59');
            return;
        }

        if (hours === 0 && minutes === 0) {
            alert('Introduceți o durată (ore sau minute)');
            return;
        }

        // Show loading state
        const priceDisplay = document.getElementById('price-display');
        priceDisplay.classList.remove('hidden');
        const loadingHtml = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin text-indigo-600"></i> <span class="ml-2">Calculare...</span></div>';
        priceDisplay.querySelector('.bg-indigo-50').innerHTML = loadingHtml;

        // Make AJAX request
        fetch('{{ route("fiscal-receipts.calculate-price") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                tenant_id: tenantId,
                hours: hours,
                minutes: minutes
            })
        })
        .then(response => {
            // Check if response is ok (status 200-299)
            if (!response.ok) {
                // Try to parse error response
                return response.json().then(err => {
                    throw new Error(err.message || 'Eroare la calcularea prețului');
                }).catch(() => {
                    throw new Error('Eroare la calcularea prețului (Status: ' + response.status + ')');
                });
            }
            return response.json();
        })
        .then(data => {
            // Check if data has success flag and it's true
            if (data.success === true && data.price !== undefined) {
                // Restore original HTML structure with calculated values
                const priceContainer = priceDisplay.querySelector('.bg-indigo-50');
                priceContainer.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Durată calculată:</p>
                            <p id="calculated-duration" class="text-lg font-semibold text-gray-900">${data.duration}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Preț calculat:</p>
                            <p id="calculated-price" class="text-2xl font-bold text-indigo-600">${data.price.toFixed(2)} RON</p>
                        </div>
                    </div>
                    <div class="mt-2 pt-2 border-t border-indigo-200">
                        <p class="text-xs text-gray-500">
                            Tarif pe oră: <span id="hourly-rate" class="font-medium">${data.hourlyRate.toFixed(2)}</span> RON
                            | Ore rotunjite: <span id="rounded-hours" class="font-medium">${data.roundedHours.toFixed(2)}</span>
                        </p>
                    </div>
                `;
            } else {
                // If success is false or missing, show error
                const errorMsg = data.message || 'Eroare la calcularea prețului';
                alert(errorMsg);
                document.getElementById('price-display').classList.add('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'Eroare la calcularea prețului');
            document.getElementById('price-display').classList.add('hidden');
        });
    }

    // Form submission
    document.getElementById('fiscal-receipt-form').addEventListener('submit', function(e) {
        const tenantId = document.getElementById('tenant_id').value;
        const hours = parseInt(document.getElementById('hours').value) || 0;
        const minutes = parseInt(document.getElementById('minutes').value) || 0;

        if (!tenantId) {
            e.preventDefault();
            alert('Selectați un tenant');
            return false;
        }

        if (hours === 0 && minutes === 0) {
            e.preventDefault();
            alert('Introduceți o durată (ore sau minute)');
            return false;
        }

        // Show loading state
        const submitBtn = document.getElementById('submit-btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Se emite bonul...';
    });
</script>
@endsection
