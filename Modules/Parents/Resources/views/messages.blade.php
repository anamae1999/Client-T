@extends('parents::layouts.master-messaging') 

@section('content')
<section class="gray-bg">
    <div class="container-fluid">
        <div class="row no-gutters">
            @include('parents::internals.dashboardtab')
            <div class="dashboard-tab-content padLR60">
                <div class="tab-content loaderParent">
                    <div id="loadingDiv">
                        <div class="loader"></div>
                    </div>
                    <div class="tab-pane fade show active">                        
                        <div class="chat-wrap">
                            @if(Session::has('response'))
                                <div class="alert alert-success">
                                    {{ Session::get('response') }}
                                </div>
                            @endif
                            <div id="app">
                                <chat-app :user="{{ auth()->user() }}"></chat-app>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Delete confirmation modal -->
<div id="deleteContactModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
                <p class="fontS18"><strong>Delete contact "<span class="user-name"></span>".</strong></p>
            </div>
            <div class="modal-body d-flex">
                <svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
                <p>Do you really want to remove "<span class="user-name"></span>" from your contact list?</p>
            </div>
            <form method="POST" action='{{ url("/contact/delete") }}'>   
            @csrf             
            @method('DELETE')           
                <input type="hidden" name="contactid"> 
                <input type="hidden" name="name"> 
                <div class="modal-footer">   
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="dlt-user dlt-btn">Confirm</button>      
                </div>                  
            </form>
        </div>
      </div>
</div>
@endsection