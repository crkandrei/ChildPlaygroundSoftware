<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    /**
     * Generate sitemap.xml dynamically
     */
    public function index(): Response
    {
        $baseUrl = config('app.url');
        $landingDomain = config('app.landing_domain');
        
        // Get all landing routes
        $routes = [
            ['url' => route('landing.index'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['url' => route('landing.about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('landing.services'), 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['url' => route('landing.pricing'), 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['url' => route('landing.gallery'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => route('landing.contact'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('landing.reservation'), 'priority' => '0.9', 'changefreq' => 'monthly'],
        ];
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        foreach ($routes as $route) {
            $url = str_replace(config('app.url'), 'https://' . $landingDomain, $route['url']);
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($url) . "</loc>\n";
            $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>" . $route['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $route['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }
        
        $xml .= '</urlset>';
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}




