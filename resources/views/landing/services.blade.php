@extends('landing.layouts.landing')

@section('content')
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4 text-center">Serviciile Noastre</h1>
        <p class="text-xl text-gray-600 text-center mb-12">Oferim o gamă completă de servicii pentru copii și familii din Vaslui</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-gray-50 p-8 rounded-lg">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Jocuri și Activități</h2>
                <p class="text-gray-700 mb-4">
                    Oferim o varietate largă de jocuri și activități interactive pentru copii de toate vârstele. De la jocuri educative la activități fizice, avem tot ce trebuie pentru o zi de neuitat.
                </p>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>Jocuri interactive</li>
                    <li>Activități educative</li>
                    <li>Jocuri de grup</li>
                    <li>Activități creative</li>
                </ul>
            </div>
            
            <div class="bg-gray-50 p-8 rounded-lg">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Zile de Naștere</h2>
                <p class="text-gray-700 mb-4">
                    Organizăm zile de naștere memorabile pentru copii cu pachete speciale și activități personalizate. Fiecare zi de naștere este unică și adaptată preferințelor copilului.
                </p>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>Pachete personalizate</li>
                    <li>Decoruri tematice</li>
                    <li>Activități speciale</li>
                    <li>Fotografii și amintiri</li>
                </ul>
            </div>
            
            <div class="bg-gray-50 p-8 rounded-lg">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Echipamente Moderne</h2>
                <p class="text-gray-700 mb-4">
                    Toate echipamentele noastre sunt de ultimă generație și sunt întreținute regulat pentru a asigura siguranța și distracția copiilor.
                </p>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>Echipamente sigure și testate</li>
                    <li>Întreținere regulată</li>
                    <li>Echipamente pentru toate vârstele</li>
                    <li>Accesibilitate pentru copii cu nevoi speciale</li>
                </ul>
            </div>
            
            <div class="bg-gray-50 p-8 rounded-lg">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Personal Calificat</h2>
                <p class="text-gray-700 mb-4">
                    Echipă noastră este formată din profesioniști dedicați siguranței și distracției copiilor. Fiecare membru al echipei este pregătit pentru a oferi cea mai bună experiență.
                </p>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>Personal certificat</li>
                    <li>Supraveghere constantă</li>
                    <li>Asistență personalizată</li>
                    <li>Răspuns rapid la nevoi</li>
                </ul>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('landing.contact') }}" class="inline-block bg-sky-600 text-white px-6 py-3 rounded-lg hover:bg-sky-700 transition-colors font-semibold">Contactează-ne pentru Mai Multe Informații</a>
        </div>
    </div>
</section>
@endsection



