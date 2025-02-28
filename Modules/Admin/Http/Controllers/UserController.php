<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\User;
use Modules\Nannies\Entities\Sitter;
use Modules\Parents\Entities\Guardian;
use Modules\Mentors\Entities\Mentor;
use Auth;
use Illuminate\Routing\Route;

use App\Notifications\AdminSuspended;
use App\Notifications\AdminBlocked;
use App\Notifications\AdminActivated;
use App\Notifications\AdminDeleted;

class UserController extends Controller
{
    public function show(){
        if (Auth::check() && Auth::user()->role == 'admin') { 
            $users = User::where('account_status', '!=','deleted')
                ->where('role', '=','sitter')
                ->orWhere('role', '=','parent')
                ->paginate(12);
            $mentors = User::where('account_status', '!=','deleted')
                ->where('role', '=','mentor')
                ->paginate(12);
            $showRefresh = 0;
            $showRefreshM = 0;
            $role = 'all';            
            return view('admin::users', compact('users','showRefresh','showRefreshM','role','mentors'));
        } else {
            abort('401');
        }
    }

    public function editUser(Request $request){
        
        if (Auth::check() && Auth::user()->role == 'admin') {
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email; 
            $user->save();  

            return response()->json($user);
        } else {
            abort('401');
        }
    }

    public function suspendUser(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $user = User::find($request->userId);
            $user->account_status = 'suspended';
            $user->account_type = 'free'; 

            if ($user->save()) {
                $recipient = new User();
                $recipient->name = $user->first_name . ' ' . $user->last_name; 
                $recipient->email = $user->email;   // This is the email you want to send to.
                $recipient->notify(new AdminSuspended()); 
            }             

            Session::flash('response', 'User account suspended!');
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }

    public function blockUser(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $user = User::find($request->userId);
            $user->account_status = 'blocked';
            $user->account_type = 'free';

            if ($user->save()) {
                $recipient = new User();
                $recipient->name = $user->first_name . ' ' . $user->last_name; 
                $recipient->email = $user->email;   // This is the email you want to send to.
                $recipient->notify(new AdminBlocked()); 
            }  

            Session::flash('response', 'User account blocked!');
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }

    public function activateUser(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {

            $user = User::find($request->userId);

            if (empty($user)) {
                User::withTrashed()
                    ->where('id', $request->userId)
                    ->restore();

                $user = User::find($request->userId);
            }

            $user->account_status = 'activated';
            if ($user->save()) {
                $recipient = new User();
                $recipient->name = $user->first_name . ' ' . $user->last_name; 
                $recipient->email = $user->email;   // This is the email you want to send to.
                $recipient->notify(new AdminActivated()); 
            }  
            
            Session::flash('response', 'User account activated!');
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }

    public function deleteUser(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $user = User::find($request->userId);
            $user->account_status = 'deleted';
            if ($user->save()) {
                $recipient = new User();
                $recipient->name = $user->first_name . ' ' . $user->last_name; 
                $recipient->email = $user->email;   // This is the email you want to send to.
                $recipient->notify(new AdminDeleted()); 
            }  
            $user->forceDelete(); 

            Session::flash('response', 'User deleted!');
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }

    public function searchUser(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $fname = $request->input('user-fname');
            $lname = $request->input('user-lname');
            $email = $request->input('user-email');
            $location = $request->input('user-location');
            $status = $request->input('user-status');
            $accountType = $request->input('user-account-type');
            $role = $request->input('user-role');
            $showRefresh = 1;
            $showRefreshM = 0;

            if ($role != 'all') {

                $users = User::where('role', '=', $role);

            } else {
                $roles = ['parent','sitter'];
                $users = User::whereIn('role', $roles);
               
            }

            if ($request->has('user-fname')) {
                $users->where('first_name', 'LIKE', '%'.$fname.'%');
            }

            if ($request->has('user-lname')) {
                $users->where('last_name', 'LIKE', '%'.$lname.'%');
            }

            if ($request->has('user-email')) {
                $users->where('email', 'LIKE', '%'.$email.'%');
            }

            if ($accountType != 'any') {
                $users->where('account_type', '=', $accountType);
            } 

            if ($status != 'any') {
                $users->where('account_status', '=', $status);
            }

            if ($location) {
                $users->where(function ($query) use ($request) {
                    $query->whereHas('guardianProfile', function ($query) use ($request) {
                        $query->where('city', 'LIKE', '%'.$request->input('user-location').'%')
                            ->orWhere('zip_code', '=', '%'.$request->input('user-location').'%');
                    });
                    $query->orWhereHas('sitterProfile', function ($query) use ($request) {
                        $query->where('city', 'LIKE', '%'.$request->input('user-location').'%')
                            ->orWhere('zip_code', '=', '%'.$request->input('user-location').'%');
                    });
                }); 
            }

            $users = $users->paginate(12);

            $mentors = User::where('role', '=','mentor')->paginate(12);

            return view('admin::users', compact(
                'users',
                'fname',
                'lname',
                'email',
                'location',
                'status',
                'accountType',
                'role',
                'showRefresh',
                'showRefreshM',
                'mentors'
            ));
        } else {
            abort('401');
        }

    }

    public function searchMentor(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $fnameM = $request->input('mentor-fname');
            $lnameM = $request->input('mentor-lname');
            $emailM = $request->input('mentor-email');
            $locationM = $request->input('mentor-location');
            $statusM = $request->input('mentor-status');
            $showRefresh = 0;
            $showRefreshM = 1;

            $mentors = User::where('role', '=', 'mentor');

            if ($request->has('mentor-fname')) {
                $mentors->where('first_name', 'LIKE', '%'.$fnameM.'%');
            }

            if ($request->has('mentor-lname')) {
                $mentors->where('last_name', 'LIKE', '%'.$lnameM.'%');
            }

            if ($request->has('mentor-email')) {
                $mentors->where('email', 'LIKE', '%'.$emailM.'%');
            }

            if ($statusM != 'any') {
                $mentors->where('account_status', '=', $statusM);
            }

            if ($locationM) {
                $mentors->where(function ($query) use ($request) {
                    $query->whereHas('mentorProfile', function ($query) use ($request) {
                        $query->where('city', 'LIKE', '%'.$request->input('mentor-location').'%')
                            ->orWhere('zip_code', '=', '%'.$request->input('mentor-location').'%');
                    });
                }); 
            }

            $mentors = $mentors->paginate(12);

            $users = User::where('role', '=','sitter')
                ->orWhere('role', '=','parent')
                ->paginate(12);

            return view('admin::users', compact(
                'users',
                'fnameM',
                'lnameM',
                'emailM',
                'locationM',
                'statusM',
                'showRefresh',
                'showRefreshM',
                'mentors'
            ));
        } else {
            abort('401');
        }

    }

    public function updateUser(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $user = User::find($request->userId);
            $generalText = $request->input('general-text');

            if ($user->role == 'sitter') {
                $profile = Sitter::where('user_id',$request->userId);
            } elseif ($user->role == 'parent') {
                $profile = Guardian::where('user_id',$request->userId);
            } elseif ($user->role == 'mentor') {
                $profile = Mentor::where('user_id',$request->userId);
            }
            
            $profile->update(['general_text' => $generalText]); 

            Session::flash('response', 'User description updated!');
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }


    // reactivate from log in of account
    public function reactivateUser(Request $request)
    {
        if (Auth::check()) {
            $user = User::find(Auth::user()->id);
            $user->account_status = 'activated';
            $user->save(); 

            Session::flash('response', 'Your account is reactivated! Your profile will now appear on search page.');
            
            if (Auth::user()->role == 'parent') {
                return redirect('/parents/dashboard');
            } elseif (Auth::user()->role == 'sitter') {
                return redirect('/nannies/dashboard');
            } elseif (Auth::user()->role == 'mentor') {
                return redirect('/mentors/dashboard');
            }
        } else {
            abort('401');
        }
    }

}
