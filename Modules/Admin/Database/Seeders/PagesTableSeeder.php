<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Page;

use Carbon\Carbon;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pages = [
            [
                'id' => 1, 
                'page_titles' => 'Home', 
                'slugs' => 'home',
                'created_at'=>date('Y-m-d H:i:s'), 
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'id' => 2, 
                'page_titles' => 'How it Works', 
                'slugs' => 'how-it-works', 
                'created_at'=>date('Y-m-d H:i:s'), 
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'id' => 3, 
                'page_titles' => 'FAQ', 
                'slugs' => 'faq',
                'created_at'=>date('Y-m-d H:i:s'), 
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'id' => 4, 
                'page_titles' => 'Blog', 
                'slugs' => 'blog',
                'created_at'=>date('Y-m-d H:i:s'), 
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'id' => 5, 
                'page_titles' => 'About Us', 
                'slugs' => 'about-us',
                'created_at'=>date('Y-m-d H:i:s'), 
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'id' => 6, 
                'page_titles' => 'Contact', 
                'slugs' => 'contact',
                'created_at'=>date('Y-m-d H:i:s'), 
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'id' => 7, 
                'page_titles' => 'Terms of Service', 
                'slugs' => 'terms-of-service',
                'created_at'=>date('Y-m-d H:i:s'), 
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'id' => 8, 
                'page_titles' => 'Privacy Policy', 
                'slugs' => 'privacy-policy',
                'created_at'=>date('Y-m-d H:i:s'), 
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'id' => 9, 
                'page_titles' => 'Cookie Statement', 
                'slugs' => 'cookie-statement',
                'created_at'=>date('Y-m-d H:i:s'), 
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'id' => 10, 
                'page_titles' => 'Thank You', 
                'slugs' => 'thank-you',
                'created_at'=>date('Y-m-d H:i:s'), 
                'updated_at'=>date('Y-m-d H:i:s')
            ],
        ];

        Page::insert($pages);
    }
}
