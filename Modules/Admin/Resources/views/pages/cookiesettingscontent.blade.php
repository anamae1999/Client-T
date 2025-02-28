@extends('admin::layouts.master')
@section('content')
<section class="gray-bg">
	<div class="container-fluid">
		<div class="row no-gutters">
			@include('admin::internals.dashboardtab')
			<div class="dashboard-tab-content padLR60">
			    <div class="tab-content" id="dashboard-tab-content">
			    	@if(Session::has('response'))
		                <div class="alert alert-success">
		                    {{ Session::get('response') }}
		                </div>
		            @endif
					<div class="tab-pane fade show active" id="v-pills-pages">
						<div class="pt-3 pb-3">	
							<a class="green" href='{{ url("/admin/pages/edit/cookie-statement") }}'><< Back to edit Cookie Statement page</a>
						</div>
						<section>							
					      	<h2>Cookie Settings Content</h2>
					      	<div class="table-container mb-5 p-4">
					      		<div id="for-cookie-accordion">
									@if(count($cookieSettings) > 0)
					                    @foreach($cookieSettings as $cookieSetting)
							      			<div class="card">
											    <div class="card-header" id="heading{{ $cookieSetting->id }}">
											      <div class="mb-0 d-flex justify-content-between">
											        <button class="btn btn-link fw600 green green-link collapsed" data-toggle="collapse" data-target="#collapse{{ $cookieSetting->id }}" aria-expanded="true" aria-controls="collapse{{ $cookieSetting->id }}">
											          {{ $cookieSetting->title }}
											        </button>
											        <div class="d-flex align-items-center">
											        	<a class="m-1 green" href='{{ url("/admin/pages/edit/cookie-item/{$cookieSetting->id}") }}'>Edit</a>
														<a class="m-1 green" href="#deleteCookieModal" data-toggle="modal" data-id="{{ $cookieSetting->id }}" data-title="{{ $cookieSetting->title }}">Delete</a>
											        </div>
											        
											      </div>
											    </div>
											    <div id="collapse{{ $cookieSetting->id }}" class="collapse" aria-labelledby="heading{{ $cookieSetting->id }}" data-parent="#for-cookie-accordion">
											      <div class="card-body">
											      	{!! $cookieSetting->content !!}	
											      </div>
											    </div>
										    </div>	
								    	@endforeach
							    	@else
										<div>
											<p>No cookie settings content available</p>
										</div>													
									@endif	
								</div>
								<div class="table-container-footer clearfix">
									 {{ $cookieSettings->appends(Request::except('page'))->links() }}
								</div>
							      		
							</div>				      	

					    </section>
					    <section>
							<div class="border-lg-grey p-4">									
								<form method="POST" action="{{ url('/admin/add-cookie-setting') }}">
						      	@csrf											
									
									<div class="cookie-setting padT10">
																							
										<div class="edit-title-container padTB10">
											<span class="fw600">Title<span class="required"> *</span></span>
											<div class="padT10">
												<input name="title" type="text" class="edit-title-input col-12 padLR10" value="{{ old('title') }}">	
												@if ($errors->has('title'))
	                                                <span class="help-block">
	                                                    {{ $errors->first('title') }}
	                                                </span>
	                                            @endif
											</div>
										</div>
										<div class="edit-content-container padT10">
				      						<span class="fw600">Content<span class="required"> *</span></span>
			      							<div class="padT10">
											    <textarea name="content" id="content-editor" class="mceEditor">{{ old('content') }}</textarea>
											    @if ($errors->has('content'))
                                                    <span class="help-block">
                                                        {{ $errors->first('content') }}
                                                    </span>
                                                @endif
											</div>
										</div>
									</div>
									<div class="padT10">
										<button type="submit" class="custom-btn btn-green btn-green-whitebg btn-primary dashboard-btn ml-2 mt-2">Add Cookie Settings Item</button>
									</div>												
								</form>	
							</div>
						</section>
					</div>

			    </div>
		  	</div>
		</div>
	</div>
</section>

<!-- Delete testimonial confirmation modal -->
<div id="deleteCookieModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Do you really want to delete the "<span class="title"></span>" cookie settings item?</strong></p>                
            </div>
            <div class="modal-body d-flex">
            	
                    
				<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<p> Are you sure you want to do this? This cannot be undone. </p>
			</div>
			<form method="POST" action='{{ url("/admin/cookie-setting/delete") }}'>	
            @csrf
            @method('DELETE')
	            <input type="hidden" name="cookieId">	
				<div class="modal-footer">   
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button class="dlt-faq dlt-btn">Delete</button>      
				</div>                  
			</form>
        </div>
      </div>
</div>

@endsection


