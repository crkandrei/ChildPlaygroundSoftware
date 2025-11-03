@extends('layouts.app')

@section('title', 'Adaugă Părinte Nou')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <a href="{{ route('guardians.index') }}" 
               class="text-gray-400 hover:text-gray-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Adaugă Părinte Nou</h1>
                <p class="text-gray-600">Completează informațiile pentru noul părinte</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('guardians.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Numele Complet <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                           placeholder="Ex: Maria Popescu"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Telefon
                    </label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('phone') border-red-500 @enderror"
                           placeholder="Ex: 0712345678">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Note (opțional)
                </label>
                <textarea id="notes" 
                          name="notes" 
                          rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('notes') border-red-500 @enderror"
                          placeholder="Informații suplimentare despre părinte...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Máximo 1000 caractere</p>
            </div>

            <!-- Terms and GDPR Acceptance -->
            <div class="pt-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Acceptare Termeni și Condiții</h3>
                
                <!-- Terms and Conditions -->
                <div class="mb-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms_accepted" 
                                   name="terms_accepted" 
                                   type="checkbox" 
                                   value="1"
                                   class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 @error('terms_accepted') border-red-500 @enderror"
                                   required>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms_accepted" class="font-medium text-gray-700">
                                Accept Termenii și Condițiile <span class="text-red-500">*</span>
                            </label>
                            <p class="text-gray-600 mt-1">
                                Am citit și accept 
                                <a href="{{ route('legal.terms.public') }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline">
                                    Termenii și Condițiile
                                </a>
                            </p>
                        </div>
                    </div>
                    @error('terms_accepted')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- GDPR Policy -->
                <div class="mb-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="gdpr_accepted" 
                                   name="gdpr_accepted" 
                                   type="checkbox" 
                                   value="1"
                                   class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 @error('gdpr_accepted') border-red-500 @enderror"
                                   required>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="gdpr_accepted" class="font-medium text-gray-700">
                                Accept Politica de Protecție a Datelor (GDPR) <span class="text-red-500">*</span>
                            </label>
                            <p class="text-gray-600 mt-1">
                                Am citit și accept 
                                <a href="{{ route('legal.gdpr.public') }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline">
                                    Politica de Protecție a Datelor cu Caracter Personal
                                </a>
                            </p>
                        </div>
                    </div>
                    @error('gdpr_accepted')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('guardians.index') }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 font-medium">
                    Anulează
                </a>
                <button type="submit" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 font-medium">
                    Adaugă Părintele
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    // Character counter for notes
    const notesTextarea = document.getElementById('notes');
    const maxLength = 1000;
    
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

    function createCounter() {
        const counter = document.createElement('p');
        counter.id = 'notes-counter';
        counter.className = 'mt-1 text-sm text-gray-500';
        notesTextarea.parentNode.appendChild(counter);
        return counter;
    }

    // Phone number formatting
    document.getElementById('phone').addEventListener('input', function(e) {
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
</script>
@endsection

