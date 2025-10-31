@extends('layouts.app')

@section('title', 'Detalii Brățară')

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
                    <h1 class="text-2xl font-bold text-gray-900">Detalii Brățară</h1>
                    <p class="text-gray-600">Vizualizare informații și activitate recentă</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                @if(Auth::user()->isSuperAdmin() || Auth::user()->isCompanyAdmin())
                    <a href="{{ route('bracelets.edit', $bracelet) }}" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Editează</a>
                    @if($bracelet->isAssigned())
                        <form method="POST" action="{{ route('bracelets.unassign', $bracelet) }}" onsubmit="return confirm('Sigur vrei să dezasignezi această brățară?')">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700">Dezasignează</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Details -->
    <div class="bg-white rounded-lg shadow p-6">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <dt class="text-sm font-medium text-gray-500">Cod RFID</dt>
                <dd class="mt-1 text-lg font-mono text-gray-900">{{ $bracelet->code }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-1">
                    @if($bracelet->isAvailable())
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Disponibilă</span>
                    @elseif($bracelet->isAssigned())
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Asignată</span>
                    @elseif($bracelet->isLost())
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Pierdută</span>
                    @elseif($bracelet->isDamaged())
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">Deteriorată</span>
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Asignată la</dt>
                <dd class="mt-1 text-gray-900">{{ $bracelet->assigned_at ? $bracelet->assigned_at->format('d.m.Y H:i') : '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Creată</dt>
                <dd class="mt-1 text-gray-900">{{ $bracelet->created_at->format('d.m.Y H:i') }}</dd>
            </div>
        </dl>
        <div class="mt-6">
            <dt class="text-sm font-medium text-gray-500">Note</dt>
            <dd class="mt-1 text-gray-900">{{ $bracelet->notes ?: '-' }}</dd>
        </div>
    </div>

    <!-- Assignment details -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Asignare</h2>
        @if($bracelet->child)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="text-sm text-gray-500">Copil</div>
                    <div class="text-gray-900">{{ $bracelet->child->first_name }} {{ $bracelet->child->last_name }}</div>
                    <div class="text-gray-500 text-sm">{{ $bracelet->child->internal_code }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Părinte</div>
                    @if($bracelet->child->guardian)
                        <div class="text-gray-900">{{ $bracelet->child->guardian->name }}</div>
                        <div class="text-gray-500 text-sm">{{ $bracelet->child->guardian->phone ?? 'N/A' }}</div>
                    @else
                        <div class="text-gray-500">-</div>
                    @endif
                </div>
            </div>
        @else
            <div class="text-gray-500">Brățara nu este asignată</div>
        @endif
    </div>

    <!-- Recent scans -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Scanări recente</h2>
        @if(($bracelet->scanEvents ?? collect())->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tip</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Moment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detalii</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bracelet->scanEvents as $event)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($event->event_type) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($event->scanned_at)->format('d.m.Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $event->details ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-gray-500">Nu există scanări recente pentru această brățară.</div>
        @endif
    </div>
</div>
@endsection


