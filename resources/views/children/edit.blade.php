@extends('layouts.app')

@section('title', 'Editează Copil')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('children.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Editează Copil</h1>
                    <p class="text-gray-600">Actualizează informațiile copilului</p>
                </div>
            </div>
            <div class="text-sm text-gray-500">
                Creat {{ $child->created_at->format('d.m.Y') }}
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('children.update', $child) }}" class="space-y-6">
            @csrf
            @method('PUT')

            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nume complet <span class="text-red-500">*</span></label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $child->name) }}"
                           maxlength="255"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                           placeholder="Ex: Andrei Popescu"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Birth Date -->
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Data nașterii <span class="text-red-500">*</span></label>
                    <input type="date"
                           id="birth_date"
                           name="birth_date"
                           value="{{ old('birth_date', $child->birth_date ? $child->birth_date->format('Y-m-d') : '') }}"
                           min="{{ \Carbon\Carbon::now()->subYears(18)->format('Y-m-d') }}"
                           max="{{ \Carbon\Carbon::now()->subDay()->format('Y-m-d') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('birth_date') border-red-500 @enderror"
                           required>
                    @error('birth_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Data trebuie să fie în trecut și copilul să aibă maximum 18 ani</p>
                </div>

                <!-- Guardian Selection -->
                <div>
                    <label for="guardian_id" class="block text-sm font-medium text-gray-700 mb-2">Părinte/Tutore <span class="text-red-500">*</span></label>
                    <select id="guardian_id" 
                            name="guardian_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('guardian_id') border-red-500 @enderror"
                            required>
                        <option value="">Selectează părintele...</option>
                        @foreach($guardians as $guardian)
                            <option value="{{ $guardian->id }}" 
                                {{ (old('guardian_id', $child->guardian_id) == $guardian->id) ? 'selected' : '' }}>
                                {{ $guardian->name }} 
                                @if($guardian->phone)
                                    - {{ $guardian->phone }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('guardian_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        @if($guardians->count() == 0)
                            <span class="text-red-600">Nu există părinți înregistrați. 
                                <a href="{{ route('guardians.create') }}" class="text-indigo-600 hover:text-indigo-500">Adaugă un părinte</a>
                            </span>
                        @else
                            Alegeți părintele copilului
                        @endif
                    </p>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Note (opțional)</label>
                <textarea id="notes" 
                          name="notes" 
                          rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('notes') border-red-500 @enderror"
                          placeholder="Informații suplimentare despre copil...">{{ old('notes', $child->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('children.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Anulează</a>
                <div class="flex items-center space-x-2">
                    @if(Auth::user()->isSuperAdmin() || Auth::user()->isCompanyAdmin() || Auth::user()->isStaff())
                        <button type="submit" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Salvează</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Character counter for notes
    const notesTextarea = document.getElementById('notes');
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

    // Strict birth date validation - only when date is complete
    const birthDateInput = document.getElementById('birth_date');
    if (birthDateInput) {
        function validateBirthDate(input) {
            const value = input.value.trim();
            
            // Don't validate if input is empty or incomplete
            if (!value) return true;
            
            // Check if date is in complete format (YYYY-MM-DD)
            const datePattern = /^\d{4}-\d{2}-\d{2}$/;
            if (!datePattern.test(value)) {
                return true; // Not complete yet, don't validate
            }
            
            const selectedDate = new Date(value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            const maxDate = new Date();
            maxDate.setHours(0, 0, 0, 0);
            maxDate.setDate(maxDate.getDate() - 1); // Yesterday
            
            const minDate = new Date();
            minDate.setFullYear(minDate.getFullYear() - 18); // 18 years ago
            
            // Check if date is valid
            if (isNaN(selectedDate.getTime())) {
                alert('Data introdusă nu este validă. Te rog verifică formatul datei.');
                input.value = '';
                input.focus();
                return false;
            }
            
            if (selectedDate > maxDate) {
                alert('Data nașterii nu poate fi în viitor sau astăzi.');
                input.value = '';
                input.focus();
                return false;
            }
            
            if (selectedDate < minDate) {
                alert('Data nașterii indică un copil mai mare de 18 ani. Te rog verifică data introdusă.');
                input.value = '';
                input.focus();
                return false;
            }
            
            return true;
        }

        // Validate only on blur (when user finishes entering)
        birthDateInput.addEventListener('blur', function(e) {
            validateBirthDate(e.target);
        });

        // Also validate on form submit
        const form = birthDateInput.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validateBirthDate(birthDateInput)) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        }
    }
</script>
@endsection
