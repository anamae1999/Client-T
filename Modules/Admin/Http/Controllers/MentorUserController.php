<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Mentors\Entities\Mentor;
use App\User;
use Auth;

use Carbon;
use Session;

use App\Notifications\MentorAccountCreated;

class MentorUserController extends Controller
{
    public function index()
    {
        return view('admin::index');
    }

    public function create(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') { 

            $data = request()->validate([           
                'first-name' => ['required', 'string', 'max:255'],
                'last-name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],   
            ]); 

            $user = new User;
            $user->email = $request->input('email');
            $user->first_name = $request->input('first-name');
            $user->last_name = $request->input('last-name');
            $user->password = bcrypt($request->input('password'));
            $user->role = 'mentor';
            $user->email_verified_at = now();
            $user->account_status = 'activated';
            $user->account_type = 'free';

            if ($user->save()) {
                Mentor::create([
                    'user_id' => $user->id,
                ]);
                Session::flash('response', 'Mentor added successfully!');

                $recipient = new User();
                $recipient->first_name = $user->first_name; 
                $recipient->email = $user->email;   // This is the email you want to send to.
                $recipient->password = $request->input('password');   
                $recipient->notify(new MentorAccountCreated());
            } 

            return redirect()->back();

        } else {
            abort('401');
        }
    }

    public function show($id)
    {
        return view('admin::show');
    }

    public function edit($id)
    {
        return view('admin::edit');
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        //
    }
}
