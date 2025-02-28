<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Session;
use Modules\Admin\Entities\Faq;
use Auth;

use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $faqsNanny = Faq::where('category','For Nanny')->paginate(5);
            $faqsParent = Faq::where('category','For Parent')->paginate(5);
            $faqsAbout = Faq::where('category','About Tiny Steps')->paginate(5);
            $faqsPrivacy = Faq::where('category','Account and Privacy')->paginate(5);            

            return view('admin::pages.faqquestions', compact('faqsNanny','faqsParent','faqsAbout','faqsPrivacy'));
        } else {
            abort('401');
        }

    }

    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {

            $data = request()->validate([
                'category' => 'required',
                'question' => 'required',
                'answer' => 'required',
            ]);

            $faq = new Faq;
            $faq->category = $request->input('category');
            $faq->question = $request->input('question');
            $faq->answer = $request->input('answer');

            $faq->save();

            Session::flash('response', 'FAQ item added successfully!');

            return redirect()->back();
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
            $faqItem = Faq::find($id);        
            return view('admin::pages.faqeditquestions',compact('faqItem'));
        } else {
            abort('401');
        }
    }


    public function update(Request $request, $id)
    {
        // dd($request);
        if (Auth::check() && Auth::user()->role == 'admin') {
            $data = request()->validate([
                'question' => 'required',
                'answer' => 'required'
            ]);

            $faq = Faq::where([
                ['id', '=', $id],
            ])->update(
                [
                    'question' => $request->input('question'),
                    'answer' => $request->input('answer')
                ]);

            Session::flash('response', 'FAQ item updated successfully!');

            return redirect()->back();
        } else {
            abort('401');
        }
    }

    public function destroy(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $id = $request->input('faqId');
            $faq = Faq::find($id);
            $faq->delete();

            Session::flash('response', 'FAQ item deleted successfully!');
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }
}
