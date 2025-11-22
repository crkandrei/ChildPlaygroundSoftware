<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the landing page homepage
     */
    public function index()
    {
        return view('landing.index', [
            'metaTitle' => 'Bongoland - Loc de Joacă Vaslui | Parc de Joacă pentru Copii',
            'metaDescription' => 'Bongoland este cel mai bun loc de joacă din Vaslui pentru copii. Oferim activități distractive, zile de naștere memorabile și un mediu sigur pentru copiii tăi.',
            'metaKeywords' => 'locuri de joacă Vaslui, parc de joacă Vaslui, playground Vaslui, activități copii Vaslui, zi de naștere copii Vaslui',
        ]);
    }

    /**
     * Display the about page
     */
    public function about()
    {
        return view('landing.about', [
            'metaTitle' => 'Despre Noi - Bongoland Vaslui',
            'metaDescription' => 'Află mai multe despre Bongoland, locul tău de joacă preferat din Vaslui. Oferim un mediu sigur și distractiv pentru copii.',
            'metaKeywords' => 'despre Bongoland, loc de joacă Vaslui, activități copii',
        ]);
    }

    /**
     * Display the services page
     */
    public function services()
    {
        return view('landing.services', [
            'metaTitle' => 'Servicii - Bongoland Vaslui',
            'metaDescription' => 'Descoperă serviciile oferite de Bongoland: jocuri, activități, zile de naștere și multe altele pentru copii din Vaslui.',
            'metaKeywords' => 'servicii Bongoland, activități copii Vaslui, jocuri copii',
        ]);
    }

    /**
     * Display the pricing page
     */
    public function pricing()
    {
        return view('landing.pricing', [
            'metaTitle' => 'Tarife și Prețuri - Bongoland Vaslui',
            'metaDescription' => 'Vezi tarifele și prețurile pentru accesul la Bongoland. Oferim pachete flexibile pentru copii și familii din Vaslui.',
            'metaKeywords' => 'tarife Bongoland, prețuri loc de joacă Vaslui, pachete copii',
        ]);
    }

    /**
     * Display the gallery page
     */
    public function gallery()
    {
        return view('landing.gallery', [
            'metaTitle' => 'Galerie Foto - Bongoland Vaslui',
            'metaDescription' => 'Explorează galeria noastră de fotografii și vezi cât de mult se distrează copiii la Bongoland Vaslui.',
            'metaKeywords' => 'galerie Bongoland, fotografii loc de joacă Vaslui',
        ]);
    }
}




