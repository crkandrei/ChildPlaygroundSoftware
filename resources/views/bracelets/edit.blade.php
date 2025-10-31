@extends('layouts.app')

@section('title', 'Editează Brățara')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('bracelets.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Editează Brățara</h1>
                    <p class="text-gray-600">Actualizează informațiile brățării RFID</p>
                </div>
            </div>
            <div class="text-sm text-gray-500">
                Creată {{ $bracelet->created_at->format('d.m.Y') }}
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('bracelets.update', $bracelet) }}" class="space-y-6">
            @csrf
            @method('PATCH')

            @if($bracelet->isAssigned())
                <div class="bg-yellow-50 border border-yellow-200 rounded p-4 text-yellow-800">
                    Brățara este în prezent asignată. Poți dezasigna brățara sau edita codul.
                </div>
            @endif

            <!-- Code -->
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Cod RFID</label>
                <input type="text" id="code" name="code" value="{{ old('code', $bracelet->code) }}" maxlength="10"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('code') border-red-500 @enderror"
                       @if($bracelet->isAssigned()) readonly @endif>
                @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Exact 10 caractere @if($bracelet->isAssigned()) (nu se poate modifica când e asignată) @endif</p>
            </div>

            <!-- Assignment (only when not assigned) -->
            @if(!$bracelet->isAssigned())
            <div>
                <label for="child_id" class="block text-sm font-medium text-gray-700 mb-2">Asignare copil (opțional)</label>
                <select id="child_id" name="child_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('child_id') border-red-500 @enderror">
                    <option value="">Fără asignare</option>
                    @foreach($children as $child)
                        <option value="{{ $child->id }}" {{ old('child_id', $bracelet->child_id) == $child->id ? 'selected' : '' }}>
                            {{ $child->first_name }} {{ $child->last_name }} @if($child->internal_code) ({{ $child->internal_code }}) @endif
                            @if($child->guardian && $child->guardian->phone) - {{ $child->guardian->phone }} @endif
                        </option>
                    @endforeach
                </select>
                @error('child_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            @else
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Copil asignat</label>
                @if($bracelet->child)
                    <div class="p-3 border rounded bg-gray-50">
                        <div class="text-sm text-gray-900">{{ $bracelet->child->first_name }} {{ $bracelet->child->last_name }}</div>
                        <div class="text-sm text-gray-500">{{ $bracelet->child->internal_code }}</div>
                        @if($bracelet->child->guardian)
                            <div class="text-sm text-gray-500">Părinte: {{ $bracelet->child->guardian->name }} {{ $bracelet->child->guardian->phone ? '· ' . $bracelet->child->guardian->phone : '' }}</div>
                        @endif
                    </div>
                @else
                    <div class="text-sm text-gray-500">-</div>
                @endif
            </div>
            @endif


            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('bracelets.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Anulează</a>
                <div class="flex items-center space-x-2">
                    @if($bracelet->isAssigned() && (Auth::user()->isSuperAdmin() || Auth::user()->isCompanyAdmin()))
                        <form method="POST" action="{{ route('bracelets.unassign', $bracelet) }}" onsubmit="return confirm('Sigur vrei să dezasignezi această brățară?')">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700">Dezasignează</button>
                        </form>
                    @elseif(!$bracelet->isAssigned() && (Auth::user()->isSuperAdmin() || Auth::user()->isCompanyAdmin()))
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
    // Auto-format code to uppercase when editable
    (function() {
        var codeInput = document.getElementById('code');
        if (codeInput && !codeInput.readOnly) {
            codeInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.toUpperCase();
            });
        }
    })();
</script>
@endsection


