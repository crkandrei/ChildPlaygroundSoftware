@extends('layouts.app')

@section('title', 'Brățări')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Gestionare Brățări</h1>
                <p class="text-gray-600">Gestionați brățările RFID și asignările lor</p>
            </div>
            @if(Auth::user()->isSuperAdmin() || Auth::user()->isCompanyAdmin())
            <button id="open-add-bracelet-modal" 
               class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-6 py-3 rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 font-medium flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Adaugă Brățară Nouă
            </button>
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Total Brățări</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $bracelets->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Disponibile</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $bracelets->where('status', 'available')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Asignate</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $bracelets->where('status', 'assigned')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Probleme</h3>
                    <p class="text-3xl font-bold text-red-600">{{ $bracelets->whereIn('status', ['lost', 'damaged'])->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bracelets Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Lista Brățărilor</h2>
        </div>
        
        @if($bracelets->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cod RFID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Copil Asignat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Părinte
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Asignată la
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Note
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acțiuni
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($bracelets as $bracelet)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-mono font-medium text-gray-900">{{ $bracelet->code }}</div>
                                    <div class="text-sm text-gray-500">
                                        Creată {{ $bracelet->created_at->format('d.m.Y') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($bracelet->isAvailable())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Disponibilă
                                </span>
                            @elseif($bracelet->isAssigned())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Asignată
                                </span>
                            @elseif($bracelet->isLost())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Pierdută
                                </span>
                            @elseif($bracelet->isDamaged())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    Deteriorată
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($bracelet->child)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-xs font-medium text-blue-600">
                                                {{ substr($bracelet->child->initials, 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $bracelet->child->initials }}</div>
                                        <div class="text-sm text-gray-500">{{ $bracelet->child->internal_code }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-400 text-sm">Fără asignare</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($bracelet->child && $bracelet->child->guardian)
                                <div class="text-sm text-gray-900">{{ $bracelet->child->guardian->name }}</div>
                                <div class="text-sm text-gray-500">{{ $bracelet->child->guardian->phone ?? 'N/A' }}</div>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($bracelet->assigned_at)
                                {{ $bracelet->assigned_at->format('d.m.Y H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">
                                {{ $bracelet->notes ?: '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('bracelets.show', $bracelet) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    Vezi
                                </a>
                                @if(Auth::user()->isSuperAdmin() || Auth::user()->isCompanyAdmin())
                                <a href="{{ route('bracelets.edit', $bracelet) }}" 
                                   class="text-yellow-600 hover:text-yellow-900">
                                    Editează
                                </a>
                                @if(!$bracelet->isAssigned())
                                <form method="POST" action="{{ route('bracelets.destroy', $bracelet) }}" 
                                      class="inline" onsubmit="return confirm('Sigur vrei să ștergi această brățară?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Șterge
                                    </button>
                                </form>
                                @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Nu există brățări</h3>
            <p class="mt-1 text-sm text-gray-500">Începeți prin a adăuga prima brățară.</p>
            @if(Auth::user()->isSuperAdmin() || Auth::user()->isCompanyAdmin())
            <div class="mt-6">
                <button id="open-add-bracelet-modal-empty" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Adaugă Prima Brățară
                </button>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
@parent
@if(Auth::user()->isSuperAdmin() || Auth::user()->isCompanyAdmin())
@php
    $children = \App\Models\Child::where('tenant_id', Auth::user()->tenant->id)
        ->with('guardian')
        ->orderBy('first_name')
        ->orderBy('last_name')
        ->get();
@endphp
<div id="add-bracelet-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
    <div id="add-bracelet-overlay" class="fixed inset-0 bg-black bg-opacity-50"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Adaugă Brățară</h3>
                <button id="close-add-bracelet-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('bracelets.store') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                            Cod RFID (opțional)
                        </label>
                        <input type="text" id="code" name="code" value="{{ old('code') }}" maxlength="10" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('code') border-red-500 @enderror" placeholder="Lăsat gol pentru generare automată">
                        @error('code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Exact 10 caractere. Lăsat gol pentru generare automată.</p>
                        <button type="button" id="generate-code" class="mt-2 bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-300">Generează Cod Automat</button>
                    </div>
                    <div class="flex items-center justify-end space-x-2">
                        <button type="button" id="cancel-add-bracelet" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Anulează</button>
                        <button type="submit" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Salvează</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const modal = document.getElementById('add-bracelet-modal');
        const openBtn = document.getElementById('open-add-bracelet-modal');
        const openBtnEmpty = document.getElementById('open-add-bracelet-modal-empty');
        const closeBtn = document.getElementById('close-add-bracelet-modal');
        const cancelBtn = document.getElementById('cancel-add-bracelet');
        const overlay = document.getElementById('add-bracelet-overlay');
        const codeInput = document.getElementById('code');
        const generateBtn = document.getElementById('generate-code');

        function openModal() { if (modal) modal.classList.remove('hidden'); }
        function closeModal() { if (modal) modal.classList.add('hidden'); }

        if (openBtn) openBtn.addEventListener('click', openModal);
        if (openBtnEmpty) openBtnEmpty.addEventListener('click', openModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
        if (overlay) overlay.addEventListener('click', closeModal);

        // Open via query param ?open=add-bracelet
        const params = new URLSearchParams(window.location.search);
        if (params.get('open') === 'add-bracelet') {
            openModal();
        }

        // Auto-open if validation errors exist
        @if ($errors->any())
            openModal();
        @endif

        // Auto-format code to uppercase
        if (codeInput) {
            codeInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.toUpperCase();
            });
        }

        // Generate code button
        if (generateBtn && codeInput) {
            generateBtn.addEventListener('click', function() {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                let result = '';
                for (let i = 0; i < 10; i++) {
                    result += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                codeInput.value = result;
            });
        }

    })();
</script>
@endif
@endsection

