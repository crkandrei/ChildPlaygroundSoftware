@php
    $currentUrl = url()->current();
    $siteName = 'Bongoland Vaslui';
    $siteDescription = 'Cel mai bun loc de joacă din Vaslui pentru copii';
    $siteLogo = asset('images/kidspass-logo.png');
    
    $localBusinessSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => $siteName,
        'description' => $siteDescription,
        'url' => config('app.url'),
        'logo' => $siteLogo,
        'image' => $siteLogo,
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => 'Vaslui',
            'addressCountry' => 'RO'
        ],
        'telephone' => '+40 XXX XXX XXX',
        'priceRange' => '$$',
        'openingHoursSpecification' => [
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'opens' => '09:00',
                'closes' => '20:00'
            ]
        ],
        'sameAs' => [
            'https://www.facebook.com/bongoland',
            'https://www.instagram.com/bongoland'
        ]
    ];
    
    $organizationSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $siteName,
        'url' => config('app.url'),
        'logo' => $siteLogo,
        'description' => $siteDescription,
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => 'Vaslui',
            'addressCountry' => 'RO'
        ],
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'telephone' => '+40 XXX XXX XXX',
            'contactType' => 'customer service',
            'areaServed' => 'RO',
            'availableLanguage' => ['ro', 'en']
        ]
    ];
@endphp

{{-- LocalBusiness Schema --}}
<script type="application/ld+json">
{!! json_encode($localBusinessSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

{{-- Organization Schema --}}
<script type="application/ld+json">
{!! json_encode($organizationSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
