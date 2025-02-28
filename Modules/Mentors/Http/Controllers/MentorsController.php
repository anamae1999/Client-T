<?php

namespace Modules\Mentors\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

// support for file
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

// models
use App\User;
use App\Contact;
use Auth;
use Session;
use DB;
use Carbon;
use DateTime;
use Modules\Mentors\Entities\Mentor;
use Modules\Mentors\Entities\MentorReview;
use Modules\Mentors\Entities\Agenda;
use Modules\Mentors\Entities\EventDetail;
use Modules\Admin\Entities\Example;

// guzzle
use GuzzleHttp;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Intervention\Image\Facades\Image as Image;
use App\Notifications\AccountDeactivated;
use App\Notifications\GoodbyeCustomer;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class MentorsController extends Controller
{
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

    public function show($id) //show mentor profile page
    {
  
            $mentor = Mentor::where('user_id', $id)->first();  
            $agendas = Agenda::orderBy('created_at', 'desc')->where('user_id', $id)->with('details')->get();
            $reviews = MentorReview::where('mentor_id', $id)->paginate(5);

            if (!is_null($mentor->trainings)) {
                $trainings = explode(", ", $mentor->trainings);
            } else {
                $trainings = [];
            }        

            if (!is_null($mentor->languages)) {
                $languages = explode(", ", $mentor->languages);
            } else {
                $languages = [];
            }

            $distance = self::distance(Auth::user()->lat, Auth::user()->lng, $mentor->user->lat, $mentor->user->lng, 'K');

            return view('mentors::mentorprofile', compact(
                'mentor',
                'trainings',
                'languages',
                'reviews',
                'agendas',
                'distance'
            ));
    }

    /**
    * Show the form for editing the specified resource.
    * @param int $id
    * @return Response
    */
    public function dashboard()
    {
        if (Auth::check() && Auth::user()->role == 'mentor') {
            $mentor = Mentor::where('user_id', Auth::user()->id)->first();  
            $agendas = Agenda::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->with('details')->get();
            $examplePhotos = Example::where('type',3)->get(); 

            // retrive values if not null else return empty values
            if (!is_null($mentor->languages)) {
                $languages = explode(", ", $mentor->languages);
            } else {
                $languages = [];
            }

            if (!is_null($mentor->trainings)) {
                $trainings = explode(", ", $mentor->trainings);
            } else {
                $trainings = [];
            }


            // values for other languages
            $langCheckbox = [
                'Dutch','English','German','French','Italian','Spanish'];        

            // values of job description dropdown
            if (!is_null($mentor->job_description)) {
                $job_descriptions = explode(", ", $mentor->job_description);
            } else {
                $job_descriptions = [];
            }

            return view('mentors::mentordashboard', compact(
                'mentor',
                'languages',
                'job_descriptions',     
                'langCheckbox',      
                'trainings',
                'agendas',
                'examplePhotos'
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
        if (Auth::check() && Auth::user()->role == 'mentor') {
            $id = Auth::user()->id;

            // identify the mentor
            $mentor = Mentor::where('user_id',$id)->first();

            $cropPos = $request->input('crop_pos');

            $job_descriptions = $request->input('job_descriptions');
            $job_descriptions = array_filter($job_descriptions);
            $job_descriptions = implode(", ", $job_descriptions);

            if ($job_descriptions == null) {
                $request['job_description'] = '';
            } else {
                $request['job_description'] = $job_descriptions;
            }

            // profile picture upload
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
                        'job_description' => 'required',
                        'email' => 'required',
                        'number' => 'required',
                        'website' => 'required',
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
                    $mentor->profile_pic = $url;
                    $mentor->update();
                }
            }

                if ($mentor->profile_pic) {
                $data = request()->validate([
                    'first-name' => 'required|regex:/^[a-zA-Z0-9-\s]+$/',
                    'last-name' => 'required|regex:/^[a-zA-Z0-9-\s]+$/',
                    'house-number' => 'required',
                    'street-name' => 'required',
                    'city' => 'required',
                    'zip-code' => 'required',
                    'job_description' => 'required',                    
                    'email' => 'required',
                    'number' => 'required',
                    'website' => 'required',                   
                ]);
            }else{
                $data = request()->validate([
                    'first-name' => 'required|regex:/^[a-zA-Z0-9-\s]+$/',
                    'last-name' => 'required|regex:/^[a-zA-Z0-9-\s]+$/',
                    'house-number' => 'required',
                    'street-name' => 'required',
                    'city' => 'required',
                    'zip-code' => 'required',
                    'job_description' => 'required',                    
                    'email' => 'required',
                    'number' => 'required',
                    'website' => 'required',
                    'profile-pic' => 'required',
                ]);
          }

                // mentor table entries  
                $mentor->house_number = $request->input('house-number');
                $mentor->street = $request->input('street-name');
                $mentor->city = $request->input('city');
                $mentor->zip_code = $request->input('zip-code');   
                $mentor->job_description = $job_descriptions; 

                $languages = $request->input('languages');

                if (!is_null($languages)) {
                    if (end($languages) == null) {
                        $mentor->languages = substr(implode(", ", $languages), 0, -9);
                        if ($mentor->languages == false) {
                            $mentor->languages = null;
                        }
                    } else {
                        $mentor->languages = implode(", ", $languages);
                    }
                } else {
                    $mentor->languages = $languages;
                }

                $trainings = $request->input('trainings');
                $trainings = array_filter($trainings);
                $trainings = implode(", ", $trainings);
                
                $mentor->trainings = $trainings;
                $mentor->general_text = $request->input('general-text');
                $mentor->email = $request->input('email');
                $mentor->number = $request->input('number');
                $mentor->website = $request->input('website');

                $mentor->update();

                // User table entries
                $user = User::find($id);
                $user->first_name = $request->input('first-name');
                $user->last_name = $request->input('last-name');

                $address = $mentor->house_number . ', ' . $mentor->street . ', ' . $mentor->zip_code;

                //Converts address into Lat and Lng
                $apiKey = config('services.google.server_key');
                $client = new Client(); //GuzzleHttp\Client
                $result =(string) $client->post("https://maps.googleapis.com/maps/api/geocode/json?components=country:NL|locality:".$mentor->city."&address=".$address.'&key='. $apiKey)->getBody();

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

    public function agendas()
    {
        if (Auth::user()->role == 'mentor') {

            $agendas = Agenda::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->with('details')->paginate(5);

            return view('mentors::agenda', compact('agendas'));
        } else {
            abort('401');
        }
    }


    public function settings()
    {
        if (Auth::check() && Auth::user()->role == 'mentor') {
            $user = Auth::user();                      
            return view('mentors::accountsettings', compact('user'));
        } else {
            abort('401');
        }
    }

    // account settings of mentors
    public function updateSettings(Request $request)
    { 
        if (Auth::check() && Auth::user()->role == 'mentor') {
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
            
            $user->save();

            Session::flash('response', 'Account settings updated successfully!');

            return redirect()->back();
        } else {
            abort('401');
        }

    }

    public function deleteAccount(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'mentor') {   

            $user = User::find($request->userId);

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
        if (Auth::check() && Auth::user()->role == 'mentor') {
            $user = User::find($request->userId);

            $user->account_status = 'deactivated';
            if ($user->save()) {
                $recipient = new User();
                $recipient->name = $user->first_name . ' ' . $user->last_name; 
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
        if (Auth::user()->role == 'mentor') {
            return view('mentors::messages');
        } else {
            abort('401');
        }
    }
}
