@extends('landing.layouts.landing')

@section('content')
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4 text-center">Galerie Foto</h1>
        <p class="text-xl text-gray-600 text-center mb-12">Vezi cât de mult se distrează copiii la Bongoland Vaslui</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @for($i = 1; $i <= 9; $i++)
            <div class="bg-gray-200 rounded-lg aspect-square flex items-center justify-center">
                <p class="text-gray-500">Imagine {{ $i }}</p>
            </div>
            @endfor
        </div>
        
        <div class="text-center mt-12">
            <p class="text-gray-600 mb-4">Vrei să vezi mai multe? Vizitează-ne sau urmărește-ne pe social media!</p>
            <a href="{{ route('landing.contact') }}" class="inline-block bg-sky-600 text-white px-6 py-3 rounded-lg hover:bg-sky-700 transition-colors font-semibold">Contactează-ne</a>
        </div>
    </div>
</section>
@endsection



