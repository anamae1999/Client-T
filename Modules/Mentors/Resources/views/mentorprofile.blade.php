@extends('layouts.layout')

@section('title')
	{{ $mentor->user->first_name }}
@endsection

@section('content')
<section class="gray-bg">
	<div class="container wrapper padTB50">
		<div class="row nanny-profile-div">
			<div class="col-md-4 col-sm-12 profile-img">
				<div class="profile-div">
					<div class="image-status">
						<div class="js-profile-pic" style='background-image: url({{ $mentor->profile_pic ? $mentor->profile_pic : asset("images/avatar-placeholder.png") }})'></div>
						
						@if($mentor->user->isOnline())
						    <span class="status online">Online</span>
						@else
							<span class="status offline">Offline</span>
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="main-details">
					<h2 class="profile-title"><em>{{ $mentor->user->first_name }}</em>,<span> {{ $mentor->city }}{{ isset($distance) ? ', ' . $distance . 'km' : '' }}</span></h2>
					@if($mentor->job_description)
					<p class="m-0">{{ $mentor->job_description }}</p>
					@endif	
				</div>
				@if(Auth::check() && Auth::user()->role != 'admin' && Auth::user()->id != $mentor->user->id)			
				<div class="btn-div padT20 padB40">
					@if(Auth::check())
						<form id="msgMentor" action='{{ url("contact/add/{$mentor->user->id}") }}' method="post">
						@csrf
							<input type="hidden" name="role" value="mentor">
							<button class="custom-btn btn-green btn-green-whitebg">Message Me</button>
						</form>						
					@endif										
				</div>
				@endif
				<div class="trainings-offered pb-3">
					<h5 class="green">Trainings or workshop offered:</h5>
					<ul class="list-box">
						@foreach ( $trainings as $key => $training )
							@if($training != null)	
								<li>{{ $training }}</li>	
							@endif
						@endforeach	
					</ul>	
				</div>
				
			</div>
		</div>
	</div>
</section>
<section class="mentor profile">
	<div class="container wrapper padTB50">
		<div class="row">
			<div class="col-md-8">

				@if($mentor->general_text)
				<div class="profile-row">
					<h2 class="profile-title">My Intention:</h2>
					<p>{!! $mentor->general_text !!}</p>
				</div>
				@endif

				@if(count($languages) > 0)
				<div class="profile-disc-item">
					<h2 class="profile-title">Spoken Language:</h2>
					<ul class="list-block">
						@foreach ( $languages as $key=>$language )
							@if($language != 'other')	
								<li>{{ $language }}</li>
							@endif
						@endforeach	
					</ul>
				</div>
				@endif

				@if(count($agendas)>0)
				<!-- Agenda Section -->
				<div class="row">
					<div class="col-8">
						<h4>Agenda:</h4>
					</div>
					<div class="col-8">
						<div class="agenda-wrapper pt-3">
							<div class="agenda-accordion-repeater">
							 	<div id="agenda-accordion">

							 		@foreach($agendas as $key => $agenda)
							 		<!-- Accordion Start Here -->
							 		<div class="card">
							 			<div class="card-header " id="heading{{$key}}">
							 				<h5 class="mb-0">
							 					<button class="accordion-toggle btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}" >
							 						{{ $agenda->title }}
							 					</button>
							 				</h5>
							 			</div>
							 			<div id="collapse{{$key}}" class="collapse" aria-labelledby="heading{{$key}}" data-parent="#agenda-accordion">
									      	<div class="card-body">
									      		@if($agenda->description)
									      		<div>
								      				<div class="info-left">
										        		<p class="agenda-para">Description:</p>
										        	</div>
										        	<div class="info-right">
										        		{!! $agenda->description !!}
										        	</div>
								      			</div>
								      			@endif

								      			<!-- Start Slider here -->
									      		<div class="agenda-slider">

									      			@foreach($agenda->details as $i => $detail)
									      			<!-- Start card-repeater here -->
										      		<div class="card-repeater">

										      			<div class="calendar-i-wrapper">

										      				@php
										      					$dates = explode(", ", $detail->dates);
										      				@endphp

										      				@foreach($dates as $date)

										      					@php
											      					$date = explode("/", $date);
											      					$date = strtotime($date[0].'-'.$date[1].'-'.$date[2]);
											      				@endphp
											      				
													        	<div class="calendar-i-repeater">
													        		<div class="top-month">{{date('M',$date)}}</div>
													        		<div class="bottom-date">
													        			<div>{{date('d',$date)}}</div>
													        			<div class="day-of-week">{{date('D',$date)}}</div>
													        		</div>
													        		
													        	</div>
												        	@endforeach
												        	

											        	</div> <!-- end of calendar-i-wrapper --> 

											        	<div class="agenda-details">
											        		<div class="row pt-2">
												        		<div class="col-3">
												        			<p class="agenda-para">Session:</p>
												        		</div>
												        		<div class="col-5">
												        			<p>{{count($dates)}} session{{count($dates)>1 ? 's' : ''}}</p>
												        		</div>
												        	</div>
												        	
												        	<div class="row pt-2">
												        		<div class="col-3">
												        			<p class="agenda-para">Time:</p>
												        		</div>
												        		<div class="col-5">
												        			<p>{{date('H:i',strtotime($detail->start_time))}} - {{date('H:i',strtotime($detail->end_time))}} CET</p>
												        		</div>
												        	</div>
												        	@if($detail->venue)
												        	<div class="row pt-2">
												        		<div class="col-3">
												        			<p class="agenda-para">Venue:</p>
												        		</div>
												        		<div class="col-5">
												        			<p>{{$detail->venue}}</p>
												        		</div>
												        	</div>
												        	@endif
												        	<div class="row pt-2">
												        		<div class="col-3">
												        			<p class="agenda-para">Language:</p>
												        		</div>
												        		<div class="col-5">
												        			<p>{{$detail->language}}{{$detail->other_language ? ', ' . $detail->other_language : ''}}</p>
												        		</div>
												        	</div>
												        	@if($detail->fee)
												        	<div class="row pt-2">
												        		<div class="col-3">
												        			<p class="agenda-para">Fee:</p>
												        		</div>
												        		<div class="col-5">
												        			<p>€{{$detail->fee}}</p>
												        		</div>
												        	</div>
												        	@endif
												        	@if($detail->promo)
												        	<div class="row pt-2">
												        		<div class="col-3">
												        			<p class="agenda-para">Promo:</p>
												        		</div>
												        		<div class="col-5">
												        			<p>{{$detail->promo}}</p>
												        		</div>
												        	</div>
												        	@endif
												        	
											        	</div> <!-- end of agenda-details -->
											        	<div class="accrdn-page-number">
											        		<span class="page-number"></span>
											        	</div>
										      		</div> <!-- end of card-repeater --> 
										      		@endforeach
										      		
									      		</div> <!-- end of agenda slider -->
									      	</div>
									    </div>
							 		</div>
							 		<!-- Accordion Ends Here -->
							 		@endforeach

							 		
							 	</div> <!-- end of agenda-accordion -->
						 	</div> <!-- end of agenda-accordion-repeater -->
						</div> <!-- end of agenda wrapper -->
					</div><!-- end of agenda col -->
				</div> <!-- end of agenda section row -->
				@endif
				
			</div>
			<div class="col-md-4">				
				<div class="profile-disc-item">					
					<h2 class="profile-title review-title text-center">Reviews</h2>
					@if(Auth::check() && (Auth::user()->role == 'parent' || Auth::user()->role == 'sitter'))
					<div id="reviewForm" class="col-md-12 text-center">
						<form method="POST" action='{{ url("mentors/review/{$mentor->user_id}") }}'>
						@csrf							
							<div class="form-group">								
						    	<textarea rows="4" name="review" class="form-control" required="required"></textarea>
							</div>
							<div class="form-group rating">
								<label>
								    <input type="radio" name="rating" value="0" checked="checked" />								    
							    </label>
								<label>
								    <input type="radio" name="rating" value="1" />
								    <span class="icon">★</span>
							    </label>
							    <label>
								    <input type="radio" name="rating" value="2" />
								    <span class="icon">★</span>
								    <span class="icon">★</span>
							    </label>
							    <label>
								    <input type="radio" name="rating" value="3" />
								    <span class="icon">★</span>
								    <span class="icon">★</span>
								    <span class="icon">★</span>   
							    </label>
							    <label>
								    <input type="radio" name="rating" value="4" />
								    <span class="icon">★</span>
								    <span class="icon">★</span>
								    <span class="icon">★</span>
								    <span class="icon">★</span>
							    </label>
							    <label>
								    <input type="radio" name="rating" value="5" />
								    <span class="icon">★</span>
								    <span class="icon">★</span>
								    <span class="icon">★</span>
								    <span class="icon">★</span>
								    <span class="icon">★</span>
							    </label>							
							</div>
						  	<div class="form-group btn-div review-btn text-center">
						  		@error('g-recaptcha-response')
								<span class="help-block error" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
						  		@if(config('services.google.captcha_key'))
								    <div class="g-recaptcha"
								        data-sitekey="{{config('services.google.captcha_key')}}">
								    </div>
								@endif
						  		<button type="submit" class="custom-btn btn-green btn-green-whitebg">Submit</button>
						  	</div>
						</form>
					</div>
					<div class="btn-div review-btn text-center">						
						<a href="#" class="submit-review-btn">Submit a review</a>
					</div>
					@endif
					<div class="reviews-div gray-bg">
						<div class="reviews">
						@if(count($reviews) > 0)
							@foreach($reviews as $review)
							<div class="review-item">
								<div class="stars">
									<ul>
										
										@for($x = 1; $x <= 5; $x++)
										    @if($x <= $review->rating)
										    	<li>
													<img src="{{ asset('images/Path_1341.png') }}" alt="rating-star">
												</li>
										    @else
										    	<li>
													<img src="{{ asset('images/Path_1340.png') }}" alt="rating-star">
												</li>
										    @endif
										@endfor
										@if(Auth::check())
		                                    @if(Auth::user()->id == $review->user_id)
		                                        <div class="review-actions">                                              
		                                            <form method="POST" action='{{url("mentors/review/delete/{$review->id}")}}'>
		                                                @csrf
		                                                @method('DELETE')  
		                                                <button class="dlt-btn"><i class="fas fa-trash-alt"></i></button>
		                                            </form>                                        
		                                        </div>
		                                    @endif
		                                @endif   
										
									</ul>
								</div>
								
								<div class="review-content">
									<p>
										{{ $review->review }} 
									</p>
								</div>								

								<div class="review-footer">
									<span class="reviewer-name">{{ $review->user->first_name }}</span>
									<span class="review-time">{{ $review->created_at->diffForHumans() }}</span>
								</div>
							</div>
							@endforeach
						@else
							<div class="p-2 text-center">
								<p>No reviews yet for this mentor.</p>
							</div>
						@endif							
						</div>
						<nav aria-label="..." class="d-flex justify-content-center blog-pagination">
						   {{ $reviews->appends(Request::except('page'))->links() }}
						</nav>
					</div>
				</div>
			</div>
		</div>
		<div class="row padT30">
			<div class="container wrapper">
				<div class="connect-wrap">
					<p class="green">For intake, registration and further information:</p>
					<button class="custom-btn btn-green btn-green-whitebg mt-3" data-toggle="modal" data-target="#connect-modal">Connect With Me</button>
				</div>	
			</div>
		</div>
		<div class="row padT30">
			<div class="container wrapper">

				@if(Auth::user()->role == 'admin')
					<a href="/admin/users" class="custom-btn btn-green btn-green-whitebg">< back to list</a>					
				@elseif(Auth::user()->role == 'mentor')
					<a href="/mentors/dashboard" class="custom-btn btn-green btn-green-whitebg">< back to dashboard</a>
				@else
					<a href="/search/mentors" class="custom-btn btn-green btn-green-whitebg">< back to list</a>
				@endif

				
			</div>
		</div>
	</div>
</section>

<!-- Connect Mentor Modal -->
<div class="modal fade" id="connect-modal" tabindex="-1" role="dialog" aria-labelledby="mentor-modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content profile-modal">
            <div class="modal-header">
            	<div class="pic" style="background-image: url({{ $mentor->profile_pic }});">	
            	</div>                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row align-items-end padB15">
                    <div class="col-12 col-sm-6 profile-modal-top">
                        <h4 class="m-0">{{ $mentor->user->first_name }}</h4>     
                        <p class="city">{{ $mentor->city }}</p>                   
                    </div>
                    <div class="col-12 col-sm-6 profile-modal-top">
                        @if($mentor->user->isOnline())
						    <span class="status online">Online</span>
						@else
							<span class="status offline">Offline</span>
						@endif
                    </div> 
                </div>
                <div class="row align-items-center padTB15 border-top-bot">
                    <div class="col-md-12">
                        @if($mentor->job_description)
							<p class="m-0">{{ $mentor->job_description }}</p>
						@endif	
                    </div>
                </div>
                <div class="row align-items-center padT15">
                    <div class="col-md-12">
                        <div class="profile-modalWlist">
                            <strong class="green">Trainings & workshops offered:</strong>
                            <ul class="list-divider trainings">
                            	@foreach ( $trainings as $key => $training )
									@if($training != null)	
										<li>{{ $training }}</li>	
									@endif
								@endforeach	
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center padT25 padB10">
                    <div class="col-md-12">
                    	<p class="m-0"><i class="fas fa-envelope green"></i> {{ $mentor->email }}</p>
                    	<p class="m-0 mt-2"><i class="fas fa-phone green"></i> {{ $mentor->number }}</p>
                    	@php
                    		$link = $mentor->website;
                    		$scheme = parse_url($link, PHP_URL_SCHEME);
                    	@endphp
                    	@if(empty($scheme))
                    		@php
    							$link = '//' . ltrim($link, '/');
    						@endphp
                    	@endif
                    	<p class="m-0 mt-2"><i class="fas fa-globe green"></i> <a class="green" href="{{ $link }}" target="_blank">{{ preg_replace("(^https?://)", "", $mentor->website ) }}</a></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
            	<div class="form-group text-center">
	            	@if(Auth::check() && Auth::user()->role != 'admin' && Auth::user()->id != $mentor->user->ids)		
					<div class="btn-div padT20 padB40">
						@if(Auth::check())
							<form id="msgMentor" action='{{ url("contact/add/{$mentor->user->id}") }}' method="post">
							@csrf
								<input type="hidden" name="role" value="mentor">
								<button class="custom-btn btn-green btn-green-whitebg">Message Me</button>
							</form>						
						@endif										
					</div>
					@endif     
					<a href="/search/mentors" class="green">back to Mentors list</a>         
				</div>
            </div>
        </div>
    </div>
</div>
<!-- END -->

<!-- END -->
@endsection