<?php

namespace Database\Seeders;
use App\Models\QuickLink;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuickLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('quick_links')->insert([
            ['title' => 'About Us', 'url' => '/about', 'is_active' => true],
            ['title' => 'Advertise', 'url' => '/advertise', 'is_active' => true],
            ['title' => 'Privacy Policy', 'url' => '/privacy-policy', 'is_active' => true],
            ['title' => 'Terms Of Use', 'url' => '/terms-conditions', 'is_active' => true],
            ['title' => 'Cookies Policy', 'url' => '/cookie-policy', 'is_active' => true],
            ['title' => 'Affiliate Disclosure', 'url' => '/affiliate-disclosure', 'is_active' => true], 
            ['title' => 'Dmca', 'url' => '/dmca', 'is_active' => true],
            ['title' => 'Disclaimer', 'url' => '/disclaimer', 'is_active' => true],   // Make sure the URL is correct
        ]);
     
    }
}

