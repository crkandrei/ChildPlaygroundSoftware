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
    
    {{-- Professional Design System --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap');
        
        :root {
            --primary: #2563EB;
            --primary-dark: #1E40AF;
            --secondary: #F59E0B;
            --accent: #EC4899;
            --success: #10B981;
            --text-primary: #111827;
            --text-secondary: #6B7280;
            --bg-primary: #FFFFFF;
            --bg-secondary: #F9FAFB;
            --border: #E5E7EB;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .font-display {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: -0.025em;
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
            background: var(--bg-primary);
            border-radius: 1rem;
            box-shadow: var(--shadow-md);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card:hover {
            box-shadow: var(--shadow-xl);
            transform: translateY(-4px);
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-secondary {
            background: white;
            color: var(--primary);
            padding: 0.875rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
            border: 2px solid var(--primary);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-secondary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }
        
        @media (min-width: 768px) {
            .section-title {
                font-size: 3rem;
            }
        }
        
        @media (min-width: 1024px) {
            .section-title {
                font-size: 3.5rem;
            }
        }
        
        .section-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            max-width: 42rem;
            margin: 0 auto;
        }
        
        @media (min-width: 768px) {
            .section-subtitle {
                font-size: 1.5rem;
            }
        }
        
        .nav-link {
            color: var(--text-secondary);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: var(--primary);
            background: rgba(37, 99, 235, 0.05);
        }
        
        .nav-link.active {
            color: var(--primary);
            background: rgba(37, 99, 235, 0.1);
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%);
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
    </style>
</head>
<body class="bg-white antialiased smooth-scroll">
    {{-- Navigation --}}
    <nav class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="container-custom">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('landing.index') }}" class="flex items-center space-x-3 group">
                        @php $logoExists = file_exists(public_path('images/kidspass-logo.png')); @endphp
                        @if($logoExists)
                            <img src="{{ asset('images/kidspass-logo.png') }}" alt="Bongoland Logo" class="h-10 w-auto transition-transform group-hover:scale-105">
                        @endif
                        <span class="text-2xl font-display font-bold gradient-text">Bongoland</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('landing.index') }}#hero" class="nav-link {{ request()->routeIs('landing.index') ? 'active' : '' }}">Acasă</a>
                    <a href="{{ route('landing.index') }}#activitati" class="nav-link">Activități</a>
                    <a href="{{ route('landing.index') }}#orar" class="nav-link">Orar</a>
                    <a href="{{ route('landing.index') }}#petreceri" class="nav-link">Petreceri</a>
                    <a href="{{ route('landing.index') }}#contact" class="nav-link">Contact</a>
                </div>
                
                {{-- Mobile menu button --}}
                <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        {{-- Mobile menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white">
            <div class="container-custom py-4 space-y-1">
                <a href="{{ route('landing.index') }}#hero" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">Acasă</a>
                <a href="{{ route('landing.index') }}#activitati" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">Activități</a>
                <a href="{{ route('landing.index') }}#orar" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">Orar</a>
                <a href="{{ route('landing.index') }}#petreceri" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">Petreceri</a>
                <a href="{{ route('landing.index') }}#contact" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">Contact</a>
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
    <footer class="bg-gray-900 text-white mt-24">
        <div class="container-custom py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div>
                    <h3 class="text-xl font-display font-bold mb-4">Bongoland</h3>
                    <p class="text-gray-400 leading-relaxed">Cel mai bun loc de joacă din Vaslui pentru copii. Oferim un mediu sigur și distractiv.</p>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Link-uri Rapide</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('landing.index') }}#activitati" class="hover:text-white transition-colors">Activități</a></li>
                        <li><a href="{{ route('landing.index') }}#orar" class="hover:text-white transition-colors">Orar</a></li>
                        <li><a href="{{ route('landing.index') }}#petreceri" class="hover:text-white transition-colors">Petreceri</a></li>
                        <li><a href="{{ route('landing.index') }}#contact" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Vaslui, România</li>
                        <li>Email: contact@bongoland.ro</li>
                        <li>Telefon: +40 XXX XXX XXX</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} Bongoland. Toate drepturile rezervate.</p>
                <p class="mt-2 text-sm text-gray-500">Vaslui, România</p>
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
