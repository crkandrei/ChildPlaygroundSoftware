@extends('layouts.app')

@section('title', 'Adaugă Brățară Nouă')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <a href="{{ route('bracelets.index') }}" 
               class="text-gray-400 hover:text-gray-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Adaugă Brățară Nouă</h1>
                <p class="text-gray-600">Introdu codul RFID sau lasă gol pentru generare automată</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('bracelets.store') }}" class="space-y-6">
            @csrf
            
            <!-- Code -->
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                    Cod RFID (opțional)
                </label>
                <input type="text" 
                       id="code" 
                       name="code" 
                       value="{{ old('code') }}"
                       maxlength="10"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('code') border-red-500 @enderror"
                       placeholder="Lăsat gol pentru generare automată">
                @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Exact 10 caractere. Lăsat gol pentru generare automată.</p>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('bracelets.index') }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 font-medium">
                    Anulează
                </a>
                <button type="submit" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 font-medium">
                    Adaugă Brățara
                </button>
            </div>
        </form>
    </div>

</div>

@section('scripts')
<script>
    // Auto-format code to uppercase
    document.getElementById('code').addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });

    // Auto-generate code button
    document.addEventListener('DOMContentLoaded', function() {
        const codeInput = document.getElementById('code');
        const generateButton = document.createElement('button');
        generateButton.type = 'button';
        generateButton.className = 'mt-2 bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-300';
        generateButton.textContent = 'Generează Cod Automat';
        
        generateButton.addEventListener('click', function() {
            // Generate a random 10-character code
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = '';
            for (let i = 0; i < 10; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            codeInput.value = result;
        });
        
        codeInput.parentNode.appendChild(generateButton);
    });
</script>
@endsection

