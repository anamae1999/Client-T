<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\User;
use App\Badge;
use Modules\Admin\Entities\Example;
use Modules\Admin\Entities\Setting;
use Modules\Admin\Entities\Revenue;
use Modules\Admin\Entities\Admin;
// support for file
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL; 
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Validator;

use Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $usersCount = User::all()
                ->where('account_status', '!=','deleted')
                ->where('account_type', '!=','admin')
                ->count();

            $nanniesCount = User::where('role','sitter')
                ->where('account_status', '!=','deleted')
                ->count();

            $parentsCount = User::where('role','parent')
                ->where('account_status', '!=','deleted')
                ->count();

            $mentorsCount = User::where('role','mentor')
                ->where('account_status', '!=','deleted')
                ->count();

            $premUsers = User::where('account_type','premium')
                ->where('account_status', '!=','deleted')
                ->count();

            $freeUsers = User::where('account_type','free')
                ->where('account_status', '!=','deleted')
                ->count();

            $premParents = User::where(['account_type' => 'premium','role' => 'parent'])
                ->where('account_status', '!=','deleted')
                ->count();

            $freeParents = User::where(['account_type' => 'free','role' => 'parent'])
                ->where('account_status', '!=','deleted')
                ->count();

            $premNannies = User::where(['account_type' => 'premium','role' => 'sitter'])
                ->where('account_status', '!=','deleted')
                ->count();

            $freeNannies = User::where(['account_type' => 'free','role' => 'sitter'])
                ->where('account_status', '!=','deleted')
                ->count(); 

            $currentYear = date('Y');

            $yearExist = Revenue::where('year','=',$currentYear)->exists();

            if (!$yearExist) {                

                $data = array(
                    array('year'=>$currentYear, 'role'=> 0),
                    array('year'=>$currentYear, 'role'=> 1),
                );

                Revenue::insert($data); // Eloquent approach
            }

            $revenues = Revenue::orderBy('year', 'asc')->get()->groupBy('year');
            
            $totalRevenue = Revenue::sum('revenue');

            return view('admin::admindashboard', compact(
                'usersCount',
                'nanniesCount',
                'parentsCount',
                'mentorsCount',
                'premUsers',
                'freeUsers',
                'premParents',
                'freeParents',
                'premNannies',
                'freeNannies',
                'revenues',
                'totalRevenue'
            ));
        } else {
            abort('401');
        }
    }

    // Account Settings Tab
    public function accountSettings()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
           
            $user = User::find(Auth::user()->id);
            $badges = Badge::all();
            $photoSamples = Example::orderBy('type')->get();

            return view('admin::accountsettings', compact('user','badges','photoSamples'));
        } else {
            abort('401');
        }
    }

    public function savehtml(request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $headhtml = $request->input('headhtml');
            $foothtml = $request->input('foothtml');

            $settings = Setting::find(1);
            $settings->headhtml = $headhtml;
            $settings->foothtml = $foothtml; 
            $settings->save(); 

            return redirect()->back();
        } else {
            abort('401');
        }
    }

    // account settings of admin
    public function updateAdmin(Request $request)
    { 
        if (Auth::check() && Auth::user()->role == 'admin') {

            if (request('password')) {
                $data = request()->validate([ 
                    'email' => 'unique:users',             
                    'password' => 'same:password_confirmation|string|min:8',
                    'password_confirmation' => 'same:password',
                    'profile-pic' => 'image',
                    'first_name' => 'regex:/^[a-zA-Z0-9\s]+$/',
                    'last_name' => 'regex:/^[a-zA-Z0-9\s]+$/',
                ]);
            } else {
                $data = request()->validate([ 
                    'email' => 'unique:users',  
                    'profile-pic' => 'image',
                    'first_name' => 'regex:/^[a-zA-Z0-9\s]+$/',
                    'last_name' => 'regex:/^[a-zA-Z0-9\s]+$/',
                ]);
            }
            

            $user = User::where('role','admin')->first();
            
            if (request('first_name')) {
               $user->first_name = request('first_name');
            }

            if (request('last_name')) {
                $user->last_name = request('last_name');
            }

            if (request('email')) {
                $user->email = request('email');
            }

            if (request('password')) {
                $user->password = bcrypt(request('password'));
            }
            
            $user->save();

            $id = Auth::user()->id;

            // admin picture upload
            $admin = Admin::where('user_id',$id)->first();
            $filenamePrepend = 'admin-' . sprintf("%06d", $user->id);
            if (Input::hasFile('profile-pic')) {
                $file = Input::file('profile-pic');         
                $fileName = str_replace(' ', '', $file->getClientOriginalName());   
                $file->move(public_path() . '/uploads/', $filenamePrepend . '-' . $fileName);
                $url = URL::to("/"). '/uploads/'. $filenamePrepend . '-' . $fileName;
                $admin->admin_pic = $url;
            }    

            $admin->save();

            Session::flash('response', 'Account details updated successfully!'); 

            return Redirect::to(URL::previous() . "#account-settings");
        } else {
            abort('401');
        }
    }

    // account settings of prices
    public function updatePrice(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $settings = Setting::find(1);

            $sitter1mo = $request->input('sitter-price-1mo');
            $sitter3mo = $request->input('sitter-price-3mo');
            $parent1mo = $request->input('parent-price-1mo');
            $parent3mo = $request->input('parent-price-3mo');

            if ($sitter1mo) {
                $settings->sitter_1mo = $sitter1mo;
                $respText = 'sitter 1 month';
            };

            if ($sitter3mo) {
                $settings->sitter_3mo = $sitter3mo;
                $respText = 'sitter 3 months';
            };

            if ($parent1mo) {
                $settings->parent_1mo = $parent1mo;
                $respText = 'parent 1 month';
            };

            if ($parent3mo) {
                $settings->parent_3mo = $parent3mo;
                $respText = 'parent 3 months';
            };

            $settings->save();

            Session::flash('response', 'Amount for '.$respText.' changed successfully!'); 

            return Redirect::to(URL::previous() . "#price-settings");
        } else {
            abort('401');
        }

    }

    // update payment notice
    public function updateNotice(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $settings = Setting::find(1);
            $paymentNotice = $request->input('payment-notice');
            $settings->payment_notice = $paymentNotice;

            $settings->save();

            Session::flash('response', 'Payment text updated successfully!'); 

            return redirect()->back();
        } else {
            abort('401');
        }
    }

    // toggle vetting
    public function toggleVetting(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $toggleVetting = $request->input('vetting-toggle');

            $settings = Setting::find(1);

            if ($toggleVetting) {
               $settings->vetting = 1;
               $toggleText = 'on';
            } else {
               $settings->vetting = 0; 
               $toggleText = 'off';
            }

            $settings->save();

            Session::flash('response', 'Vetting feature turned ' . $toggleText . '!'); 

            return Redirect::to(URL::previous() . "#vetting-settings");
        } else {
            abort('401');
        }
    }

    // toggle vetting
    public function toggleCookie(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $toggleCookie = $request->input('cookie-toggle');

            $settings = Setting::find(1);

            if ($toggleCookie) {
               $settings->cookie = 1;
               $toggleText = 'on';
            } else {
               $settings->cookie = 0; 
               $toggleText = 'off';
            }

            $settings->save();

            Session::flash('response', 'Cookie notification turned ' . $toggleText . '!'); 

            return Redirect::to(URL::previous() . "#cookie-settings");
        } else {
            abort('401');
        }
    }

    // Social media
    public function updateSocial(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $facebook = $request->input('facebook');
            $twitter = $request->input('twitter');
            $instagram = $request->input('instagram');
            $linkedin = $request->input('linkedin');
            $whatsapp = $request->input('whatsapp');

            $settings = Setting::find(1);
            $settings->facebook = $facebook;
            $settings->twitter = $twitter;
            $settings->instagram = $instagram;
            $settings->linkedin = $linkedin;
            $settings->whatsapp = $whatsapp;

            $settings->save();

            Session::flash('response', 'Social media links updated!'); 

            return Redirect::to(URL::previous() . "#social-links");
        } else {
            abort('401');
        }
    }

    public function updateFooter(Request $request) 
    {
        if (Auth::check() && Auth::user()->role == 'admin') {

            $heading = $request->input('foot_heading');
            $content = $request->input('foot_content');
            $email = $request->input('foot_email');
            $commerce = $request->input('foot_commerce');
            $copyright = $request->input('foot_copyright');
            $contactNum = $request->input('foot_contact_number');

            $settings = Setting::find(1);
            $settings->foot_heading = $heading;
            $settings->foot_content = $content;
            $settings->foot_email = $email;
            $settings->foot_commerce = $commerce;
            $settings->foot_copyright = $copyright;
            $settings->contact_number = $contactNum;

            $settings->save();

            Session::flash('response', 'Footer text updated!'); 

            return Redirect::to(URL::previous() . "#footer-text");

        } else {
            abort('401');
        }
    }

    public function updateTooltip(Request $request) 
    {
        if (Auth::check() && Auth::user()->role == 'admin') {

            $payTip = $request->input('payment_tooltip');
            $dashTip = $request->input('dashboard_tooltip');
            $jdTip = $request->input('jd_tooltip');
            $lfTip = $request->input('lf_tooltip');
            $mtTip = $request->input('mt_tooltip');

            $settings = Setting::find(1);
            $settings->payment_tooltip = $payTip;
            $settings->dashboard_tooltip = $dashTip;
            $settings->job_description_tooltip = $jdTip;
            $settings->looking_for_tooltip = $lfTip;
            $settings->mentor_tooltip = $mtTip;

            $settings->save();

            Session::flash('response', 'Tooltip text updated!'); 

            return Redirect::to(URL::previous() . "#tooltip-text");

        } else {
            abort('401');
        }
    }

    public function addBadge(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {

            $data = request()->validate([
                'badge-name' => 'required',
                'badge-image' => 'required|image',
            ]);

            $badge = new Badge;
            $badge->badge_name    = $request->input('badge-name');

             // badge picture upload
            $filenamePrepend = $request->input('badge-name');
            if (Input::hasFile('badge-image')) {
                $file = Input::file('badge-image');     
                $fileName = str_replace(' ', '', $file->getClientOriginalName());       
                $file->move(public_path() . '/uploads/', $filenamePrepend . '-' . $fileName);
                $url = URL::to("/"). '/uploads/'. $filenamePrepend . '-' . $fileName;
                $badge->badge_pic  = $url;
            }        

            $badge->save();

            Session::flash('response', 'Badge item added successfully!');

            return Redirect::to(URL::previous() . "#badges");
        } else {
            abort('401');
        }
    }

    public function destroyBadge(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $id = $request->input('badgeId');
            $badge = Badge::find($id);
            $badge->delete();

            Session::flash('response', 'Badge item deleted successfully!');
            
            return redirect()->back();
        } else {
            abort('401');
        }

    }

    public function updateProfileExampleText(Request $request) 
    {
        if (Auth::check() && Auth::user()->role == 'admin') {

            $settings = Setting::find(1);
            $settings->nanny_photo_example_heading = $request->input('nanny_photo_example_heading');
            $settings->nanny_photo_example_top_text = $request->input('nanny_photo_example_top_text');
            $settings->nanny_photo_example_bottom_text = $request->input('nanny_photo_example_bottom_text');
            $settings->parent_photo_example_heading = $request->input('parent_photo_example_heading');
            $settings->parent_photo_example_top_text = $request->input('parent_photo_example_top_text');
            $settings->parent_photo_example_bottom_text = $request->input('parent_photo_example_bottom_text');
            $settings->mentor_photo_example_heading = $request->input('mentor_photo_example_heading');
            $settings->mentor_photo_example_top_text = $request->input('mentor_photo_example_top_text');
            $settings->mentor_photo_example_bottom_text = $request->input('mentor_photo_example_bottom_text');

            $settings->save();

            Session::flash('response', 'Profile photo example text updated!'); 

            return Redirect::to(URL::previous() . "#profile-photo-example-text");

        } else {
            abort('401');
        }
    }

    public function addExamplePhoto(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {

            $data = request()->validate([
                'sample-photo-image' => 'required|image',
            ]);

            $samplePhoto = new Example;
            $samplePhoto->type = $request->input('photo-type');
             // badge picture upload

            $filenamePrepend = $request->input('sample-photo-image');
            if (Input::hasFile('sample-photo-image')) {
                $file = Input::file('sample-photo-image');   
                $fileName = str_replace(' ', '', $file->getClientOriginalName());         
                $file->move(public_path() . '/uploads/', $filenamePrepend . '-' . $fileName);
                $url = URL::to("/"). '/uploads/'. $filenamePrepend . '-' . $fileName;
                $samplePhoto->photo_example_pic = $url;
            }        

            $samplePhoto->save();

            Session::flash('response', 'Example profile photo item added successfully!');

            return Redirect::to(URL::previous() . "#profile-photo-example-images");
        } else {
            abort('401');
        }
    }

    public function destroyPhotoExample(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $id = $request->input('photoSampleId');
            $photoExample = Example::find($id);
            $photoExample->delete();

            Session::flash('response', 'Example profile photo item deleted successfully!');
            
            return Redirect::to(URL::previous() . "#profile-photo-example-images");
        } else {
            abort('401');
        }

    }
}
