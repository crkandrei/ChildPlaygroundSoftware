@extends('landing.layouts.landing')

@section('content')
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4 text-center">Rezervare Zi de Naștere</h1>
        <p class="text-xl text-gray-600 text-center mb-12">Rezervă o zi de naștere memorabilă pentru copilul tău</p>
        
        <div class="bg-gray-50 p-8 rounded-lg mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Ce Include Rezervarea?</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>3 ore de joacă pentru copii</li>
                <li>Decoruri tematice personalizate</li>
                <li>Activități speciale organizate</li>
                <li>Fotografii de amintire</li>
                <li>Supraveghere personal calificat</li>
                <li>Până la 15 copii inclusi în preț</li>
            </ul>
        </div>
        
        <form action="{{ route('landing.reservation.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="child_name" class="block text-sm font-medium text-gray-700 mb-2">Numele Copilului *</label>
                    <input type="text" name="child_name" id="child_name" value="{{ old('child_name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    @error('child_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="parent_name" class="block text-sm font-medium text-gray-700 mb-2">Numele Părintelui *</label>
                    <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    @error('parent_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telefon *</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="birthday_date" class="block text-sm font-medium text-gray-700 mb-2">Data Zilei de Naștere *</label>
                    <input type="date" name="birthday_date" id="birthday_date" value="{{ old('birthday_date') }}" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    @error('birthday_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="number_of_children" class="block text-sm font-medium text-gray-700 mb-2">Număr de Copii *</label>
                    <input type="number" name="number_of_children" id="number_of_children" value="{{ old('number_of_children', 1) }}" required min="1" max="50" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    @error('number_of_children')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Mesaj sau Cerințe Speciale</label>
                <textarea name="message" id="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                <p class="text-sm text-blue-700">
                    <strong>Notă:</strong> Rezervările se fac cu minim 24 de ore înainte. Vom reveni în cel mai scurt timp pentru confirmare.
                </p>
            </div>
            
            <button type="submit" class="w-full bg-sky-600 text-white px-6 py-3 rounded-lg hover:bg-sky-700 transition-colors font-semibold text-lg">Trimite Rezervarea</button>
        </form>
    </div>
</section>
@endsection




