@extends('layouts.app')

@section('title', 'Zile Sesiuni Jungle')
@section('page-title', 'Zile Sesiuni Jungle')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Zile Sesiuni Jungle 🌳</h1>
                <p class="text-gray-600 text-lg">Setați zilele când sunt permise sesiunile Jungle pentru <strong>{{ $tenant->name }}</strong></p>
            </div>
            <a href="{{ route('pricing.index') }}{{ Auth::user()->isSuperAdmin() ? '?tenant_id=' . $tenant->id : '' }}" 
               class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200 font-medium flex items-center shadow-md">
                <i class="fas fa-arrow-left mr-2"></i>
                Înapoi
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('pricing.jungle-session-days.update') }}">
            @csrf
            <input type="hidden" name="tenant_id" value="{{ $tenant->id }}">

            <div class="space-y-4">
                @php
                    $days = [
                        0 => 'Luni',
                        1 => 'Marți',
                        2 => 'Miercuri',
                        3 => 'Joi',
                        4 => 'Vineri',
                        5 => 'Sâmbătă',
                        6 => 'Duminică',
                    ];
                @endphp

                @foreach($days as $dayNum => $dayName)
                <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-32">
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $dayName }}</label>
                    </div>
                    <div class="flex-1">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   name="days[]" 
                                   value="{{ $dayNum }}"
                                   {{ in_array($dayNum, $jungleSessionDays ?? []) ? 'checked' : '' }}
                                   class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <span class="ml-3 text-sm text-gray-700">
                                Sesiunile Jungle sunt permise în {{ strtolower($dayName) }}
                            </span>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <a href="{{ route('pricing.index') }}{{ Auth::user()->isSuperAdmin() ? '?tenant_id=' . $tenant->id : '' }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Anulează
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Salvează Configurare
                </button>
            </div>
        </form>
    </div>

    <!-- Info Box -->
    <div class="bg-green-50 border border-green-200 rounded-xl p-6">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-green-600 text-xl mr-3 mt-1"></i>
            <div>
                <h3 class="font-medium text-green-900 mb-2">Informații importante</h3>
                <ul class="text-sm text-green-800 space-y-1 list-disc list-inside">
                    <li>Sesiunile Jungle sunt gratuite (similar cu sesiunile Birthday)</li>
                    <li>Sesiunile Jungle SE INCLUDE în rapoarte și statistici (spre deosebire de Birthday care se exclude)</li>
                    <li>O sesiune nu poate fi simultan Birthday și Jungle</li>
                    <li>Dacă nu selectați nicio zi, sesiunile Jungle nu vor fi disponibile</li>
                    <li>Checkbox-ul pentru Jungle va fi ascuns în zilele neconfigurate</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

