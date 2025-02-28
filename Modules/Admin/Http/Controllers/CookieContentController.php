<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Auth;
use Session;
use Modules\Admin\Entities\CookieSetting;
use Illuminate\Support\Facades\Validator;

class CookieContentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {

            $cookieSettings = CookieSetting::paginate(5);            
            
            return view('admin::pages.cookiesettingscontent',compact('cookieSettings'));
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
                'content' => 'required',
            ]);

            $cookieSetting = new CookieSetting;
            $cookieSetting->title  = $request->input('title');
            $cookieSetting->content  = $request->input('content');  

            $cookieSetting->save();

            Session::flash('response', 'Cookie Settings item added successfully!');

            return redirect()->back();
        } else {
            abort('401');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $cookieItem = CookieSetting::find($id);        
            return view('admin::pages.cookiesettingeditcontent',compact('cookieItem'));
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
                'title' => 'required',
                'content' => 'required',               
            ]);

            $cookieItem = CookieSetting::find($id);
            $cookieItem->title = $request->input('title');
            $cookieItem->content = $request->input('content');


            $cookieItem->save();

            Session::flash('response', 'Cookie settings item updated successfully!');

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
            $id = $request->input('cookieId');
            $cookieItem = CookieSetting::find($id);
            $cookieItem->delete();

            Session::flash('response', 'Cookie settings item deleted successfully!');
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }
}
