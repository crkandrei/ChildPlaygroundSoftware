<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <title>{{ $metaTitle ?? 'Bongoland Vaslui – Loc de joacă pentru copii | Petreceri și Serbări Copii' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Cauți un loc de joacă pentru copii în Vaslui? Bongoland este cea mai modernă locație cu trambuline, tobogane, zonă pentru copii mici, petreceri și serbări. Vezi programul, prețurile și galeria foto.' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'loc de joacă vaslui, loc joacă copii vaslui, petreceri copii vaslui, serbări copii vaslui, bongoland vaslui, joacă interior vaslui, parc copii vaslui' }}">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ $canonicalUrl ?? 'https://bongoland.ro' }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonicalUrl ?? 'https://bongoland.ro' }}">
    <meta property="og:title" content="{{ $metaTitle ?? 'Bongoland Vaslui – Loc de joacă pentru copii | Petreceri și Serbări Copii' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Cauți un loc de joacă pentru copii în Vaslui? Bongoland este cea mai modernă locație cu trambuline, tobogane, zonă pentru copii mici, petreceri și serbări.' }}">
    <meta property="og:image" content="{{ asset('images/bongoland-logo.png') }}">
    <meta property="og:locale" content="ro_RO">
    <meta property="og:site_name" content="Bongoland Vaslui">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle ?? 'Bongoland Vaslui – Loc de joacă pentru copii' }}">
    <meta name="twitter:description" content="{{ $metaDescription ?? 'Cel mai modern loc de joacă interior din Vaslui, cu trambuline, tobogane și petreceri pentru copii.' }}">
    <meta name="twitter:image" content="{{ asset('images/bongoland-logo.png') }}">
    
    <!-- Geo Tags -->
    <meta name="geo.region" content="RO-VS">
    <meta name="geo.placename" content="Vaslui">
    <meta name="geo.position" content="46.64634280826934;27.726681232452396">
    <meta name="ICBM" content="46.64634280826934, 27.726681232452396">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Schema.org LocalBusiness JSON-LD -->
    @verbatim
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "@id": "https://bongoland.ro/#business",
        "name": "Bongoland",
        "alternateName": "Bongoland Vaslui",
        "description": "Loc de joacă interior pentru copii în Vaslui, cu trambuline, tobogane, tiroliană, zonă de petreceri și activități pentru toate vârstele. Situat în incinta Restaurant Stil.",
        "url": "https://bongoland.ro",
        "telephone": "+40748394441",
        "email": "contact@bongoland.ro",
        "image": [
            "https://bongoland.ro/images/bongoland-logo.png"
        ],
        "logo": "https://bongoland.ro/images/bongoland-logo.png",
        "priceRange": "$$",
        "currenciesAccepted": "RON",
        "paymentAccepted": "Cash, Card",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Strada Andrei Mureșanu 28, Restaurant Stil",
            "addressLocality": "Vaslui",
            "addressRegion": "VS",
            "postalCode": "730006",
            "addressCountry": "RO"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": 46.64634280826934,
            "longitude": 27.726681232452396
        },
        "openingHoursSpecification": [
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday"],
                "opens": "15:30",
                "closes": "20:30"
            },
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": "Friday",
                "opens": "15:30",
                "closes": "22:00"
            },
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Saturday", "Sunday"],
                "opens": "11:00",
                "closes": "21:00"
            }
        ],
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Servicii Bongoland",
            "itemListElement": [
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "Loc de joacă interior",
                        "description": "Acces la toate atracțiile: trambuline, tobogane, tiroliană, piscină cu bile, traseu obstacole"
                    }
                },
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "Petreceri pentru copii",
                        "description": "Organizare petreceri aniversare cu mâncare proaspătă și acces la locul de joacă"
                    }
                },
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "Serbări școlare",
                        "description": "Organizare serbări pentru grădinițe și școli din Vaslui"
                    }
                }
            ]
        },
        "sameAs": [
            "https://www.facebook.com/bongolandvaslui",
            "https://www.instagram.com/bongoland_vaslui/"
        ],
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "5",
            "reviewCount": "150",
            "bestRating": "5",
            "worstRating": "1"
        }
    }
    </script>
    
    <!-- Amusement Park Schema for better categorization -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "AmusementPark",
        "name": "Bongoland - Loc de Joacă Vaslui",
        "description": "Cel mai mare loc de joacă interior din Vaslui pentru copii de toate vârstele",
        "url": "https://bongoland.ro",
        "telephone": "+40748394441",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Strada Andrei Mureșanu 28, Restaurant Stil",
            "addressLocality": "Vaslui",
            "addressRegion": "VS",
            "postalCode": "730006",
            "addressCountry": "RO"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": 46.64634280826934,
            "longitude": 27.726681232452396
        }
    }
    </script>
    @endverbatim
    
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/landing.tsx'])
</head>
<body>
    <div id="landing-root"></div>
</body>
</html>
