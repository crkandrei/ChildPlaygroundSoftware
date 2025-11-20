@extends('landing.layouts.landing')

@section('content')
{{-- Hero Section --}}
<section id="hero" class="relative bg-gradient-to-br from-indigo-50 via-white to-cyan-50 overflow-hidden">
    <div class="container-custom section-padding">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="relative z-10">
                <div class="inline-block mb-4">
                    <span class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white text-sm font-semibold px-4 py-2 rounded-full">
                        #1 Loc de Joacă în Vaslui
                    </span>
                </div>
                <h1 class="font-display text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-6 leading-tight">
                    Locul unde <span class="gradient-text">copiii</span> învață jucându-se
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-xl">
                    Un spațiu modern și sigur unde copiii dezvoltă abilități sociale și creative prin joacă, sub supravegherea unui personal calificat.
                </p>
                
                {{-- Benefits --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-medium">Mediu 100% sigur</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-medium">Personal calificat</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-medium">Program flexibil</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-medium">Petreceri private</span>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#contact" class="btn-primary inline-flex items-center justify-center group">
                        Rezervă acum
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="#activitati" class="btn-secondary">
                        Descoperă activitățile
                    </a>
                </div>
            </div>
            
            <div class="relative lg:block">
                <div class="relative">
                    {{-- Main Image Placeholder --}}
                    <div class="relative bg-gradient-to-br from-blue-400 to-purple-500 rounded-3xl overflow-hidden shadow-2xl aspect-square">
                        <div class="absolute inset-0 flex items-center justify-center text-white">
                            <div class="text-center p-8">
                                <div class="text-8xl mb-4">🎪</div>
                                <p class="text-xl font-semibold">Adaugă fotografii reale aici</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Floating Stats Card --}}
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-xl p-6 hidden lg:block">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">500+</div>
                                <div class="text-sm text-gray-600">Copii fericiți</div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Floating Rating Card --}}
                    <div class="absolute -top-6 -right-6 bg-white rounded-2xl shadow-xl p-6 hidden lg:block">
                        <div class="flex items-center space-x-2 mb-2">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <div class="text-sm text-gray-600">Recenzii excelente</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Stats Section --}}
<section class="bg-white border-y border-gray-100 py-16">
    <div class="container-custom">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-gray-900 mb-2">500+</div>
                <div class="text-gray-600">Copii fericiți</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-gray-900 mb-2">200+</div>
                <div class="text-gray-600">Petreceri organizate</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-gray-900 mb-2">5★</div>
                <div class="text-gray-600">Rating mediu</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-gray-900 mb-2">100%</div>
                <div class="text-gray-600">Părinți mulțumiți</div>
            </div>
        </div>
    </div>
</section>

{{-- Activități Section --}}
<section id="activitati" class="section-padding bg-gray-50">
    <div class="container-custom">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <h2 class="section-title font-display gradient-text mb-4">Activități diverse pentru fiecare copil</h2>
            <p class="text-xl text-gray-600">
                Oferim o gamă variată de activități care stimulează creativitatea, imaginația și dezvoltarea socială a copiilor
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            {{-- Card 1 --}}
            <div class="card p-8 group hover:border-blue-200 border-2 border-transparent">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Tobogane & Softplay</h3>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Zone speciale cu echipamente moderne și sigure, adaptate pentru diferite vârste. Tobogane colorate, piscine cu bile și multe altele.
                </p>
                <a href="#contact" class="text-blue-600 font-semibold inline-flex items-center group-hover:translate-x-1 transition-transform">
                    Află mai multe
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            
            {{-- Card 2 --}}
            <div class="card p-8 group hover:border-pink-200 border-2 border-transparent">
                <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Ateliere Creative</h3>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Workshop-uri de pictură, desen, modelare și activități manuale. Dezvoltăm creativitatea și abilitățile motorii fine.
                </p>
                <a href="#contact" class="text-pink-600 font-semibold inline-flex items-center group-hover:translate-x-1 transition-transform">
                    Află mai multe
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            
            {{-- Card 3 --}}
            <div class="card p-8 group hover:border-purple-200 border-2 border-transparent">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Mini Disco & Jocuri</h3>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Sesiuni de dans, muzică și jocuri interactive în grup. Copiii își fac prieteni noi și învață să lucreze în echipă.
                </p>
                <a href="#contact" class="text-purple-600 font-semibold inline-flex items-center group-hover:translate-x-1 transition-transform">
                    Află mai multe
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Orar Section --}}
<section id="orar" class="section-padding bg-white">
    <div class="container-custom">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <h2 class="section-title font-display gradient-text mb-4">Programul săptămânal</h2>
            <p class="text-xl text-gray-600 mb-6">
                Suntem deschiși în fiecare zi pentru joacă liberă și evenimente private
            </p>
            @php
                $startDate = \Carbon\Carbon::now()->startOfWeek();
                $endDate = \Carbon\Carbon::now()->endOfWeek();
            @endphp
            <div class="inline-flex items-center bg-gray-100 px-6 py-3 rounded-full">
                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-gray-900 font-semibold">{{ $startDate->format('d.m') }} - {{ $endDate->format('d.m.Y') }}</span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-4 max-w-6xl mx-auto">
            @php
                $days = [
                    ['name' => 'Luni', 'free' => true, 'private' => false],
                    ['name' => 'Marți', 'free' => true, 'private' => false],
                    ['name' => 'Miercuri', 'free' => true, 'private' => true, 'private_time' => '14:00-16:00'],
                    ['name' => 'Joi', 'free' => true, 'private' => false],
                    ['name' => 'Vineri', 'free' => true, 'private' => true, 'private_time' => '15:00-17:00'],
                    ['name' => 'Sâmbătă', 'free' => true, 'private' => false],
                    ['name' => 'Duminică', 'free' => true, 'private' => false],
                ];
            @endphp
            
            @foreach($days as $day)
            <div class="card p-5 hover:shadow-xl">
                <h3 class="text-lg font-bold text-gray-900 mb-4 text-center border-b border-gray-100 pb-3">{{ $day['name'] }}</h3>
                @if($day['private'])
                    <div class="space-y-2">
                        <div class="bg-green-50 text-green-700 px-3 py-2 rounded-lg text-xs font-medium text-center">
                            <div class="font-semibold mb-1">Joacă liberă</div>
                            <div class="text-green-600">09:00-20:00</div>
                        </div>
                        <div class="bg-purple-50 text-purple-700 px-3 py-2 rounded-lg text-xs font-medium text-center">
                            <div class="font-semibold mb-1">Eveniment privat</div>
                            <div class="text-purple-600">{{ $day['private_time'] }}</div>
                        </div>
                    </div>
                @else
                    <div class="bg-green-50 text-green-700 px-3 py-2 rounded-lg text-xs font-medium text-center">
                        <div class="font-semibold mb-1">Joacă liberă</div>
                        <div class="text-green-600">09:00-20:00</div>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Petreceri Section --}}
<section id="petreceri" class="section-padding bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50">
    <div class="container-custom">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <h2 class="section-title font-display gradient-text mb-4">Petreceri de neuitat</h2>
            <p class="text-xl text-gray-600">
                Organizăm petreceri private pentru zilele de naștere ale copiilor. Noi ne ocupăm de tot, tu te bucuri doar de momentele speciale.
            </p>
        </div>
        
        {{-- Benefits Grid --}}
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 mb-12 max-w-5xl mx-auto">
            <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Ce include pachetul nostru?</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $benefits = [
                        ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => '3 ore de joacă', 'desc' => 'Pentru toți invitații'],
                        ['icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01', 'title' => 'Decoruri tematice', 'desc' => 'Personalizate pe tema preferată'],
                        ['icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Animator dedicat', 'desc' => 'Jocuri și activități organizate'],
                        ['icon' => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z', 'title' => 'Fotografii incluse', 'desc' => 'Amintiri pentru totdeauna'],
                        ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'title' => 'Până la 15 copii', 'desc' => 'Invită toți prietenii'],
                        ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Siguranță maximă', 'desc' => 'Supraveghere permanentă'],
                    ];
                @endphp
                @foreach($benefits as $benefit)
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $benefit['icon'] }}"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">{{ $benefit['title'] }}</h4>
                        <p class="text-sm text-gray-600">{{ $benefit['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        {{-- Pricing Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            {{-- Basic --}}
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition-shadow">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Pachet Basic</h3>
                    <div class="flex items-baseline justify-center">
                        <span class="text-5xl font-bold text-gray-900">250</span>
                        <span class="text-gray-600 ml-2">RON</span>
                    </div>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        2 ore de joacă
                    </li>
                    <li class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Decoruri simple
                    </li>
                    <li class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Până la 10 copii
                    </li>
                </ul>
                <a href="#contact" class="block w-full btn-secondary text-center">
                    Alege pachetul
                </a>
            </div>
            
            {{-- Premium --}}
            <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl shadow-2xl p-8 transform scale-105 relative">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-yellow-400 text-gray-900 text-sm font-bold px-4 py-1 rounded-full shadow-lg">
                        CEL MAI POPULAR
                    </span>
                </div>
                <div class="text-center mb-6 mt-4">
                    <h3 class="text-xl font-bold text-white mb-2">Pachet Premium</h3>
                    <div class="flex items-baseline justify-center">
                        <span class="text-5xl font-bold text-white">350</span>
                        <span class="text-white/80 ml-2">RON</span>
                    </div>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center text-white">
                        <svg class="w-5 h-5 text-yellow-300 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        3 ore de joacă
                    </li>
                    <li class="flex items-center text-white">
                        <svg class="w-5 h-5 text-yellow-300 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Decoruri tematice
                    </li>
                    <li class="flex items-center text-white">
                        <svg class="w-5 h-5 text-yellow-300 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Animator dedicat
                    </li>
                    <li class="flex items-center text-white">
                        <svg class="w-5 h-5 text-yellow-300 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Fotografii incluse
                    </li>
                    <li class="flex items-center text-white">
                        <svg class="w-5 h-5 text-yellow-300 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Până la 15 copii
                    </li>
                </ul>
                <a href="#contact" class="block w-full bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold py-3 rounded-lg text-center transition-colors">
                    Alege pachetul
                </a>
            </div>
            
            {{-- Deluxe --}}
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition-shadow">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Pachet Deluxe</h3>
                    <div class="flex items-baseline justify-center">
                        <span class="text-5xl font-bold text-gray-900">450</span>
                        <span class="text-gray-600 ml-2">RON</span>
                    </div>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        4 ore de joacă
                    </li>
                    <li class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Decoruri premium
                    </li>
                    <li class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Animator + fotograf
                    </li>
                    <li class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Album foto
                    </li>
                    <li class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Până la 20 copii
                    </li>
                </ul>
                <a href="#contact" class="block w-full btn-secondary text-center">
                    Alege pachetul
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Contact Section --}}
<section id="contact" class="section-padding bg-white">
    <div class="container-custom max-w-6xl">
        <div class="text-center mb-16">
            <h2 class="section-title font-display gradient-text mb-4">Contactează-ne</h2>
            <p class="text-xl text-gray-600">
                Suntem aici să răspundem la toate întrebările tale
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">
            {{-- Contact Info --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="card p-6 hover:shadow-xl">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Telefon</h3>
                            <p class="text-gray-600">+40 XXX XXX XXX</p>
                            <p class="text-sm text-gray-500 mt-1">Luni - Duminică, 09:00 - 20:00</p>
                        </div>
                    </div>
                </div>
                
                <div class="card p-6 hover:shadow-xl">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Email</h3>
                            <p class="text-gray-600">contact@bongoland.ro</p>
                            <p class="text-sm text-gray-500 mt-1">Răspundem în 24h</p>
                        </div>
                    </div>
                </div>
                
                <div class="card p-6 hover:shadow-xl">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Locație</h3>
                            <p class="text-gray-600">Vaslui, România</p>
                            <p class="text-sm text-gray-500 mt-1">Parcare disponibilă</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <p class="text-sm text-gray-700 leading-relaxed">
                        <strong class="text-gray-900">Vino să ne cunoști!</strong> Suntem bucuroși să îți arătăm spațiul și să răspundem la toate întrebările tale.
                    </p>
                </div>
            </div>
            
            {{-- Contact Form --}}
            <div class="lg:col-span-3">
                <div class="card p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Trimite-ne un mesaj</h3>
                    <form action="{{ route('landing.contact.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="parent_name" class="block text-sm font-semibold text-gray-700 mb-2">Nume părinte *</label>
                            <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name') }}" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none">
                            @if(isset($errors) && $errors->has('parent_name'))
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $errors->first('parent_name') }}</p>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="child_name" class="block text-sm font-semibold text-gray-700 mb-2">Nume copil</label>
                                <input type="text" name="child_name" id="child_name" value="{{ old('child_name') }}" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none">
                            </div>
                            <div>
                                <label for="child_age" class="block text-sm font-semibold text-gray-700 mb-2">Vârstă copil</label>
                                <input type="number" name="child_age" id="child_age" value="{{ old('child_age') }}" min="1" max="18" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none">
                            </div>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Mesajul tău *</label>
                            <textarea name="message" id="message" rows="5" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none resize-none"
                                placeholder="Spune-ne cum te putem ajuta...">{{ old('message') }}</textarea>
                            @if(isset($errors) && $errors->has('message'))
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $errors->first('message') }}</p>
                            @endif
                        </div>
                        
                        <button type="submit" class="w-full btn-primary flex items-center justify-center group">
                            Trimite mesajul
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="section-padding bg-gradient-to-br from-blue-600 to-purple-600 text-white">
    <div class="container-custom text-center">
        <h2 class="text-4xl md:text-5xl font-display font-bold mb-6">
            Gata să creăm amintiri de neuitat?
        </h2>
        <p class="text-xl text-white/90 mb-10 max-w-2xl mx-auto">
            Alătură-te sutelor de familii care au ales Bongoland pentru dezvoltarea și fericirea copiilor lor
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#contact" class="btn-primary bg-yellow-400 hover:bg-yellow-500 text-gray-900 inline-flex items-center justify-center">
                Rezervă acum
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="#orar" class="btn-secondary bg-white/10 hover:bg-white/20 text-white border-white/30 hover:border-white/50">
                Vezi programul
            </a>
        </div>
    </div>
</section>
@endsection
