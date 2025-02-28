<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Auth;
use Session;
use Modules\Admin\Entities\Testimonial;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $testimonials = Testimonial::latest()->paginate(5);    
            
            return view('admin::pages.testimonials',compact('testimonials'));
        } else {
            abort('401');
        }
    }
   

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {

            $data = request()->validate([
                'author' => 'required',
                'content' => 'required',
                'rating' => 'required',
            ]);

            $testi = new Testimonial;
            $testi->testi_content = $request->input('content');
            $testi->testi_author = $request->input('author');
            $testi->testi_rating = $request->input('rating');

            $testi->save();

            Session::flash('response', 'Testimonial item added successfully!');

            return redirect()->back();
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
    public function update(Request $request)
    {
    
        if (Auth::check() && Auth::user()->role == 'admin') {

            $data = request()->validate([
                'author' => 'required',
                'content' => 'required',
                'rating' => 'required',
            ]);

            if ($request->input('hidden')) {
                $hidden = 1;
            } else {
                $hidden = 0;
            }

            $id = $request->input('testiId');


            $testi = Testimonial::where([
                ['id', '=', $id],
            ])->update(
                [
                    'testi_author' => $request->input('author'),
                    'testi_content' => $request->input('content'),
                    'testi_rating' => $request->input('rating'),
                    'hidden' => $hidden,
                ]);

            Session::flash('response', 'Testimonial item updated successfully!');

            return redirect()->back();
        } else {
            abort('401');
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function submitted(Request $request)
    {

        if (Auth::check()) {

            $data = request()->validate([
                'content' => 'required',
                'rating' => 'required',
                'g-recaptcha-response' => 'required|recaptcha',
            ]);

            $author = Auth::user()->first_name;

            $testi = new Testimonial;
            $testi->testi_content = $request->input('content');
            $testi->testi_author = $author;
            $testi->testi_rating = $request->input('rating');

            $testi->save();

            Session::flash('response', 'Testimonial submitted!');

            return redirect()->back();
        } else {
            abort('401');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $id = $request->input('testiId');
            $testi = Testimonial::find($id);
            $testi->delete();

            Session::flash('response', 'Testimonial item deleted successfully!');
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }
}
