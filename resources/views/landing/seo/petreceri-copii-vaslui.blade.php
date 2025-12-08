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
    
    <!-- Schema.org Event -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "LocalBusiness",
        "name": "Bongoland - Petreceri Copii Vaslui",
        "description": "Organizăm petreceri și aniversări pentru copii în Vaslui. Pachete complete cu acces loc de joacă, mâncare proaspătă și decorațiuni.",
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
            "name": "Pachete Petreceri",
            "itemListElement": [
                {
                    "@@type": "Offer",
                    "name": "Pachet Aniversar Luni-Joi",
                    "price": "90",
                    "priceCurrency": "RON",
                    "description": "Timp nelimitat, pizza/crispy, băuturi, momentul tortului"
                },
                {
                    "@@type": "Offer",
                    "name": "Pachet Aniversar Weekend",
                    "price": "110",
                    "priceCurrency": "RON",
                    "description": "3 ore acces, pizza/crispy, băuturi, voucher gratis"
                },
                {
                    "@@type": "Offer",
                    "name": "Pachet Regele Junglei",
                    "price": "2500",
                    "priceCurrency": "RON",
                    "description": "Pachet complet pentru 10 copii + 10 părinți"
                }
            ]
        }
    }
    </script>
    
    @vite(['resources/css/app.css'])
    
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 50%, #c084fc 100%);
        }
    </style>
</head>
<body class="bg-white">
    <!-- Header -->
    <header class="bg-gradient-to-r from-purple-800 via-purple-600 to-pink-500 text-white py-4 shadow-lg">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/bongoland-logo.png') }}" alt="Bongoland Vaslui" class="h-12 w-auto">
            </a>
            <nav class="hidden md:flex items-center gap-6">
                <a href="/" class="hover:text-yellow-300 transition-colors font-semibold">Acasă</a>
                <a href="/loc-de-joaca-vaslui" class="hover:text-yellow-300 transition-colors font-semibold">Loc de Joacă</a>
                <a href="/petreceri-copii-vaslui" class="text-yellow-300 font-semibold">Petreceri</a>
                <a href="/serbari-copii-vaslui" class="hover:text-yellow-300 transition-colors font-semibold">Serbări</a>
                <a href="/#contact" class="bg-yellow-400 text-purple-900 px-4 py-2 rounded-lg font-bold hover:bg-yellow-300 transition-colors">Rezervă</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Petreceri pentru Copii în Vaslui – Bongoland
            </h1>
            <p class="text-xl md:text-2xl max-w-3xl mx-auto opacity-95">
                Organizăm petreceri de vis pentru copilul tău! 
                Mâncare proaspătă, acces la toate atracțiile și momente de neuitat.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="py-12 md:py-16">
        <div class="container mx-auto px-4">
            
            <!-- Intro Section -->
            <section class="max-w-4xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-purple-800 mb-6">
                    Aniversări de vis pentru copii la Bongoland Vaslui
                </h2>
                <div class="prose prose-lg max-w-none text-gray-700">
                    <p>
                        Vrei să organizezi o <strong>petrecere de neuitat pentru copilul tău</strong>? La Bongoland Vaslui, 
                        transformăm fiecare aniversare într-o aventură magică! Suntem cel mai mare loc de joacă 
                        interior din Vaslui, cu experiență vastă în organizarea de evenimente pentru copii.
                    </p>
                    <p>
                        Ce face petrecerile noastre speciale? În primul rând, <strong>mâncarea proaspătă din bucătăria proprie</strong>. 
                        Nu servim produse congelate – pizza, crispy și toate preparatele sunt făcute pe loc, cu grijă. 
                        În al doilea rând, copiii au acces la toate atracțiile: trambuline, tobogane, tiroliană, piscină cu bile.
                    </p>
                    <p>
                        Tu te relaxezi, noi ne ocupăm de tot: mâncare, băuturi, momentul tortului, lumânări și chiar 
                        invitații digitale pe WhatsApp. Alege pachetul potrivit și rezervă data dorită!
                    </p>
                </div>
            </section>

            <!-- Packages -->
            <section class="mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-purple-800 mb-8 text-center">
                    Pachete Petreceri Copii Vaslui
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <!-- Package 1 -->
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border-2 border-purple-100">
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-6 text-white text-center">
                            <h3 class="text-2xl font-bold">Pachet Aniversar</h3>
                            <p class="opacity-90">Luni - Joi</p>
                        </div>
                        <div class="p-6">
                            <div class="text-center mb-6">
                                <p class="text-4xl font-bold text-purple-600">90 lei</p>
                                <p class="text-gray-500">/ copil (minim 10 copii)</p>
                            </div>
                            <ul class="space-y-3 mb-6">
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Pizza sau Crispy la alegere</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>1 apă + 1 suc Tedi</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>1 șampanie pentru copii</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Momentul tortului + lumânări</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Invitație digitală WhatsApp</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span class="font-bold">Timp NELIMITAT la loc de joacă</span>
                                </li>
                            </ul>
                            <a href="/#contact" class="block w-full bg-blue-500 text-white text-center py-3 rounded-xl font-bold hover:bg-blue-600 transition-colors">
                                Rezervă Acum
                            </a>
                        </div>
                    </div>

                    <!-- Package 2 - Popular -->
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border-4 border-purple-500 relative transform md:scale-105">
                        <div class="absolute top-4 right-4 bg-yellow-400 text-purple-900 px-3 py-1 rounded-full text-sm font-bold">
                            ⭐ POPULAR
                        </div>
                        <div class="bg-gradient-to-r from-purple-600 to-pink-500 p-6 text-white text-center">
                            <h3 class="text-2xl font-bold">Pachet Aniversar</h3>
                            <p class="opacity-90">Vineri - Duminică</p>
                        </div>
                        <div class="p-6">
                            <div class="text-center mb-6">
                                <p class="text-4xl font-bold text-purple-600">110 lei</p>
                                <p class="text-gray-500">/ copil (minim 10 copii)</p>
                            </div>
                            <ul class="space-y-3 mb-6">
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Pizza sau Crispy la alegere</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>1 apă + 2 sucuri Tedi</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>1 șampanie pentru copii + pahare</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Momentul tortului + lumânări</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Invitație digitală WhatsApp</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Acces loc de joacă 3 ore</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span class="font-bold text-purple-600">1 voucher 1 oră GRATIS</span>
                                </li>
                            </ul>
                            <a href="/#contact" class="block w-full bg-purple-600 text-white text-center py-3 rounded-xl font-bold hover:bg-purple-700 transition-colors">
                                Rezervă Acum
                            </a>
                        </div>
                    </div>

                    <!-- Package 3 -->
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border-2 border-purple-100">
                        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-6 text-white text-center">
                            <h3 class="text-2xl font-bold">Regele Junglei</h3>
                            <p class="opacity-90">Luni - Duminică</p>
                        </div>
                        <div class="p-6">
                            <div class="text-center mb-6">
                                <p class="text-4xl font-bold text-orange-600">2500 lei</p>
                                <p class="text-gray-500">pachet complet</p>
                            </div>
                            <ul class="space-y-3 mb-6">
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span class="font-bold">10 copii + 10 părinți</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Pizza/Crispy pentru copii</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span class="font-bold">Platouri mix grill pentru părinți</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Băuturi pentru toți</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Momentul tortului complet</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Acces loc de joacă 3 ore</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Voucher 1 oră gratis</span>
                                </li>
                            </ul>
                            <a href="/#contact" class="block w-full bg-orange-500 text-white text-center py-3 rounded-xl font-bold hover:bg-orange-600 transition-colors">
                                Rezervă Acum
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- What's Included -->
            <section class="mb-16 bg-purple-50 rounded-3xl p-8 md:p-12">
                <h2 class="text-3xl md:text-4xl font-bold text-purple-800 mb-8 text-center">
                    Ce este inclus în petrecerile Bongoland?
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-bold text-purple-700 mb-4">🍕 Mâncare proaspătă din bucătăria noastră</h3>
                        <p class="text-gray-700">
                            Nu servim produse congelate! Pizza, crispy și toate preparatele sunt făcute pe loc, 
                            cu ingrediente proaspete. Pentru părinți avem platouri mix grill (în pachetul Regele Junglei).
                        </p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-purple-700 mb-4">🎢 Acces la toate atracțiile</h3>
                        <p class="text-gray-700">
                            Copiii au acces la trambuline, tobogane, tiroliană, piscină cu bile și traseu cu obstacole. 
                            Distracție garantată pentru toate vârstele!
                        </p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-purple-700 mb-4">🎂 Momentul tortului</h3>
                        <p class="text-gray-700">
                            Organizăm momentul tortului cu lumânări și șampanie pentru copii. 
                            Tu aduci tortul, noi ne ocupăm de rest!
                        </p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-purple-700 mb-4">📱 Invitații digitale</h3>
                        <p class="text-gray-700">
                            Primești invitații personalizate pe WhatsApp pe care le poți trimite părinților invitaților. 
                            Simplu și modern!
                        </p>
                    </div>
                </div>
            </section>

            <!-- How to Book -->
            <section class="mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-purple-800 mb-8 text-center">
                    Cum rezervi o petrecere la Bongoland Vaslui?
                </h2>
                <div class="max-w-3xl mx-auto">
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="flex-1 text-center md:text-left">
                            <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto md:mx-0 mb-4">
                                <span class="text-2xl font-bold text-purple-600">1</span>
                            </div>
                            <h3 class="font-bold text-purple-800 mb-2">Alege pachetul</h3>
                            <p class="text-gray-600">Selectează pachetul potrivit pentru petrecerea ta</p>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto md:mx-0 mb-4">
                                <span class="text-2xl font-bold text-purple-600">2</span>
                            </div>
                            <h3 class="font-bold text-purple-800 mb-2">Sună sau scrie</h3>
                            <p class="text-gray-600">Contactează-ne la 0748 394 441 sau pe WhatsApp</p>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto md:mx-0 mb-4">
                                <span class="text-2xl font-bold text-purple-600">3</span>
                            </div>
                            <h3 class="font-bold text-purple-800 mb-2">Confirmă rezervarea</h3>
                            <p class="text-gray-600">Alege data și ora, iar noi ne ocupăm de tot!</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA -->
            <section class="bg-gradient-to-r from-purple-600 to-pink-500 rounded-3xl p-8 md:p-12 text-white text-center">
                <h2 class="text-3xl font-bold mb-6">Rezervă petrecerea perfectă pentru copilul tău!</h2>
                <p class="text-xl opacity-95 mb-8 max-w-2xl mx-auto">
                    Sună acum la <a href="tel:+40748394441" class="text-yellow-300 font-bold">0748 394 441</a> 
                    sau scrie-ne pe WhatsApp pentru a rezerva data dorită.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="tel:+40748394441" class="inline-block bg-yellow-400 text-purple-900 px-8 py-3 rounded-xl font-bold text-lg hover:bg-yellow-300 transition-colors">
                        📞 Sună Acum
                    </a>
                    <a href="https://wa.me/40748394441?text=Bună! Aș dori să rezerv o petrecere la Bongoland." target="_blank" class="inline-block bg-green-500 text-white px-8 py-3 rounded-xl font-bold text-lg hover:bg-green-600 transition-colors">
                        💬 WhatsApp
                    </a>
                </div>
            </section>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-purple-900 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p class="opacity-80">
                © {{ date('Y') }} Bongoland Vaslui. Toate drepturile rezervate.
            </p>
            <div class="mt-4 space-x-4">
                <a href="/" class="hover:text-yellow-300">Acasă</a>
                <a href="/loc-de-joaca-vaslui" class="hover:text-yellow-300">Loc de Joacă</a>
                <a href="/serbari-copii-vaslui" class="hover:text-yellow-300">Serbări</a>
            </div>
        </div>
    </footer>
</body>
</html>

