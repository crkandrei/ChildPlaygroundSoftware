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
        return view('landing.app', [
            'metaTitle' => 'Bongoland Vaslui – Loc de joacă pentru copii | Petreceri și Serbări Copii',
            'metaDescription' => 'Cauți un loc de joacă pentru copii în Vaslui? Bongoland este cea mai modernă locație cu trambuline, tobogane, zonă pentru copii mici, petreceri și serbări. Vezi programul, prețurile și galeria foto.',
            'metaKeywords' => 'loc de joacă vaslui, loc joacă copii vaslui, petreceri copii vaslui, serbări copii vaslui, bongoland vaslui, joacă interior vaslui',
            'canonicalUrl' => 'https://bongoland.ro',
        ]);
    }

    /**
     * SEO Page: Loc de Joacă Vaslui
     */
    public function locDeJoaca()
    {
        return view('landing.seo.loc-de-joaca-vaslui', [
            'metaTitle' => 'Loc de Joacă Copii Vaslui – Bongoland | Cel Mai Mare Parc Interior',
            'metaDescription' => 'Bongoland este cel mai mare loc de joacă interior din Vaslui. Trambuline, tobogane, tiroliană, piscină cu bile și zonă pentru copii mici. Deschis zilnic, prețuri accesibile!',
            'metaKeywords' => 'loc de joacă vaslui, loc joacă copii vaslui, parc interior copii vaslui, joacă interior vaslui, playground vaslui',
            'canonicalUrl' => 'https://bongoland.ro/loc-de-joaca-vaslui',
        ]);
    }

    /**
     * SEO Page: Petreceri Copii Vaslui
     */
    public function petreceriCopii()
    {
        return view('landing.seo.petreceri-copii-vaslui', [
            'metaTitle' => 'Petreceri pentru Copii în Vaslui – Bongoland | Aniversări și Evenimente',
            'metaDescription' => 'Organizezi o petrecere pentru copilul tău? La Bongoland Vaslui avem pachete complete pentru aniversări: acces loc de joacă, mâncare proaspătă, decorațiuni. Rezervă acum!',
            'metaKeywords' => 'petreceri copii vaslui, aniversari copii vaslui, zile nastere copii vaslui, petreceri loc de joaca vaslui',
            'canonicalUrl' => 'https://bongoland.ro/petreceri-copii-vaslui',
        ]);
    }

    /**
     * SEO Page: Serbări Copii Vaslui
     */
    public function serbariCopii()
    {
        return view('landing.seo.serbari-copii-vaslui', [
            'metaTitle' => 'Serbări Școlare și Grădiniță în Vaslui – Bongoland | Evenimente pentru Copii',
            'metaDescription' => 'Organizăm serbări de Crăciun, 8 Martie și sfârșit de an pentru grădinițe și școli din Vaslui. Spațiu generos, mâncare proaspătă, prețuri speciale pentru grupuri!',
            'metaKeywords' => 'serbări copii vaslui, serbări grădiniță vaslui, serbări școlare vaslui, evenimente copii vaslui',
            'canonicalUrl' => 'https://bongoland.ro/serbari-copii-vaslui',
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
