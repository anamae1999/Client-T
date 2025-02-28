<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

use Session;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\Category;

use Auth;
use DB;
use App\User;
use App\Schedule;
use App\Screening;
use Modules\Admin\Entities\Page;
use Modules\Nannies\Entities\Sitter;
use Modules\Parents\Entities\Guardian;
use Modules\Mentors\Entities\Mentor;

// guzzle
use GuzzleHttp;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;



class PageController extends Controller
{
    public function getSchedColumns($table)
    {
        return DB::getSchemaBuilder()->getColumnListing($table);
    }

    // distance calculator if not filtered
    public function userDistance($query, $lat, $lng) {

     $haversine = "(6371 * acos(cos(radians($lat)) 
                     * cos(radians(lat)) 
                     * cos(radians(lng) 
                     - radians($lng)) 
                     + sin(radians($lat)) 
                     * sin(radians(lat))))";
         return $query
            ->select('*')
            ->selectRaw("{$haversine} AS distance")
            ->orderBy("distance");
    }

    // distance calculator from advanced search
    public function userWithinDistance($query, $lat, $lng, $minRadius, $maxRadius) {

     $haversine = "(6371 * acos(cos(radians($lat)) 
                     * cos(radians(lat)) 
                     * cos(radians(lng) 
                     - radians($lng)) 
                     + sin(radians($lat)) 
                     * sin(radians(lat))))";
         return $query
            ->select('*')
            ->selectRaw("{$haversine} AS distance")
            ->whereRaw("{$haversine} >= ?", [$minRadius])
            ->whereRaw("{$haversine} <= ?", [$maxRadius])
            ->orderBy("distance");
    }

    // list pages on admin dashboard
    public function showPage()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {        
            $pages = Page::paginate(10);
            $posts = Post::orderBy('created_at', 'desc')->paginate(10); 
            $categories = Category::all();            
            
            return view('admin::pages', compact('posts', 'categories','pages'));
        } else {
            abort('401');
        }
    }

    // update meta from pages tab in admin dashboard
    public function updateMeta(Request $request, $id)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {  
            // get home page row from pages table
            $page = Page::find($id);

            $page->meta_titles = $request->input('meta-title');
            $page->meta_descriptions = $request->input('meta-description');
            $page->meta_keywords = $request->input('meta-keywords');
            $page->user_id = Auth::user()->id;
            $page->update();

            Session::flash('response', 'Page meta updated successfully!');  

            return redirect()->back();
        } else {
            abort('401');
        }

    }

    // filter search results from search box on home page
    public function search(Request $request)
    {
        $data = request()->validate([
            'role' => 'required'
        ]);

        $role = $request->input('role');

        $searchWord = $request->input('search-location');

        if ($role == 'parents') {
            $roleFinder = 'parent';
            $func = 'guardianProfile';
            $funcUser = 'sitterProfile';
        } elseif ($role == 'nannies') {
            $roleFinder = 'sitter';
            $func = 'sitterProfile';
            $funcUser = 'guardianProfile';
        } else {
            abort(404);
        }  

        if (Auth::check() && !isset($searchWord)) {
            $searchWord = str_replace(' ', '', Auth::user()->$funcUser->zip_code);
        }       

        $users = User::where('account_status', '=','activated');

        // if searching for nanny detect if passed screening
        if ($role == 'nannies') {
            $users->whereHas('screening', function($q){
                $q->where('application_status','passed');
            });
        } 

        $users->whereHas($func, function($q){
            $q->whereNotNull('job_description');
        });

        $users = $users->where('role',$roleFinder);

        if ($searchWord) {
            //Converts zip_code into Lat and Lng
            $apiKey = config('services.google.server_key');
            $client = new Client(); //GuzzleHttp\Client
            $result =(string) $client->post("https://maps.googleapis.com/maps/api/geocode/json?components=country:NL|postal_code:".$searchWord.'&key='. $apiKey)->getBody();

            $json = json_decode($result);

            if ($json->status != 'ZERO_RESULTS') {
                $lat = $json->results[0]->geometry->location->lat;
                $lng = $json->results[0]->geometry->location->lng;
                $guestCoords = array("lat"=>$lat, "lng"=>$lng);

                // calculate distance
                $users = self::userWithinDistance($users, $lat, $lng, 0, 15); 
            } else {
                $invalidZip = 1;
                $users = $users->whereNull('id');
            }
        } else {
            $users->orderBy('created_at', 'desc');
        }

        $jobDesc = '';

        // pull all column names from db table
        $schedColumns = self::getSchedColumns('schedules'); 

        $users = $users->paginate(6);

        $showRefresh = 1; 

        $canonical = 'search';

        return view('search', compact('users','role','searchWord','jobDesc','schedColumns','showRefresh','canonical','invalidZip','guestCoords'));

    } 

    // list results from search link on nav or via url
    public function listProfile($role)
    {
        if(Auth::check()){
            $loggedInRole = Auth::user()->role;
        }        

        if (!empty($role)) {
            if ($role == 'parents') {
                $roleFinder = 'parent';
                $func = 'guardianProfile';
            } elseif ($role == 'nannies' ) {
                $roleFinder = 'sitter';
                $func = 'sitterProfile';
            } elseif ($role == 'mentors' ) {
                $roleFinder = 'mentor';
                $func = 'mentorProfile';
            } else {
                abort(404);
            }      
        } else {
            return redirect('home');
        }
        

        if (Auth::check() && $loggedInRole != 'mentor' && $loggedInRole == $roleFinder) {
            abort(401);
        }   

        $users = User::where('account_status', '=','activated');

        // if searching for nanny detect if passed screening
        if ($role == 'nannies') {
            $users->whereHas('screening', function($q){
                $q->where('application_status','passed');
            });
        } 
        
        $users->whereHas($func, function($q){
            $q->whereNotNull('job_description');
        });             

        if(Auth::check() && Auth::user()->lat && Auth::user()->lng){

            // get own latitide and longitude
            $lat = Auth::user()->lat;
            $lng = Auth::user()->lng;

            $users = $users->where('role', $roleFinder)->with($func);

            // calculate distance
            $users = self::userDistance($users, $lat, $lng);

        } else {
            $users = $users->where('role',$roleFinder);
        }

        $searchWord = '';
        $jobDesc = '';
        $showRefresh = 0;
        $canonical = 'search';
        $users = $users->paginate(6);
        // pull all column names from db table
        $schedColumns = self::getSchedColumns('schedules'); 

        return view('search', compact('users','role','searchWord','jobDesc','schedColumns','showRefresh','canonical'));
    }

    // filter results from search box on search page
    public function searchLocation(Request $request, $role)
    {
        $searchWord = $request->input('search-location');
        $jobDesc = $request->input('job-desc');

        if ($role == 'parents') {
            $roleFinder = 'parent';
            $func = 'guardianProfile';
        } elseif ($role == 'nannies' ) {
            $roleFinder = 'sitter';
            $func = 'sitterProfile';
        } elseif ($role == 'mentors' ) {
            $roleFinder = 'mentor';
            $func = 'mentorProfile';
        } else {
            abort(404);
        }  

        if (Auth::check()){
            if (Auth::user()->role == 'sitter') {
                $funcUser = 'sitterProfile';
            } elseif (Auth::user()->role == 'parent') {
                $funcUser = 'guardianProfile';
            } elseif (Auth::user()->role == 'mentor') {
                $funcUser = 'mentorProfile';
            }
        }      

        if (Auth::check() && !isset($searchWord)) {
            $searchWord = str_replace(' ', '', Auth::user()->$funcUser->zip_code);
        }  

        $users = User::where('account_status', '=','activated');

        // if searching for nanny detect if passed screening
        if ($role == 'nannies') {
            $users->whereHas('screening', function($q){
                $q->where('application_status','passed');
            });
        } 

        $users->whereHas($func, function($q){
            $q->whereNotNull('job_description');
        });

        $users = $users->whereHas($func, function($q) use ($jobDesc, $role){

            if ($jobDesc && $role != 'mentors') {
                $q->where('job_description', '=', $jobDesc);
            }

        });

        if ($searchWord) {
            //Converts zip_code into Lat and Lng
            $apiKey = config('services.google.server_key');
            $client = new Client(); //GuzzleHttp\Client
            $result =(string) $client->post("https://maps.googleapis.com/maps/api/geocode/json?components=country:NL|postal_code:".$searchWord.'&key='. $apiKey)->getBody();

            $json = json_decode($result);

            if ($json->status != 'ZERO_RESULTS') {
                $lat = $json->results[0]->geometry->location->lat;
                $lng = $json->results[0]->geometry->location->lng;
                $guestCoords = array("lat"=>$lat, "lng"=>$lng);

                // calculate distance
                $users = self::userWithinDistance($users, $lat, $lng, 0, 15); 
            } else {
                $invalidZip = 1;
                $users = $users->whereNull('id');
            }
        } else {

            $users->orderBy('created_at', 'desc');

        }

        $users = $users->paginate(6);

        // pull all column names from db table
        $schedColumns = self::getSchedColumns('schedules');

        $showRefresh = 1;
        $canonical = 'search';

        return view('search', compact('users','role', 'searchWord', 'jobDesc','schedColumns','showRefresh','canonical','invalidZip','guestCoords'));
    }

    // search via radio button
    public function searchJob(Request $request, $role)
    {
        $searchWord = $request->input('search-location');
        $jobDesc = $request->input('job-desc');

        if ($role == 'parents') {
            $roleFinder = 'parent';
            $func = 'guardianProfile';
        } elseif ($role == 'nannies' ) {
            $roleFinder = 'sitter';
            $func = 'sitterProfile';
        } else {
            abort(404);
        }     

        if (Auth::check()){
            if (Auth::user()->role == 'sitter') {
                $funcUser = 'sitterProfile';
            } elseif (Auth::user()->role == 'parent') {
                $funcUser = 'guardianProfile';
            } elseif (Auth::user()->role == 'mentor') {
                $funcUser = 'mentorProfile';
            }elseif (Auth::user()->role == 'admin') {
                $funcUser = 'admin';
            }
        }

        if (Auth::check() && !isset($searchWord)) {
            $searchWord = str_replace(' ', '', Auth::user()->$funcUser->zip_code);
        }     

        $users = User::where('account_status', '=','activated');

        // if searching for nanny detect if passed screening
        if ($role == 'nannies') {
            $users->whereHas('screening', function($q){
                $q->where('application_status','passed');
            });
        } 

        $users->whereHas($func, function($q){
            $q->whereNotNull('job_description');
        });

        $users = $users->whereHas($func, function($q) use ($jobDesc){
            
            $q->where('job_description', '=', $jobDesc);

        });

        if ($searchWord) {

            //Converts zip_code into Lat and Lng
            $apiKey = config('services.google.server_key');
            $client = new Client(); //GuzzleHttp\Client
            $result =(string) $client->post("https://maps.googleapis.com/maps/api/geocode/json?components=country:NL|postal_code:".$searchWord.'&key='. $apiKey)->getBody();

            $json = json_decode($result);

            if ($json->status != 'ZERO_RESULTS') {
                $lat = $json->results[0]->geometry->location->lat;
                $lng = $json->results[0]->geometry->location->lng;
                $guestCoords = array("lat"=>$lat, "lng"=>$lng);

                // calculate distance
                $users = self::userWithinDistance($users, $lat, $lng, 0, 15); 
            } else {
                $invalidZip = 1;
                $users = $users->whereNull('id');
            }
        } else {
            $users->orderBy('created_at', 'desc');
        }

        $users = $users->paginate(6);

        // pull all column names from db table
        $schedColumns = self::getSchedColumns('schedules');

        $showRefresh = 1;

        $canonical = 'search';

        return view('search', compact('users','role', 'searchWord', 'jobDesc','schedColumns','showRefresh','canonical','invalidZip','guestCoords'));
    }

    // filter results from advanced search on search page
    public function searchAdvanced(Request $request, $role)
    {
        if ($role == 'parents') {
            $roleFinder = 'parent';
            $func = 'guardianProfile';
        } elseif ($role == 'nannies' ) {
            $roleFinder = 'sitter';
            $func = 'sitterProfile';
        } else {
            abort(404);
        }

        $searchWord = $request->input('search-location');
        $jobDesc = $request->input('job-desc');

        $users = User::where('role', $roleFinder)
            ->where('account_status', '=','activated');

        // if searching for nanny detect if passed screening
        if ($role == 'nannies') {
            $users->whereHas('screening', function($q){
                $q->where('application_status','passed');
            });
        } 

        $users->whereHas($func, function($q){
            $q->whereNotNull('job_description');
        });
        
        // query for items on slider
        if ($role == 'parents') {
            $users->where(function ($query) use ($request, $func, $jobDesc) { //where user model
                $query->whereHas($func, function ($query) use ($request, $jobDesc) { //has guardian or sitter profile(model/relationship)
                    
                    // where profile values fullfill these conditions
                    $query->where('hourly_rate', '>=', $request->minRate)
                        ->where('hourly_rate', '<=', $request->maxRate)
                        ->where('num_of_children', '>=', $request->minChild)
                        ->where('num_of_children', '<=', $request->maxChild)
                        ->where('youngest_child', '>=', $request->minAge)
                        ->where('eldest_child', '<=', $request->maxAge); 

                    if ($jobDesc) {
                        $query->where('job_description', '=', $jobDesc);
                    }

                });   
            });
        } else if ($role == 'nannies') {
            $users->where(function ($query) use ($request, $func, $jobDesc) { //where user model
                $query->whereHas($func, function ($query) use ($request, $jobDesc) { //has guardian or sitter profile(model/relationship)
                    
                    // where profile values fullfill these conditions
                    $query->where('hourly_rate', '>=', $request->minRate)
                        ->where('hourly_rate', '<=', $request->maxRate);

                    if ($jobDesc) {
                        $query->where('job_description', '=', $jobDesc);
                    }

                });
            });
        }

        // query for availability
        if ($request->availability) {
          
            $users->where(function ($query) use ($request) { //where user model
                
                $query->whereHas('schedule', function ($query) use ($request)  {  //has schedule(model/relationship)

                    $availabilities = $request->availability; //get array of availability choices

                    $query->where(function ($query) use ($availabilities) {

                        // compare matches if any of the chosen is within user's schedule
                        foreach ($availabilities as $availablity) {  
                            $query->orwhere($availablity, '=', 1); 
                        }
                    });       
                });
            });
        }        

        // query for distance
        if(Auth::check() && Auth::user()->lat && Auth::user()->lng){

            // get own latitide and longitude
            $lat = Auth::user()->lat;
            $lng = Auth::user()->lng; 
            $minDistance =  $request->minDistance;          
            $maxDistance =  $request->maxDistance;          

            // calculate distance
            $users = self::userWithinDistance($users, $lat, $lng, $minDistance, $maxDistance);  

        }

        $users = $users->paginate(6);   

        $showRefresh = 1;   

        $canonical = 'search';        

        return view('search', compact('users','role','searchWord','jobDesc','showRefresh','canonical'));
        
    }

    // filter results from links on footer
    public function searchDescription(Request $request, $jobDesc)
    {
        switch ($jobDesc) {
            case 'permanent-nanny':
                $jobDesc = 'Permanent Nanny';
                break;

            case 'occasional-sitter':
                $jobDesc = 'Occasional Sitter';
                break;

            case 'afterschool-sitter':
                $jobDesc = 'Afterschool Sitter';
                break;

            case 'night-sitter':
                $jobDesc = 'Night Sitter';
                break;
            
            default:
                abort(404);
                break;
        }

        $users = User::where('account_status', '=','activated');
        
        $users->whereHas('screening', function($q){
            $q->where('application_status','passed');
        });
        
        $users = $users->whereHas('sitterProfile', function($q) use ($jobDesc){
            $q->where('job_description', '=',  $jobDesc);
        });

        // query for distance
        if(Auth::check() && Auth::user()->lat && Auth::user()->lng){

            // get own latitide and longitude
            $lat = Auth::user()->lat;
            $lng = Auth::user()->lng;        

            // calculate distance
            $users = self::userDistance($users, $lat, $lng);  

        }

        $users = $users->orderBy('created_at', 'desc')->paginate(6);

        $role = 'nannies';
        // pull all column names from db table
        $schedColumns = self::getSchedColumns('schedules');   

        $showRefresh = 0;    

        $canonical = 'search';   

        return view('search', compact('users','role','jobDesc','schedColumns','showRefresh','canonical'));
    }

}




