<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Auth;
use Session;
use Modules\Admin\Entities\Member;
use Illuminate\Support\Facades\Validator;

// support for file
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $members = Member::all();    
            
            return view('admin::pages.teammembers',compact('members'));
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
                'member_pic' => 'required|image',
                'member_name' => 'required',
                'member_position' => 'required',
                'member_intro' => 'required',
            ]);

            $member = new Member;
            $member->member_name = $request->input('member_name');
            $member->member_position = $request->input('member_position');
            $member->member_introduction = $request->input('member_intro');

            if (Input::hasFile('member_pic')) {
                $file = Input::file('member_pic');
                $file->move(public_path() . '/uploads/', $file->getClientOriginalName());
                $url = URL::to("/"). '/uploads/'. $file->getClientOriginalName();
                $member->member_pic = $url;
            }

            $member->save();

            Session::flash('response', 'Team member added successfully!');

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
    public function update(Request $request, $id)
    {

        if (Auth::check() && Auth::user()->role == 'admin') {

            $member = Member::find($id);

            if ($request->input('member_name')) {
                $member->member_name = $request->input('member_name');
            }

            if ($request->input('member_position')) {
                $member->member_position = $request->input('member_position');
            }

            if ($request->input('member_intro')) {
                $member->member_introduction = $request->input('member_intro');
            }    

            if (Input::hasFile('member_pic')) {
                $file = Input::file('member_pic');
                $file->move(public_path() . '/uploads/', $file->getClientOriginalName());
                $url = URL::to("/"). '/uploads/'. $file->getClientOriginalName();
                $member->member_pic = $url;
            }

            $member->save();

            Session::flash('response', 'Team member updated successfully!');

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
            $id = $request->input('memberId');
            $member = Member::find($id);
            $member->delete();

            Session::flash('response', 'Team member successfully deleted!');
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }
}
