@extends('landing.layouts.landing')

@section('content')
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4 text-center">Contactează-ne</h1>
        <p class="text-xl text-gray-600 text-center mb-12">Suntem aici să răspundem la întrebările tale</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Informații de Contact</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Adresă</h3>
                        <p class="text-gray-700">Vaslui, România</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Telefon</h3>
                        <p class="text-gray-700">+40 XXX XXX XXX</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Email</h3>
                        <p class="text-gray-700">contact@bongoland.ro</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Program</h3>
                        <p class="text-gray-700">Luni - Duminică: 09:00 - 20:00</p>
                    </div>
                </div>
            </div>
            
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Trimite-ne un Mesaj</h2>
                <form action="{{ route('landing.contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nume *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telefon</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subiect *</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Mesaj *</label>
                        <textarea name="message" id="message" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="w-full bg-sky-600 text-white px-6 py-3 rounded-lg hover:bg-sky-700 transition-colors font-semibold">Trimite Mesajul</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection




