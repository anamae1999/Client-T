<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Content;

class ContentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $contents = [

            // HOME page seeder start
            // home banner section
            [ 
                'section_name' => 'banner', 
                'content_types' => 'banner-title'
            ],
            [
                'section_name' => 'banner', 
                'content_types' => 'banner-sign-up-title'
            ],
            [
                'section_name' => 'banner', 
                'content_types' => 'banner-content'
            ],
            [
                'section_name' => 'banner', 
                'content_types' => 'banner-bg'
            ],

            // home services section
            [
                'section_name' => 'services', 
                'content_types' => 'services-title1'
            ],
            [
                'section_name' => 'services', 
                'content_types' => 'services-image1'
            ],
            [
                'section_name' => 'services', 
                'content_types' => 'services-content1'
            ],
            [
                'section_name' => 'services', 
                'content_types' => 'services-title2'
            ],
            [ 
                'section_name' => 'services', 
                'content_types' => 'services-image2'
            ],
            [
                'section_name' => 'services', 
                'content_types' => 'services-content2'
            ],
            [ 
                'section_name' => 'services', 
                'content_types' => 'services-title3'
            ],
            [ 
                'section_name' => 'services', 
                'content_types' => 'services-image3'
            ],
            [
                'section_name' => 'services', 
                'content_types' => 'services-content3'
            ],

            // home how it works section
            [
                'section_name' => 'how-it-works', 
                'content_types' => 'how-it-works-title'
            ],
            [
                'section_name' => 'how-it-works', 
                'content_types' => 'how-it-works-content'
            ],
            [
                'section_name' => 'how-it-works', 
                'content_types' => 'how-it-works-col1-title'
            ],
            [ 
                'section_name' => 'how-it-works', 
                'content_types' => 'how-it-works-col1-img'
            ],
            [ 
                'section_name' => 'how-it-works', 
                'content_types' => 'how-it-works-col1-content'
            ],
            [
                'section_name' => 'how-it-works', 
                'content_types' => 'how-it-works-col2-title'
            ],
            [
                'section_name' => 'how-it-works', 
                'content_types' => 'how-it-works-col2-img'
            ],
            [
                'section_name' => 'how-it-works', 
                'content_types' => 'how-it-works-col2-content'
            ],
            [
                'section_name' => 'how-it-works', 
                'content_types' => 'how-it-works-col3-title'
            ],
            [
                'section_name' => 'how-it-works', 
                'content_types' => 'how-it-works-col3-img'
            ],
            [
                'section_name' => 'how-it-works', 
                'content_types' => 'how-it-works-col3-content'
            ],
            [ 
                'section_name' => 'how-it-works', 
                'content_types' => 'how-it-works-btn-text'
            ],
            [ 
                'section_name' => 'how-it-works', 
                'content_types' => 'how-it-works-btn-link'
            ],

            // CTA section first
            [
                'section_name' => 'cta-1st', 
                'content_types' => 'cta-1st-title'
            ],
            [ 
                'section_name' => 'cta-1st', 
                'content_types' => 'cta-1st-btn-text'
            ],

            // home nannies and babysitters section
            [
                'section_name' => 'nannies-and-babysitters', 
                'content_types' => 'nannies-title'
            ],
            [
                'section_name' => 'nannies-and-babysitters', 
                'content_types' => 'nannies-content'
            ],

            // testimonials section
            [
                'section_name' => 'testimonials', 
                'content_types' => 'testi-title'
            ],

            // CTA section second
            [
                'section_name' => 'cta-2nd', 
                'content_types' => 'cta-2nd-title'
            ],
            [ 
                'section_name' => 'cta-2nd', 
                'content_types' => 'cta-2nd-btn-text'
            ],

            // HOME page seeder end

            // HOW IT WORKS page seeder start

            // How it works main
            [ 
                'section_name' => 'how-it-works-main', 
                'content_types' => 'how-it-works-main-title'
            ],
            [ 
                'section_name' => 'how-it-works-main', 
                'content_types' => 'how-it-works-main-content'
            ],

            // For Nanny
            [ 
                'section_name' => 'for-nanny', 
                'content_types' => 'for-nanny-title'
            ],
            [ 
                'section_name' => 'for-nanny', 
                'content_types' => 'for-nanny-col1-title'
            ],
            [ 
                'section_name' => 'for-nanny', 
                'content_types' => 'for-nanny-col1-image'
            ],
            [ 
                'section_name' => 'for-nanny', 
                'content_types' => 'for-nanny-col1-content-title'
            ],
            [ 
                'section_name' => 'for-nanny', 
                'content_types' => 'for-nanny-col1-content'
            ],
            [ 
                'section_name' => 'for-nanny', 
                'content_types' => 'for-nanny-col2-title'
            ],
            [ 
                'section_name' => 'for-nanny', 
                'content_types' => 'for-nanny-col2-image'
            ],
            [ 
                'section_name' => 'for-nanny', 
                'content_types' => 'for-nanny-col2-content-title'
            ],
            [ 
                'section_name' => 'for-nanny', 
                'content_types' => 'for-nanny-col2-content'
            ],
            [ 
                'section_name' => 'for-nanny', 
                'content_types' => 'for-nanny-col3-title'
            ],
            [ 
                'section_name' => 'for-nanny', 
                'content_types' => 'for-nanny-col3-image'
            ],
            [ 
                'section_name' => 'for-nanny', 
                'content_types' => 'for-nanny-col3-content-title'
            ],
            [ 
                'section_name' => 'for-nanny', 
                'content_types' => 'for-nanny-col3-content'
            ],

            // For Parent
            [ 
                'section_name' => 'for-parent', 
                'content_types' => 'for-parent-title'
            ],
            [ 
                'section_name' => 'for-parent', 
                'content_types' => 'for-parent-col1-title'
            ],
            [ 
                'section_name' => 'for-parent', 
                'content_types' => 'for-parent-col1-image'
            ],
            [ 
                'section_name' => 'for-parent', 
                'content_types' => 'for-parent-col1-content-title'
            ],
            [ 
                'section_name' => 'for-parent', 
                'content_types' => 'for-parent-col1-content'
            ],
            [ 
                'section_name' => 'for-parent', 
                'content_types' => 'for-parent-col2-title'
            ],
            [ 
                'section_name' => 'for-parent', 
                'content_types' => 'for-parent-col2-image'
            ],
            [ 
                'section_name' => 'for-parent', 
                'content_types' => 'for-parent-col2-content-title'
            ],
            [ 
                'section_name' => 'for-parent', 
                'content_types' => 'for-parent-col2-content'
            ],
            [ 
                'section_name' => 'for-parent', 
                'content_types' => 'for-parent-col3-title'
            ],
            [ 
                'section_name' => 'for-parent', 
                'content_types' => 'for-parent-col3-image'
            ],
            [ 
                'section_name' => 'for-parent', 
                'content_types' => 'for-parent-col3-content-title'
            ],
            [ 
                'section_name' => 'for-parent', 
                'content_types' => 'for-parent-col3-content'
            ],

            // how-it-works-cta1
            [
                'section_name' => 'how-it-works-cta1', 
                'content_types' => 'how-it-works-cta1-title'
            ],
            [
                'section_name' => 'how-it-works-cta1', 
                'content_types' => 'how-it-works-cta1-btn-text'
            ],

            // Program
            [ 
                'section_name' => 'program', 
                'content_types' => 'program-title'
            ],
            [ 
                'section_name' => 'program', 
                'content_types' => 'program-content'
            ],
            [ 
                'section_name' => 'program', 
                'content_types' => 'program-image'
            ],
            [ 
                'section_name' => 'program', 
                'content_types' => 'program-content2'
            ],
            [ 
                'section_name' => 'program', 
                'content_types' => 'program-btn-text'
            ],
            [ 
                'section_name' => 'program', 
                'content_types' => 'program-btn-link'
            ],

            // Benefits
            [ 
                'section_name' => 'benefits', 
                'content_types' => 'benefits-title'
            ],
            [ 
                'section_name' => 'benefits', 
                'content_types' => 'benefits-list1'
            ],
            [ 
                'section_name' => 'benefits', 
                'content_types' => 'benefits-list2'
            ],
            [ 
                'section_name' => 'benefits', 
                'content_types' => 'benefits-list3'
            ],
            [ 
                'section_name' => 'benefits', 
                'content_types' => 'benefits-list4'
            ],
            [ 
                'section_name' => 'benefits', 
                'content_types' => 'benefits-list5'
            ],

            // how-it-works-cta2
            [
                'section_name' => 'how-it-works-cta2', 
                'content_types' => 'how-it-works-cta2-title'
            ],
            [
                'section_name' => 'how-it-works-cta2', 
                'content_types' => 'how-it-works-cta2-btn-text'
            ],
            // HOW IT WORKS page seeder end

            // FAQ page seeder start

            // FAQ main
            [ 
                'section_name' => 'faq-main', 
                'content_types' => 'faq-main-title'
            ],
            [ 
                'section_name' => 'faq-main', 
                'content_types' => 'faq-main-content'
            ],

            // FAQ cta
            [
                'section_name' => 'faq-cta', 
                'content_types' => 'faq-cta-title'
            ],
            [
                'section_name' => 'faq-cta', 
                'content_types' => 'faq-cta-btn-text'
            ],
            [
                'section_name' => 'faq-cta', 
                'content_types' => 'faq-cta-btn-link'
            ],

            
            // FAQ page seeder end

            // BLOG page seeder start

            // Blog main
            [
                'section_name' => 'blog-main', 
                'content_types' => 'blog-main-title'
            ],
            [
                'section_name' => 'blog-main', 
                'content_types' => 'blog-main-content'
            ],
            [
                'section_name' => 'blog-filter', 
                'content_types' => 'blog-filter-text'
            ],

            // BLOG page seeder end

            // ABOUT US page seeder start
            // About us Section
            [ 
                'section_name' => 'about-us', 
                'content_types' => 'about-us-title'
            ],
            [ 
                'section_name' => 'about-us', 
                'content_types' => 'about-us-content'
            ],

            // Mission Section
            [ 
                'section_name' => 'mission', 
                'content_types' => 'mission-title'
            ],
            [ 
                'section_name' => 'mission', 
                'content_types' => 'mission-image'
            ],
            [
                'section_name' => 'mission', 
                'content_types' => 'mission-content'
            ],

            // Vision Section
            [
                'section_name' => 'vision', 
                'content_types' => 'vision-title'
            ],
            [ 
                'section_name' => 'vision', 
                'content_types' => 'vision-image'
            ],
            [ 
                'section_name' => 'vision', 
                'content_types' => 'vision-content'
            ],

            // Text Row Section
            [ 
                'section_name' => 'about-us-text-row', 
                'content_types' => 'about-us-text-row-heading'
            ],
            [ 
                'section_name' => 'about-us-text-row', 
                'content_types' => 'about-us-text-row-content'
            ],

            // Awards Section
            [
                'section_name' => 'awards', 
                'content_types' => 'awards-title'
            ],

            // CTA section second
            [
                'section_name' => 'about-us-cta', 
                'content_types' => 'about-us-cta-title'
            ],
            [
                'section_name' => 'about-us-cta', 
                'content_types' => 'about-us-cta-btn-text'
            ],
            // ABOUT US page seeder end

            // CONTACT US page seeder start

            // contact-us-main
            [
                'section_name' => 'contact-us-main', 
                'content_types' => 'contact-us-main-title'
            ],
            [
                'section_name' => 'contact-us-main', 
                'content_types' => 'contact-us-main-content'
            ],

            // Form and Image
            [
                'section_name' => 'form-and-image', 
                'content_types' => 'form-and-image-image'
            ],
            [
                'section_name' => 'form-and-image', 
                'content_types' => 'form-and-image-email'
            ],
            [
                'section_name' => 'form-and-image', 
                'content_types' => 'form-and-image-coc-num'
            ],
            [
                'section_name' => 'form-and-image', 
                'content_types' => 'form-and-image-social-title'
            ],
            [
                'section_name' => 'form-and-image', 
                'content_types' => 'form-and-image-form-title'
            ],
            [
                'section_name' => 'form-and-image', 
                'content_types' => 'form-and-image-form-intro'
            ],

            // contact-us-cta
            [
                'section_name' => 'contact-us-cta', 
                'content_types' => 'contact-us-cta-title'
            ],
            [
                'section_name' => 'contact-us-cta', 
                'content_types' => 'contact-us-cta-btn-text'
            ],


            // CONTACT US page seeder end

            // Terms of Service page seeder start
            [
                'section_name' => 'terms-of-service', 
                'content_types' => 'tos-heading'
            ],
            [
                'section_name' => 'terms-of-service', 
                'content_types' => 'tos-content'
            ],
            // Terms of Service page seeder end

            // Privacy Policy page seeder start
            [
                'section_name' => 'privacy-policy', 
                'content_types' => 'pp-heading'
            ],
            [
                'section_name' => 'privacy-policy', 
                'content_types' => 'pp-content'
            ],
            // Privacy Policy page seeder end

            // Cookie Statement page seeder start
            [
                'section_name' => 'cookie-statement', 
                'content_types' => 'cs-heading'
            ],
            [
                'section_name' => 'cookie-statement', 
                'content_types' => 'cs-content'
            ],
            // Cookie Statement page seeder end

            // Thank You page seeder start
            [
                'section_name' => 'thank-you', 
                'content_types' => 'ty-heading'
            ],
            [
                'section_name' => 'thank-you', 
                'content_types' => 'ty-content'
            ],
            [
                'section_name' => 'thank-you', 
                'content_types' => 'ty-background'
            ],
            [
                'section_name' => 'thank-you', 
                'content_types' => 'ty-cta-btn-text'
            ],
          
            // Thank You page seeder end
        ];

        Content::insert($contents);
    }
}
