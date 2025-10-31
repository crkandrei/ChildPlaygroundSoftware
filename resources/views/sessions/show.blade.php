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
                    <a href="{{ route('sessions.receipt', $session->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-receipt mr-2"></i>
                        Printează Bon
                    </a>
                    @endif
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $session->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $session->status === 'completed' ? 'Închisă' : ucfirst($session->status) }}
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
                        {{ $session->bracelet ? $session->bracelet->code : '-' }}
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
            </div>
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
@endsection

