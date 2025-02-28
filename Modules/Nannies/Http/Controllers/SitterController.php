<?php

// Nanny Profile Controller

namespace Modules\Nannies\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

// support for file
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

// models
use Modules\Nannies\Entities\Sitter;
use Modules\Nannies\Entities\Review;
use Modules\Nannies\Entities\Reference;
use Modules\Admin\Entities\Example;
use App\User;
use App\IdealSubscription;
use App\Schedule;
use App\Badge;
use App\Vetting;
use App\Screening;
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

use Intervention\Image\Facades\Image as Image;
use App\Notifications\AccountDeactivated;
use App\Notifications\GoodbyeCustomer;
use App\Notifications\VettingRequested;
use App\Notifications\AdminVettingRequested;
use App\Notifications\VettingCancelled;
use App\Notifications\ScreeningRequested;
use App\Notifications\AdminScreeningRequested;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

use Stripe\Stripe;

class SitterController extends Controller
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
    public function show($id) //show nanny profile page
    {
        if (Auth::check() && Auth::user()->role != 'sitter' || Auth::user()->id == $id){
            $sitter = Sitter::where('user_id', $id)->first();
            $vetting = Vetting::where('user_id', $id)->first();            
            $reviews = Review::where('sitter_id', $id)->paginate(5);
            $references = Reference::where('sitter_id', $sitter->id)->get();
            
            $screening = Screening::where('user_id', $id)->first();
            
            if (($screening && $screening->status == 'verified')) {
                $badges = Badge::all();
                
                foreach ($badges as $key => $badge) {
                    
                    if ($badge->badge_name == $screening->badge_name) {
                        $nannyBadge = $badge->badge_pic;
                    }

                }                
            }

             if (($screening && $screening->status == 'verified')) {
                $badges = Badge::all();
                
                foreach ($badges as $key => $badge) {
                    
                    if ($badge->badge_name == $screening->badge_name2) {
                        $nannyBadge2 = $badge->badge_pic;
                    }

                }                
            }

             if (($screening && $screening->status == 'verified')) {
                $badges = Badge::all();
                
                foreach ($badges as $key => $badge) {
                    
                    if ($badge->badge_name == $screening->badge_name3) {
                        $nannyBadge3 = $badge->badge_pic;
                    }

                }                
            }

             if (($screening && $screening->status == 'verified')) {
                $badges = Badge::all();
                
                foreach ($badges as $key => $badge) {
                    
                    if ($badge->badge_name == $screening->badge_name4) {
                        $nannyBadge4 = $badge->badge_pic;
                    }

                }                
            }

             if (($screening && $screening->status == 'verified')) {
                $badges = Badge::all();
                
                foreach ($badges as $key => $badge) {
                    
                    if ($badge->badge_name == $screening->badge_name5) {
                        $nannyBadge5 = $badge->badge_pic;
                    }

                }                
            }






            $exists = Contact::where('owner_id','=',Auth::user()->id)
            ->where('contact_id','=',$id)->exists();

            if ($exists) {
                $userIsMyContact = true;
            } 

            // retrive values if not null else return empty values
            if (!is_null($sitter->qualifications)) {
                $qualifications = explode(", ", $sitter->qualifications);
            } else {
                $qualifications = [];
            }

            if (!is_null($sitter->languages)) {
                $languages = explode(", ", $sitter->languages);
            } else {
                $languages = [];
            }

            if (!is_null($sitter->stages_experience)) {
                $stagesExperience = explode(", ", $sitter->stages_experience);
            } else {
                $stagesExperience = [];
            }

            if (!is_null($sitter->activities)) {
                $activities = explode(", ", $sitter->activities);
            } else {
                $activities = [];
            }

            if (!is_null($sitter->additional_services)) {
                $additionalServices = explode(", ", $sitter->additional_services);
            } else {
                $additionalServices = [];
            }

            if (!is_null($sitter->date_of_birth)) {
                // calculate age
                $birthDate = explode("/", $sitter->date_of_birth);

                //get age from date or birthdate
                $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                    ? ((date("Y") - $birthDate[2]) - 1)
                    : (date("Y") - $birthDate[2]));
            } else {            
                $age = '';
            }    

            // schedules
            $scheds = Schedule::where('user_id', $id)->first(); 

            // pull all column names from db table
            $schedColumns = self::getSchedColumns('schedules');

            $googleKey = config('services.google.key');  

            $distance = self::distance(Auth::user()->lat, Auth::user()->lng, $sitter->user->lat, $sitter->user->lng, 'K');          

            return view('nannies::nannyprofile', compact(
                'sitter',
                'qualifications',
                'languages',
                'stagesExperience',
                'activities',
                'additionalServices',
                'age',
                'scheds',
                'schedColumns',
                'vetting',
                'reviews',
                'googleKey',
                'userIsMyContact',
                'distance',
                'references',
                'nannyBadge',
                'nannyBadge2',
                'nannyBadge3',
                'nannyBadge4',
                'nannyBadge5'
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
    public function dashboard() //profile from dashboard
    {
        if (Auth::check() && Auth::user()->role == 'sitter') {
            $user = Auth::user();
            $sitter = Sitter::where('user_id', Auth::user()->id)->first();    
            $references = Reference::where('sitter_id', $sitter->id)->get();
            $screening = Screening::where('user_id', Auth::user()->id)->first();
            $examplePhotos = Example::where('type',1)->get();

            // retrive values if not null else return empty values
            if (!is_null($sitter->qualifications)) {
                $qualifications = explode(", ", $sitter->qualifications);
            } else {
                $qualifications = [];
            }

            if (!is_null($sitter->languages)) {
                $languages = explode(", ", $sitter->languages);
            } else {
                $languages = [];
            }

            if (!is_null($sitter->stages_experience)) {
                $stagesExperience = explode(", ", $sitter->stages_experience);
            } else {
                $stagesExperience = [];
            }

            if (!is_null($sitter->activities)) {
                $activities = explode(", ", $sitter->activities);
            } else {
                $activities = [];
            }

            if (!is_null($sitter->additional_services)) {
                $additionalServices = explode(", ", $sitter->additional_services);
            } else {
                $additionalServices = [];
            }

            if (!is_null($sitter->date_of_birth)) {
                // calculate age
                $birthDate = explode("/", $sitter->date_of_birth);

                //get age from date or birthdate
                $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                    ? ((date("Y") - $birthDate[2]) - 1)
                    : (date("Y") - $birthDate[2]));
            } else {
                $birthDate = [];
                $age = '';
            }    

            if (!is_null($sitter->begin_date)) {

                $beginDate = explode("/", $sitter->begin_date);

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

             // values for qualifications
            $qualCheckbox = [
                'With VOG/Certificate of Conduct','Willing to apply VOG upon hiring','With EHBO First Aid for Baby & Children','Willing to take EHBO First Aid for Baby & Children upon hiring','Driving License'];

            // values for Additional Services
            $servCheckbox = [
                'Child-related chores','Cooking for the family','Light house chores','None'];

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

            return view('nannies::nannydashboard', compact(
                'user',
                'sitter',
                'qualifications',
                'languages',
                'stagesExperience',
                'activities',
                'additionalServices',
                'birthDate',
                'age',
                'langDropdown',            
                'jdDropdown',
                'scheds',
                'schedColumns',
                'beginDate',
                'langCheckbox',
                'qualCheckbox',
                'servCheckbox',
                'actCheckbox',
                'stgsCheckbox',
                'references',
                'screening',
                'examplePhotos'
            ));
        } else {
            abort('401');
        }
    }

    public function settings()
    {
        if (Auth::check() && Auth::user()->role == 'sitter') {
            $user = Auth::user();               
            $stripePK = config('services.stripe.key');

            if ($user->account_type == 'free') {
                $intent = $user->createSetupIntent();
            } else {

                if ($user->sepa_source_id) {
                    Stripe::setApiKey(config('services.stripe.secret'));

                    $stripeSource = \Stripe\Source::retrieve([
                        'id' => $user->sepa_source_id
                    ]);

                }
                

                if ($user->subscribed('Nannies Premium Plans')) {  
                    $via = 'card';       
                    $planType = $user->subscription('Nannies Premium Plans')->stripe_plan;

                    if ($planType == 'tsnp-monthly') {
                        $plan = 'Monthly';
                    }

                    if ($planType == 'tsnp-3months') {
                        $plan = '3 Months';
                    }

                    $pastDue = false;
                } else {
                    $via = 'ideal';
                    if ($user->idealSubscription->name == 'Nanny 3mos Premium Membership') {
                        $plan = '3 Months';
                    }

                    if ($user->idealSubscription->name == 'Nanny 1mo Premium Membership') {
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

            return view('nannies::accountsettings', compact(
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


    public function requestVetting(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'sitter') {
            $requestVetting = $request->input('request-vetting');

            if ($requestVetting == 'true') {
                $vetting = new Vetting;
                $vetting->user_id = Auth::user()->id;         

                if ($vetting->save()) {
                    $recipient = new User();
                    $recipient->name = Auth::user()->first_name; 
                    $recipient->email = Auth::user()->email;   // This is the email you want to send to.
                    $recipient->notify(new VettingRequested()); 

                    $notice = new User();
                    $notice->first_name = Auth::user()->first_name; 
                    $notice->last_name = Auth::user()->last_name; 
                    $notice->user_email = Auth::user()->email;
                    $notice->email = config('services.email.mail_receiver');   // This is the email you want to send to.
                    $notice->notify(new AdminVettingRequested()); 
                }

                Session::flash('response', 'You have successfully requested for vetting!');

                return redirect()->back();
            }
         } else {
            abort('401');
        }
        
    }

    public function cancelVetting(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'sitter') {
            $id = $request->input('vetting_id');
            $vetting = Vetting::find($id);

            if ($vetting->delete()) {
                $recipient = new User();
                $recipient->name = Auth::user()->first_name; 
                $recipient->email = Auth::user()->email;   // This is the email you want to send to.
                $recipient->notify(new VettingCancelled()); 
            }

            Session::flash('response', 'You have cancelled your request for vetting!');
            
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
    public function update(Request $request, MessageBag $message_bag)
    {

        if (Auth::check() && Auth::user()->role == 'sitter') {

            $id = Auth::user()->id;


            // schedule table entries
            $sched = Schedule::where('user_id',$id)->first();;

            // pull all column names from db table
            $schedColumns = self::getSchedColumns('schedules');
            $schedEmpty = 0;

            // assign values from request with same name from column
            foreach ($schedColumns as $schedColumn) {

                if (($schedColumn != 'id') && ($schedColumn != 'user_id') && ($schedColumn != 'created_at') && ($schedColumn != 'updated_at')) {
                    if ($request->input($schedColumn)) {
                        $sched->$schedColumn = 1;
                        $schedEmpty += 1;
                    } else {
                        $sched->$schedColumn = 0;
                    }             
                }
            }

            $request['availability'] = $schedEmpty;            

            $dobMonth = $request->input('dob-month');
            $dobDay = $request->input('dob-day');
            $dobYear = $request->input('dob-year');

            //get age from date or birthdate
            $age = (date("md", date("U", mktime(0, 0, 0, $dobMonth, $dobDay, $dobYear))) > date("md")
                ? ((date("Y") - $dobYear) - 1)
                : (date("Y") - $dobYear));

            $request['age'] = $age;

            // identify the sitter
            $sitter = Sitter::where('user_id',$id)->first();
                    $data = request()->validate([
                        'first-name' => 'required|regex:/^[a-zA-Z0-9-\s]+$/',
                        'last-name' => 'required|regex:/^[a-zA-Z0-9-\s]+$/',
                        'contact-number' => 'required',
                        'house-number' => 'required',
                        'street-name' => 'required',
                        'city' => 'required',
                        'zip-code' => 'required',
                        'gender' => 'required',
                        'job-description' => 'required',
                        'dob-month' => 'required',
                        'dob-day' => 'required',
                        'dob-year' => 'required',
                        'bd-month' => 'required',
                        'bd-day' => 'required',
                        'bd-year' => 'required',
                        'general-text' => 'required',
                        'age' => ['numeric','gte:18'],
                        'avg-hourly' => 'required',                        
                        'stages-experience' => 'required|array|min:1', 
                        'additional-services' => 'required|array|min:1',
                        'kids-activities' => 'required|array|min:1',
                        'qualifications' => 'required|array|min:1',
                        'availability' => 'gt:0',
                        'profile-pic' => 'image',
                    ]);


            // if picture was already uploaded run validation set without profile pic
                $data = request()->validate([
                    'first-name' => 'required|regex:/^[a-zA-Z0-9-\s]+$/',
                    'last-name' => 'required|regex:/^[a-zA-Z0-9-\s]+$/',
                    'contact-number' => 'required',
                    'house-number' => 'required',
                    'street-name' => 'required',
                    'city' => 'required',
                    'zip-code' => 'required',
                    'gender' => 'required',
                    'job-description' => 'required',
                    'dob-month' => 'required',
                    'dob-day' => 'required',
                    'dob-year' => 'required',
                    'bd-month' => 'required',
                    'bd-day' => 'required',
                    'bd-year' => 'required',
                    'general-text' => 'required',
                    'age' => ['numeric','gte:18'],
                    'avg-hourly' => 'required',                    
                    'stages-experience' => 'required|array|min:1', 
                    'additional-services' => 'required|array|min:1',
                    'kids-activities' => 'required|array|min:1',
                    'qualifications' => 'required|array|min:1',
                    'availability' => 'gt:0',
                ]);

            

            // sitter table entries   
            $sitter->contact_number = $request->input('contact-number');                            
            $sitter->house_number = $request->input('house-number');
            $sitter->street = $request->input('street-name');
            $sitter->city = $request->input('city');
            $sitter->zip_code = $request->input('zip-code');  
          
            $sitter->date_of_birth = $dobMonth . '/' . $dobDay . '/' . $dobYear;

            $bdMonth = $request->input('bd-month');
            $bdDay = $request->input('bd-day');
            $bdYear = $request->input('bd-year');

            $sitter->begin_date = $bdMonth . '/' . $bdDay . '/' . $bdYear;

            $sitter->hourly_rate = $request->input('avg-hourly');
            $sitter->gender = $request->input('gender');
            $sitter->job_description = $request->input('job-description');
            $sitter->years_of_experience = $request->input('years-of-experience');       
            $sitter->mother_tongue = $request->input('mother-tongue');
            $sitter->general_text = $request->input('general-text');

            // checkboxes
            $languages = $request->input('languages');
            $stagesExperience = $request->input('stages-experience');
            $activities = $request->input('kids-activities');
            $qualifications = $request->input('qualifications');
            $additionalServices = $request->input('additional-services');

            if (!is_null($languages)) {
                if (end($languages) == null) {
                    $sitter->languages = substr(implode(", ", $languages), 0, -9);
                    if ($sitter->languages == false) {
                        $sitter->languages = null;
                    }
                } else {
                    $sitter->languages = implode(", ", $languages);
                }
            } else {
                $sitter->languages = $languages;
            }

            if (!is_null($stagesExperience)) {
                if (end($stagesExperience) == null) {
                    $sitter->stages_experience = substr(implode(", ", $stagesExperience), 0, -9);
                    if ($sitter->stages_experience == false) {
                        $sitter->stages_experience = null;
                    }
                } else {
                    $sitter->stages_experience = implode(", ", $stagesExperience);
                }
            } else {
                $sitter->stages_experience = $stagesExperience;
            }

            if (!is_null($activities)) {
                if (end($activities) == null) {
                    $sitter->activities = substr(implode(", ", $activities), 0, -9);
                    if ($sitter->activities == false) {
                        $sitter->activities = null;
                    }
                } else {
                    $sitter->activities = implode(", ", $activities);
                }
            } else {
                $sitter->activities = $activities;
            }

            if (!is_null($qualifications)) {
                if (end($qualifications) == null) {
                    $sitter->qualifications = substr(implode(", ", $qualifications), 0, -9);
                    if ($sitter->qualifications == false) {
                        $sitter->qualifications = null;
                    }
                } else {
                    $sitter->qualifications = implode(", ", $qualifications);
                }
            } else {
                $sitter->qualifications = $qualifications;
            }      

            if (!is_null($additionalServices)) {
                if (end($additionalServices) == null) {
                    $sitter->additional_services = substr(implode(", ", $additionalServices), 0, -9);
                    if ($sitter->additional_services == false) {
                        $sitter->additional_services = null;
                    }
                } else {
                    $sitter->additional_services = implode(", ", $additionalServices);
                }
            } else {
                $sitter->additional_services = $additionalServices;
            }

            $sitter->update();
            $sched->update(); 
            
            // User table entries
            $user = User::find($id);
            $user->first_name = $request->input('first-name');
            $user->last_name = $request->input('last-name');

            $address = $sitter->house_number . ', ' . $sitter->street . ', ' . $sitter->zip_code;

            //Converts address into Lat and Lng
            $apiKey = config('services.google.server_key');
            $client = new Client(); //GuzzleHttp\Client
            $result =(string) $client->post("https://maps.googleapis.com/maps/api/geocode/json?components=country:NL|locality:".$sitter->city."&address=".$address.'&key='. $apiKey)->getBody();

            $json = json_decode($result);


                $user->lat = null;
                $user->lng = null;
            
            $user->save();

            // references table entries
            $user->references()->delete();
            // array of references
            $refFnames = $request->input('ref-fname');
            $refLnames = $request->input('ref-lname');
            $refContactNumbers = $request->input('ref-contact-num');
            $refEmails = $request->input('ref-email');

            // create empty array for references
            $references = [];

            foreach ($refFnames as $key => $refFname) {
                $references[$key]['first_name'] = $refFname;
            }

            foreach ($refLnames as $key => $refLname) {
                $references[$key]['last_name'] = $refLname;
            }

            foreach ($refContactNumbers as $key => $refContactNumber) {
                $references[$key]['contact_number'] = $refContactNumber;
            }

            foreach ($refEmails as $key => $refEmail) {
                $references[$key]['email'] = $refEmail;
            }

            foreach ($references as $key => $reference) {
                $references[$key]['user_id'] = $id;
                $references[$key]['sitter_id'] = $sitter->id;
            }

            Reference::insert($references);

            // check if sitter has screening record
            $screening = Screening::where('user_id', Auth::user()->id)->first();

            if (empty($screening)) {
                $screening = new Screening;
                $screening->user_id = Auth::user()->id;  

                if ($screening->save()) {
                    $recipient = new User();
                    $recipient->name = Auth::user()->first_name; 
                    $recipient->email = Auth::user()->email;   // This is the email you want to send to.
                    $recipient->notify(new ScreeningRequested()); 

                    $notice = new User();
                    $notice->first_name = Auth::user()->first_name; 
                    $notice->last_name = Auth::user()->last_name; 
                    $notice->user_email = Auth::user()->email;
                    $notice->profile = URL::to('/').'/nannies/profile/'. Auth::user()->id .'/'. Auth::user()->first_name;
                    $notice->email = config('services.email.mail_screening');   // This is the admin email you want to send to.
                    $notice->notify(new AdminScreeningRequested()); 
                }
            } else {
                // dd('false');
            }

            Session::flash('response', 'Profile updated successfully!');

            return redirect()->back();
        } else {
            abort('401');
        }
    }

   public function profile(Request $request){

        if (Auth::check() && Auth::user()->role == 'sitter') {
              // identify the sitter
            $id = Auth::user()->id;
            $sitter = Sitter::where('user_id',$id)->first();

            $cropPos = $request->input('crop_pos');

            // if has profile picture input, save pic even if failed update profile so that user does not need to select again
            $filenamePrepend = sprintf("%06d", $id);
            if (Input::hasFile('profile-pic')) {

                $validator = Validator::make($request->all(), [
                    'profile-pic' => 'image',
                ]);

                if ($validator->fails()) {
                    $data = request()->validate([
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
                        
                        return redirect()->back()->withErrors($message_bag);
                    }   

                    $url = URL::to("/"). '/uploads/'. $filenamePrepend . '-' . $fileName;
                    $sitter->profile_pic = $url;
                    $sitter->update();
                }
            } //end if has profile picture input
             Session::flash('response', 'Profile Picture updated successfully!');

            return redirect()->back();
        }else {
            abort('401');
        }
    }

    // account settings of nannies
    public function updateSettings(Request $request)
    { 
        if (Auth::check() && Auth::user()->role == 'sitter') {
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

                    if ($user->subscribed('Nannies Premium Plans')) {

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
        if (Auth::check() && Auth::user()->role == 'sitter') {   

            $user = User::find($request->userId);

            if ($user->subscribed('Nannies Premium Plans')) {         
                if ($user->subscription('Nannies Premium Plans')->cancelNow()) {
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
                $recipient->name = $user->first_name; 
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
        if (Auth::check() && Auth::user()->role == 'sitter') {
            $user = User::find($request->userId);
            if ($user->subscribed('Nannies Premium Plans')) {         
                if ($user->subscription('Nannies Premium Plans')->cancelNow()) {
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

    public function messages(Request $request)
    {
        if (Auth::user()->role == 'sitter') {
            return view('nannies::messages');
        } else {
            abort('401');
        }
    }

}
