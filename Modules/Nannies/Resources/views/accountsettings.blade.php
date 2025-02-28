@extends('nannies::layouts.master') 
@section('content')
<section class="gray-bg">
    <div class="container-fluid">
        <div class="row no-gutters">
            @include('parents::internals.dashboardtab')
            <div class="dashboard-tab-content padLR60">
                @if(Session::has('response'))
                    <div class="alert alert-success">
                        {{ Session::get('response') }}
                    </div>
                @endif
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if(Session::has('failed'))
                    <div class="alert alert-danger">
                        {{ Session::get('failed') }}
                    </div>
                @endif         
                <div class="tab-content loaderParent">                
                    <div id="loadingDiv">
                        <div class="loader"></div>
                    </div> 
                    
                    <div class="tab-pane fade show active">
                        <div class="row no-gutters justify-content-center">
                            <div class="col-12 shadow white-bg rounded my-md-3 my-0"> 
                                <div class="d-flex flex-row flex-wrap align-items-center px-4 px-sm-5 pt-4 pb-3 row no-gutters">
                                    <div class="col-12">
                                        <div class="pb-3 col-details">
                                            <h4 class="brown m-0">Account Settings for Nanny</h4>
                                        </div>
                                    </div>
                                </div>
                                <form class="admin-accset" method="post" action="{{ url('nannies/update-settings') }}" enctype="multipart/form-data" class="admin-accset" autocomplete="off">
                                @csrf
                                @method('patch')
                                    <div class="row no-gutters">
                                        <div class="col-md-12 p-4 p-sm-5">
                                            <div class="row align-items-start pb-3">
                                                <div class="col-lg-6 pb-3 pb-lg-0">
                                                    <label class="green" for="">Current email address</label>
                                                    <p class="account-settings-email">{{ $user->email }}</p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="green" for="">New email address</label>
                                                    <input type="email" class="ad-input form-control" name="email">
                                                    @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            {{ $errors->first('email') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row align-items-start pb-5">        
                                                <div class="col-lg-6 pb-3 pb-lg-0">
                                                    <label class="green" for="">New Password <span class="pass-req">(Min. 8 Characters)</span></label>
                                                    <input id="password-field" type="password" class="ad-input form-control" name="password">
                                                    <span toggle="#password-field" class="fa fa-fw fa-eye password-icon toggle-password"></span>
                                                    @if ($errors->has('password'))
                                                        <span class="help-block">
                                                            {{ $errors->first('password') }}
                                                        </span>
                                                    @endif

                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="green" for="">Confirm New Password</label>
                                                    <input id="password-field-confirmation" type="password" class="ad-input form-control" name="password_confirmation">
                                                    <span toggle="#password-field-confirmation" class="fa fa-fw fa-eye password-icon toggle-password"></span>
                                                    @if ($errors->has('password_confirmation'))
                                                        <span class="help-block">
                                                            {{ $errors->first('password_confirmation') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>                                            
                                            <div class="row">  
                                                <div class="col-md-12 pb-5 sub-pay-btn">
                                                    <div class="row align-items-center">                  
                                                        <div class="col-md-auto col-sm-12 mb-2 mb-md-0">
                                                            <button type="submit" class="custom-btn btn-white py-2">Update Account</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <p class="green mb-2"><em>Last active: {{ date("d-m-Y", strtotime($user->last_login)) }}</em></p>
                                                    <p class="brown mb-2">De-activate my account, 2 options</p>
                                                    <p class="mb-2">                                        
                                                        <a class="brown-link" href="#suspendUserModal" data-toggle="modal" data-id="{{ $user->id }}">Deactivate account</a>
                                                    </p>
                                                    <p class="mb-2">
                                                        <a class="brown-link" href="#deleteUserModal" data-toggle="modal" data-id="{{ $user->id }}">Delete account</a>
                                                    </p>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="row no-gutters justify-content-center mt-2 mt-sm-3 mt-md-0">
                            <div class="col-12 shadow white-bg rounded my-md-3 my-0">
                                <div id="payment" class="row no-gutters">
                                    <div class="col-md-12 p-3 p-sm-5"> 
                                                                                   
                                        <div class="row">
                                            <div class="col-md-12 brown">

                                                @if(Auth::user()->account_type != 'premium')
                                                <div class="pb-3 col-details">                                                                                                        
                                                    <h4>Become a premium member!</h4>
                                                
                                                    <ul class="mb-0">
                                                        <li>Instant contact with others in your neighborhood</li>
                                                        <li>Others can read and reply to your messages for free</li>
                                                    </ul>
                                                </div>
                                                @endif

                                                @if(Auth::user()->account_type == 'premium')
                                                <div class="premium-wrap">
                                                    <div class="dash-prem-badge inlineBlock align-middle">
                                                        <img src="{{ asset('images/premium-badge.png') }}">
                                                    </div>                                                    
                                                    <div class="inlineBlock align-middle pl-2 pl-sm-4 premium-text">
                                                        @if($pastDue)
                                                        <h4 class="green">Your premium membership is past due.</h4>
                                                            @if($user->idealSubscription->status == 'pending')
                                                                <p class="brown">Your renewal payment is in process via SEPA Direct debit.</p>
                                                            @endif
                                                        @else
                                                        <h4 class="green">You are a premium member!</h4>
                                                        @endif
                                                        @if($via)
                                                            @if($via == 'card')
                                                                <p class="brown">You are currently subscribed to <strong>{{$plan}} Premium Plan</strong> via <strong>{{ucfirst($user->card_brand)}}</strong> ending in <strong>{{$user->card_last_four}}</strong>.</p>
                                                            @endif
                                                            @if($via == 'ideal')
                                                                <p class="brown">You are currently subscribed to <strong>{{$plan}} Premium Plan</strong> via <strong>Ideal</strong> payment which {{ $pastDue ? 'ended' : 'will end'}} at <strong>{{date('M d, Y',strtotime($user->idealSubscription->ends_at))}}</strong>.</p>

                                                                @if(isset($stripeSource))
                                                                    <p><a class="brown-link" href="{{ $stripeSource->mandate->url }}" target="_blank">View</a> your SEPA Direct Debit Mandate acceptance.</p>
                                                                @endif
                                                            @endif
                                                                
                                                        @endif
                                                        <p>You can cancel your subscription by clicking the link below.</p>
                                                        <div class="mt-3">
                                                            <a href="#cancelSubsModal" class="brown-link" data-toggle="modal" data-id="{{ $user->id }}">Cancel my Subscription</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif                                                    
                                                
                                            </div>
                                        </div>

                                        @if(isset(Auth::user()->sitterProfile->job_description))
                                            @if(Auth::user()->account_type == 'free')
                                            <div class="row">                                            
                                                <div class="col-md-12 py-5">
                                                    <div class="inlineBlock help-text-city-container help-text-pay">
                                                        <h4 class="green mb-3 inline-block">1) Choose your subscription:
                                                            @if($settings->payment_tooltip)
                                                            <div class="help-text-city on767">
                                                                <div class="question-mark">?</div>
                                                                <div class="help-text-city-content text-left">
                                                                    <em class="fonts14">{!! $settings->payment_tooltip !!}</em>
                                                                    <span class="help-text-close">x</span>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </h4>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-11 col-sm-12 col-xl-9 col-lg-11 mb-0 sub-pay-card-wrap">
                                                            <table class="sub-pay-container sub-pay-card col-12">
                                                                <tbody>
                                                                    @if($settings->sitter_1mo != 0 || $settings->sitter_3mo != 0)
                                                                        @if($settings->sitter_1mo != 0)
                                                                        <tr class="sub-pay-row">
                                                                            <td scope="row">
                                                                                <div class="custom-control custom-radio-green custom-control-inline test">
                                                                                    <input type="radio" id="1month" value="1mo" name="subscription" class="custom-control-input btn btn-info btn-lg">
                                                                                    <label class="custom-control-label" for="1month">1 month</label>
                                                                                </div>
                                                                            </td>
                                                                            <td>€ {{ $settings->sitter_1mo }}</td>
                                                                            <td>(€ {{ $settings->sitter_1mo }} per month)</td>
                                                                        </tr>
                                                                        @endif

                                                                        @if($settings->sitter_3mo != 0)
                                                                        <tr class="sub-pay-row help-text-city-container help-text-pay">
                                                                            <td scope="row">
                                                                                <div class="custom-control custom-radio-green custom-control-inline test">
                                                                                    <input type="radio" id="3month" name="subscription" class="custom-control-input btn btn-info btn-lg" value="3mo">
                                                                                    <label class="custom-control-label" for="3month">3 months</label>
                                                                                </div>
                                                                            </td>
                                                                            <td>€ {{ $settings->sitter_3mo }}</td>
                                                                            <td>(€ {{ round(($settings->sitter_3mo / 3), 2) }} per month)
                                                                                @if($settings->payment_tooltip)
                                                                                <div class="help-text-city onDesktop">
                                                                                    <div class="question-mark">?</div>
                                                                                    <div class="help-text-city-content text-left">
                                                                                        <em class="fonts14">{!! $settings->payment_tooltip !!}</em>
                                                                                        <span class="help-text-close">x</span>
                                                                                    </div>
                                                                                </div>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        @endif
                                                                    @else
                                                                        <tr class="sub-pay-row">
                                                                            <td scope="row">
                                                                                <div class="custom-control custom-radio-green custom-control-inline test">
                                                                                    No plans currently available to subscribe. Please check again at a later time.
                                                                                </div>
                                                                            </td>                                                                        
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pb-4">
                                                    <h4 class="green mb-3">2) Choose your payment method:</h4>
                                                    <div class="row">
                                                        <div class="col-12 col-xl-6 col-lg-7 col-md-8 col-sm-10 mb-0">
                                                            <table class="sub-pay-container pay-container col-12">
                                                                <tbody>
                                                                    <tr class="sub-pay-row">
                                                                        <td class="text-center"><img src="{{ asset('images/ideal-logo.png') }}" alt=""></td>
                                                                        <td scope="row">
                                                                            <div class="custom-control custom-radio-green custom-control-inline">
                                                                                <input type="radio" id="ideal" name="payment" class="custom-control-input" value="0">
                                                                                <label class="custom-control-label" for="ideal">iDEAL</label>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="sub-pay-row">
                                                                        <td class="text-center"><img src="{{ asset('images/generic-credit-card-icon.png') }}" alt=""></td>
                                                                        <td scope="row">
                                                                            <div class="custom-control custom-radio-green custom-control-inline">
                                                                                <input type="radio" id="card" name="payment" class="custom-control-input" value="1">
                                                                                <label class="custom-control-label" for="card">Pay with Card</label>
                                                                            </div> 
                                                                        </td>
                                                                    </tr>     
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pb-4">
                                                    <p class="mb-3">{{ $settings->payment_notice }}</p>
                                                    <div class="d-flex">
                                                        <img class="mr-2" src="{{ asset('images/padlock.png') }}" width="22" height="29">
                                                        <p class="green fontW300 fontS18 mb-0 row no-gutters align-items-center d-flex">Your data will be processed through a secure connection</p>                                                    
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pb-5 sub-pay-btn">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-auto col-sm-12 mb-3 mb-md-0">
                                                        @if(!empty($user->screening->status))
                                                            @if($user->screening->status == 'verified')
                                                                <a id="payBtn" href="" class="custom-btn btn-green btn-green-whitebg py-2 hide" data-toggle="modal"><img class="mr-2" src="{{ asset('images/checked.png') }}">Pay</a>
                                                             @else
                                                                <a id="payBtn"  href="" class="custom-btn btn-green btn-green-whitebg py-2 hide" data-toggle="modal" data-target="#myModal" ><img class="mr-2" src="{{ asset('images/checked.png') }}">Pay</a>
                                                            @endif
                                                        @else
                                                             <a id="payBtn" href="" class="custom-btn btn-green btn-green-whitebg py-2 hide" data-toggle="modal" data-target="#myModal" ><img class="mr-2" src="{{ asset('images/checked.png') }}">Pay</a>
                                                        @endif
                                                            
                                                                    
                                                            
                                                            
                                                        </div>                                                    
                                                    </div>
                                                </div>                  
                                            </div>
                                            @endif  
                                        @else
                                            <div class="alert alert-info">
                                                Please update your profile to continue with premium membership.
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row align-items-center">
                                                    <div class="col-md-auto col-sm-12 mb-3 mb-md-0 px-0">          
                                                        <a href="/nannies/dashboard" class="custom-btn btn-white py-2">Profile</a>
                                                    </div>                                                    
                                                </div>
                                            </div>                                          
                                        @endif
                                        
                                         
                                    </div>
                                </div>  
                                
                            </div>
                        </div>
      

                        @if($settings->vetting == 1)
                        <div class="row no-gutters justify-content-center mt-2 mt-sm-3 mt-md-0">
                            <div class="col-12 shadow white-bg rounded my-md-3 py-5">
                                <div class="d-flex flex-row flex-wrap align-items-center px-4 px-sm-5 pb-3 row no-gutters">
                                    <div class="col-12">
                                        <div class="col-details pb-3">
                                            <h4 class="brown m-0">Vetting for Nanny</h4>
                                        </div>                                        
                                    </div>
                                </div>
                               
                                    <div class="row no-gutters">
                                        <div class="col-md-12 px-5"> 
                                            <div class="row pb-4">
                                                <div class="col-md-12 brown">
                                                    @if(!empty($user->vetting->status))
                                                    <p>You have requested for vetting.</p>
                                                    <p>Application Status: {{ $user->vetting->application_status }}</p>
                                                    <p>Status: {{ $user->vetting->status }}</p>
                                                    @else
                                                    <p>You have not requested for vetting.</p> 
                                                    @endif               
                                                </div>
                                            </div>                                           
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row align-items-center">                  
                                                        <div class="col-md-auto col-sm-12 mb-2 mb-md-0">
                                                            @if(!empty($user->vetting->status))
                                                                <form method="POST" action='{{ url("/nannies/cancel/vetting") }}'>    
                                                                @csrf
                                                                @method('DELETE')
                                                                    <input type="hidden" name="vetting_id" value="{{ $user->vetting->id }}">
                                                                    <button type="submit" class="custom-btn btn-white py-2">Cancel Vetting Request</button>        
                                                                </form> 
                                                             
                                                            @else
                                                                <form method="POST" action="{{ url('/nannies/request/vetting') }}">
                                                                @csrf
                                                                    <input type="hidden" name="request-vetting" value="true">
                                                                    <button type="submit" class="custom-btn btn-white py-2">Request for Vetting</button>        
                                                                </form> 
                                                            @endif  
                                                        </div>                                                        
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Delete confirmation modal -->
<div id="deleteUserModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
                <p class="fontS18"><strong>Do you really want to delete your account?</strong></p>
            </div>
            <div class="modal-body d-flex">
                <svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
                <div>
                    @if($user->account_type == 'premium')
                    <p>Your premium subscription would be cancelled.</p>
                    @endif
                    <p>Confirm deletion of account.</p>  
                </div>  
            </div>
            <form method="POST" action='{{ url("/nannies/delete") }}'>   
            @csrf                    
                <input type="hidden" name="userId"> 
                <div class="modal-footer">   
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="dlt-user dlt-btn">Delete</button>      
                </div>                  
            </form>
        </div>
      </div>
</div>

<!-- Suspend confirmation modal -->
<div id="suspendUserModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
                <p class="fontS18"><strong>Do you really want to deactivate your account?</strong></p>
            </div>
            <div class="modal-body d-flex">
                <svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
                <div>
                    @if($user->account_type == 'premium')
                        <p>Your premium subscription would be cancelled.</p>
                    @endif                    
                    <p>You would no longer appear in searches.</p>
                    <p>Your account would automatically be activated when you logged in.</p> 
                    <p>Confirm deactivation of account.</p>
                    
                </div> 
            </div>
            <form method="POST" action='{{ url("/nannies/deactivate") }}'>  
            @csrf            
                <input type="hidden" name="userId"> 
                <div class="modal-footer">   
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="spd-btn">Deactivate</button>      
                </div>                  
            </form>
        </div>
    </div>
</div>

@if($user->account_type == 'premium')
<!-- Cancel Subscription confirmation modal -->
<div id="cancelSubsModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content p-2 modal-loader-parent">
            <div class="modal-loader-div hide">                
                <div class="modal-loader"></div>
            </div>
            <div class="modal-header">
                <p class="fontS18"><strong>Do you really want to cancel your subscription?</strong></p>
            </div>
            <div class="modal-body d-flex">
                <svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
                <div>
                    <p>Confirm cancellation of subscription.</p>                   
                </div> 
            </div>
            <form id="formCancel" method="POST" action='{{ url("/cancel-subscription/{$user->id}") }}'>  
            @csrf            
                <input type="hidden" name="userId"> 
                <div class="modal-footer">   
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="spd-btn">Continue</button>      
                </div>                  
            </form>
        </div>
    </div>
</div>
@endif

@if($user->account_type == 'free')
<!-- Card payment method modal -->
<div id="cardPaymentModal" class="modal fade card-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content p-2 modal-loader-parent">
            <div class="modal-loader-div hide">                
                <div class="modal-loader"></div>
            </div>
            <div class="modal-header cda34f-bg">
                <p class="fontS18 brown"><strong>Card Payment</strong></p>
            </div>
            <form method="post" action='{{ url("/subscription/{$user->id}") }}' id="card-payment-form">
            @csrf
                <input type="hidden" name="plan-type" value="">
                <div class="modal-body f8f8f8-bg">
                    <div class="form form-cb">      
                        <label for="card-element" class="green">
                          Credit or debit card
                        </label>
                        <div id="card-element">
                          <!-- A Stripe Element will be inserted here. -->
                        </div>
                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert" class="card-errors mt-3"></div>        
                    </div>
                </div>
                <div class="modal-footer cda34f-bg">   
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    
                    <button id="card-button" data-secret="{{ $intent->client_secret }}" class="custom-btn btn-green btn-green-whitebg py-2">
                        Confirm Payment
                    </button>     
                </div>
            </form> 
        </div>
    </div>
</div>

<!-- Ideal payment method modal -->
<div id="idealPaymentModal" class="modal fade ideal-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content p-2 modal-loader-parent">
            <div class="modal-loader-div hide">                
                <div class="modal-loader"></div>
            </div>
            <div class="modal-header cda34f-bg">
                <p class="fontS18 brown"><strong>Ideal Payment</strong></p>
            </div>
            <form method="post" action='{{ url("/ideal-payment/{$user->id}") }}' id="ideal-payment-form">
            @csrf
                <div class="modal-body f8f8f8-bg">  
                    <input type="hidden" name="plan-type" value="">  
                    <div class="form">
                        <label for="email" class="green">
                          Email
                        </label>
                        <p>{{ $user->email }}</p>
                        <input  type="hidden" name="email" class="full ideal-email" required="required" value="{{ $user->email }}">
                    </div>          
                    <div class="form mt-3">
                        <label for="name" class="green">
                          Name
                        </label>
                        <input name="name" class="full" required="required" value="{{ $user->first_name }} {{ $user->last_name }}">
                    </div>                    
                    <div class="form mt-3">
                        <label for="ideal-bank-element" class="green">
                          iDEAL Bank
                        </label>
                        <div id="ideal-bank-element">                            

                        </div>
                        <input id="idealBank" type="hidden" name="ideal_bank">
                    </div>

                    <!-- Used to display form errors. -->
                    <div id="error-message" role="alert" class="ideal-error mt-3"></div>

                    <!-- Display mandate acceptance text. -->
                    <div id="mandate-acceptance" class="mandate-acceptance">
                        <p>By providing your IBAN and confirming this payment, you authorise
                        (A) Tiny Steps and Stripe, our payment service provider, to send instructions to your bank to
                        debit your account and (B) your bank to debit your account in accordance with
                        those instructions. You are entitled to a refund from your bank under the terms
                        and conditions of your agreement with your bank. A refund must be claimed
                        within 8 weeks starting from the date on which your account was debited.</p>
                    </div>
                </div>
                <div class="modal-footer cda34f-bg">   
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button id="payIdealBtn" class="custom-btn btn-green btn-green-whitebg py-2" data-email="{{ $user->email }}">
                        Proceed
                    </button>     
                </div>
            </form>
        </div>
    </div>
</div>
 @if(!empty($user->screening->status))
 @if($user->screening->status != 'verified')
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #CDA34F;">
          <button  type="button" class="close" data-dismiss="modal">&times;</button>
          <img style="max-width:80px;" src="https://dev.tinysteps.nl/images/TinyStepsLogo.svg">
        </div>
        <div class="modal-body">
            <h5 style="color:#59342A;"><b>SCREENING PROCESS REQUIRED</b></h5>
          <p>Before subscribing for premium membership, you must first pass the screening, acquire a verified badge and be visible in the search list.</p>
        </div>
        <div class="modal-footer">
          <button style="background-color: #28994B;color:#FFFFFF;" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
 @endif
@endif
<script type="text/javascript">
document.getElementById('myModal').style.display = 'none';
</script>
<script>
// When the user clicks on div, open the popup
function myFunction() {
  var popup = document.getElementById("myModal");
  popup.classList.toggle("show");
}
</script>

<script>
    function showLoading() {
        jQuery('.modal-loader-div').removeClass('hide');
    }

    function stopLoading() {
        jQuery('.modal-loader-div').addClass('hide');
    }
    const stripe = Stripe('{{ $stripePK }}');
    const elements = stripe.elements();
    var cardOptions = {
      style: {
        base: {
          fontSize: '16px',
          color: '#373E27',
        },
      }
    }

    // Create an instance of the card Element.
    const cardElement = elements.create('card', cardOptions);
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    // Add an instance of the card Element into the `card-element` <div>.
    cardElement.mount('#card-element');

    // ********************IDEAL ELEMENT POPULATION START********************
    var idealElements = stripe.elements();
    var idealOptions = {
      style: {
        base: {
          fontSize: '16px',
          color: '#32325d',
          padding: '10px 12px',
        },
      }
    }

    // Create an instance of the idealBank Element.
    var idealBank = idealElements.create('idealBank', idealOptions);

    // Add an instance of the idealBank Element into
    // the `ideal-bank-element` <div>.
    idealBank.mount('#ideal-bank-element');

    idealBank.on('change', function(event) {
      var bank = event.value;
      var idealBank = document.getElementById('idealBank');
      console.log(idealBank);
      idealBank.setAttribute('value', bank);
    });

    // Handle real-time validation errors from the card Element.
    cardElement.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    // ********************IDEAL ELEMENT POPULATION END********************


    // Handle form submission.
    var formCard = document.getElementById('card-payment-form');

    formCard.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe
            .handleCardSetup(clientSecret, cardElement, {
                payment_method_data: {
                    //billing_details: { name: cardHolderName.value }
                }
            })
            .then(function(result) {
                // console.log(result);
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // console.log(result);
                    // Send the token to your server.
                    stripeTokenHandler(result.setupIntent.payment_method);
                }
            });
    });

    // Submit the form with the token ID.
    function stripeTokenHandler(paymentMethod) {
        showLoading();
        // Insert the token ID into the form so it gets submitted to the server
        var formCard = document.getElementById('card-payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'paymentMethod');
        hiddenInput.setAttribute('value', paymentMethod);
        formCard.appendChild(hiddenInput);

        // Submit the form
        formCard.submit();
    }

    // ideal form submission
    var formIdeal = document.getElementById('ideal-payment-form');
    formIdeal.addEventListener('submit', function(event) {
        event.preventDefault();
        showLoading(); 
        formIdeal.submit();         
    });
    
</script>
@endif

@if($user->account_type == 'premium')
<script>
    function showLoading() {
        jQuery('.modal-loader-div').removeClass('hide');
    }

    function stopLoading() {
        jQuery('.modal-loader-div').addClass('hide');
    }

    // Handle form submission.
    var formCancel = document.getElementById('formCancel');

    formCancel.addEventListener('submit', function(event) {
        event.preventDefault();
        showLoading();   
        formCancel.submit();     
    });


</script>
@endif

@endsection

