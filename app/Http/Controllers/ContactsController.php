<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use App\Contact;
use App\Events\NewMessage;
use Auth;
use DB;
use Session;

use App\Notifications\NewMessageMail;

class ContactsController extends Controller
{
    public function get()
    {

        if(Auth::user()->role == 'sitter') {
            $contacts1 = User::where('account_status', '=','activated')
                ->join('contacts', 'users.id', '=', 'contacts.contact_id')
                ->join('guardians', 'users.id', '=', 'guardians.user_id');
            $contacts2 = User::where('account_status', '=','activated')
                ->join('contacts', 'users.id', '=', 'contacts.contact_id')
                ->join('mentors', 'users.id', '=', 'mentors.user_id');            
        } elseif (Auth::user()->role == 'parent') {
            $contacts1 = User::where('account_status', '=','activated')
                ->join('contacts', 'users.id', '=', 'contacts.contact_id')
                ->join('sitters', 'users.id', '=', 'sitters.user_id'); 
            $contacts2 = User::where('account_status', '=','activated')
                ->join('contacts', 'users.id', '=', 'contacts.contact_id')
                ->join('mentors', 'users.id', '=', 'mentors.user_id');           
        } elseif (Auth::user()->role == 'mentor') {
            $contacts1 = User::where('account_status', '=','activated')
                ->join('contacts', 'users.id', '=', 'contacts.contact_id')
                ->join('sitters', 'users.id', '=', 'sitters.user_id'); 
            $contacts2 = User::where('account_status', '=','activated')
                ->join('contacts', 'users.id', '=', 'contacts.contact_id')
                ->join('guardians', 'users.id', '=', 'guardians.user_id');           
        }     

        $contacts1 = $contacts1->where('contacts.owner_id', '=', auth()->id());
        $contacts2 = $contacts2->where('contacts.owner_id', '=', auth()->id());

        if(Auth::user()->role == 'sitter') {
            $contacts1 = $contacts1->select('users.id','users.role','users.first_name','users.email','guardians.profile_pic')
            ->distinct();
            $contacts2 = $contacts2->select('users.id','users.role','users.first_name','users.email','mentors.profile_pic')
            ->distinct();  
        } elseif (Auth::user()->role == 'parent') {
            $contacts1 = $contacts1->select('users.id','users.role','users.first_name','users.email','sitters.profile_pic')
            ->distinct();
            $contacts2 = $contacts2->select('users.id','users.role','users.first_name','users.email','mentors.profile_pic')
            ->distinct();         
        }  elseif (Auth::user()->role == 'mentor') {
            $contacts1 = $contacts1->select('users.id','users.role','users.first_name','users.email','sitters.profile_pic')
            ->distinct();
            $contacts2 = $contacts2->select('users.id','users.role','users.first_name','users.email','guardians.profile_pic')
            ->distinct();        
        }  

        $contacts1 = $contacts1->get();
        $contacts2 = $contacts2->get();
                  
        $contacts = $contacts1->merge($contacts2);

        foreach ($contacts as $contact) {
            
            if ($contact->role == 'sitter') {
                $urlRole = 'nannies';
            } elseif ($contact->role == 'parent') {
                $urlRole = 'parents';
            } elseif ($contact->role == 'mentor') {
                $urlRole = 'mentors';
            }
             $contact->profile = '/'.$urlRole.'/profile/'.$contact->id.'/'.strtolower($contact->first_name); 
        }

        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();

        // add an unread key to each contact with the count of unread messages
        $contacts = $contacts->map(function($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();

            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

            return $contact;
        });

        return response()->json($contacts);  
        
    }

    public function getSelf()
    {
        if(Auth::user()->role == 'sitter') {
            $self = User::where('users.id', '=',auth()->id())
                ->join('sitters', 'users.id', '=', 'sitters.user_id')
                ->select('users.id','users.first_name','users.email','sitters.profile_pic');    
        } elseif (Auth::user()->role == 'parent') {
            $self = User::where('users.id', '=',auth()->id())
                ->join('guardians', 'users.id', '=', 'guardians.user_id')
                ->select('users.id','users.first_name','users.email','guardians.profile_pic'); ;
        } elseif (Auth::user()->role == 'mentor') {
            $self = User::where('users.id', '=',auth()->id())
                ->join('mentors', 'users.id', '=', 'mentors.user_id')
                ->select('users.id','users.first_name','users.email','mentors.profile_pic'); ;
        }
        $self = $self->first();

        return response()->json($self);
    }

    public function addContact(Request $request, $id)
    {
        $authRole = Auth::user()->role;
        $contactRole = $request->role;

        $exists = Contact::where('owner_id','=',auth()->id())
            ->where('contact_id','=',$id)->exists();

        if (!$exists) {
            $contact = new Contact;
            $contact->contact_id = $id;
            $contact->owner_id = auth()->id();
            $contact->save();
        } 

        if($contactRole == 'sitter') {
            $queryRole = 'sitters';  
            $altRole = 'nannies';                    
        } elseif ($contactRole == 'parent') {
            $queryRole = 'guardians';
            $altRole = 'parents';                  
        } elseif ($contactRole == 'mentor') {
            $queryRole = 'mentors'; 
            $altRole = 'mentors';                 
        } 

        $talkingTo = User::where('users.id', '=',$id)
                ->join($queryRole, 'users.id', '=', $queryRole.'.user_id')
                ->select('users.id','users.first_name','users.email',$queryRole.'.profile_pic'); 

        $talkingTo = $talkingTo->first();

        if($authRole == 'sitter') {
            $module = 'nannies';
        } elseif ($authRole == 'parent') {
            $module = 'parents'; 
        } elseif ($authRole == 'mentor') {
            $module = 'mentors'; 
        }

        $talkingTo->profile = '/'.$altRole.'/profile/'.$id.'/'.strtolower($talkingTo->first_name);

        $redirectTo = '/'.$module.'/messages?id='.$id.'&first_name='.$talkingTo->first_name.'&profile_pic='.$talkingTo->profile_pic.'&profile='.$talkingTo->profile;

        // params from this url are applied to messaging on  ContactList.vue component
        return redirect($redirectTo);
    }

    public function deleteContact(Request $request)
    {
        $contactId = $request->contactid;
        $name = $request->name;

        $contact = Contact::where('owner_id','=',auth()->id())
            ->where('contact_id','=',$contactId);

        $contact->delete();

        Session::flash('response', $name. ' removed from your contact list!');

        return redirect()->back();

    }

    public function getMessagesFor($id)
    {
        // mark all messages with the selected contact as read
        Message::where('from', $id)->where('to', auth()->id())->update(['read' => true]);

        // update user to no unread message
        $user = User::find(auth()->id());
        $user->has_message = 0;
        $user->save();

        // get all messages between the authenticated user and the selected user
        $messages = Message::where(function($q) use ($id) {
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->id());
        })
        ->get();

        return response()->json($messages);
    }

    public function sender(Request $request)
    {

        $authID = auth()->id();

        $message = Message::create([
            'from' => $authID,
            'to' => $request->contact_id,
            'text' => $request->text
        ]);

        // User sending the message
        $me = User::find($authID);
        $me->talking_to = $request->contact_id;
        $me->save();

        // update user(message receiver) to have unread message if not talking to $me or if offline
        $user = User::find($request->contact_id);
        if (Auth::user()->talking_to != $user->id || $user->talking_to != $authID || !$user->isOnline()) {
            $user->has_message = 1;            
            if ($user->save()) {
                $recipient = new User();
                $recipient->name = $user->first_name . ' ' . $user->last_name; 
                $recipient->text = $request->text;
                $recipient->sender = Auth::user()->first_name . ' ' . Auth::user()->last_name;
                $recipient->email = $user->email;   // This is the email you want to send to.;                
                $recipient->notify(new NewMessageMail()); 
            } 
        }        

        $exists = Contact::where('owner_id','=',$request->contact_id)
            ->where('contact_id','=',$authID)->exists();

        if (!$exists) {
            $contact = new Contact;
            $contact->contact_id = $authID;
            $contact->owner_id = $request->contact_id;
            $contact->save();
        }

        broadcast(new NewMessage($message));

        return response()->json($message);
    }


    public function removeTalkingTo(Request $request)
    {
        $user = User::find(auth()->id());
        $user->talking_to = null;
        $user->save();
    }

}
