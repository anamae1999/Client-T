@extends('mentors::layouts.master') 
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
                                            <h4 class="brown m-0">Account Settings</h4>
                                        </div>
                                    </div>
                                </div>
                                <form class="admin-accset" method="post" action="{{ url('mentors/update-settings') }}" enctype="multipart/form-data" class="admin-accset" autocomplete="off">
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
                    <p>Confirm deletion of account.</p>  
                </div>  
            </div>
            <form method="POST" action='{{ url("/mentors/delete") }}'>   
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
                    <p>You would no longer appear in searches.</p>
                    <p>Your account would automatically be activated when you logged in.</p> 
                    <p>Confirm deactivation of account.</p>     
                </div> 
            </div>
            <form method="POST" action='{{ url("/mentors/deactivate") }}'>  
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
@endsection

