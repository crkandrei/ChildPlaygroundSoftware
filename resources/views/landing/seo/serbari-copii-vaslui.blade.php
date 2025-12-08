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
        "name": "Bongoland - Serbări Școlare Vaslui",
        "description": "Organizăm serbări de Crăciun, 8 Martie și sfârșit de an pentru grădinițe și școli din Vaslui. Spațiu generos, mâncare proaspătă.",
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
        "hasOfferCatalog": {
            "@@type": "OfferCatalog",
            "name": "Serbări pentru Instituții",
            "itemListElement": [
                {
                    "@@type": "Offer",
                    "name": "Serbări de Crăciun",
                    "description": "Organizare serbări de Crăciun pentru grădinițe și școli"
                },
                {
                    "@@type": "Offer",
                    "name": "Serbări 8 Martie",
                    "description": "Evenimente speciale de 8 Martie pentru copii"
                },
                {
                    "@@type": "Offer",
                    "name": "Serbări Sfârșit de An",
                    "description": "Celebrarea încheierii anului școlar"
                }
            ]
        }
    }
    </script>
    
    @vite(['resources/css/app.css'])
    
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #0891b2 0%, #06b6d4 50%, #22d3ee 100%);
        }
    </style>
</head>
<body class="bg-white">
    <!-- Header -->
    <header class="bg-gradient-to-r from-cyan-800 via-cyan-600 to-teal-500 text-white py-4 shadow-lg">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/bongoland-logo.png') }}" alt="Bongoland Vaslui" class="h-12 w-auto">
            </a>
            <nav class="hidden md:flex items-center gap-6">
                <a href="/" class="hover:text-yellow-300 transition-colors font-semibold">Acasă</a>
                <a href="/loc-de-joaca-vaslui" class="hover:text-yellow-300 transition-colors font-semibold">Loc de Joacă</a>
                <a href="/petreceri-copii-vaslui" class="hover:text-yellow-300 transition-colors font-semibold">Petreceri</a>
                <a href="/serbari-copii-vaslui" class="text-yellow-300 font-semibold">Serbări</a>
                <a href="/#contact" class="bg-yellow-400 text-cyan-900 px-4 py-2 rounded-lg font-bold hover:bg-yellow-300 transition-colors">Rezervă</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Serbări Școlare și Grădiniță în Vaslui – Bongoland
            </h1>
            <p class="text-xl md:text-2xl max-w-3xl mx-auto opacity-95">
                Organizăm serbări de Crăciun, 8 Martie și sfârșit de an 
                pentru grădinițe și școli din Vaslui și împrejurimi.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="py-12 md:py-16">
        <div class="container mx-auto px-4">
            
            <!-- Intro Section -->
            <section class="max-w-4xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-cyan-800 mb-6">
                    Serbări memorabile pentru copii la Bongoland Vaslui
                </h2>
                <div class="prose prose-lg max-w-none text-gray-700">
                    <p>
                        Cauți un loc unde să organizezi <strong>serbarea de Crăciun</strong>, <strong>evenimentul de 8 Martie</strong> 
                        sau <strong>petrecerea de sfârșit de an</strong> pentru grădinița sau școala ta? La Bongoland Vaslui 
                        oferim spațiul perfect pentru evenimente școlare, cu capacitate pentru grupuri de 20 până la 100+ copii.
                    </p>
                    <p>
                        Suntem cel mai mare loc de joacă interior din Vaslui și avem experiență în organizarea de 
                        <strong>evenimente pentru instituții de învățământ</strong>. Copiii se bucură de trambuline, tobogane 
                        și tiroliană, în timp ce educatorii și părinții se pot relaxa în zona noastră de restaurant.
                    </p>
                    <p>
                        Oferim <strong>prețuri speciale pentru grădinițe și școli</strong>, mâncare proaspătă din bucătăria proprie 
                        și flexibilitate în alegerea datei și orei. Contactează-ne pentru o ofertă personalizată!
                    </p>
                </div>
            </section>

            <!-- Types of Events -->
            <section class="mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-cyan-800 mb-8 text-center">
                    Ce tipuri de serbări organizăm?
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <!-- Christmas -->
                    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-3xl p-8 text-white text-center shadow-xl">
                        <div class="text-6xl mb-4">🎄</div>
                        <h3 class="text-2xl font-bold mb-4">Serbări de Crăciun</h3>
                        <p class="opacity-95">
                            Organizăm serbări de Crăciun pline de magie! Copiii se joacă, 
                            cântă colinde și primesc vizita lui Moș Crăciun (opțional). 
                            Atmosferă festivă și gustări delicioase.
                        </p>
                    </div>

                    <!-- 8 Martie -->
                    <div class="bg-gradient-to-br from-pink-500 to-rose-500 rounded-3xl p-8 text-white text-center shadow-xl">
                        <div class="text-6xl mb-4">🌷</div>
                        <h3 class="text-2xl font-bold mb-4">Serbări 8 Martie</h3>
                        <p class="opacity-95">
                            Sărbătorim mamele și bunicile într-un mod special! 
                            Copiii pregătesc surprize, joacă și oferă flori. 
                            Un eveniment plin de emoție și bucurie.
                        </p>
                    </div>

                    <!-- End of Year -->
                    <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-3xl p-8 text-white text-center shadow-xl">
                        <div class="text-6xl mb-4">🎓</div>
                        <h3 class="text-2xl font-bold mb-4">Sfârșit de An</h3>
                        <p class="opacity-95">
                            Celebrăm împreună încheierea anului școlar! 
                            Distracție maximă, premii pentru copii și amintiri de neuitat. 
                            Perfectă pentru întreaga clasă sau grupă.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Benefits -->
            <section class="mb-16 bg-cyan-50 rounded-3xl p-8 md:p-12">
                <h2 class="text-3xl md:text-4xl font-bold text-cyan-800 mb-8 text-center">
                    De ce să alegi Bongoland pentru serbările școlare?
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                    <div class="flex items-start gap-4 bg-white rounded-xl p-6 shadow-md">
                        <div class="text-cyan-600 text-2xl">✓</div>
                        <div>
                            <h3 class="font-bold text-cyan-800 mb-1">Spațiu generos pentru grupuri mari</h3>
                            <p class="text-gray-600">Capacitate pentru 20-100+ copii, cu loc suficient pentru toată lumea</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 bg-white rounded-xl p-6 shadow-md">
                        <div class="text-cyan-600 text-2xl">✓</div>
                        <div>
                            <h3 class="font-bold text-cyan-800 mb-1">Acces la toate atracțiile</h3>
                            <p class="text-gray-600">Trambuline, tobogane, tiroliană, piscină cu bile și traseu obstacole</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 bg-white rounded-xl p-6 shadow-md">
                        <div class="text-cyan-600 text-2xl">✓</div>
                        <div>
                            <h3 class="font-bold text-cyan-800 mb-1">Mâncare proaspătă din bucătăria proprie</h3>
                            <p class="text-gray-600">Pizza, crispy, sucuri – totul pregătit proaspăt pentru copii</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 bg-white rounded-xl p-6 shadow-md">
                        <div class="text-cyan-600 text-2xl">✓</div>
                        <div>
                            <h3 class="font-bold text-cyan-800 mb-1">Personal dedicat</h3>
                            <p class="text-gray-600">Echipa noastră ajută la supraveghere și organizare</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 bg-white rounded-xl p-6 shadow-md">
                        <div class="text-cyan-600 text-2xl">✓</div>
                        <div>
                            <h3 class="font-bold text-cyan-800 mb-1">Prețuri speciale pentru instituții</h3>
                            <p class="text-gray-600">Oferte personalizate pentru grădinițe și școli</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 bg-white rounded-xl p-6 shadow-md">
                        <div class="text-cyan-600 text-2xl">✓</div>
                        <div>
                            <h3 class="font-bold text-cyan-800 mb-1">Flexibilitate maximă</h3>
                            <p class="text-gray-600">Alegem împreună data și ora potrivită pentru grupul tău</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 bg-white rounded-xl p-6 shadow-md">
                        <div class="text-cyan-600 text-2xl">✓</div>
                        <div>
                            <h3 class="font-bold text-cyan-800 mb-1">Zonă separată pentru masă</h3>
                            <p class="text-gray-600">Spațiu dedicat pentru servit gustările, separat de zona de joacă</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 bg-white rounded-xl p-6 shadow-md">
                        <div class="text-cyan-600 text-2xl">✓</div>
                        <div>
                            <h3 class="font-bold text-cyan-800 mb-1">Experiență vastă</h3>
                            <p class="text-gray-600">Peste 1.000 de evenimente organizate cu succes</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- How It Works -->
            <section class="mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-cyan-800 mb-8 text-center">
                    Cum decurge o serbare la Bongoland?
                </h2>
                <div class="max-w-4xl mx-auto">
                    <div class="space-y-6">
                        <div class="flex items-start gap-6">
                            <div class="bg-cyan-100 rounded-full w-12 h-12 flex items-center justify-center shrink-0">
                                <span class="text-xl font-bold text-cyan-700">1</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-cyan-800 text-lg mb-2">Sosirea și primirea</h3>
                                <p class="text-gray-600">Copiii sunt întâmpinați de echipa noastră. Durata: ~15 minute</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-6">
                            <div class="bg-cyan-100 rounded-full w-12 h-12 flex items-center justify-center shrink-0">
                                <span class="text-xl font-bold text-cyan-700">2</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-cyan-800 text-lg mb-2">Joacă liberă</h3>
                                <p class="text-gray-600">Copiii explorează toate atracțiile: trambuline, tobogane, tiroliană. Durata: ~60-90 minute</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-6">
                            <div class="bg-cyan-100 rounded-full w-12 h-12 flex items-center justify-center shrink-0">
                                <span class="text-xl font-bold text-cyan-700">3</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-cyan-800 text-lg mb-2">Pauza pentru gustări</h3>
                                <p class="text-gray-600">Servim mâncare proaspătă în zona de restaurant. Durata: ~30-45 minute</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-6">
                            <div class="bg-cyan-100 rounded-full w-12 h-12 flex items-center justify-center shrink-0">
                                <span class="text-xl font-bold text-cyan-700">4</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-cyan-800 text-lg mb-2">Activități speciale (opțional)</h3>
                                <p class="text-gray-600">Programe artistice, Moș Crăciun, premieri – în funcție de tipul serbării</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-6">
                            <div class="bg-cyan-100 rounded-full w-12 h-12 flex items-center justify-center shrink-0">
                                <span class="text-xl font-bold text-cyan-700">5</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-cyan-800 text-lg mb-2">Încă puțină joacă și plecare</h3>
                                <p class="text-gray-600">Copiii se mai joacă, apoi se pregătesc de plecare. Durata totală tipică: 2.5-3 ore</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Pricing Info -->
            <section class="mb-16 bg-gradient-to-r from-cyan-600 to-teal-500 rounded-3xl p-8 md:p-12 text-white">
                <h2 class="text-3xl font-bold mb-6 text-center">
                    Prețuri serbări pentru grădinițe și școli
                </h2>
                <div class="max-w-3xl mx-auto text-center">
                    <p class="text-xl opacity-95 mb-8">
                        Oferim prețuri speciale pentru instituții de învățământ, în funcție de:
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white/20 rounded-xl p-6">
                            <p class="font-bold text-lg">Numărul de copii</p>
                            <p class="opacity-90">20, 30, 50, 100+ copii</p>
                        </div>
                        <div class="bg-white/20 rounded-xl p-6">
                            <p class="font-bold text-lg">Ziua săptămânii</p>
                            <p class="opacity-90">Luni-Vineri vs Weekend</p>
                        </div>
                        <div class="bg-white/20 rounded-xl p-6">
                            <p class="font-bold text-lg">Serviciile incluse</p>
                            <p class="opacity-90">Joacă, mâncare, activități</p>
                        </div>
                    </div>
                    <p class="text-lg opacity-95">
                        <strong>Contactează-ne pentru o ofertă personalizată!</strong><br>
                        Fiecare serbare este unică, iar prețul depinde de cerințele specifice ale grupului tău.
                    </p>
                </div>
            </section>

            <!-- CTA -->
            <section class="bg-white rounded-3xl p-8 md:p-12 text-center shadow-xl border-2 border-cyan-100">
                <h2 class="text-3xl font-bold text-cyan-800 mb-6">
                    Organizezi o serbare pentru grădiniță sau școală?
                </h2>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    Contactează-ne acum pentru a discuta detaliile și a primi o ofertă personalizată. 
                    Suntem aici să facem serbarea memorabilă!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="tel:+40748394441" class="inline-block bg-cyan-600 text-white px-8 py-3 rounded-xl font-bold text-lg hover:bg-cyan-700 transition-colors">
                        📞 Sună: 0748 394 441
                    </a>
                    <a href="https://wa.me/40748394441?text=Bună! Doresc să organizez o serbare pentru grădiniță/școală la Bongoland." target="_blank" class="inline-block bg-green-500 text-white px-8 py-3 rounded-xl font-bold text-lg hover:bg-green-600 transition-colors">
                        💬 Scrie pe WhatsApp
                    </a>
                </div>
                <p class="mt-6 text-gray-500">
                    Sau vizitează-ne la: <strong>Strada Andrei Mureșanu 28, Parcul Copou, Vaslui</strong>
                </p>
            </section>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-cyan-900 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p class="opacity-80">
                © {{ date('Y') }} Bongoland Vaslui. Toate drepturile rezervate.
            </p>
            <div class="mt-4 space-x-4">
                <a href="/" class="hover:text-yellow-300">Acasă</a>
                <a href="/loc-de-joaca-vaslui" class="hover:text-yellow-300">Loc de Joacă</a>
                <a href="/petreceri-copii-vaslui" class="hover:text-yellow-300">Petreceri</a>
            </div>
        </div>
    </footer>
</body>
</html>

