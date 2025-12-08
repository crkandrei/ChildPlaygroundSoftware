<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate sitemap.xml dynamically
     */
    public function index(): Response
    {
        $baseUrl = 'https://bongoland.ro';
        
        // Define all public landing pages
        $routes = [
            // Homepage - highest priority
            ['url' => $baseUrl, 'priority' => '1.0', 'changefreq' => 'weekly'],
            
            // SEO Dedicated Pages - high priority for local search
            ['url' => $baseUrl . '/loc-de-joaca-vaslui', 'priority' => '0.95', 'changefreq' => 'weekly'],
            ['url' => $baseUrl . '/petreceri-copii-vaslui', 'priority' => '0.95', 'changefreq' => 'weekly'],
            ['url' => $baseUrl . '/serbari-copii-vaslui', 'priority' => '0.95', 'changefreq' => 'weekly'],
        ];
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        foreach ($routes as $route) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($route['url']) . "</loc>\n";
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
