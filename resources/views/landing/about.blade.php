@extends('landing.layouts.landing')

@section('content')
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Despre Bongoland Vaslui</h1>
        
        <div class="prose prose-lg max-w-none">
            <p class="text-xl text-gray-700 mb-6">
                Bongoland este cel mai modern și sigur loc de joacă din Vaslui, dedicat copiilor și familiilor. Cu o experiență de peste 10 ani în organizarea de activități pentru copii, suntem mândri să oferim cel mai bun serviciu din zonă.
            </p>
            
            <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Misiunea Noastră</h2>
            <p class="text-gray-700 mb-6">
                Misiunea noastră este să oferim copiilor din Vaslui un mediu sigur, distractiv și educativ unde să se dezvolte, să învețe și să se distreze. Credem că fiecare copil merită cea mai bună experiență de joacă.
            </p>
            
            <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">De Ce Să Ne Alegi?</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6">
                <li>Mediu complet sigur și monitorizat</li>
                <li>Echipamente moderne și întreținute regulat</li>
                <li>Personal calificat și dedicat</li>
                <li>O gamă largă de activități pentru toate vârstele</li>
                <li>Pachete flexibile adaptate nevoilor tale</li>
                <li>Organizare profesională de zile de naștere</li>
            </ul>
            
            <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Locația Noastră</h2>
            <p class="text-gray-700 mb-6">
                Ne găsești în Vaslui, într-un loc ușor accesibil și cu parcare disponibilă. Spațiul nostru este proiectat special pentru a oferi cea mai bună experiență pentru copii și părinți.
            </p>
        </div>
        
        <div class="mt-12">
            <a href="{{ route('landing.contact') }}" class="inline-block bg-sky-600 text-white px-6 py-3 rounded-lg hover:bg-sky-700 transition-colors font-semibold">Contactează-ne</a>
        </div>
    </div>
</section>
@endsection




