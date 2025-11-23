@extends('landing.layouts.landing')

@section('content')
{{-- Hero Section --}}
<section id="hero" class="relative bg-gradient-to-br from-lime-100 via-green-50 to-yellow-50 overflow-hidden">
    {{-- Jungle decorative elements --}}
    <div class="absolute inset-0 overflow-hidden opacity-20 pointer-events-none">
        <div class="absolute top-0 left-0 text-9xl animate-pulse">🌴</div>
        <div class="absolute top-20 right-10 text-7xl animate-bounce" style="animation-delay: 0.5s;">🦜</div>
        <div class="absolute bottom-20 left-10 text-8xl animate-pulse" style="animation-delay: 1s;">🦁</div>
        <div class="absolute top-1/2 right-20 text-6xl animate-bounce" style="animation-delay: 1.5s;">🐒</div>
        <div class="absolute bottom-10 right-1/4 text-7xl animate-pulse" style="animation-delay: 2s;">🌺</div>
    </div>
    
    <div class="container-custom section-padding relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="relative z-10">
                <div class="inline-block mb-6 animate-bounce">
                    <span class="bg-gradient-to-r from-orange-fun to-sunshine-yellow text-white text-lg font-bold px-6 py-3 rounded-full shadow-xl border-4 border-orange-600" style="box-shadow: 0 6px 0 #E5A712;">
                        🏆 #1 Loc de Joacă în Vaslui 🏆
                    </span>
                </div>
                <h1 class="font-display text-5xl md:text-6xl lg:text-7xl text-jungle-dark mb-6 leading-tight" style="text-shadow: 3px 3px 0px rgba(255, 217, 61, 0.5);">
                    Aventura în <span class="gradient-text">JUNGLĂ</span> 🌴 pentru copiii tăi! 🦁
                </h1>
                <p class="text-xl md:text-2xl text-text-dark mb-8 leading-relaxed max-w-xl font-medium">
                    🎨 Un paradis tropical plin de joacă, distracție și aventuri! Copiii se vor simți ca adevărați exploratori în junglă! 🐒
                </p>
                
                {{-- Benefits --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                    <div class="flex items-center space-x-3 bg-white/80 p-4 rounded-2xl shadow-lg border-4 border-jungle-green transform hover:scale-105 transition-all">
                        <div class="flex-shrink-0 text-4xl">🛡️</div>
                        <span class="text-jungle-dark font-bold text-lg">100% Sigur</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white/80 p-4 rounded-2xl shadow-lg border-4 border-sky-blue transform hover:scale-105 transition-all">
                        <div class="flex-shrink-0 text-4xl">👨‍👩‍👧</div>
                        <span class="text-jungle-dark font-bold text-lg">Personal Expert</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white/80 p-4 rounded-2xl shadow-lg border-4 border-purple-fun transform hover:scale-105 transition-all">
                        <div class="flex-shrink-0 text-4xl">⏰</div>
                        <span class="text-jungle-dark font-bold text-lg">Orar Flexibil</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white/80 p-4 rounded-2xl shadow-lg border-4 border-coral-pink transform hover:scale-105 transition-all">
                        <div class="flex-shrink-0 text-4xl">🎂</div>
                        <span class="text-jungle-dark font-bold text-lg">Petreceri Epic</span>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-6">
                    <a href="#contact" class="btn-primary inline-flex items-center justify-center group text-xl">
                        🎯 Rezervă Aventura! 🎯
                        <svg class="w-6 h-6 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="#activitati" class="btn-secondary text-xl">
                        🌴 Descoperă Jungla 🦜
                    </a>
                </div>
            </div>
            
            <div class="relative lg:block">
                <div class="relative">
                    {{-- Main Image Placeholder --}}
                    <div class="relative bg-gradient-to-br from-jungle-green via-jungle-lime to-sunshine-yellow rounded-3xl overflow-hidden shadow-2xl aspect-square border-8 border-white transform hover:rotate-2 transition-all duration-300">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center p-8">
                                <div class="text-9xl mb-4 animate-bounce">🌴🦁🐒</div>
                                <p class="text-3xl font-bold text-white drop-shadow-lg">Junglă de Aventuri!</p>
                                <p class="text-xl font-semibold text-white/90 mt-2">🎪 Adaugă fotografii reale aici 📸</p>
                            </div>
                        </div>
                        {{-- Decorative jungle elements --}}
                        <div class="absolute top-4 left-4 text-5xl animate-pulse">🦜</div>
                        <div class="absolute top-4 right-4 text-5xl animate-bounce">🌺</div>
                        <div class="absolute bottom-4 left-4 text-5xl animate-pulse">🐘</div>
                        <div class="absolute bottom-4 right-4 text-5xl animate-bounce">🦒</div>
                    </div>
                    
                    {{-- Floating Stats Card --}}
                    <div class="absolute -bottom-6 -left-6 bg-gradient-to-br from-orange-fun to-sunshine-yellow rounded-3xl shadow-2xl p-6 hidden lg:block border-4 border-white transform hover:scale-110 transition-all">
                        <div class="flex items-center space-x-4">
                            <div class="text-5xl animate-bounce">😊</div>
                            <div>
                                <div class="text-3xl font-bold text-white drop-shadow-lg">500+</div>
                                <div class="text-sm text-white font-bold">Copii Fericiți! 🎉</div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Floating Rating Card --}}
                    <div class="absolute -top-6 -right-6 bg-gradient-to-br from-coral-pink to-purple-fun rounded-3xl shadow-2xl p-6 hidden lg:block border-4 border-white transform hover:scale-110 transition-all">
                        <div class="flex items-center space-x-1 mb-2 text-4xl">
                            ⭐⭐⭐⭐⭐
                        </div>
                        <div class="text-lg font-bold text-white drop-shadow-lg">Recenzii Super! 🎉</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Stats Section --}}
<section class="bg-gradient-to-r from-sunshine-yellow via-orange-fun to-coral-pink border-y-8 border-jungle-dark py-16">
    <div class="container-custom">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center transform hover:scale-110 transition-all">
                <div class="text-6xl mb-3 animate-bounce">😊</div>
                <div class="text-5xl font-bold text-white drop-shadow-lg mb-2">500+</div>
                <div class="text-white font-bold text-xl">Copii Fericiți</div>
            </div>
            <div class="text-center transform hover:scale-110 transition-all">
                <div class="text-6xl mb-3 animate-bounce" style="animation-delay: 0.2s;">🎉</div>
                <div class="text-5xl font-bold text-white drop-shadow-lg mb-2">200+</div>
                <div class="text-white font-bold text-xl">Petreceri Epic</div>
            </div>
            <div class="text-center transform hover:scale-110 transition-all">
                <div class="text-6xl mb-3 animate-bounce" style="animation-delay: 0.4s;">⭐</div>
                <div class="text-5xl font-bold text-white drop-shadow-lg mb-2">5★</div>
                <div class="text-white font-bold text-xl">Rating Maxim</div>
            </div>
            <div class="text-center transform hover:scale-110 transition-all">
                <div class="text-6xl mb-3 animate-bounce" style="animation-delay: 0.6s;">💯</div>
                <div class="text-5xl font-bold text-white drop-shadow-lg mb-2">100%</div>
                <div class="text-white font-bold text-xl">Părinți Mulțumiți</div>
            </div>
        </div>
    </div>
</section>

{{-- Activități Section --}}
<section id="activitati" class="section-padding bg-gradient-to-br from-lime-50 via-green-50 to-emerald-50 relative overflow-hidden">
    {{-- Decorative jungle elements --}}
    <div class="absolute top-10 left-10 text-8xl opacity-20 animate-pulse">🌴</div>
    <div class="absolute bottom-10 right-10 text-8xl opacity-20 animate-pulse">🦜</div>
    
    <div class="container-custom relative z-10">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <h2 class="section-title font-display gradient-text mb-4">🎨 Aventuri în Junglă pentru Toți! 🌴</h2>
            <p class="text-2xl text-text-dark font-semibold">
                🦁 Explorează, creează și distrează-te în paradisul nostru tropical! Fiecare zi e o nouă aventură! 🐒
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            {{-- Card 1 --}}
            <div class="card p-8 group bg-gradient-to-br from-sky-blue/20 to-blue-300/30 border-4 border-sky-blue hover:border-jungle-green">
                <div class="text-8xl mb-6 group-hover:scale-125 transition-transform animate-bounce">🎢</div>
                <h3 class="text-3xl font-bold text-jungle-dark mb-4 font-display">Tobogane & Aventuri!</h3>
                <p class="text-text-dark mb-6 leading-relaxed text-lg font-medium">
                    🌈 Zone magice cu echipamente super-sigure! Tobogane uriașe, piscine cu bile colorate și surprize peste tot! 🎪
                </p>
                <a href="#contact" class="bg-gradient-to-r from-sky-blue to-blue-400 text-white font-bold px-6 py-3 rounded-full inline-flex items-center group-hover:translate-x-2 transition-all shadow-lg">
                    Hai în Aventură! 🚀
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            
            {{-- Card 2 --}}
            <div class="card p-8 group bg-gradient-to-br from-coral-pink/20 to-pink-300/30 border-4 border-coral-pink hover:border-jungle-green">
                <div class="text-8xl mb-6 group-hover:scale-125 transition-transform animate-bounce" style="animation-delay: 0.2s;">🎨</div>
                <h3 class="text-3xl font-bold text-jungle-dark mb-4 font-display">Ateliere Creative!</h3>
                <p class="text-text-dark mb-6 leading-relaxed text-lg font-medium">
                    🖌️ Pictură, desen și artă fantastică! Creează opera ta de artă în junglă! Imagică liberă și distracție! 🌈
                </p>
                <a href="#contact" class="bg-gradient-to-r from-coral-pink to-pink-400 text-white font-bold px-6 py-3 rounded-full inline-flex items-center group-hover:translate-x-2 transition-all shadow-lg">
                    Devino Artist! 🎨
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            
            {{-- Card 3 --}}
            <div class="card p-8 group bg-gradient-to-br from-purple-fun/20 to-purple-400/30 border-4 border-purple-fun hover:border-jungle-green">
                <div class="text-8xl mb-6 group-hover:scale-125 transition-transform animate-bounce" style="animation-delay: 0.4s;">💃</div>
                <h3 class="text-3xl font-bold text-jungle-dark mb-4 font-display">Disco & Party!</h3>
                <p class="text-text-dark mb-6 leading-relaxed text-lg font-medium">
                    🎵 Dans, muzică și petrecere non-stop! Fă-ți prieteni noi și arată-le mișcările tale cool de dans! 🕺
                </p>
                <a href="#contact" class="bg-gradient-to-r from-purple-fun to-purple-500 text-white font-bold px-6 py-3 rounded-full inline-flex items-center group-hover:translate-x-2 transition-all shadow-lg">
                    Hai la Dans! 💃
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Orar Section --}}
<section id="orar" class="section-padding bg-gradient-to-br from-sunshine-yellow/30 via-orange-fun/20 to-coral-pink/20 relative overflow-hidden">
    {{-- Decorative elements --}}
    <div class="absolute top-0 right-0 text-9xl opacity-10 animate-pulse">⏰</div>
    <div class="absolute bottom-0 left-0 text-9xl opacity-10 animate-pulse">📅</div>
    
    <div class="container-custom relative z-10">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <h2 class="section-title font-display gradient-text mb-4">📅 Program Săptămânal 🎉</h2>
            <p class="text-2xl text-text-dark mb-6 font-bold">
                🌴 Suntem deschiși ZILNIC pentru aventuri în junglă! 🦁
            </p>
            @php
                $startDate = \Carbon\Carbon::now()->startOfWeek();
                $endDate = \Carbon\Carbon::now()->endOfWeek();
            @endphp
            <div class="inline-flex items-center bg-gradient-to-r from-jungle-green to-jungle-lime px-8 py-4 rounded-full shadow-xl border-4 border-white transform hover:scale-105 transition-all">
                <span class="text-4xl mr-3">📅</span>
                <span class="text-white font-bold text-xl">{{ $startDate->format('d.m') }} - {{ $endDate->format('d.m.Y') }}</span>
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
            <div class="card p-6 bg-white border-4 border-jungle-green hover:border-sunshine-yellow transform hover:rotate-3">
                <h3 class="text-2xl font-bold text-jungle-dark mb-4 text-center border-b-4 border-jungle-lime pb-3 font-display">{{ $day['name'] }}</h3>
                @if($day['private'])
                    <div class="space-y-3">
                        <div class="bg-gradient-to-r from-jungle-green to-jungle-lime text-white px-4 py-3 rounded-2xl text-sm font-bold text-center shadow-lg">
                            <div class="text-lg mb-1">🎮 Joacă Liberă</div>
                            <div class="text-2xl">09:00-20:00</div>
                        </div>
                        <div class="bg-gradient-to-r from-purple-fun to-pink-400 text-white px-4 py-3 rounded-2xl text-sm font-bold text-center shadow-lg">
                            <div class="text-lg mb-1">🎉 Eveniment Privat</div>
                            <div class="text-2xl">{{ $day['private_time'] }}</div>
                        </div>
                    </div>
                @else
                    <div class="bg-gradient-to-r from-jungle-green to-jungle-lime text-white px-4 py-3 rounded-2xl text-sm font-bold text-center shadow-lg">
                        <div class="text-lg mb-1">🎮 Joacă Liberă</div>
                        <div class="text-2xl">09:00-20:00</div>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Petreceri Section --}}
<section id="petreceri" class="section-padding bg-gradient-to-br from-coral-pink/30 via-purple-fun/20 to-sunshine-yellow/30 relative overflow-hidden">
    {{-- Party decorations --}}
    <div class="absolute inset-0 opacity-10 text-9xl">
        <div class="absolute top-10 left-10 animate-bounce">🎈</div>
        <div class="absolute top-10 right-10 animate-bounce" style="animation-delay: 0.3s;">🎁</div>
        <div class="absolute bottom-10 left-10 animate-bounce" style="animation-delay: 0.6s;">🎂</div>
        <div class="absolute bottom-10 right-10 animate-bounce" style="animation-delay: 0.9s;">🎊</div>
    </div>
    
    <div class="container-custom relative z-10">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <h2 class="section-title font-display gradient-text mb-4">🎉 Petreceri EPICE în Junglă! 🎂</h2>
            <p class="text-2xl text-text-dark font-bold">
                🦁 Organizăm cele mai tari petreceri de naștere! Tu te relaxezi, noi ne ocupăm de TOTUL! 🎈
            </p>
        </div>
        
        {{-- Benefits Grid --}}
        <div class="bg-gradient-to-br from-white to-sunshine-yellow/20 rounded-3xl shadow-2xl p-8 md:p-12 mb-12 max-w-5xl mx-auto border-8 border-jungle-green">
            <h3 class="text-4xl font-bold text-jungle-dark mb-8 text-center font-display">🎁 Ce Include Pachetul Magic? ✨</h3>
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
                @foreach($benefits as $index => $benefit)
                @php
                    $emojis = ['⏰', '🎨', '🤹', '📸', '👥', '🛡️'];
                    $colors = ['from-jungle-green to-jungle-lime', 'from-coral-pink to-pink-400', 'from-purple-fun to-purple-500', 'from-sky-blue to-blue-400', 'from-sunshine-yellow to-orange-fun', 'from-orange-fun to-red-400'];
                @endphp
                <div class="flex items-start space-x-4 bg-gradient-to-r {{ $colors[$index] }} p-4 rounded-2xl shadow-lg transform hover:scale-105 transition-all">
                    <div class="flex-shrink-0 text-5xl">
                        {{ $emojis[$index] }}
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-xl mb-1">{{ $benefit['title'] }}</h4>
                        <p class="text-white/90 font-medium">{{ $benefit['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        {{-- Pricing Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            {{-- Basic --}}
            <div class="bg-gradient-to-br from-sky-blue/30 to-blue-300/30 rounded-3xl shadow-2xl p-8 hover:shadow-2xl transition-all border-4 border-sky-blue transform hover:scale-105 hover:rotate-2">
                <div class="text-center mb-6">
                    <div class="text-6xl mb-3 animate-bounce">🌟</div>
                    <h3 class="text-3xl font-bold text-jungle-dark mb-2 font-display">Pachet STARTER</h3>
                    <div class="flex items-baseline justify-center">
                        <span class="text-6xl font-bold text-jungle-dark">250</span>
                        <span class="text-jungle-dark ml-2 text-2xl font-bold">RON</span>
                    </div>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center text-jungle-dark font-bold text-lg">
                        <span class="text-3xl mr-3">✅</span>
                        ⏰ 2 ore de joacă
                    </li>
                    <li class="flex items-center text-jungle-dark font-bold text-lg">
                        <span class="text-3xl mr-3">✅</span>
                        🎈 Decoruri simple
                    </li>
                    <li class="flex items-center text-jungle-dark font-bold text-lg">
                        <span class="text-3xl mr-3">✅</span>
                        👥 Până la 10 copii
                    </li>
                </ul>
                <a href="#contact" class="block w-full btn-secondary text-center text-lg">
                    🎯 Alegeți Starter! 🎯
                </a>
            </div>
            
            {{-- Premium --}}
            <div class="bg-gradient-to-br from-jungle-green via-jungle-lime to-sunshine-yellow rounded-3xl shadow-2xl p-8 transform scale-110 relative border-8 border-orange-fun animate-pulse" style="animation-duration: 2s;">
                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
                    <span class="bg-gradient-to-r from-orange-fun to-red-500 text-white text-xl font-bold px-8 py-3 rounded-full shadow-2xl border-4 border-white animate-bounce">
                        🏆 CEL MAI POPULAR! 🏆
                    </span>
                </div>
                <div class="text-center mb-6 mt-8">
                    <div class="text-8xl mb-4 animate-spin" style="animation-duration: 3s;">⭐</div>
                    <h3 class="text-4xl font-bold text-white mb-2 font-display drop-shadow-lg">Pachet PREMIUM 👑</h3>
                    <div class="flex items-baseline justify-center">
                        <span class="text-7xl font-bold text-white drop-shadow-lg">350</span>
                        <span class="text-white ml-2 text-3xl font-bold">RON</span>
                    </div>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center text-white font-bold text-lg">
                        <span class="text-4xl mr-3">✨</span>
                        ⏰ 3 ore de joacă
                    </li>
                    <li class="flex items-center text-white font-bold text-lg">
                        <span class="text-4xl mr-3">✨</span>
                        🎨 Decoruri tematice
                    </li>
                    <li class="flex items-center text-white font-bold text-lg">
                        <span class="text-4xl mr-3">✨</span>
                        🤹 Animator dedicat
                    </li>
                    <li class="flex items-center text-white font-bold text-lg">
                        <span class="text-4xl mr-3">✨</span>
                        📸 Fotografii incluse
                    </li>
                    <li class="flex items-center text-white font-bold text-lg">
                        <span class="text-4xl mr-3">✨</span>
                        👥 Până la 15 copii
                    </li>
                </ul>
                <a href="#contact" class="block w-full bg-gradient-to-r from-orange-fun to-red-500 hover:from-red-500 hover:to-orange-fun text-white font-bold py-5 rounded-full text-center transition-all text-xl shadow-2xl border-4 border-white transform hover:scale-105">
                    🎉 VREAU PREMIUM! 🎉
                </a>
            </div>
            
            {{-- Deluxe --}}
            <div class="bg-gradient-to-br from-purple-fun/30 to-coral-pink/30 rounded-3xl shadow-2xl p-8 hover:shadow-2xl transition-all border-4 border-purple-fun transform hover:scale-105 hover:rotate-2">
                <div class="text-center mb-6">
                    <div class="text-6xl mb-3 animate-bounce">💎</div>
                    <h3 class="text-3xl font-bold text-jungle-dark mb-2 font-display">Pachet DELUXE 💎</h3>
                    <div class="flex items-baseline justify-center">
                        <span class="text-6xl font-bold text-jungle-dark">450</span>
                        <span class="text-jungle-dark ml-2 text-2xl font-bold">RON</span>
                    </div>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center text-jungle-dark font-bold text-lg">
                        <span class="text-3xl mr-3">🌟</span>
                        ⏰ 4 ore de joacă
                    </li>
                    <li class="flex items-center text-jungle-dark font-bold text-lg">
                        <span class="text-3xl mr-3">🌟</span>
                        🎨 Decoruri premium
                    </li>
                    <li class="flex items-center text-jungle-dark font-bold text-lg">
                        <span class="text-3xl mr-3">🌟</span>
                        🤹 Animator + fotograf
                    </li>
                    <li class="flex items-center text-jungle-dark font-bold text-lg">
                        <span class="text-3xl mr-3">🌟</span>
                        📖 Album foto
                    </li>
                    <li class="flex items-center text-jungle-dark font-bold text-lg">
                        <span class="text-3xl mr-3">🌟</span>
                        👥 Până la 20 copii
                    </li>
                </ul>
                <a href="#contact" class="block w-full btn-primary text-center text-lg">
                    💎 Vreau Deluxe! 💎
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Contact Section --}}
<section id="contact" class="section-padding bg-gradient-to-br from-green-50 via-lime-50 to-yellow-50 relative overflow-hidden">
    {{-- Contact decorations --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 text-9xl animate-pulse">📞</div>
        <div class="absolute bottom-10 right-10 text-9xl animate-pulse">✉️</div>
    </div>
    
    <div class="container-custom max-w-6xl relative z-10">
        <div class="text-center mb-16">
            <h2 class="section-title font-display gradient-text mb-4">📞 Hai să Vorbim! 💬</h2>
            <p class="text-2xl text-text-dark font-bold">
                🌴 Suntem aici pentru tine! Hai să organizăm cea mai tare petrecere! 🎉
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">
            {{-- Contact Info --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="card p-8 bg-gradient-to-r from-jungle-green to-jungle-lime border-4 border-white transform hover:rotate-2">
                    <div class="flex items-start space-x-4">
                        <div class="text-6xl">📞</div>
                        <div>
                            <h3 class="font-bold text-white text-2xl mb-2">Sună-ne Acum!</h3>
                            <p class="text-white font-bold text-xl">+40 XXX XXX XXX</p>
                            <p class="text-white/90 font-medium mt-2">📅 Luni - Duminică, 09:00 - 20:00</p>
                        </div>
                    </div>
                </div>
                
                <div class="card p-8 bg-gradient-to-r from-coral-pink to-purple-fun border-4 border-white transform hover:rotate-2">
                    <div class="flex items-start space-x-4">
                        <div class="text-6xl">✉️</div>
                        <div>
                            <h3 class="font-bold text-white text-2xl mb-2">Scrie-ne Email!</h3>
                            <p class="text-white font-bold text-xl">contact@bongoland.ro</p>
                            <p class="text-white/90 font-medium mt-2">⚡ Răspundem în 24h</p>
                        </div>
                    </div>
                </div>
                
                <div class="card p-8 bg-gradient-to-r from-sunshine-yellow to-orange-fun border-4 border-white transform hover:rotate-2">
                    <div class="flex items-start space-x-4">
                        <div class="text-6xl">📍</div>
                        <div>
                            <h3 class="font-bold text-white text-2xl mb-2">Vino în Junglă!</h3>
                            <p class="text-white font-bold text-xl">Vaslui, România</p>
                            <p class="text-white/90 font-medium mt-2">🚗 Parcare disponibilă</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-purple-fun to-pink-400 border-8 border-white p-6 rounded-3xl shadow-2xl transform hover:scale-105 transition-all">
                    <p class="text-lg text-white leading-relaxed font-bold text-center">
                        🌴 <strong class="text-2xl">Hai să ne cunoaștem!</strong> 🦁<br/>
                        Suntem super entuziasmați să îți arătăm jungla noastră magică! 🎉
                    </p>
                </div>
            </div>
            
            {{-- Contact Form --}}
            <div class="lg:col-span-3">
                <div class="card p-8 bg-gradient-to-br from-white to-lime-50 border-4 border-jungle-green">
                    <h3 class="text-3xl font-bold text-jungle-dark mb-6 font-display text-center">💬 Trimite-ne un Mesaj Magic! ✨</h3>
                    <form action="{{ route('landing.contact.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="parent_name" class="block text-lg font-bold text-jungle-dark mb-2">👨‍👩‍👧 Nume Părinte *</label>
                            <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name') }}" required 
                                class="w-full px-6 py-4 border-4 border-jungle-green rounded-2xl focus:ring-4 focus:ring-sunshine-yellow focus:border-sunshine-yellow transition-all outline-none text-lg font-medium">
                            @if(isset($errors) && $errors->has('parent_name'))
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $errors->first('parent_name') }}</p>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="child_name" class="block text-lg font-bold text-jungle-dark mb-2">🧒 Nume Copil</label>
                                <input type="text" name="child_name" id="child_name" value="{{ old('child_name') }}" 
                                    class="w-full px-6 py-4 border-4 border-sky-blue rounded-2xl focus:ring-4 focus:ring-coral-pink focus:border-coral-pink transition-all outline-none text-lg font-medium">
                            </div>
                            <div>
                                <label for="child_age" class="block text-lg font-bold text-jungle-dark mb-2">🎂 Vârstă</label>
                                <input type="number" name="child_age" id="child_age" value="{{ old('child_age') }}" min="1" max="18" 
                                    class="w-full px-6 py-4 border-4 border-purple-fun rounded-2xl focus:ring-4 focus:ring-orange-fun focus:border-orange-fun transition-all outline-none text-lg font-medium">
                            </div>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-lg font-bold text-jungle-dark mb-2">💬 Mesajul Tău *</label>
                            <textarea name="message" id="message" rows="5" required 
                                class="w-full px-6 py-4 border-4 border-jungle-lime rounded-2xl focus:ring-4 focus:ring-sunshine-yellow focus:border-sunshine-yellow transition-all outline-none resize-none text-lg font-medium"
                                placeholder="Spune-ne despre petrecerea visurilor tale... 🎉">{{ old('message') }}</textarea>
                            @if(isset($errors) && $errors->has('message'))
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $errors->first('message') }}</p>
                            @endif
                        </div>
                        
                        <button type="submit" class="w-full btn-primary flex items-center justify-center group text-2xl py-6">
                            🚀 Trimite Mesajul Magic! ✨
                            <svg class="w-6 h-6 ml-3 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="section-padding bg-gradient-to-br from-jungle-green via-jungle-lime to-sunshine-yellow text-white relative overflow-hidden">
    {{-- Animated decorations --}}
    <div class="absolute inset-0 opacity-20">
        <div class="text-9xl absolute top-10 left-10 animate-bounce">🌴</div>
        <div class="text-9xl absolute top-10 right-10 animate-bounce" style="animation-delay: 0.5s;">🦁</div>
        <div class="text-9xl absolute bottom-10 left-1/4 animate-bounce" style="animation-delay: 1s;">🎉</div>
        <div class="text-9xl absolute bottom-10 right-1/4 animate-bounce" style="animation-delay: 1.5s;">🐒</div>
    </div>
    
    <div class="container-custom text-center relative z-10">
        <h2 class="text-5xl md:text-7xl font-display font-bold mb-8 drop-shadow-lg" style="text-shadow: 4px 4px 0px rgba(0,0,0,0.2);">
            🌴 Gata de AVENTURĂ? 🦁
        </h2>
        <p class="text-3xl text-white mb-12 max-w-3xl mx-auto font-bold drop-shadow-lg">
            🎉 Alătură-te sutelor de familii care și-au transformat zilele copiilor în AVENTURI DE NEUITAT! 🌈
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="#contact" class="bg-gradient-to-r from-orange-fun to-red-500 hover:from-red-500 hover:to-orange-fun text-white font-bold text-2xl px-12 py-6 rounded-full inline-flex items-center justify-center border-8 border-white shadow-2xl transform hover:scale-110 transition-all">
                🎯 REZERVĂ ACUM! 🎯
                <svg class="w-8 h-8 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="#orar" class="bg-white/90 hover:bg-white text-jungle-dark font-bold text-2xl px-12 py-6 rounded-full border-8 border-white shadow-2xl transform hover:scale-110 transition-all">
                📅 Vezi Programul 📅
            </a>
        </div>
    </div>
</section>
@endsection
