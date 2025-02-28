<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

use Auth;
use Session;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    // protected $redirectTo = '/';

    protected function redirectTo()
    {
        $role = Auth::user()->role;

        switch ($role) {
            case'sitter':
                if (isset($_COOKIE['profile']) && strpos($_COOKIE['profile'], 'parents')) {
                    $profile = $_COOKIE['profile'];                    
                    setcookie("profile", "", time() - 3600);
                    $this->redirectTo = $profile;
                } else {
                    $this->redirectTo = '/nannies';
                }                 
                break;

            case 'parent':
                if (isset($_COOKIE['profile']) && strpos($_COOKIE['profile'], 'nannies')) {
                    $profile = $_COOKIE['profile'];                    
                    setcookie("profile", "", time() - 3600);
                    $this->redirectTo = $profile;
                } else {
                    $this->redirectTo = '/parents'; 
                }                                
                break;

            case 'admin':
                $this->redirectTo = '/admin';                
                break;

            default:
                $this->redirectTo = '/?fr=verified'; 
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
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
