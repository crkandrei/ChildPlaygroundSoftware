@extends('landing.layouts.landing')

@section('content')
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4 text-center">Tarife și Prețuri</h1>
        <p class="text-xl text-gray-600 text-center mb-12">Oferim pachete flexibile adaptate nevoilor tale</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-gray-50 p-8 rounded-lg border-2 border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Acces Standard</h2>
                <div class="text-3xl font-bold text-sky-600 mb-4">50 RON</div>
                <p class="text-gray-600 mb-6">per oră</p>
                <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6">
                    <li>Acces la toate jocurile</li>
                    <li>Supraveghere personal</li>
                    <li>Activități incluse</li>
                </ul>
                <a href="{{ route('landing.contact') }}" class="block text-center bg-sky-600 text-white px-6 py-3 rounded-lg hover:bg-sky-700 transition-colors font-semibold">Află Mai Mult</a>
            </div>
            
            <div class="bg-sky-50 p-8 rounded-lg border-2 border-sky-600 transform scale-105">
                <div class="bg-sky-600 text-white px-3 py-1 rounded-full text-sm font-semibold inline-block mb-4">POPULAR</div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Pachet Zi de Naștere</h2>
                <div class="text-3xl font-bold text-sky-600 mb-4">300 RON</div>
                <p class="text-gray-600 mb-6">pachet complet</p>
                <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6">
                    <li>3 ore de joacă</li>
                    <li>Decoruri tematice</li>
                    <li>Activități speciale</li>
                    <li>Fotografii incluse</li>
                    <li>Până la 15 copii</li>
                </ul>
                <a href="{{ route('landing.reservation') }}" class="block text-center bg-sky-600 text-white px-6 py-3 rounded-lg hover:bg-sky-700 transition-colors font-semibold">Rezervă Acum</a>
            </div>
            
            <div class="bg-gray-50 p-8 rounded-lg border-2 border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Abonament Lunar</h2>
                <div class="text-3xl font-bold text-sky-600 mb-4">400 RON</div>
                <p class="text-gray-600 mb-6">pe lună</p>
                <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6">
                    <li>Acces nelimitat</li>
                    <li>Reduceri la evenimente</li>
                    <li>Prioritate la rezervări</li>
                    <li>Oferte exclusive</li>
                </ul>
                <a href="{{ route('landing.contact') }}" class="block text-center bg-sky-600 text-white px-6 py-3 rounded-lg hover:bg-sky-700 transition-colors font-semibold">Află Mai Mult</a>
            </div>
        </div>
        
        <div class="mt-12 bg-gray-50 p-8 rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Informații Importante</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Toate prețurile includ TVA</li>
                <li>Rezervările se fac cu minim 24 de ore înainte</li>
                <li>Oferim reduceri pentru grupuri mari</li>
                <li>Pachetele pot fi personalizate în funcție de nevoile tale</li>
            </ul>
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('landing.contact') }}" class="inline-block bg-sky-600 text-white px-6 py-3 rounded-lg hover:bg-sky-700 transition-colors font-semibold">Contactează-ne pentru Ofertă Personalizată</a>
        </div>
    </div>
</section>
@endsection




