<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Auth;
use Session;
use Modules\Admin\Entities\Award;
use Illuminate\Support\Facades\Validator;

// support for file
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class AwardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {

            $awards = Award::paginate(5);            
            
            return view('admin::pages.awards',compact('awards'));
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
                'title' => 'required',
                'image' => 'required|image|max:2048',
            ]);

            $award = new Award;
            $award->award_title  = $request->input('title');

             // award picture upload
            $filenamePrepend = $request->input('title');
            if (Input::hasFile('image')) {
                $file = Input::file('image');            
                $file->move(public_path() . '/uploads/', $filenamePrepend . '-' . $file->getClientOriginalName());
                $url = URL::to("/"). '/uploads/'. $filenamePrepend . '-' . $file->getClientOriginalName();
                $award->award_image  = $url;
            }        

            $award->save();

            Session::flash('response', 'Award/Certification item added successfully!');

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
                'title' => 'required',
            ]);

            $id = $request->input('awardId');
            // award picture upload
            $filenamePrepend = $request->input('title');
            if (Input::hasFile('image')) {
                $file = Input::file('image');            
                $file->move(public_path() . '/uploads/', $filenamePrepend . '-' . $file->getClientOriginalName());
                $url = URL::to("/"). '/uploads/'. $filenamePrepend . '-' . $file->getClientOriginalName();
            } else {
                $url = $request->input('oldImage');
            }

            $award = Award::where([
                ['id', '=', $id],
            ])->update(
                [
                    'award_title' => $request->input('title'),
                    'award_image' => $url,
                ]);

            Session::flash('response', 'Award/Certification item updated successfully!');

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
            $id = $request->input('awardId');
            $testi = Award::find($id);
            $testi->delete();

            Session::flash('response', 'Award/Certification item deleted successfully!');
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }
}
