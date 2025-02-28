<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

// Database interaction
use Session;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\Category;

// Entities from admin module
use Modules\Admin\Entities\Section;
use Modules\Admin\Entities\Content;
use Modules\Admin\Entities\Page;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $page = Page::where('slugs','blog')->first();

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

        $categories = Category::all(); 
        $posts = Post::orderBy('created_at', 'desc')->where('published','=',1)->paginate(6); 

        return view('blog::index', compact('page','sections','passedContents','showSection','posts','categories'));
    }


    public function categorized($category_name)
    {

        $page = Page::where('slugs','blog')->first();

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

        $categories = Category::all(); 

        
        foreach ($categories as $category) {
           $loweredCat = str_replace(' ','-',strtolower($category->category));
           if ($category_name == $loweredCat) {
               $posts = Post::orderBy('created_at', 'desc')->where([['category_id',$category->id],['published','=',1]])->paginate(6);
           } 
        }
            
        

        return view('blog::index', compact('page','sections','passedContents','showSection','posts','categories'));
    }

}
