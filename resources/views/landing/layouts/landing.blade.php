<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- SEO Meta Tags --}}
    <title>{{ $metaTitle ?? 'Bongoland - Loc de Joacă Vaslui' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Bongoland este cel mai bun loc de joacă din Vaslui pentru copii. Oferim activități distractive, zile de naștere memorabile și un mediu sigur.' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'locuri de joacă Vaslui, parc de joacă Vaslui, playground Vaslui, activități copii Vaslui, zi de naștere copii Vaslui' }}">
    <meta name="author" content="Bongoland Vaslui">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $metaTitle ?? 'Bongoland - Loc de Joacă Vaslui' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Bongoland este cel mai bun loc de joacă din Vaslui pentru copii.' }}">
    <meta property="og:image" content="{{ asset('images/bongoland-og.jpg') }}">
    <meta property="og:locale" content="ro_RO">
    <meta property="og:site_name" content="Bongoland Vaslui">
    
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $metaTitle ?? 'Bongoland - Loc de Joacă Vaslui' }}">
    <meta name="twitter:description" content="{{ $metaDescription ?? 'Bongoland este cel mai bun loc de joacă din Vaslui pentru copii.' }}">
    <meta name="twitter:image" content="{{ asset('images/bongoland-og.jpg') }}">
    
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Structured Data (JSON-LD) --}}
    @include('landing.components.structured-data')
    
    @stack('styles')
    
    {{-- Jungle Cartoon Theme 🌴🦁 --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&family=Chewy&family=Comic+Neue:wght@400;700&display=swap');
        
        :root {
            --jungle-green: #2ECC71;
            --jungle-dark: #27AE60;
            --jungle-lime: #7FD12D;
            --sunshine-yellow: #FFD93D;
            --orange-fun: #FF9F1C;
            --brown-earth: #8B6F47;
            --sky-blue: #6BCFFF;
            --coral-pink: #FF6B9D;
            --purple-fun: #9B59B6;
            --text-dark: #2C3E50;
            --text-light: #546E7A;
            --bg-cream: #FFF9E6;
            --bg-light-green: #E8F8F5;
            --shadow-sm: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 8px 0 rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 8px 16px 0 rgba(0, 0, 0, 0.15);
            --shadow-xl: 0 12px 24px 0 rgba(0, 0, 0, 0.18);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Fredoka', 'Comic Neue', cursive, sans-serif;
            color: var(--text-dark);
            line-height: 1.7;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background: var(--bg-cream);
        }
        
        .font-display {
            font-family: 'Chewy', 'Fredoka', cursive;
            font-weight: 400;
            letter-spacing: 0.02em;
        }
        
        .section-padding {
            padding: 5rem 0;
        }
        
        @media (min-width: 768px) {
            .section-padding {
                padding: 6rem 0;
            }
        }
        
        @media (min-width: 1024px) {
            .section-padding {
                padding: 8rem 0;
            }
        }
        
        .container-custom {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        
        @media (min-width: 640px) {
            .container-custom {
                padding: 0 2rem;
            }
        }
        
        @media (min-width: 1024px) {
            .container-custom {
                padding: 0 3rem;
            }
        }
        
        .card {
            background: white;
            border-radius: 2rem;
            box-shadow: var(--shadow-md);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 4px solid transparent;
        }
        
        .card:hover {
            box-shadow: var(--shadow-xl);
            transform: translateY(-8px) rotate(-1deg);
            border-color: var(--sunshine-yellow);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--jungle-green) 0%, var(--jungle-lime) 100%);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 2rem;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: 4px solid var(--jungle-dark);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-transform: uppercase;
            box-shadow: 0 6px 0 var(--jungle-dark);
        }
        
        .btn-primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 0 var(--jungle-dark);
        }
        
        .btn-primary:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 var(--jungle-dark);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, var(--sunshine-yellow) 0%, var(--orange-fun) 100%);
            color: var(--text-dark);
            padding: 1rem 2.5rem;
            border-radius: 2rem;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: 4px solid #E5A712;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-transform: uppercase;
            box-shadow: 0 6px 0 #E5A712;
        }
        
        .btn-secondary:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 0 #E5A712;
        }
        
        .btn-secondary:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 #E5A712;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, var(--jungle-green) 0%, var(--jungle-lime) 50%, var(--sunshine-yellow) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 400;
            line-height: 1.3;
            margin-bottom: 1rem;
            color: var(--text-dark);
            text-shadow: 3px 3px 0px rgba(255, 217, 61, 0.4);
        }
        
        @media (min-width: 768px) {
            .section-title {
                font-size: 3.5rem;
            }
        }
        
        @media (min-width: 1024px) {
            .section-title {
                font-size: 4rem;
            }
        }
        
        .section-subtitle {
            font-size: 1.25rem;
            color: var(--text-light);
            max-width: 42rem;
            margin: 0 auto;
            font-weight: 500;
        }
        
        @media (min-width: 768px) {
            .section-subtitle {
                font-size: 1.5rem;
            }
        }
        
        .nav-link {
            color: var(--text-dark);
            font-weight: 600;
            padding: 0.75rem 1.25rem;
            border-radius: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            font-size: 1.05rem;
        }
        
        .nav-link:hover {
            color: white;
            background: linear-gradient(135deg, var(--jungle-green), var(--jungle-lime));
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(46, 204, 113, 0.3);
        }
        
        .nav-link.active {
            color: white;
            background: linear-gradient(135deg, var(--jungle-green), var(--jungle-lime));
            box-shadow: 0 4px 8px rgba(46, 204, 113, 0.3);
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, var(--jungle-green) 0%, var(--jungle-lime) 50%, var(--sunshine-yellow) 100%);
        }
        
        .feature-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .smooth-scroll {
            scroll-behavior: smooth;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        /* Jungle-themed animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes swing {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            75% { transform: rotate(-5deg); }
        }
        
        @keyframes wiggle {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-3deg); }
            50% { transform: rotate(3deg); }
            75% { transform: rotate(-3deg); }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .animate-swing {
            animation: swing 2s ease-in-out infinite;
        }
        
        .animate-wiggle {
            animation: wiggle 1s ease-in-out infinite;
        }
        
        /* Fun hover effects */
        .hover-grow:hover {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }
        
        .hover-shake:hover {
            animation: wiggle 0.5s ease-in-out;
        }
        
        /* Jungle gradient background patterns */
        .jungle-pattern {
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(46, 204, 113, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 217, 61, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(127, 209, 45, 0.1) 0%, transparent 50%);
        }
    </style>
</head>
<body class="antialiased smooth-scroll">
    {{-- Navigation --}}
    <nav class="bg-gradient-to-r from-jungle-green via-jungle-lime to-sunshine-yellow shadow-lg sticky top-0 z-50 border-b-4 border-jungle-dark" style="background: linear-gradient(90deg, #2ECC71 0%, #7FD12D 50%, #FFD93D 100%);">
        <div class="container-custom">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('landing.index') }}" class="flex items-center space-x-3 group">
                        @php $logoExists = file_exists(public_path('images/kidspass-logo.png')); @endphp
                        @if($logoExists)
                            <img src="{{ asset('images/kidspass-logo.png') }}" alt="Bongoland Logo" class="h-12 w-auto transition-transform group-hover:scale-105 drop-shadow-lg">
                        @endif
                        <span class="text-3xl font-display text-white drop-shadow-lg">🌴 Bongoland 🦁</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('landing.index') }}#hero" class="bg-white/90 hover:bg-white text-jungle-dark font-bold px-5 py-3 rounded-full transition-all hover:scale-105 shadow-md">🏠 Acasă</a>
                    <a href="{{ route('landing.index') }}#activitati" class="bg-white/90 hover:bg-white text-jungle-dark font-bold px-5 py-3 rounded-full transition-all hover:scale-105 shadow-md">🎨 Activități</a>
                    <a href="{{ route('landing.index') }}#orar" class="bg-white/90 hover:bg-white text-jungle-dark font-bold px-5 py-3 rounded-full transition-all hover:scale-105 shadow-md">📅 Orar</a>
                    <a href="{{ route('landing.index') }}#petreceri" class="bg-white/90 hover:bg-white text-jungle-dark font-bold px-5 py-3 rounded-full transition-all hover:scale-105 shadow-md">🎉 Petreceri</a>
                    <a href="{{ route('landing.index') }}#contact" class="bg-white/90 hover:bg-white text-jungle-dark font-bold px-5 py-3 rounded-full transition-all hover:scale-105 shadow-md">📞 Contact</a>
                </div>
                
                {{-- Mobile menu button --}}
                <button id="mobile-menu-button" class="md:hidden p-3 rounded-xl bg-white/90 text-jungle-dark hover:bg-white transition-all shadow-md">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        {{-- Mobile menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t-4 border-jungle-dark bg-white/95">
            <div class="container-custom py-4 space-y-2">
                <a href="{{ route('landing.index') }}#hero" class="block px-5 py-4 rounded-2xl bg-gradient-to-r from-jungle-green to-jungle-lime text-white font-bold transition-all shadow-md">🏠 Acasă</a>
                <a href="{{ route('landing.index') }}#activitati" class="block px-5 py-4 rounded-2xl bg-sky-blue/20 text-jungle-dark font-bold hover:bg-sky-blue/40 transition-all">🎨 Activități</a>
                <a href="{{ route('landing.index') }}#orar" class="block px-5 py-4 rounded-2xl bg-sunshine-yellow/20 text-jungle-dark font-bold hover:bg-sunshine-yellow/40 transition-all">📅 Orar</a>
                <a href="{{ route('landing.index') }}#petreceri" class="block px-5 py-4 rounded-2xl bg-coral-pink/20 text-jungle-dark font-bold hover:bg-coral-pink/40 transition-all">🎉 Petreceri</a>
                <a href="{{ route('landing.index') }}#contact" class="block px-5 py-4 rounded-2xl bg-purple-fun/20 text-jungle-dark font-bold hover:bg-purple-fun/40 transition-all">📞 Contact</a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @php
            if (!isset($errors)) {
                $errors = new \Illuminate\Support\ViewErrorBag();
            }
        @endphp
        
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mx-auto max-w-7xl mt-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mx-auto max-w-7xl mt-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mx-auto max-w-7xl mt-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">Erori de validare:</p>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gradient-to-br from-jungle-dark to-brown-earth text-white mt-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="text-9xl">🌴🦁🐒🦜🌺🍃🌴🦒🐘🦓</div>
        </div>
        <div class="container-custom py-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div>
                    <h3 class="text-2xl font-display mb-4">🌴 Bongoland 🦁</h3>
                    <p class="text-white/80 leading-relaxed font-medium">Cel mai distractiv loc de joacă din Vaslui pentru copii! Aventură în junglă cu securitate maximă! 🎉</p>
                </div>
                
                <div>
                    <h4 class="text-xl font-bold mb-4">🔗 Link-uri Rapide</h4>
                    <ul class="space-y-3 text-white/80 font-medium">
                        <li><a href="{{ route('landing.index') }}#activitati" class="hover:text-sunshine-yellow transition-colors inline-flex items-center">🎨 Activități</a></li>
                        <li><a href="{{ route('landing.index') }}#orar" class="hover:text-sunshine-yellow transition-colors inline-flex items-center">📅 Orar</a></li>
                        <li><a href="{{ route('landing.index') }}#petreceri" class="hover:text-sunshine-yellow transition-colors inline-flex items-center">🎉 Petreceri</a></li>
                        <li><a href="{{ route('landing.index') }}#contact" class="hover:text-sunshine-yellow transition-colors inline-flex items-center">📞 Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-xl font-bold mb-4">📍 Contact</h4>
                    <ul class="space-y-3 text-white/80 font-medium">
                        <li>📍 Vaslui, România</li>
                        <li>📧 contact@bongoland.ro</li>
                        <li>📞 +40 XXX XXX XXX</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t-4 border-sunshine-yellow/30 mt-12 pt-8 text-center">
                <p class="text-white/90 font-bold text-lg">&copy; {{ date('Y') }} Bongoland 🌴 Toate drepturile rezervate.</p>
                <p class="mt-2 text-sunshine-yellow font-medium">🦁 Aventura ta în junglă începe aici! 🌴</p>
            </div>
        </div>
    </footer>

    {{-- Mobile menu script --}}
    <script>
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.length > 1) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        const offset = 80; // Navbar height
                        const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                        // Close mobile menu if open
                        const mobileMenu = document.getElementById('mobile-menu');
                        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                        }
                    }
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
