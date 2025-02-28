<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

// Database interaction
use Auth;
use Session;
use Modules\Admin\Entities\Page;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\Comment;
use Modules\Blog\Entities\Category;
use Modules\Blog\Entities\Guest;

// support for file
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
  
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') { 


            if (Input::hasFile('post-image') || Input::hasFile('author_pic')) {
                $validator = Validator::make($request->all(), [
                    'post-image' => 'image',
                    'author_pic' => 'image',
                ]);

                if ($validator->fails()) {
                    $data = request()->validate([           
                        'post-title' => 'required',
                        'post-body' => 'required',
                        'category-id' => 'required',
                        'post-image' => 'image',
                        'slug' => 'required|unique:posts|alpha_dash',
                        'author_pic' => 'image',
                        'author_name' => 'required',
                        'author_desc' => 'required',
                    ]);
                } else {
                    if (Input::hasFile('post-image')) {
                        $file = Input::file('post-image');
                        $fileName = str_replace(' ', '', $file->getClientOriginalName());
                        $file->move(public_path() . '/uploads/', $fileName);
                        $urlPost = URL::to("/"). '/uploads/'. $fileName;                        
                        Session::put('urlPost', $urlPost);
                    }

                    if (Input::hasFile('author_pic')) {
                        $file = Input::file('author_pic');
                        $fileName = str_replace(' ', '', $file->getClientOriginalName());
                        $file->move(public_path() . '/uploads/', $fileName);
                        $urlAuthor = URL::to("/"). '/uploads/'. $fileName;
                        Session::put('urlAuthor', $urlAuthor);
                    }
                }
            }


            $data = request()->validate([           
                'post-title' => 'required',
                'post-body' => 'required',
                'category-id' => 'required',
                'slug' => 'required|unique:posts|alpha_dash',
                'author_name' => 'required',
                'author_desc' => 'required',    
            ]); 

            $posts = new Post;
            if (Input::hasFile('post-image')) {
                $posts->post_image = $urlPost;
            }
            if (Input::hasFile('author_pic')) {
                $posts->author_pic = $urlAuthor;
            }
            if ($request->input('post-image-hidden')) {
                $posts->post_image = $request->input('post-image-hidden');
            }
            if ($request->input('author_pic-hidden')) {
                $posts->author_pic = $request->input('author_pic-hidden');
            }
            $posts->post_title = $request->input('post-title');
            $posts->user_id = Auth::user()->id;
            $posts->post_body = $request->input('post-body');
            $posts->author_name = $request->input('author_name');
            $posts->author_desc = $request->input('author_desc');
            $posts->category_id = $request->input('category-id');
            $posts->meta_title = $request->input('meta-title');
            $posts->meta_description = $request->input('meta-description');
            $posts->meta_keyword = $request->input('meta-keyword');
            $posts->slug = $request->input('slug');
            $posts->published = $request->input('visibility');
            
            if ($posts->save()) {
                Session::flash('response', 'Post added successfully!');
                Session::forget(['urlPost','urlAuthor']);
                return redirect('blog/pages/edit/post/' . $posts->id);
            } else {                
                return redirect()->back();
            }    

        } else {
            abort('401');
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($slug)
    {

        if (Auth::check() && Auth::user()->role == 'admin') { 
            $post = Post::where('slug',$slug)->first();            
        } else {
            $post = Post::where([
                ['slug',$slug],
                ['published','=',1]
            ])->first();
        }        

        if ($post) {
            $category = Category::find($post->category_id);
            $comments = Comment::where('post_id', $post->id );       

            return view('blog::bloginner',compact('post','category','comments'));
        } else {
            abort(404);
        }
    
    }

    public function search(Request $request){ 

        if (Auth::check() && Auth::user()->role == 'admin') { 

            $pages = Page::paginate(10);           

            $keyword = $request->input('search-posts'); 
            $posts = Post::where('post_title', 'LIKE', '%'.$keyword.'%')->orWhere('post_body', 'LIKE', '%'.$keyword.'%')->paginate(10); 
            $categories = Category::all();

            return view('admin::pages', compact('posts', 'categories','pages'));
        } else {
            abort('401');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {        
        if (Auth::check() && Auth::user()->role == 'admin') {
            $post = Post::find($id);
            $categories = Category::all();            
            return view('admin::pages/blogeditcontent',compact('post','categories'));
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
    public function update(Request $request, $id)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $data = request()->validate([           
                'post-title' => 'required',
                'post-body' => 'required',
                'category-id' => 'required',
                'post-image' => 'image',
                'slug' => 'required|alpha_dash|unique:posts,slug,' . $id,
                'author_pic' => 'image',
                'author_name' => 'required',
                'author_desc' => 'required',
            ]);

            $posts = Post::find($id);
            $posts->post_title = $request->input('post-title');
            $posts->user_id = Auth::user()->id;
            $posts->post_body = $request->input('post-body');
            $posts->author_name = $request->input('author_name');
            $posts->author_desc = $request->input('author_desc');
            $posts->category_id = $request->input('category-id');
            $posts->meta_title = $request->input('meta-title');
            $posts->meta_description = $request->input('meta-description');
            $posts->meta_keyword = $request->input('meta-keyword');
            $posts->slug = $request->input('slug');
            $posts->published = $request->input('visibility');

            if (Input::hasFile('post-image')) {
                $file = Input::file('post-image');
                $fileName = str_replace(' ', '', $file->getClientOriginalName());
                $file->move(public_path() . '/uploads/', $fileName);
                $url = URL::to("/"). '/uploads/'. $fileName;
                $posts->post_image = $url;
            }

            if (Input::hasFile('author_pic')) {
                $file = Input::file('author_pic');
                $fileName = str_replace(' ', '', $file->getClientOriginalName());
                $file->move(public_path() . '/uploads/', $fileName);
                $url = URL::to("/"). '/uploads/'. $fileName;
                $posts->author_pic = $url;
            }

            $posts->save();

            Session::flash('response', 'Post updated successfully!');

            return redirect()->back();
        } else {
            abort('401');
        }
    }

    public function destroy(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $id = $request->input('postId');
            $post = Post::find($id);
            $post->delete();

            Session::flash('response', 'Post deleted successfully!');
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }

    // Comments
    public function addComment(Request $request, $id){ 

        // if comment is from a logged in user
        if(Auth::check()){ 
            $data = request()->validate([ 
                'comment' => 'required',
                'g-recaptcha-response' => 'required|recaptcha',
            ]);
            $comment = new Comment;
            $comment->user_id = Auth::user()->id;
            $comment->post_id = $id;
            $comment->comment = $request->input('comment');
            $comment->website = $request->input('website');
            $comment->save();
        } else {

            $data = request()->validate([ 
                'comment' => 'required',
                'name' => 'required',
                'email' => 'required',
                'g-recaptcha-response' => 'required|recaptcha',
            ]); 

            $guest = new Guest;
            $guest->name = $request->input('name');
            $guest->email = $request->input('email');
            $guest->save();

            $comment = new Comment;
            $comment->guest_id = $guest->id;
            $comment->post_id = $id;
            $comment->comment = $request->input('comment');
            $comment->website = $request->input('website');
            $comment->save();  
        }

        $comments = Comment::all();

        Session::flash('response', 'Your comment has been added successfully!');

        return redirect()->back();

    }

    public function deleteComment($comment_id)
    {

        if(Auth::check()){
            $comment = Comment::find($comment_id);
            $comment->delete();

            Session::flash('response', 'Your comment has been deleted successfully!');
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }

    public function updateComment(Request $request, $comment_id)
    {

        if(Auth::check()){
            $comment = Comment::find($comment_id);
            $comment->comment = $request->input('updated_comment');
            $comment->update();

            Session::flash('response', 'Your comment has been updated successfully!');
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }
}
