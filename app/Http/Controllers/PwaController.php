<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSetting;
use Illuminate\Http\Response;

class PwaController extends Controller
{
    public function manifest(): Response
    {
        $name      = WebsiteSetting::getValue('site_name', config('app.name'));
        $short     = $this->shortName($name);
        $themeColor = WebsiteSetting::getValue('theme_color', '#DC143C');
        $bgColor    = WebsiteSetting::getValue('bg_color', '#0D1117');

        $manifest = [
            'name'             => $name,
            'short_name'       => $short,
            'description'      => WebsiteSetting::getValue('site_default_meta_description', 'Your trusted source for the latest news.'),
            'start_url'        => '/',
            'scope'            => '/',
            'display'          => 'standalone',
            'orientation'      => 'portrait',
            'theme_color'      => $themeColor,
            'background_color' => $bgColor,
            'lang'             => 'en',
            'categories'       => ['news'],
            'icons'            => [
                [
                    'src'     => '/icons/icon-192.png',
                    'sizes'   => '192x192',
                    'type'    => 'image/png',
                    'purpose' => 'any maskable',
                ],
                [
                    'src'     => '/icons/icon-512.png',
                    'sizes'   => '512x512',
                    'type'    => 'image/png',
                    'purpose' => 'any maskable',
                ],
                [
                    'src'     => '/icons/icon.svg',
                    'sizes'   => 'any',
                    'type'    => 'image/svg+xml',
                    'purpose' => 'any',
                ],
            ],
            'screenshots' => [],
        ];

        return response(json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
            ->header('Content-Type', 'application/manifest+json')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    private function shortName(string $name): string
    {
        if (mb_strlen($name) <= 12) {
            return $name;
        }
        $words = explode(' ', $name);
        return count($words) >= 2
            ? $words[0] . ' ' . $words[1]
            : mb_substr($name, 0, 12);
    }
}
