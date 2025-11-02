<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KidsPass') - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Choices.js CSS for searchable selects -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

    <style>
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        .sidebar-hidden {
            transform: translateX(-100%);
        }
        .sidebar-visible {
            transform: translateX(0);
        }
        /* Mobile: sidebar hidden by default */
        @media (max-width: 1023px) {
            #sidebar {
                transform: translateX(-100%);
            }
            #sidebar.sidebar-visible {
                transform: translateX(0);
            }
            #sidebar.sidebar-collapsed {
                width: 16rem !important; /* Reset to full width on mobile */
            }
            #main-content.main-content-collapsed {
                margin-left: 0 !important;
            }
            /* Hide collapse button on mobile */
            #sidebar-collapse-btn {
                display: none !important;
            }
        }
        /* Desktop: show sidebar and collapse button */
        @media (min-width: 1024px) {
            #sidebar {
                transform: translateX(0) !important;
            }
            #sidebar.sidebar-hidden {
                transform: translateX(0) !important;
            }
        }
        /* Sidebar collapsed state */
        @media (min-width: 1024px) {
            #sidebar.sidebar-collapsed {
                width: 5rem !important; /* 80px */
            }
            #sidebar.sidebar-collapsed .sidebar-text {
                opacity: 0;
                width: 0;
                overflow: hidden;
                transition: opacity 0.3s ease, width 0.3s ease;
            }
            #sidebar.sidebar-collapsed nav > div {
                padding-left: 0 !important;
                padding-right: 0 !important;
                display: flex;
                flex-direction: column;
                align-items: stretch;
                gap: 0.5rem;
            }
            #sidebar.sidebar-collapsed nav a {
                justify-content: center !important;
                align-items: center !important;
                padding: 0.75rem 0 !important;
                width: 100%;
                max-width: 100%;
                position: relative;
            }
            #sidebar.sidebar-collapsed .sidebar-icon {
                margin-left: 0 !important;
                margin-right: 0 !important;
                margin-top: 0 !important;
                margin-bottom: 0 !important;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            #sidebar.sidebar-collapsed nav a span.sidebar-text {
                display: none !important;
            }
            #sidebar.sidebar-collapsed nav a::after {
                content: attr(data-title);
                position: absolute;
                left: calc(100% + 0.75rem);
                top: 50%;
                transform: translateY(-50%);
                background-color: #1f2937;
                color: white;
                padding: 0.5rem 0.75rem;
                border-radius: 0.375rem;
                white-space: nowrap;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.2s ease;
                z-index: 1000;
                font-size: 0.875rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }
            #sidebar.sidebar-collapsed nav a:hover::after {
                opacity: 1;
            }
            #sidebar.sidebar-collapsed .sidebar-logo-text {
                opacity: 0;
                width: 0;
                overflow: hidden;
                transition: opacity 0.3s ease, width 0.3s ease;
            }
            #sidebar.sidebar-collapsed .sidebar-toggle-btn {
                margin: 0 auto;
            }
            /* Adjust main content margin when sidebar is collapsed */
            #main-content.main-content-collapsed {
                margin-left: 5rem !important;
            }
        }
        .admin-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        /* Choices.js minimal styling overrides (optional) */
        .choices__inner { min-height: 42px; padding-top: 6px; padding-bottom: 6px; }
        .choices__list--dropdown .choices__item { font-size: 0.9rem; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="w-64 bg-gray-900 text-white sidebar-transition fixed inset-y-0 left-0 z-50 sidebar-hidden lg:static lg:translate-x-0 lg:sidebar-visible">
            <div class="flex items-center justify-between h-16 bg-gray-800 px-4">
                <div class="flex items-center flex-1 min-w-0">
                    @php $logoExists = file_exists(public_path('images/kidspass-logo.png')); @endphp
                    @if($logoExists)
                        <img src="{{ asset('images/kidspass-logo.png') }}" alt="KidsPass" class="w-8 h-8 rounded-lg mr-3 flex-shrink-0">
                    @else
                        <div class="w-8 h-8 bg-sky-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-child text-white text-sm"></i>
                        </div>
                    @endif
                    <h1 class="text-xl font-bold sidebar-logo-text whitespace-nowrap">KidsPass</h1>
                </div>
                <button id="sidebar-collapse-btn" class="sidebar-toggle-btn text-gray-400 hover:text-white ml-2 lg:block hidden">
                    <i class="fas fa-chevron-left text-sm"></i>
                </button>
            </div>
            
            <nav class="mt-8">
                <div class="px-4 space-y-2">
                    <a href="{{ route('dashboard') }}" 
                       data-title="Dashboard"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-sky-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-tachometer-alt sidebar-icon mr-3"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('scan') }}" 
                       data-title="Scanare Brățară"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('scan') ? 'bg-sky-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-qrcode sidebar-icon mr-3"></i>
                        <span class="sidebar-text">Scanare Brățară</span>
                    </a>

                    <a href="{{ route('sessions.index') }}" 
                       data-title="Sesiuni"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('sessions.*') ? 'bg-sky-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-stopwatch sidebar-icon mr-3"></i>
                        <span class="sidebar-text">Sesiuni</span>
                    </a>
                    
                    <a href="{{ route('children.index') }}" 
                       data-title="Copii"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('children.*') ? 'bg-sky-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-child sidebar-icon mr-3"></i>
                        <span class="sidebar-text">Copii</span>
                    </a>
                    
                    @if(Auth::user()->isSuperAdmin() || Auth::user()->isCompanyAdmin())
                    <a href="{{ route('guardians.index') }}" 
                       data-title="Părinți"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('guardians.*') ? 'bg-sky-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-users sidebar-icon mr-3"></i>
                        <span class="sidebar-text">Părinți</span>
                    </a>
                    
                    <a href="{{ route('bracelets.index') }}" 
                       data-title="Brățări"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('bracelets.*') ? 'bg-sky-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-qrcode sidebar-icon mr-3"></i>
                        <span class="sidebar-text">Brățări</span>
                    </a>
                    
                    <a href="{{ route('reports.index') }}" 
                       data-title="Rapoarte"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('reports.*') ? 'bg-sky-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-chart-pie sidebar-icon mr-3"></i>
                        <span class="sidebar-text">Rapoarte</span>
                    </a>
                    @endif
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div id="main-content" class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
                <div class="flex items-center justify-between px-3 md:px-4 lg:px-6 py-3 md:py-4">
                    <div class="flex items-center">
                        <button id="sidebar-toggle" class="text-gray-500 hover:text-gray-700 lg:hidden">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h2 class="text-lg md:text-xl lg:text-2xl font-semibold text-gray-800 ml-3 md:ml-4 lg:ml-0">@yield('page-title', 'Dashboard')</h2>
                    </div>
                    
                    <div class="flex items-center space-x-2 md:space-x-4">
                        <!-- User Menu -->
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center space-x-2 md:space-x-3 text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                                <div class="w-8 h-8 bg-sky-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-medium text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="font-medium text-gray-700">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->role->display_name ?? 'N/A' }}</p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400 hidden md:block"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                    @if(Auth::user()->tenant)
                                        <p class="text-xs text-gray-400">{{ Auth::user()->tenant->name }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('change-password') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-key mr-2"></i>Schimbă Parola
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container mx-auto px-3 md:px-4 lg:px-6 py-4 md:py-6 lg:py-8">
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Overlay for mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 hidden lg:hidden"></div>

    <!-- Choices.js for searchable selects (load before page scripts) -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    @yield('scripts')

    <script>
        // Sidebar collapse/expand functionality
        const sidebar = document.getElementById('sidebar');
        const collapseBtn = document.getElementById('sidebar-collapse-btn');
        const mainContent = document.getElementById('main-content');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const overlay = document.getElementById('sidebar-overlay');
        
        // Initialize sidebar state based on screen size
        function initializeSidebar() {
            if (window.innerWidth >= 1024) {
                // Desktop: show sidebar, restore collapsed state if saved
                sidebar.classList.remove('sidebar-hidden');
                sidebar.classList.add('sidebar-visible');
                overlay.classList.add('hidden');
                
                const savedState = localStorage.getItem('sidebarCollapsed');
                if (savedState === 'true') {
                    sidebar.classList.add('sidebar-collapsed');
                    mainContent.classList.add('main-content-collapsed');
                    if (collapseBtn) {
                        collapseBtn.querySelector('i').classList.remove('fa-chevron-left');
                        collapseBtn.querySelector('i').classList.add('fa-chevron-right');
                    }
                } else {
                    sidebar.classList.remove('sidebar-collapsed');
                    mainContent.classList.remove('main-content-collapsed');
                    if (collapseBtn) {
                        collapseBtn.querySelector('i').classList.remove('fa-chevron-right');
                        collapseBtn.querySelector('i').classList.add('fa-chevron-left');
                    }
                }
            } else {
                // Mobile: hide sidebar by default
                sidebar.classList.add('sidebar-hidden');
                sidebar.classList.remove('sidebar-visible', 'sidebar-collapsed');
                mainContent.classList.remove('main-content-collapsed');
                overlay.classList.add('hidden');
            }
        }
        
        // Initialize on page load
        initializeSidebar();

        // Sidebar collapse button (desktop only)
        if (collapseBtn) {
            collapseBtn.addEventListener('click', function() {
                // Only work on desktop
                if (window.innerWidth < 1024) return;
                
                const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
                
                if (isCollapsed) {
                    sidebar.classList.remove('sidebar-collapsed');
                    mainContent.classList.remove('main-content-collapsed');
                    collapseBtn.querySelector('i').classList.remove('fa-chevron-right');
                    collapseBtn.querySelector('i').classList.add('fa-chevron-left');
                    localStorage.setItem('sidebarCollapsed', 'false');
                } else {
                    sidebar.classList.add('sidebar-collapsed');
                    mainContent.classList.add('main-content-collapsed');
                    collapseBtn.querySelector('i').classList.remove('fa-chevron-left');
                    collapseBtn.querySelector('i').classList.add('fa-chevron-right');
                    localStorage.setItem('sidebarCollapsed', 'true');
                }
            });
        }

        // Sidebar toggle for mobile
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                const isVisible = sidebar.classList.contains('sidebar-visible');
                
                if (isVisible) {
                    sidebar.classList.remove('sidebar-visible');
                    sidebar.classList.add('sidebar-hidden');
                    overlay.classList.add('hidden');
                } else {
                    sidebar.classList.remove('sidebar-hidden');
                    sidebar.classList.add('sidebar-visible');
                    overlay.classList.remove('hidden');
                }
            });
        }

        // Close sidebar when clicking overlay
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('sidebar-visible');
                sidebar.classList.add('sidebar-hidden');
                overlay.classList.add('hidden');
            });
        }

        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                initializeSidebar();
            }, 150);
        });

        // User menu toggle
        document.getElementById('user-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
        });

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('user-menu');
            const userButton = document.getElementById('user-menu-button');
            
            if (!userButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html>
