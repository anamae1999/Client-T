<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Cache\RateLimiter;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use Illuminate\Routing\Route;

use Auth;
use Session;
use View;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $decayMinutes = 1440; // Default is 1

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        if($seconds<60){
          $lockout_time = $seconds.' seconds';
        }else{
          $lockout_time = $this->secondsToTime($seconds);
        }

        throw ValidationException::withMessages([
            $this->username() => [Lang::get('auth.throttle', ['lockout_time' => $lockout_time])],
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    }


    public function secondsToTime($seconds) {
      $dtF = new \DateTime('@0');
      $dtT = new \DateTime("@$seconds");
      return $dtF->diff($dtT)->format('%h hours, %i minutes and %s seconds');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';

    protected function redirectTo()
    {
        $role = Auth::user()->role;
        $account_status = Auth::user()->account_status;

        if ($account_status == 'activated' || $account_status == 'admin') {

            switch ($role) {
                case 'sitter':   

                    if (isset($_COOKIE['profile']) && strpos($_COOKIE['profile'], 'parents')) {
                        $profile = $_COOKIE['profile'];                    
                        setcookie("profile", "", time() - 3600);
                        $this->redirectTo = $profile;
                    } else {
                        $this->redirectTo = '/search/parents';
                    }   
                    break;

                case 'parent':
                    if (isset($_COOKIE['profile']) && strpos($_COOKIE['profile'], 'nannies')) {
                        $profile = $_COOKIE['profile'];                    
                        setcookie("profile", "", time() - 3600);
                        $this->redirectTo = $profile;
                    } else {
                        $this->redirectTo = '/search/nannies';  
                    }                                   
                    break;

                case 'mentor':
                    
                    $this->redirectTo = '/mentors/dashboard';  
                                                     
                    break;

                case 'admin':
                    $this->redirectTo = '/admin';                
                    break;
            }

            return $this->redirectTo;

        } elseif ($account_status == 'blocked') { 
            Session::flash('unauthorized', 'The account has been blocked. Please contact TinySteps.');           
            Auth::logout();
        } elseif ($account_status == 'suspended') {
            Session::flash('unauthorized', 'The account has been suspended. Please contact TinySteps.');
            Auth::logout();
        } elseif ($account_status == 'deactivated') {
            return route('reactivate');
        }
        
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout','getRegister');
    }

}
