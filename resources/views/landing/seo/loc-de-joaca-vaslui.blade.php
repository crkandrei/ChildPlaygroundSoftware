<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ $canonicalUrl }}">
    
    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ asset('images/bongoland-logo.png') }}">
    <meta property="og:locale" content="ro_RO">
    
    <!-- Geo Tags -->
    <meta name="geo.region" content="RO-VS">
    <meta name="geo.placename" content="Vaslui">
    <meta name="geo.position" content="46.64634280826934;27.726681232452396">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Schema.org -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "LocalBusiness",
        "name": "Bongoland - Loc de Joacă Vaslui",
        "description": "Cel mai mare loc de joacă interior din Vaslui pentru copii de toate vârstele. Trambuline, tobogane, tiroliană, piscină cu bile.",
        "url": "{{ $canonicalUrl }}",
        "telephone": "+40748394441",
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "Strada Andrei Mureșanu 28, Restaurant Stil",
            "addressLocality": "Vaslui",
            "addressRegion": "VS",
            "postalCode": "730006",
            "addressCountry": "RO"
        },
        "geo": {
            "@@type": "GeoCoordinates",
            "latitude": 46.64634280826934,
            "longitude": 27.726681232452396
        },
        "openingHoursSpecification": [
            {
                "@@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday"],
                "opens": "15:30",
                "closes": "20:30"
            },
            {
                "@@type": "OpeningHoursSpecification",
                "dayOfWeek": "Friday",
                "opens": "15:30",
                "closes": "22:00"
            },
            {
                "@@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Saturday", "Sunday"],
                "opens": "11:00",
                "closes": "21:00"
            }
        ]
    }
    </script>
    
    @vite(['resources/css/app.css'])
    
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #065f46 0%, #059669 50%, #10b981 100%);
        }
    </style>
</head>
<body class="bg-white">
    <!-- Header -->
    <header class="bg-gradient-to-r from-green-800 via-green-600 to-emerald-500 text-white py-4 shadow-lg">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/bongoland-logo.png') }}" alt="Bongoland Vaslui" class="h-12 w-auto">
            </a>
            <nav class="hidden md:flex items-center gap-6">
                <a href="/" class="hover:text-yellow-300 transition-colors font-semibold">Acasă</a>
                <a href="/loc-de-joaca-vaslui" class="text-yellow-300 font-semibold">Loc de Joacă</a>
                <a href="/petreceri-copii-vaslui" class="hover:text-yellow-300 transition-colors font-semibold">Petreceri</a>
                <a href="/serbari-copii-vaslui" class="hover:text-yellow-300 transition-colors font-semibold">Serbări</a>
                <a href="/#contact" class="bg-yellow-400 text-green-900 px-4 py-2 rounded-lg font-bold hover:bg-yellow-300 transition-colors">Rezervă</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Loc de Joacă Copii Vaslui – Bongoland
            </h1>
            <p class="text-xl md:text-2xl max-w-3xl mx-auto opacity-95">
                Cel mai mare și modern loc de joacă interior din Vaslui, 
                cu atracții pentru copii de toate vârstele.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="py-12 md:py-16">
        <div class="container mx-auto px-4">
            
            <!-- Intro Section -->
            <section class="max-w-4xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-6">
                    Bine ai venit la Bongoland – Cel mai mare loc de joacă din Vaslui
                </h2>
                <div class="prose prose-lg max-w-none text-gray-700">
                    <p>
                        <strong>Bongoland</strong> este cel mai mare și modern <strong>loc de joacă interior din Vaslui</strong>, 
                        situat în incinta Restaurantului Stil, în Parcul Copou. Cu o suprafață generoasă dedicată 
                        distracției copiilor, oferim un spațiu sigur, curat și plin de aventuri pentru micuții 
                        cu vârste cuprinse între 0 și 12 ani.
                    </p>
                    <p>
                        La Bongoland, fiecare vizită devine o experiență de neuitat. Copiii tăi vor explora 
                        o lume plină de culori, râsete și activități captivante: de la trambuline profesionale 
                        și tobogane înalte, până la tiroliană și piscină cu bile. Iar tu, ca părinte, te poți 
                        relaxa în zona noastră de restaurant cu mâncare proaspătă din bucătăria proprie.
                    </p>
                    <p>
                        Suntem deschisi <strong>zilnic</strong>, cu program adaptat pentru familii: 
                        luni-joi 15:30-20:30, vineri 15:30-22:00, și sâmbătă-duminică 11:00-21:00. 
                        Vino să descoperi de ce suntem alegerea preferată a familiilor din Vaslui!
                    </p>
                </div>
            </section>

            <!-- Attractions -->
            <section class="mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-8 text-center">
                    Ce găsești la locul de joacă Bongoland Vaslui
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-green-100 hover:border-green-300 transition-colors">
                        <div class="text-4xl mb-4">🎯</div>
                        <h3 class="text-xl font-bold text-green-800 mb-2">Trambuline Profesionale</h3>
                        <p class="text-gray-600">Trambuline cu plase de protecție pentru sărituri în siguranță. Ideale pentru copii între 3-12 ani.</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-green-100 hover:border-green-300 transition-colors">
                        <div class="text-4xl mb-4">🛝</div>
                        <h3 class="text-xl font-bold text-green-800 mb-2">Tobogane</h3>
                        <p class="text-gray-600">Tobogane variate pentru toate vârstele, de la cele blânde pentru cei mici până la cele rapide pentru cei mari.</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-green-100 hover:border-green-300 transition-colors">
                        <div class="text-4xl mb-4">⚡</div>
                        <h3 class="text-xl font-bold text-green-800 mb-2">Tiroliană</h3>
                        <p class="text-gray-600">Zboară prin junglă cu tiroliană noastră! Experiență plină de adrenalină într-un mediu complet sigur.</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-green-100 hover:border-green-300 transition-colors">
                        <div class="text-4xl mb-4">🔵</div>
                        <h3 class="text-xl font-bold text-green-800 mb-2">Piscină cu Bile</h3>
                        <p class="text-gray-600">Mii de bile colorate într-o piscină sigură și distractivă. Spațiu ideal pentru jocuri imaginative.</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-green-100 hover:border-green-300 transition-colors">
                        <div class="text-4xl mb-4">🏃</div>
                        <h3 class="text-xl font-bold text-green-800 mb-2">Traseu cu Obstacole</h3>
                        <p class="text-gray-600">Parcurs cu provocări fizice: căi suspendate, obstacole și poduri de funie pentru copiii curajoși.</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-green-100 hover:border-green-300 transition-colors">
                        <div class="text-4xl mb-4">👶</div>
                        <h3 class="text-xl font-bold text-green-800 mb-2">Zonă pentru Cei Mici</h3>
                        <p class="text-gray-600">Zonă delimitată special pentru bebeluși și toddleri (0-3 ani), cu echipamente adaptate vârstei lor.</p>
                    </div>
                </div>
            </section>

            <!-- Prices -->
            <section class="mb-16 bg-green-50 rounded-3xl p-8 md:p-12">
                <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-8 text-center">
                    Prețuri loc de joacă Bongoland Vaslui
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
                    <div class="bg-white rounded-2xl p-6 text-center shadow-lg">
                        <p class="text-4xl font-bold text-green-600 mb-2">30 lei</p>
                        <p class="font-semibold text-green-800">Pe oră</p>
                        <p class="text-sm text-gray-500">Acces la toate atracțiile</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-2xl p-6 text-center shadow-lg text-white">
                        <p class="text-4xl font-bold mb-2">80 lei</p>
                        <p class="font-semibold">Oferta Jungle</p>
                        <p class="text-sm opacity-90">Timp nelimitat toată ziua!</p>
                        <p class="text-xs opacity-75 mt-2">Doar Luni - Vineri</p>
                    </div>
                </div>
                <p class="text-center text-gray-600 mt-6">
                    * Prețurile sunt valabile pentru un copil. Adulții au acces gratuit în zona de restaurant.
                </p>
            </section>

            <!-- Why Choose Us -->
            <section class="mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-8 text-center">
                    De ce să alegi Bongoland Vaslui pentru copilul tău?
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                    <div class="flex items-start gap-4">
                        <div class="text-green-600 text-2xl">✓</div>
                        <div>
                            <h3 class="font-bold text-green-800">Cel mai mare loc de joacă din Vaslui</h3>
                            <p class="text-gray-600">Suprafață generoasă pentru ca fiecare copil să exploreze în voie</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-green-600 text-2xl">✓</div>
                        <div>
                            <h3 class="font-bold text-green-800">Curățenie și siguranță permanentă</h3>
                            <p class="text-gray-600">Dezinfectăm zilnic toate zonele de joacă</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-green-600 text-2xl">✓</div>
                        <div>
                            <h3 class="font-bold text-green-800">Parteneriat cu Restaurant Stil</h3>
                            <p class="text-gray-600">Bucătărie proprie cu mâncare proaspătă</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-green-600 text-2xl">✓</div>
                        <div>
                            <h3 class="font-bold text-green-800">Spațiu încălzit/răcit tot anul</h3>
                            <p class="text-gray-600">Confort pentru copii indiferent de anotimp</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-green-600 text-2xl">✓</div>
                        <div>
                            <h3 class="font-bold text-green-800">Zonă dedicată pentru părinți</h3>
                            <p class="text-gray-600">Relaxează-te în timp ce copiii se joacă</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Location & Contact -->
            <section class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-3xl p-8 md:p-12 text-white text-center">
                <h2 class="text-3xl font-bold mb-6">Vizitează Bongoland Vaslui</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <div>
                        <p class="font-bold text-lg mb-2">📍 Adresă</p>
                        <p class="opacity-90">Strada Andrei Mureșanu 28<br>Parcul Copou, Restaurant Stil<br>Vaslui</p>
                    </div>
                    <div>
                        <p class="font-bold text-lg mb-2">📞 Telefon</p>
                        <a href="tel:+40748394441" class="text-yellow-300 hover:text-yellow-200 text-xl font-bold">0748 394 441</a>
                    </div>
                    <div>
                        <p class="font-bold text-lg mb-2">🕐 Program</p>
                        <p class="opacity-90">Luni-Joi: 15:30-20:30<br>Vineri: 15:30-22:00<br>Sâm-Dum: 11:00-21:00</p>
                    </div>
                </div>
                <a href="/" class="inline-block bg-yellow-400 text-green-900 px-8 py-3 rounded-xl font-bold text-lg hover:bg-yellow-300 transition-colors">
                    Mergi la pagina principală
                </a>
            </section>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-green-900 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p class="opacity-80">
                © {{ date('Y') }} Bongoland Vaslui. Toate drepturile rezervate.
            </p>
            <div class="mt-4 space-x-4">
                <a href="/" class="hover:text-yellow-300">Acasă</a>
                <a href="/petreceri-copii-vaslui" class="hover:text-yellow-300">Petreceri</a>
                <a href="/serbari-copii-vaslui" class="hover:text-yellow-300">Serbări</a>
            </div>
        </div>
    </footer>
</body>
</html>

