<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Vetting; 
use App\Screening; 
use App\Badge; 
use App\User;
use Auth;

use Session;

use App\Notifications\VettingPassed;
use App\Notifications\VettingFailed;
use App\Notifications\ScreeningProcessing;
use App\Notifications\ScreeningPassed;
use App\Notifications\ScreeningFailed;


class VettingController extends Controller
{

    public function index()
    {
        if (Auth::check() && Auth::user()->role == 'admin') { 
            $usersVetting = User::whereHas('vetting')->paginate(12);   
            $usersScreening = User::whereHas('screening')->paginate(12); 
            $badges = Badge::all();

            return view('admin::vetting', compact('usersVetting','usersScreening','badges'));
        } else {
            abort('401');
        }
    }

    public function updateBadge(request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') { 

            $id = $request->input('userId');
            $badgenum = $request->input('badge-num');
            $badgeval = $request->input('badge-type');
            $empty  = '';

            $badges = Badge::all();
                
                foreach ($badges as $key => $badge) {  
                    if ($badge->badge_name == $badgeval) {
                        $nannyBadge = $badge->badge_pic;
                    }else if($badgeval == 'none'){
                        $nannyBadge = $empty;  
                    }
                }       


            if($badgenum==1){
            $screening = Screening::where([
                ['user_id', '=', $id],
            ])->update(['badge_name' => $request->input('badge-type')]);

            $screening = Screening::where([
                ['user_id', '=', $id],
            ])->update(['bandge_img1' => $nannyBadge]);
            }
            else if($badgenum==2){
            $screening = Screening::where([
                ['user_id', '=', $id],
            ])->update(['badge_name2' => $request->input('badge-type')]);
            $screening = Screening::where([
                ['user_id', '=', $id],
            ])->update(['bandge_img2' => $nannyBadge]);    
            }
            else if($badgenum==3){
            $screening = Screening::where([
                ['user_id', '=', $id],
            ])->update(['badge_name3' => $request->input('badge-type')]);
            $screening = Screening::where([
                ['user_id', '=', $id],
            ])->update(['bandge_img3' => $nannyBadge]);
            }
            else if($badgenum==4){
            $screening = Screening::where([
                ['user_id', '=', $id],
            ])->update(['badge_name4' => $request->input('badge-type')]);
            $screening = Screening::where([
                ['user_id', '=', $id],
            ])->update(['bandge_img4' => $nannyBadge]);    
            }
            else if($badgenum==5){
            $screening = Screening::where([
                ['user_id', '=', $id],
            ])->update(['badge_name5' => $request->input('badge-type')]);
            $screening = Screening::where([
                ['user_id', '=', $id],
            ])->update(['bandge_img5' => $nannyBadge]);    
            }

            Session::flash('response', 'Badge assigned to user successfully!');

            return redirect()->back();
        } else {
            abort('401');
        }
    }

    
    public function updateRemarks(request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') { 

            $id = $request->input('userId');

            if ($request->type == 'vetting') {
                $vetting = Vetting::where([
                    ['user_id', '=', $id],
                ])->update(['remarks' => $request->input('remarks')]);
            }

            if ($request->type == 'screening') {
                $screening = Screening::where([
                    ['user_id', '=', $id],
                ])->update(['remarks' => $request->input('remarks')]);
            }

            Session::flash('response', 'Remarks updated successfully!');

            return redirect()->back();
        } else {
            abort('401');
        }
    }


    public function process(request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $id = $request->input('userId');
            $user = User::find($id);

            if ($request->type == 'vetting') {
                $vetting = Vetting::where([
                    ['user_id', '=', $id],
                ])->update(
                    [
                        'application_status' => 'processing',
                        'status' => 'unverified'
                    ]); 

                Session::flash('response', 'User vetting request updated to processing!');
            }

            if ($request->type == 'screening') {
                $screening = Screening::where([
                    ['user_id', '=', $id],
                ])->update(
                    [
                        'application_status' => 'processing',
                        'status' => 'unverified'
                    ]);

                $recipient = new User();
                $recipient->name = $user->first_name; 
                $recipient->email = $user->email;   // This is the email you want to send to.
                $recipient->notify(new ScreeningProcessing()); 

                Session::flash('response', 'User screening request updated to processing!');
            }

            
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }


    public function pend(request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $id = $request->input('userId');

            if ($request->type == 'vetting') {

                $vetting = Vetting::where([
                    ['user_id', '=', $id],
                ])->update(
                    [
                        'application_status' => 'pending',
                        'status' => 'unverified'
                    ]); 

                Session::flash('response', 'User vetting request updated to pending!');
            }

            if ($request->type == 'screening') {
                $screening = Screening::where([
                    ['user_id', '=', $id],
                ])->update(
                    [
                        'application_status' => 'pending',
                        'status' => 'unverified'
                    ]); 

                Session::flash('response', 'User screening request updated to pending!');

            }
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }


    public function passed(request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $id = $request->input('userId');
            $user = User::find($id);

            if ($request->type == 'vetting') {
                $vetting = Vetting::where([
                    ['user_id', '=', $id],
                ])->update(
                    [
                        'application_status' => 'passed',
                        'status' => 'verified'
                    ]); 

                $recipient = new User();
                $recipient->name = $user->first_name; 
                $recipient->email = $user->email;   // This is the email you want to send to.
                $recipient->notify(new VettingPassed()); 

                Session::flash('response', 'User vetting request updated to passed!');
            }

            if ($request->type == 'screening') {
                $screening = Screening::where([
                    ['user_id', '=', $id],
                ])->update(
                    [
                        'application_status' => 'passed',
                        'status' => 'verified'
                    ]);

                $recipient = new User();
                $recipient->name = $user->first_name; 
                $recipient->email = $user->email;   // This is the email you want to send to.
                $recipient->notify(new ScreeningPassed());

                Session::flash('response', 'User screening request updated to passed!');
            }
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }


    public function failed(request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $id = $request->input('userId');
            $user = User::find($id);

            if ($request->type == 'vetting') {

                $vetting = Vetting::where([
                    ['user_id', '=', $id],
                ])->update(
                    [
                        'application_status' => 'failed',
                        'status' => 'unverified'
                    ]); 

                $recipient = new User();
                $recipient->name = $user->first_name; 
                $recipient->email = $user->email;   // This is the email you want to send to.
                $recipient->notify(new VettingFailed()); 

                Session::flash('response', 'User vetting request updated to failed!');
            }

            if ($request->type == 'screening') {
                if($user->forceDelete($id)){
                    $recipient = new User();
                    $recipient->name = $user->first_name; 
                    $recipient->email = $user->email;   // This is the email you want to send to.
                    $recipient->notify(new ScreeningFailed()); 
                }                
            }
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }

    public function search(request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $badges = Badge::all();
            $keyword = $request->input('keyword');

            if ($request->type == 'vetting' && ($keyword)) {                
                $usersVetting = User::where(function ($q) use ($keyword) { 
                    $q->whereHas('vetting', function ($q) use ($keyword) {  
                        $q->where('application_status', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('remarks', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('status', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('created_at', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('first_name', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('last_name', 'LIKE', '%'.$keyword.'%');
                    });  
                });                 
            } else {
                $usersVetting = User::whereHas('vetting');
            } 

            if ($request->type == 'screening' && ($keyword)) {                
                $usersScreening = User::where(function ($quer) use ($keyword) { 
                    $quer->whereHas('screening', function ($quer) use ($keyword) {  
                        $quer->where('application_status', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('remarks', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('status', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('badge_name', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('badge_name2', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('badge_name3', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('badge_name4', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('badge_name5', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('created_at', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('first_name', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('last_name', 'LIKE', '%'.$keyword.'%');
                    });                     
                });                 
            } else {
                $usersScreening = User::whereHas('screening');
            } 

            $usersScreening = $usersScreening->paginate(12);
            $usersVetting = $usersVetting->paginate(12);

            return view('admin::vetting', compact('usersVetting','usersScreening','keyword','badges'));
        } else {
            abort('401');
        }
    }


}
