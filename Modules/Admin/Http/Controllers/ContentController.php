<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

// Database interaction
use Auth;
use Session;
use App\User;
use App\Schedule;
use DB;
use Modules\Admin\Entities\Section;
use Modules\Admin\Entities\Content;
use Modules\Admin\Entities\Page;
use Modules\Admin\Entities\Faq;
use Modules\Nannies\Entities\Sitter;
use Modules\Admin\Entities\Testimonial;
use Modules\Admin\Entities\Award;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\Category;
use Modules\Admin\Entities\Member;

// support for file
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

use Stripe\Stripe;

class ContentController extends Controller
{
    public function getSchedColumns($table)
    {
        return DB::getSchemaBuilder()->getColumnListing($table);
    }

    // show content of pages
    public function showPage(Request $request)
    {
        
        if ($request->path() == '/') {
            $url = 'home';

            // users for featured nannies
            $users = User::where('role', 'sitter')
            ->where('account_status','=','activated')
            ->whereHas('sitterProfile', function($q){
                $q->whereNotNull('job_description')
                  ->whereNotNull('profile_pic');
            });
            $users->whereHas('screening', function($q){
                $q->where('application_status','passed');
            });
            $users = $users->orderBy('created_at', 'desc')->get(); 

            if (count($users) > 10 ) {
               $users = $users->take(10);
            } 

            // users for featured mentors
            $mentors = User::where('role', 'mentor')
            ->where('account_status','=','activated')
            ->whereHas('mentorProfile', function($q){
                $q->whereNotNull('profile_pic');
            });
            $mentors = $mentors->orderBy('created_at', 'desc')->get(); 

            if (count($mentors) > 10 ) {
               $mentors = $mentors->take(10);
            } 

            $testimonials = Testimonial::where('hidden','=',0)->take(30)->latest()->get();

            // pull all column names from db table
            $schedColumns = self::getSchedColumns('schedules'); 

            $post = Post::where('published','!=',0)->latest()->first();

        } elseif ($request->path() == 'faq') {
            $url = $request->path();
            $faqsNanny = Faq::where('category','For Nanny')->get();
            $faqsParent = Faq::where('category','For Parent')->get();
            $faqsAbout = Faq::where('category','About Tiny Steps')->get();
            $faqsPrivacy = Faq::where('category','Account and Privacy')->get();
        } elseif ($request->path() == 'about-us') {
            $url = $request->path();
            $awards = Award::all();
            $members = Member::all();            
        } else {
            $url = $request->path();
        }

        $page = Page::where('slugs',$url)->first();



        // get all sections of page
        $sections = Section::where('page_id',$page->id)->get();
        
        $passedContents = []; //contents under a section
        $showSection = []; //sections itself
        foreach ($sections as $section) {

            // identify section to show/hide
            if ($section->hidden == 1) {
                $showSection[$section->section_names] = 'hide';
            } else {
                $showSection[$section->section_names] = 'show';
            }           

            // get all contents of each section of page
            $contents = Content::where('section_name',$section->section_names)->get();
            foreach ($contents as $content) {
                
                $passedContents[$content->content_types] = $content->contents;
            }  
        }    

        switch ($url) {
            case 'how-it-works':
                return view('howitworks', compact('page','sections','passedContents','showSection'));
                break;

            case 'faq':
                return view('faq', compact('page','sections','passedContents','showSection','faqsNanny','faqsParent','faqsAbout','faqsPrivacy'));
                break;

            case 'about-us':
                return view('aboutus', compact('page','sections','passedContents','showSection','awards','members'));
                break;

            case 'contact':
                return view('contact', compact('page','sections','passedContents','showSection'));
                break;

            case 'terms-of-service':
                return view('termsofservice', compact('page','sections','passedContents','showSection'));
                break;

            case 'privacy-policy':
                return view('privacypolicy', compact('page','sections','passedContents','showSection'));
                break;

            case 'cookie-statement':
                return view('cookiestatement', compact('page','sections','passedContents','showSection'));
                break;

            case 'thank-you':
                return view('thankyou', compact('page','sections','passedContents','showSection'));
                break;
            
            default:
                return view('home', compact('page','sections','passedContents','showSection','users','mentors','schedColumns','post','testimonials'));
                break;
        }
    }


    public function editPage($slug)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            
            $page = Page::where('slugs',$slug)->first();

            // get all sections of page
            $sections = Section::where('page_id',$page->id)->get();

            $passedContents = []; //contents under a section
            $showSection = []; //sections itself
            foreach ($sections as $section) {

                // identify section to show/hide
                if ($section->hidden == 1) {
                    $showSection[$section->section_names] = 'hide';
                } else {
                    $showSection[$section->section_names] = 'show';
                }           

                // get all contents of each section of page
                $contents = Content::where('section_name',$section->section_names)->get();
                foreach ($contents as $content) {
                    
                    $passedContents[$content->content_types] = $content->contents;
                }  
            }    

            switch ($page->slugs) {
                case 'home':
                    return view('admin::pages/homecontent', compact('page','sections','passedContents','showSection'));
                    break;

                case 'how-it-works':
                    return view('admin::pages/howitworkscontent', compact('page','sections','passedContents','showSection'));
                    break;

                case 'faq':
                    return view('admin::pages/faqcontent', compact('page','sections','passedContents','showSection'));
                    break;

                case 'blog':
                    return view('admin::pages/blogcontent', compact('page','sections','passedContents','showSection'));
                    break;

                case 'about-us':
                    return view('admin::pages/aboutuscontent', compact('page','sections','passedContents','showSection'));
                    break;

                case 'contact':
                    return view('admin::pages/contactcontent', compact('page','sections','passedContents','showSection'));
                    break;

                case 'terms-of-service':
                    return view('admin::pages/termsofservicecontent', compact('page','sections','passedContents','showSection'));
                    break;

                case 'privacy-policy':
                    return view('admin::pages/privacypolicycontent', compact('page','sections','passedContents','showSection'));
                    break;

                case 'cookie-statement':
                    return view('admin::pages/cookiestatementcontent', compact('page','sections','passedContents','showSection'));
                    break;

                case 'thank-you':
                    return view('admin::pages/thankyoucontent', compact('page','sections','passedContents','showSection'));
                    break;
                
                default:
                    return redirect()->back();
                    break;
            }
        } else {
            abort('401');
        }

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateContent(Request $request, $id)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {

            // get page from pages table
            $page = Page::find($id);

            switch ($id) {
                //home
                case '1': 
                    // hide/unhide section  
                    $sectionNames = [
                        // ['section_names in sections table', 'input field name']
                        ['banner','banner-hidden'], 
                        ['services','services-hidden'], 
                        ['how-it-works','how-it-works-hidden'], 
                        ['cta-1st','cta-1st-hidden'],
                        ['nannies-and-babysitters','nannies-and-babysitters-hidden'], 
                        ['testimonials','testimonials-hidden'], 
                        ['cta-2nd','cta-2nd-hidden'],
                        ['mentors','mentors-hidden'],
                        ['screening','screening-hidden'],
                        ['sitter-types','sitter-types-hidden'],
                    ];

                    // update contents
                    $content_types = [
                        'banner-title', 'banner-sign-up-title', 'banner-content', 'services-title1', 'services-title2', 'services-title3',
                        'services-content1', 'services-content2' , 'services-content3', 'how-it-works-title', 'how-it-works-content',
                        'how-it-works-col1-title', 'how-it-works-col1-content', 'how-it-works-col2-title', 'how-it-works-col2-content',
                        'how-it-works-col3-title', 'how-it-works-col3-content', 'how-it-works-btn-text', 'how-it-works-btn-link', 
                        'cta-1st-title', 'cta-1st-btn-text', 'cta-1st-btn-link', 'nannies-title', 'nannies-content', 'testi-title', 'cta-2nd-title', 'cta-2nd-btn-text', 'cta-2nd-btn-link','mentors-title','mentors-content','mentors-btn-text', 'service-modal1', 'service-modal2', 'service-modal3','screening-title','screening-content','screening-content1','sitter-types-title','sitter-types-content1','sitter-types-content2','sitter-types-content3','sitter-types-content4',
                    ];

                    // update images
                    $images = [
                        'banner-bg', 'services-image1', 'services-image2', 'services-image3', 'how-it-works-col1-img', 'how-it-works-col2-img', 'how-it-works-col3-img','steps-screens-contentimg1','steps-screens-contentimg2','sitter-image-content1','sitter-image-content2','sitter-image-content3','sitter-image-content4',
                    ];
                    break;

                //how it works
                case '2':                 
                    $sectionNames = [
                        ['how-it-works-main', 'how-it-works-main-hidden'], 
                        ['for-nanny', 'for-nanny-hidden'], 
                        ['for-parent', 'for-parent-hidden'], 
                        ['how-it-works-cta1', 'how-it-works-cta1-hidden'], 
                        ['program', 'program-hidden'], 
                        ['benefits', 'benefits-hidden'], 
                        ['how-it-works-cta2', 'how-it-works-cta2-hidden'],
                    ];

                    $content_types = [
                        'how-it-works-main-title', 'how-it-works-main-content', 'for-nanny-title', 'for-nanny-col1-title', 
                        'for-nanny-col1-content-title', 'for-nanny-col1-content', 'for-nanny-col2-title', 'for-nanny-col2-content-title', 
                        'for-nanny-col2-content', 'for-nanny-col3-title', 'for-nanny-col3-content-title', 'for-nanny-col3-content', 
                        'for-parent-title', 'for-parent-col1-title', 'for-parent-col1-content-title', 'for-parent-col1-content', 
                        'for-parent-col2-title', 'for-parent-col2-content-title', 'for-parent-col2-content', 'for-parent-col3-title', 
                        'for-parent-col3-content-title', 'for-parent-col3-content', 'how-it-works-cta1-title', 'how-it-works-cta1-btn-text', 
                        'program-title', 'program-content',  'program-content2', 'program-btn-text', 'program-btn-link', 'benefits-title', 
                        'benefits-list1', 'benefits-list2', 'benefits-list3', 'benefits-list4', 'benefits-list5', 'how-it-works-cta2-title', 
                        'how-it-works-cta2-btn-text',
                    ];

                    $images = [
                        'for-nanny-col1-image', 'for-nanny-col2-image', 'for-nanny-col3-image', 'for-parent-col1-image', 'for-parent-col2-image', 
                        'for-parent-col3-image', 'program-image', 
                    ];
                    break;

                //faq
                case '3':                 
                    $sectionNames = [
                        ['faq-main','faq-main-hidden'], ['faq-cta','faq-cta-hidden'],
                    ];

                    $content_types = [
                        'faq-main-title', 'faq-main-content', 'faq-cta-title', 'faq-cta-btn-text', 'faq-cta-btn-link',
                    ];

                    $images = [];
                    break;

                //blog
                case '4':                 
                    $sectionNames = [
                        ['blog-main', 'blog-main-hidden'], ['blog-filter', 'blog-filter-hidden'],
                    ];

                    $content_types = [
                        'blog-main-title', 'blog-main-content', 'blog-filter-text',
                    ];

                    $images = [];
                    break;

                //about us
                case '5':                 
                    $sectionNames = [
                        ['about-us', 'about-us-hidden'], ['mission', 'mission-hidden'], ['vision', 'vision-hidden'], 
                        ['about-us-text-row','about-us-text-row-hidden'], ['awards', 'awards-hidden'], ['owners', 'owners-hidden'], 
                        ['about-us-cta', 'about-us-cta-hidden'],
                    ];

                    $content_types = [
                        'about-us-title', 'about-us-content', 'mission-title', 'mission-content', 'vision-title', 'vision-content', 'about-us-text-row-heading', 'about-us-text-row-content', 'awards-title', 'about-us-cta-title', 'about-us-cta-btn-text',
                    ];

                    $images = [
                        'mission-image', 'vision-image',
                    ];
                    break;

                //contact us
                case '6':                 
                    $sectionNames = [
                        ['contact-us-main', 'contact-us-main-hidden'], 
                        ['form-and-image', 'form-and-image-hidden'], 
                        ['contact-us-cta', 'contact-us-cta-hidden'],
                    ];

                    $content_types = [
                        'contact-us-main-title', 'contact-us-main-content', 'form-and-image-email', 'form-and-image-coc-num', 'form-and-image-contact-num','form-and-image-social-title', 'form-and-image-form-title', 'form-and-image-form-intro', 'contact-us-cta-title', 'contact-us-cta-btn-text',
                    ];

                    $images = [
                        'form-and-image-image',
                    ];
                    break;

                // terms of service page
                case '7':
                    $sectionNames = [
                        ['terms-of-service', 'terms-of-service-hidden'],                         
                    ];

                    $content_types = [
                        'tos-heading', 'tos-content',
                    ];

                    $images = [];
                    break;

                // Privacy Policy page
                case '8':
                    $sectionNames = [
                        ['privacy-policy', 'privacy-policy-hidden'],                         
                    ];

                    $content_types = [
                        'pp-heading', 'pp-content',
                    ];

                    $images = [];
                    break;

                // Cookie Statement page
                case '9':
                    $sectionNames = [
                        ['cookie-statement', 'cookie-statement-hidden'],                         
                    ];

                    $content_types = [
                        'cs-heading', 'cs-content',
                    ];

                    $images = [];
                    break;

                // Thank You page
                case '10':
                    $sectionNames = [
                        ['thank-you', 'thank-you-hidden'],                         
                    ];

                    $content_types = [
                        'ty-heading', 'ty-content', 'ty-cta-btn-text',
                    ];

                    $images = [
                        'ty-background',
                    ];
                    break;
                
                default:
                    return redirect()->back();
                    break;
            }

            // update section hide/show
            $index = 0;
            foreach ($sectionNames as $sectionName) {
                $hidden = ( $request->input($sectionNames[$index][1]) ? 1 : 0); 
                $section = Section::where([
                    ['section_names', '=', $sectionNames[$index][0]],
                    ['page_id', '=', $page->id],
                ])->update(['hidden' => $hidden]);
                $index++;
            }        

            // insert content to db
            foreach ($content_types as $content_type) {
                $content = Content::where([
                    ['content_types', '=', $content_type],
                ])->update(['contents' => $request->input($content_type)]);
            }

            // upload images and insert path to db
            foreach ($images as $image) {
                if (Input::hasFile($image)) {
                    $file = Input::file($image);  
                    $fileName = str_replace(' ', '', $file->getClientOriginalName());          
                    $file->move(public_path() . '/uploads/', $fileName);
                    $url = URL::to("/"). '/uploads/'. $fileName;

                    $content = Content::where([
                        ['content_types', '=', $image],
                    ])->update(['contents' => $url]);
                }            
            } 

            $page->user_id = Auth::user()->id;

            if ($page->save()) {
                $page->touch();
            }

            Session::flash('response', 'Page content updated successfully!');  

            return redirect()->back();
        } else {
            abort('401');
        }
    }


    /**
    * Display a listing of the resource.
    * @return Response
    */
    public function newBlog()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {     
            $categories = Category::all();
            return view('admin::pages.bloginnercontent', compact('categories'));
        } else {
            abort('401');
        }
    }

    public function mceUpload(Request $request)
    {
        dd($request);
    }


}
