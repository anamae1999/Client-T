<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Admin\Entities\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



        $sections = [
            // Home Section seeders
            [ 
                'page_id' => '1', 
                'section_names' => 'banner'
            ],
            [
                'page_id' => '1', 
                'section_names' => 'services'
            ],
            [
                'page_id' => '1', 
                'section_names' => 'how-it-works'
            ],
            [
                'page_id' => '1', 
                'section_names' => 'cta-1st'
            ],
            [ 
                'page_id' => '1', 
                'section_names' => 'nannies-and-babysitters'
            ],
            [
                'page_id' => '1', 
                'section_names' => 'testimonials'
            ],
            [
                'page_id' => '1', 
                'section_names' => 'cta-2nd'
            ],
            [
                'page_id' => '1', 
                'section_names' => 'steps-screens'
            ],

            // How it Works Section seeders
            [
                'page_id' => '2', 
                'section_names' => 'how-it-works-main'
            ],   
            [
                'page_id' => '2', 
                'section_names' => 'for-nanny'
            ], 
            [
                'page_id' => '2', 
                'section_names' => 'for-parent'
            ],  
            [
                'page_id' => '2', 
                'section_names' => 'how-it-works-cta1'
            ], 
            [
                'page_id' => '2', 
                'section_names' => 'program'
            ], 
            [
                'page_id' => '2', 
                'section_names' => 'benefits'
            ],
            [
                'page_id' => '2', 
                'section_names' => 'how-it-works-cta2'
            ],

            // FAQ section
            [
                'page_id' => '3', 
                'section_names' => 'faq-main'
            ],
            [
                'page_id' => '3', 
                'section_names' => 'faq-cta'
            ],

            // Blog Section seeders
            [
                'page_id' => '4', 
                'section_names' => 'blog-main'
            ],
            [
                'page_id' => '4', 
                'section_names' => 'blog-filter'
            ],

            // About Us Section seeders
            [
                'page_id' => '5', 
                'section_names' => 'about-us'
            ],         
            [ 
                'page_id' => '5', 
                'section_names' => 'mission'
            ],         
            [
                'page_id' => '5', 
                'section_names' => 'vision'
            ],  
            [
                'page_id' => '5', 
                'section_names' => 'about-us-text-row'
            ],       
            [ 
                'page_id' => '5', 
                'section_names' => 'awards'
            ],         
            [
                'page_id' => '5', 
                'section_names' => 'owners'
            ],       
            [
                'page_id' => '5', 
                'section_names' => 'about-us-cta'
            ],

            // Contact Us Section seeders
            [
                'page_id' => '6', 
                'section_names' => 'contact-us-main'
            ],
            [
                'page_id' => '6', 
                'section_names' => 'form-and-image'
            ],
            [
                'page_id' => '6', 
                'section_names' => 'contact-us-cta'
            ],

            // Terms of Service Section seeders
            [
                'page_id' => '7', 
                'section_names' => 'terms-of-service'
            ],

            // Privacy Policy Section seeders
            [
                'page_id' => '8', 
                'section_names' => 'privacy-policy'
            ],

            // Cookie Statement Section seeders
            [
                'page_id' => '9', 
                'section_names' => 'cookie-statement'
            ],

            // Thank You Section seeders
            [
                'page_id' => '10', 
                'section_names' => 'thank-you'
            ],
            
        ];

        Section::insert($sections);
    }
}
