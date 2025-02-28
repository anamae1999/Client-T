<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Schedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Modules\Nannies\Entities\Sitter;
use Modules\Parents\Entities\Guardian;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    protected function redirectTo()
    {
        $role = Auth::user()->role;

        switch ($role) {
            case 'sitter':
                $this->redirectTo = '/nannies';
                break;

            case 'parent':
                $this->redirectTo = '/parents';                
                break;            
        }

        return $this->redirectTo;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if ($data['role'] == 'sitter') {
            if(!empty($data['dob-month']) && !empty($data['dob-day']) && !empty($data['dob-year'])){
                $dobMonth = $data['dob-month'];
                $dobDay = $data['dob-day'];
                $dobYear = $data['dob-year'];


                //get age from date or birthdate
                $age = (date("md", date("U", mktime(0, 0, 0, $dobMonth, $dobDay, $dobYear))) > date("md")
                    ? ((date("Y") - $dobYear) - 1)
                    : (date("Y") - $dobYear));

                $data['age'] = $age;

            }

            return Validator::make($data, [
                'first-name' => ['required', 'string', 'max:255'],
                'last-name' => ['required', 'string', 'max:255'],
                'role' => ['required'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'g-recaptcha-response' => 'required|recaptcha',
                'age' => ['numeric','gte:18'],
                'dob-month' => 'required',
                'dob-day' => 'required',
                'dob-year' => 'required',
            ]);
        } else {
            return Validator::make($data, [
                'first-name' => ['required', 'string', 'max:255'],
                'last-name' => ['required', 'string', 'max:255'],
                'role' => ['required'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'g-recaptcha-response' => 'required|recaptcha',
            ]);
        }   
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'first_name' => $data['first-name'],
            'last_name' => $data['last-name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'account_status' => 'activated',
            'account_type' => 'free',
            'password' => Hash::make($data['password']),
        ]);

        Schedule::create([
            'user_id' => $user->id,
        ]);

        if ($data['role'] == 'sitter') {
            $dobMonth = $data['dob-month'];
            $dobDay = $data['dob-day'];
            $dobYear = $data['dob-year'];
            $birthdate = $dobMonth . '/' . $dobDay . '/' . $dobYear;
            Sitter::create([
                'user_id' => $user->id,
                'date_of_birth' =>  $birthdate,
            ]);
        }

        if ($data['role'] == 'parent') {
            Guardian::create([
                'user_id' => $user->id,
            ]);
        }

        return $user;
    }
}
