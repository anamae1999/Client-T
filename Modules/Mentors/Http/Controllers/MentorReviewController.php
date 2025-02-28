<?php

namespace Modules\Mentors\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Auth;
use Session;

use Illuminate\Support\Facades\Validator;

// model
use Modules\Mentors\Entities\MentorReview;

class MentorReviewController extends Controller
{
    public function create(Request $request, $id)
    {
        $data = request()->validate([           
            'g-recaptcha-response' => 'required|recaptcha',
        ]);
        $review = new MentorReview;
        $review->user_id = Auth::user()->id;
        $review->mentor_id = $id;
        $review->review = $request->input('review');
        $review->rating = $request->input('rating');
        $review->save();

        Session::flash('response', 'Your review has been added!');
        
        return redirect()->back();
    }

    public function delete($review_id){
        $comment = MentorReview::find($review_id);
        $comment->delete();

        Session::flash('response', 'Your review has been deleted!');
        
        return redirect()->back();
    }
}
