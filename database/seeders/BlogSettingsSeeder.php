<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogSetting;


class BlogSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

    

    {
        $settings = [
            // ['key' => 'brand_name', 'title' => 'Brand Name', 'content' => 'This is the name of your Blog'],
            ['key' => 'about', 'title' => 'About Us', 'content' => 'This is the about us page.'],
            ['key' => 'advertise', 'title' => 'Advertise', 'content' => 'This is the advertise page.'],
            ['key' => 'privacy_policy', 'title' => 'Privacy Policy', 'content' => 'This is the privacy & policy page.'],
            ['key' => 'terms_conditions', 'title' => 'Terms Of Use', 'content' => 'This is the terms & conditions page.'],
            ['key' => 'cookies_policy', 'title' => 'Cookies Policy', 'content' => 'This is the Cookie page.'],
            ['key' => 'affiliate_disclosure', 'title' => 'Affiliate Disclosure', 'content' => 'This is the Affiliate disclosure page.'],
            ['key' => 'dmca', 'title' => 'DMCA', 'content' => 'This is the Dmca page.'],
            ['key' => 'disclaimer', 'title' => 'Disclaimer', 'content' => 'This is the Disclaimer page.'],
        ];

        
        foreach ($settings as $setting) {
            BlogSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
