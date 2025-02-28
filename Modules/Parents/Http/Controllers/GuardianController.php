<?php

namespace Modules\Parents\Http\Controllers;

use Notification;
use App\Notifications\GoodbyeCustomer;
use App\Notifications\AccountDeactivated;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

// support for file
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

// models
use Modules\Parents\Entities\Guardian;
use Modules\Admin\Entities\Example;
use App\User;
use App\IdealSubscription;
use App\Schedule;
use App\Contact;
use Auth;
use Session;
use DB;
use Carbon;
use DateTime;

// guzzle
use GuzzleHttp;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

use Intervention\Image\Facades\Image as Image;

use Stripe\Stripe;

class GuardianController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    
    public function getSchedColumns($table)
    {
        return DB::getSchemaBuilder()->getColumnListing($table);
    }

    public function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return round(($miles * 1.609344), 1);
        } else if ($unit == "N") {
            return round(($miles * 0.8684), 1);
        } else {
            return round($miles, 1);
        }
    }
    
    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) //show parent profile page
    {
        if (Auth::check() && Auth::user()->role != 'parent' || Auth::user()->id == $id){
            $guardian = Guardian::where('user_id', $id)->first(); 

            $exists = Contact::where('owner_id','=',Auth::user()->id)
            ->where('contact_id','=',$id)->exists();

            if ($exists) {
                $userIsMyContact = true;
            }    

            // retrive values if not null else return empty values

            if (!is_null($guardian->languages)) {
                $languages = explode(", ", $guardian->languages);
            } else {
                $languages = [];
            }

            if (!is_null($guardian->stages_experience)) {
                $stagesExperience = explode(", ", $guardian->stages_experience);
            } else {
                $stagesExperience = [];
            }

            if (!is_null($guardian->activities)) {
                $activities = explode(", ", $guardian->activities);
            } else {
                $activities = [];
            }

            if (!is_null($guardian->additional_services)) {
                $additionalServices = explode(", ", $guardian->additional_services);
            } else {
                $additionalServices = [];
            }

            if (!is_null($guardian->gender_of_children)) {
                $genders = explode(", ", $guardian->gender_of_children);
            } else {
                $genders = [];
            } 

            if (!is_null($guardian->age_of_children)) {
                $ages = explode(", ", $guardian->age_of_children);
            } else {
                $ages = [];
            } 

            $genderAges = [$genders,$ages];

            // dd($genderAges[0]);

            // schedules
            $scheds = Schedule::where('user_id', $id)->first(); 

            // pull all column names from db table
            $schedColumns = self::getSchedColumns('schedules');

            $googleKey = config('services.google.key');

            $distance = self::distance(Auth::user()->lat, Auth::user()->lng, $guardian->user->lat, $guardian->user->lng, 'K');

            return view('parents::parentprofile', compact(
                'guardian',
                'languages',
                'stagesExperience',
                'activities',
                'additionalServices',
                'scheds',
                'schedColumns',
                'genderAges',
                'googleKey',
                'userIsMyContact',
                'distance'
            ));
        } else {
            abort('401');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function dashboard()
    {
        if (Auth::check() && Auth::user()->role == 'parent') {
            $guardian = Guardian::where('user_id', Auth::user()->id)->first();  
            $examplePhotos = Example::where('type',2)->get();  

            // retrive vaot null else return empty values

            if (!is_null($guardian->languages)) {
                $languages = explode(", ", $guardian->languages);
            } else {
                $languages = [];
            }

            if (!is_null($guardian->stages_experience)) {
                $stagesExperience = explode(", ", $guardian->stages_experience);
            } else {
                $stagesExperience = [];
            }

            if (!is_null($guardian->activities)) {
                $activities = explode(", ", $guardian->activities);
            } else {
                $activities = [];
            }

            if (!is_null($guardian->additional_services)) {
                $additionalServices = explode(", ", $guardian->additional_services);
            } else {
                $additionalServices = [];
            } 

            if (!is_null($guardian->gender_of_children)) {
                $genders = explode(", ", $guardian->gender_of_children);
            } else {
                $genders = [];
            } 

            if (!is_null($guardian->age_of_children)) {
                $ages = explode(", ", $guardian->age_of_children);
            } else {
                $ages = [];
            } 

            if (!is_null($guardian->begin_date)) {

                $beginDate = explode("/", $guardian->begin_date);

            } else {
                $beginDate = [];
            }

            // values for languages
            $langDropdown = [
                'Dutch','German','French','Italian','English','Arabic','Bulgarian','Chinese',
                'Croatian','Czech','Danish','Estonian','Filipino','Finnish','Greek','Hindi',
                'Hungarian','Indonesian','Irish','Latvian','Lithuanian','Maltese','Persian','Polish',
                'Portuguese','Romanian','Russian','Slovak','Slovenian','Spanish','Swedish','Turskish'];

            // values for other languages
            $langCheckbox = [
                'Dutch','English','German','French','Italian','Spanish'];

            // values for Additional Services
            $servCheckbox = [
                'Child-related chores','Cooking for the family','Light house chores'];

            // values for Activities
            $actCheckbox = [
                'Sensory Play','Messy Play','Dancing','Music','Magic Art','Art & Craft','Cooking & Baking','Drama & Creative Expression','Sports','Nature Play','Yoga for Kids','Homework Tutorial'];

            // values for Stages
            $stgsCheckbox = [
                '0 - 1 year old | Baby','1 - 4 year old | Toddler','4 - 6 year old | Preschooler','6 - 12 year old | Gradeschooler','12 - 16 year old | Teenager'];

            // values of job description dropdown
            $jdDropdown = ['Permanent Nanny', 'Occasional Sitter', 'Afterschool Sitter','Night Sitter'];

            // schedules
            $scheds = Schedule::where('user_id', Auth::user()->id)->first(); 

            // pull all column names from db table
            $schedColumns = self::getSchedColumns('schedules');

            return view('parents::parentdashboard', compact(
                'guardian',
                'languages',
                'stagesExperience',
                'activities',
                'additionalServices',
                'genders',
                'ages',
                'langDropdown',            
                'jdDropdown',                
                'scheds',
                'schedColumns',
                'beginDate',
                'langCheckbox',
                'servCheckbox',
                'actCheckbox',
                'stgsCheckbox',
                'examplePhotos'

            ));
        } else {
            abort('401');
        }
    }

    public function settings()
    {
        if (Auth::check() && Auth::user()->role == 'parent') {
            $user = Auth::user();  
            $stripePK = config('services.stripe.key');

            if ($user->account_type == 'free') {
                $intent = $user->createSetupIntent();    
                $via = '';            
            } else {

                if ($user->sepa_source_id) {
                    Stripe::setApiKey(config('services.stripe.secret'));

                    $stripeSource = \Stripe\Source::retrieve([
                        'id' => $user->sepa_source_id
                    ]);

                }

                if ($user->subscribed('Parents Premium Plans')) {  
                    $via = 'card';       
                    $planType = $user->subscription('Parents Premium Plans')->stripe_plan;

                    if ($planType == 'tspp-monthly') {
                        $plan = 'Monthly';
                    }

                    if ($planType == 'tspp-3months') {
                        $plan = '3 Months';
                    }
                    $pastDue = false;
                } else {
                    $via = 'ideal';
                    if ($user->idealSubscription->name == 'Parent 3mos Premium Membership') {
                        $plan = '3 Months';
                    }

                    if ($user->idealSubscription->name == 'Parent 1mo Premium Membership') {
                        $plan = 'Monthly';
                    }  

                    $subsEnd = $user->idealSubscription->ends_at;
 
                    if ( $subsEnd <= now() ) {
                        $pastDue = true;                    
                    } else {
                        $pastDue = false;
                    }  
                }

            }    
            return view('parents::accountsettings', compact(
                'user',
                'stripePK',
                'intent',
                'plan',
                'via',
                'pastDue',
                'stripeSource'
            ));
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
    public function update(Request $request, MessageBag $message_bag)
    {
        if (Auth::check() && Auth::user()->role == 'parent') {
            $id = Auth::user()->id;

            // identify the guardian
            $guardian = Guardian::where('user_id',$id)->first();  

            $cropPos = $request->input('crop_pos');

            // if has profile picture input, save pic even if failed update profile so that user does not need to select again
            $filenamePrepend = sprintf("%06d", $id);
            if (Input::hasFile('profile-pic')) {

                $validator = Validator::make($request->all(), [
                    'profile-pic' => 'image',
                ]);

                if ($validator->fails()) {
                    $data = request()->validate([
                        'first-name' => 'required|regex:/^[a-zA-Z0-9-\s]+$/',
                        'last-name' => 'required|regex:/^[a-zA-Z0-9-\s]+$/',
                        'house-number' => 'required',
                        'street-name' => 'required',
                        'city' => 'required',
                        'zip-code' => 'required',
                        'job-description' => 'required',
                        'bd-month' => 'required',
                        'bd-day' => 'required',
                        'bd-year' => 'required',
                        'general-text' => 'required',
                        'profile-pic' => 'image',
                    ]);
                } else { 

                    $file = Input::file('profile-pic'); 

                    $extension = $file->getClientOriginalExtension();

                    $fileName = str_replace(' ', '', $file->getClientOriginalName());

                    // move the file to uploads folder
                    $file->move(public_path() . '/uploads/', $filenamePrepend . '-' . $fileName);

                    $mimes = ['jpeg','jpg','png','gif','svg'];
                    if (in_array(strtolower($extension), $mimes)) {
                        // resize image from the uploads folder then resave as 300x300
                        $image = Image::make(public_path() . '/uploads/' . $filenamePrepend . '-' . $fileName)->fit(300,300,function ($contraint) {}, $cropPos);
                        $image->save();
                    } else {
                        $message_bag->add('profile-pic', 'Invalid file type. Only jpeg, png, jpg, gif or svg is allowed.');
                        // dd($message_bag);
                        return redirect()->back()->withErrors($message_bag);
                    }                

                    $url = URL::to("/"). '/uploads/'. $filenamePrepend . '-' . $fileName;       
                    $guardian->profile_pic = $url;
                    $guardian->update();
                }
                
            } //end if has profile picture input     


            // if picture was already uploaded run validation set without profile pic
            if ($guardian->profile_pic) {                
                $data = request()->validate([
                    'first-name' => 'required|regex:/^[a-zA-Z0-9-\s]+$/',
                    'last-name' => 'required|regex:/^[a-zA-Z0-9-\s]+$/',
                    'house-number' => 'required',
                    'street-name' => 'required',
                    'city' => 'required',
                    'zip-code' => 'required',
                    'job-description' => 'required',
                    'bd-month' => 'required',
                    'bd-day' => 'required',
                    'bd-year' => 'required',
                    'general-text' => 'required',
                ]);
            } else {
                $data = request()->validate([
                    'first-name' => 'required|regex:/^[a-zA-Z0-9-\s]+$/',
                    'last-name' => 'required|regex:/^[a-zA-Z0-9-\s]+$/',
                    'house-number' => 'required',
                    'street-name' => 'required',
                    'city' => 'required',
                    'zip-code' => 'required',
                    'job-description' => 'required',
                    'bd-month' => 'required',
                    'bd-day' => 'required',
                    'bd-year' => 'required',
                    'general-text' => 'required',
                    'profile-pic' => 'required',
                ]);
            }

            // guradians table entries                 
            $guardian->house_number = $request->input('house-number');
            $guardian->street = $request->input('street-name');
            $guardian->city = $request->input('city');
            $guardian->zip_code = $request->input('zip-code');
            $guardian->num_of_children = $request->input('num-of-children');

            

            $guardian->job_description = $request->input('job-description');  
            $guardian->hourly_rate = $request->input('avg-hourly');
            $guardian->mother_tongue = $request->input('mother-tongue');
            $guardian->general_text = $request->input('general-text');

            $bdMonth = $request->input('bd-month');
            $bdDay = $request->input('bd-day');
            $bdYear = $request->input('bd-year');

            $guardian->begin_date = $bdMonth . '/' . $bdDay . '/' . $bdYear;

            // checkboxes
            $languages = $request->input('languages');
            $stagesExperience = $request->input('stages-experience');
            $activities = $request->input('kids-activities');
            $qualifications = $request->input('qualifications');
            $additionalServices = $request->input('additional-services');
            $genders = $request->input('gender-of-children');
            $ages = $request->input('age-of-children');
            $maxAge = max($ages);
            $minAge = min($ages);

            if (!is_null($languages)) {
                if (end($languages) == null) {
                    $guardian->languages = substr(implode(", ", $languages), 0, -9);
                    if ($guardian->languages == false){
                        $guardian->languages = null;
                    }
                } else {
                    $guardian->languages = implode(", ", $languages);
                }                
            } else {
                $guardian->languages = $languages;
            }

            if (!is_null($stagesExperience)) {
                if (end($stagesExperience) == null) {
                    $guardian->stages_experience = substr(implode(", ", $stagesExperience), 0, -9);
                    if ($guardian->stages_experience == false){
                        $guardian->stages_experience = null;
                    }
                } else {
                    $guardian->stages_experience = implode(", ", $stagesExperience);
                }
            } else {
                $guardian->stages_experience = $stagesExperience;
            }

            if (!is_null($activities)) {
                if (end($activities) == null) {
                    $guardian->activities = substr(implode(", ", $activities), 0, -9);
                    if ($guardian->activities == false){
                        $guardian->activities = null;
                    }
                } else {
                    $guardian->activities = implode(", ", $activities);
                }               
            } else {
                $guardian->activities = $activities;
            }  

            if (!is_null($additionalServices)) {   
                if (end($additionalServices) == null) {
                    $guardian->additional_services = substr(implode(", ", $additionalServices), 0, -9);
                    if ($guardian->additional_services == false){
                        $guardian->additional_services = null;
                    }
                } else {
                    $guardian->additional_services = implode(", ", $additionalServices);
                }
            } else {
                $guardian->additional_services = $additionalServices;
            }   

            if (!is_null($genders)) {
                $guardian->gender_of_children = implode(", ", $genders);
            }

            if (!is_null($ages)) {
                $guardian->age_of_children = implode(", ", $ages);
                $guardian->eldest_child = $maxAge;
                $guardian->youngest_child = $minAge;
            }

            $guardian->update();

            // schedule table entries
            $sched = Schedule::where('user_id',$id)->first();;

            // pull all column names from db table
            $schedColumns = self::getSchedColumns('schedules');

            // assign values from request with same name from column
            foreach ($schedColumns as $schedColumn) {

                if (($schedColumn != 'id') && ($schedColumn != 'user_id') && ($schedColumn != 'created_at') && ($schedColumn != 'updated_at')) {
                    if ($request->input($schedColumn)) {
                        $sched->$schedColumn = 1;
                    } else {
                        $sched->$schedColumn = 0;
                    }             
                }
            }

            $sched->update();
            
            // User table entries
            $user = User::find($id);
            $user->first_name = $request->input('first-name');
            $user->last_name = $request->input('last-name');

            $address = $guardian->house_number . ', ' . $guardian->street . ', ' . $guardian->zip_code;

            //Converts address into Lat and Lng
            $apiKey = config('services.google.server_key');
            $client = new Client(); //GuzzleHttp\Client
            $result =(string) $client->post("https://maps.googleapis.com/maps/api/geocode/json?components=country:NL|locality:".$guardian->city."&address=".$address.'&key='. $apiKey)->getBody();

            $json = json_decode($result);


            if ($json->status != 'ZERO_RESULTS') {
                $user->lat = $json->results[0]->geometry->location->lat;
                $user->lng = $json->results[0]->geometry->location->lng;
            } else {
                $user->lat = null;
                $user->lng = null;
            }
            
            $user->save();

            Session::flash('response', 'Profile updated successfully!');

            return redirect()->back();
        } else {
            abort('401');
        }
    }

    // account settings of parents
    public function updateSettings(Request $request)
    { 
        if (Auth::check() && Auth::user()->role == 'parent') {
            $id = Auth::user()->id;

            if (request('password')) {
                $data = request()->validate([
                    'email' => 'unique:users',
                    'password' => 'same:password_confirmation|string|min:8',
                    'password_confirmation' => 'same:password'
                ]);
            } else {
                $data = request()->validate([
                    'email' => 'unique:users'
                ]);
            }

            $user = User::find($id);
            if (request('email')) {
                $user->email = request('email');
            }

            if (request('password')) {
                $user->password = bcrypt(request('password'));
            }

            if ($user->save()) {

                if (request('email')) {
                    Stripe::setApiKey(config('services.stripe.secret'));

                    if ($user->subscribed('Parents Premium Plans')) {
                        
                        $customer = \Stripe\Customer::update(
                            $user->stripe_id,
                                [
                                    'email' => request('email')
                                ]
                        );

                    } else if ($user->sepa_source_id) {                        

                        $stripeSource = \Stripe\Source::retrieve([
                            'id' => $user->sepa_source_id
                        ]);

                        $sepaSource = \Stripe\Source::update(
                          $user->sepa_source_id,
                          ['owner' => ['email' => request('email')]]
                        );

                        $customer = \Stripe\Customer::update(
                            $stripeSource->customer,
                                [
                                    'email' => request('email')
                                ]
                        );

                    }                    
                }
                
            }

            Session::flash('response', 'Account settings updated successfully!');

            return redirect()->back();
        } else {
            abort('401');
        }
    }

    public function deleteAccount(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'parent') {
            $user = User::find($request->userId);

            if ($user->subscribed('Parents Premium Plans')) {         
                if ($user->subscription('Parents Premium Plans')->cancelNow()) {
                    $user->update(['account_type' => 'free']);
                } 
            } else {
                if ($user->account_type == 'premium') {
                    $user->account_type = 'free';
                    $user->ideal_source_id = null;
                    $user->ideal_charge_id = null;
                    $user->sepa_source_id = null;
                    $subscription = IdealSubscription::where('user_id',$user->id)->first();

                    if ($user->update()) {
                        $subscription->delete();
                    }
                }                
            } 

            $user->account_status = 'deleted';
            if ($user->save()) {
                $recipient = new User();
                $recipient->name = $user->first_name . ' ' . $user->last_name; 
                $recipient->email = $user->email;   // This is the email you want to send to.
                $recipient->notify(new GoodbyeCustomer());  
            } 
            $user->forceDelete();
            
            return redirect('/');
        } else {
            abort('401');
        }
    }


    public function deactivateAccount(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'parent') {
            $user = User::find($request->userId);

            if ($user->subscribed('Parents Premium Plans')) {         
                if ($user->subscription('Parents Premium Plans')->cancelNow()) {
                    $user->update(['account_type' => 'free']);
                } 
            } else {
                if ($user->account_type == 'premium') {
                    $user->account_type = 'free';
                    $user->ideal_source_id = null;
                    $user->ideal_charge_id = null;
                    $user->sepa_source_id = null;
                    $subscription = IdealSubscription::where('user_id',$user->id)->first();

                    if ($user->update()) {
                        $subscription->delete();
                    }
                }                
            } 

            $user->account_status = 'deactivated';
            
            if ($user->save()) {
                $recipient = new User();
                $recipient->name = $user->first_name; 
                $recipient->email = $user->email;   // This is the email you want to send to.
                $recipient->notify(new AccountDeactivated());  
            }

            Session::flash('deactivated', 'Account deactivated!');
   
            return redirect('/')->with(Auth::logout());
        } else {
            abort('401');
        }
    }

    public function messages()
    {
        if (Auth::user()->role == 'parent') {
            return view('parents::messages');
        } else {
            abort('401');
        }
    }

}
