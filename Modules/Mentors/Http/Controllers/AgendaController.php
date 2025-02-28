<?php

namespace Modules\Mentors\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Session;

// models
use Auth;
use Modules\Mentors\Entities\Agenda;
use Modules\Mentors\Entities\EventDetail;

use Illuminate\Support\Facades\Validator;

class AgendaController extends Controller
{

    public function index()
    {
        // values for languages
        $languages = ['Dutch','English','German','French','Italian','Spanish'];

        return view('mentors::agendacontent', compact('languages'));
    }


    public function create(Request $request)
    {
        $data = request()->validate([           
            'title' => 'required', 
        ]); 

        $agenda = new Agenda;
        $agenda->user_id = Auth::user()->id;
        $agenda->title = $request->input('title');
        $agenda->description = $request->input('description');
        $agenda->save();

        // arrays of form submission
        $sdDays = $request->input('sd-day');
        $sdMonths = $request->input('sd-month');
        $sdYears = $request->input('sd-year');
        $startHours = $request->input('st-start-hr');
        $startMins = $request->input('st-start-min');
        $endHours = $request->input('st-end-hr');
        $endMins = $request->input('st-end-min');
        $venues = $request->input('venue');
        $fees = $request->input('fee');
        $promos = $request->input('promo');
        $languages = $request->input('language');
        $otherLanguages = $request->input('other-lang');
        
        // count how many event-details in an agenda
        $evtDetailsCount = $request->input('event-details-count');

        // formulate each session dates for each event details then store in $sessionDates
        $sessionDates = [];
        $data = [];
        for ($i=0; $i < $evtDetailsCount; $i++) { 
            $sessionDatesLength = count($sdDays[$i]);   

            for ($s=0; $s < $sessionDatesLength; $s++) { 
                $sessionDate = $sdDays[$i][$s] .'/'.$sdMonths[$i][$s].'/'.$sdYears[$i][$s];
                $sessionDates[$i][$s] = $sessionDate;
            }   

            // each event details data
            $eachSessionDates = implode(", ", $sessionDates[$i]);
            $eachStartTime = $startHours[$i].':'.$startMins[$i];
            $eachEndTime = $endHours[$i].':'.$endMins[$i];
            $eachVenue = $venues[$i];
            $eachFee = $fees[$i];
            $eachPromo = $promos[$i];
            $eachLanguage = $languages[$i];
            $eachOtherLanguage = ucwords($otherLanguages[$i]);

            // generate data array for insert on db
            $data[$i] = [
                'agenda_id' => $agenda->id,
                'dates' => $eachSessionDates,
                'start_time' => $eachStartTime,
                'end_time' => $eachEndTime,
                'venue' => $eachVenue,
                'language' => $eachLanguage,
                'other_language' => $eachOtherLanguage,
                'fee' => $eachFee,
                'promo' => $eachPromo
            ];
        }              

        if (EventDetail::insert($data)) {
            Session::flash('response', 'Agenda added successfully!');
            return redirect('mentors/edit-agenda/' . $agenda->id);
        } else {                
            return redirect()->back();
        }    
    }

    public function edit($id)
    {        
        if (Auth::check() && Auth::user()->role == 'mentor') {
            // values for languages
            $languages = ['Dutch','English','German','French','Italian','Spanish'];
            $agenda = Agenda::with('details')->find($id);       
            return view('mentors::editagendacontent',compact('agenda','languages'));
        } else {
            abort('401');
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::check() && Auth::user()->role == 'mentor') {
            $data = request()->validate([           
                'title' => 'required', 
            ]); 

            $agenda = Agenda::find($id);
            $agenda->user_id = Auth::user()->id;
            $agenda->title = $request->input('title');
            $agenda->description = $request->input('description');
            $agenda->save();

            $agenda->details()->delete();

            // arrays of form submission
            $sdDays = $request->input('sd-day');
            $sdMonths = $request->input('sd-month');
            $sdYears = $request->input('sd-year');
            $startHours = $request->input('st-start-hr');
            $startMins = $request->input('st-start-min');
            $endHours = $request->input('st-end-hr');
            $endMins = $request->input('st-end-min');
            $venues = $request->input('venue');
            $languages = $request->input('language');
            $otherLanguages = $request->input('other-lang');
            $fees = $request->input('fee');
            $promos = $request->input('promo');

            // count how many event-details in an agenda
            $evtDetailsCount = $request->input('event-details-count');

            // formulate each session dates for each event details then store in $sessionDates
            $sessionDates = [];
            $data = [];
            for ($i=0; $i < $evtDetailsCount; $i++) { 
                $sessionDatesLength = count($sdDays[$i]);   

                for ($s=0; $s < $sessionDatesLength; $s++) { 
                    $sessionDate = $sdDays[$i][$s] .'/'.$sdMonths[$i][$s].'/'.$sdYears[$i][$s];
                    $sessionDates[$i][$s] = $sessionDate;
                }   

                // each event details data
                $eachSessionDates = implode(", ", $sessionDates[$i]);
                $eachStartTime = $startHours[$i].':'.$startMins[$i];
                $eachEndTime = $endHours[$i].':'.$endMins[$i];
                $eachVenue = $venues[$i];
                $eachLanguage = $languages[$i];
                $eachFee = $fees[$i];
                $eachPromo = $promos[$i];
                $eachOtherLanguage = ucwords($otherLanguages[$i]);

                // generate data array for insert on db
                $data[$i] = [
                    'agenda_id' => $agenda->id,
                    'dates' => $eachSessionDates,
                    'start_time' => $eachStartTime,
                    'end_time' => $eachEndTime,
                    'venue' => $eachVenue,
                    'language' => $eachLanguage,
                    'other_language' => $eachOtherLanguage,
                    'fee' => $eachFee,
                    'promo' => $eachPromo
                ];
            }              

            EventDetail::insert($data);
            Session::flash('response', 'Agenda updated successfully!');
            
            return redirect('mentors/edit-agenda/' . $agenda->id);
        } else {
            abort('401');
        }


    }

    public function destroy(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'mentor') {
            $id = $request->input('agendaId');
            $agenda = Agenda::find($id);
            $agenda->delete();

            Session::flash('response', 'Agenda item deleted successfully!');
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }
}
