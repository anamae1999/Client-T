@extends('layouts.layout')

@section('title')
	{{ $sitter->user->first_name }}
@endsection

@section('content')
<section class="gray-bg nanny profile">
	<div class="container wrapper padTB50">	
		@if(Session::has('response'))
		    <div class="alert alert-success">
		        {{ Session::get('response') }}
		    </div>
		@endif
		<div class="row nanny-profile-div">			
			<div class="col-md-4 col-sm-12 profile-img">
				<div class="profile-div">
					<div class="image-status">
						<div class="js-profile-pic" style='background-image: url({{ $sitter->profile_pic ? $sitter->profile_pic : asset("images/avatar-placeholder.png") }})'>
							<!-- @if(!empty($vetting))
								@if($vetting->status == 'verified' && $settings->vetting == 1)
									<img class="verified-badge-mobile{{ !empty($nannyBadge) ? ' vetting-badge' : ''}}" src="{{ asset('images/verified-badge.png') }}">
								@endif				
							@endif -->
							<div class="verified-badge-mobile" style="float:top;">
							@if(!empty($nannyBadge))				
								<img  src="{{ $nannyBadge }}">								
							@endif
							@if(!empty($nannyBadge2))				
								<img  src="{{ $nannyBadge2 }}">								
							@endif
							@if(!empty($nannyBadge3))				
								<img  src="{{ $nannyBadge3 }}">								
							@endif
							@if(!empty($nannyBadge4))				
								<img  src="{{ $nannyBadge4 }}">								
							@endif
							@if(!empty($nannyBadge5))				
								<img  src="{{ $nannyBadge5 }}">								
							@endif
						   </div>
						</div>
						
						@if($sitter->user->isOnline())
						    <span class="status online">Online</span>
						@else
							<span class="status offline">Offline</span>
						@endif

						@if($sitter->user->account_type == 'premium')
						<div class="premium-status">
							<img src="{{ asset('images/newpremiumbagde.png') }}" style="">
						</div>
						@endif
					</div>
				</div>
			</div>
			<!-- @if(!empty($vetting))
				@if($vetting->status == 'verified' && $settings->vetting == 1)
					<img class="verified-badge{{ !empty($nannyBadge) ? ' vetting-badge' : ''}}" src="{{ asset('images/verified-badge.png') }}">
				@endif				
			@endif -->
						
		  								

			<div class="verified-badge" style="display:flex;">
			<div >
			@if(!empty($nannyBadge))			
				<img  class="verified-badgem" src="{{ $nannyBadge }}">
				@endif
		  @if(!empty($nannyBadge2))
			<img  class="verified-badgem" src="{{ $nannyBadge2 }}">	
		  @endif
		   @if(!empty($nannyBadge3))
			<img  class="verified-badgem" src="{{ $nannyBadge3 }}">	
		  @endif
		   @if(!empty($nannyBadge4))
			<img  class="verified-badgem" src="{{ $nannyBadge4 }}">	
		  @endif
		   @if(!empty($nannyBadge5))
			<img  class="verified-badgem" src="{{ $nannyBadge5 }}">	
		  @endif
			</div>	
			</div>					

			
			<div class="col-md-8">
				<div class="main-details">
					
					@if(!empty($vetting) && $vetting->status == 'verified' && $settings->vetting == 1)
						<h2 class="profile-title v-badge-s"><em>{{ $sitter->user->first_name }},</em><span> {{ $age }}, {{ $sitter->city }}{{ isset($distance) && Auth::user()->role != 'admin' ? ', ' . $distance . 'km' : '' }}</span></h2>
					@else
						<h2 class="profile-title"><em>{{ $sitter->user->first_name }},</em><span> {{ $age }}, {{ $sitter->city }}{{ isset($distance) && Auth::user()->role != 'admin' ? ', ' . $distance . 'km' : '' }}</span></h2>
					@endif
						

					@if($sitter->job_description && $sitter->years_of_experience)
					<p class="profile-disc mb-0">{{ $sitter->job_description }}, {{ $sitter->years_of_experience }} years experience</p>
					@endif	

					@if($sitter->hourly_rate)
					<p class="profile-hourly-rate m-0">&euro; {{ $sitter->hourly_rate }} hourly rate</p>
					@endif	

					@if($sitter->begin_date)
					<p class="begin-date">Start date of job: {{ date("d/m/Y", strtotime($sitter->begin_date)) }}</p>
					@endif
				</div>
				<div class="profile-dates pb-3{{ !empty($vetting) && ($vetting->status == 'verified') && ($settings->vetting == 1) ? ' with-vetting' : '' }}">
					<h4 class="mb-2">Availability</h4>
					<table cellpadding="0" cellspacing="0" border="0" width="100%" class="desktop-sched-cal">
						<tbody>
							<tr>
								<td>Time</td>
								<td>Mon</td>
								<td>Tue</td>
								<td>Wed</td>
								<td>Thu</td>
								<td>Fri</td>
								<td>Sat</td>
								<td>Sun</td>
							</tr>
							<tr>
								<td>00:00 - 06:00</td>
								@foreach($schedColumns as $schedColumn)
									@if(strpos($schedColumn, 'dawn') !== false)	
										<td>
											<span class='green-box {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
										</td>
									@endif
								@endforeach	
							</tr>
							<tr>
								<td>06:00 - 12:00</td>
								@foreach($schedColumns as $schedColumn)
									@if(strpos($schedColumn, 'morning') !== false)	
										<td>
											<span class='green-box {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
										</td>
									@endif
								@endforeach	
							</tr>
							<tr>
								<td>12:00 - 18:00</td>
								@foreach($schedColumns as $schedColumn)
									@if(strpos($schedColumn, 'afternoon') !== false)	
										<td>
											<span class='green-box {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
										</td>
									@endif
								@endforeach								
							</tr>
							<tr>
								<td>18:00 - 00:00</td>
								@foreach($schedColumns as $schedColumn)
									@if(strpos($schedColumn, 'evening') !== false)	
										<td>
											<span class='green-box {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
										</td>
									@endif
								@endforeach	
							</tr>
						</tbody>
					</table>
					<!-- SCHEDULE FOR MOBILE START-->
					<table cellpadding="0" cellspacing="0" border="0" width="100%" class="mobile-sched-cal">
						<tbody>
							<tr>
								<td>Day</td>
								<td class="sched">00:00<br>06:00</td>
								<td class="sched">06:00<br>12:00</td>
								<td class="sched">12:00<br>18:00</td>
								<td class="sched">18:00<br>00:00</td>										
							</tr>
							<tr>
								<td>Mon</td>
								@foreach($schedColumns as $schedColumn)
									@if(strpos($schedColumn, 'mon') !== false)	
										<td>
											<span class='green-box {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
										</td>
									@endif
								@endforeach									
							</tr>
							<tr>
								<td>Tue</td>
								@foreach($schedColumns as $schedColumn)
									@if(strpos($schedColumn, 'tue') !== false)	
										<td>
											<span class='green-box {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
										</td>
									@endif
								@endforeach	
							</tr>
							<tr>
								<td>Wed</td>
								@foreach($schedColumns as $schedColumn)
									@if(strpos($schedColumn, 'wed') !== false)	
										<td>
											<span class='green-box {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
										</td>
									@endif
								@endforeach	
							</tr>
							<tr>
								<td>Thu</td>
								@foreach($schedColumns as $schedColumn)
									@if(strpos($schedColumn, 'thu') !== false)	
										<td>
											<span class='green-box {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
										</td>
									@endif
								@endforeach	
							</tr>
							<tr>
								<td>Fri</td>
								@foreach($schedColumns as $schedColumn)
									@if(strpos($schedColumn, 'fri') !== false)	
										<td>
											<span class='green-box {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
										</td>
									@endif
								@endforeach	
							</tr>
							<tr>
								<td>Sat</td>
								@foreach($schedColumns as $schedColumn)
									@if(strpos($schedColumn, 'sat') !== false)	
										<td>
											<span class='green-box {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
										</td>
									@endif
								@endforeach	
							</tr>
							<tr>
								<td>Sun</td>
								@foreach($schedColumns as $schedColumn)
									@if(strpos($schedColumn, 'sun') !== false)	
										<td>
											<span class='green-box {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
										</td>
									@endif
								@endforeach
							</tr>
						</tbody>
					</table>
					<!-- SCHEDULE FOR MOBILE END -->
				</div>
				@if(Auth::user()->role == 'parent' || Auth::user()->role == 'mentor')	
					<div class="btn-div">		
						@if(Auth::user()->account_type == 'premium' || !empty($userIsMyContact) || Auth::user()->role == 'mentor')
							<form id="msgParent" action='{{ url("contact/add/{$sitter->user->id}") }}' method="post">
							@csrf
								<input type="hidden" name="role" value="sitter">
								<button class="custom-btn btn-green btn-green-whitebg">Message Me</button>
							</form>	
						@else						
							<button class="custom-btn btn-green btn-green-whitebg" data-toggle="modal" data-target="#msg-modal">Message Me</button>
						@endif	
										
					</div>
				@endif
			</div>
		</div>
	</div>
</section>
<section class="nanny profile">
	<div class="container wrapper padTB50">
		<div class="row">
			<div class="col-md-8">

				@if(count($qualifications) > 0)
				<div class="profile-disc-item">
					<h2 class="profile-title">Qualifications</h2>
					<ul class="box items-col-3 list-block">	
						@foreach ( $qualifications as $qualification )
							@if($qualification != 'other')
								<li>{{ $qualification }}</li>
							@endif
						@endforeach	
					</ul>
				</div>
				@endif

				@if(count($stagesExperience) > 0)
				<div class="profile-disc-item">
					<h2 class="profile-title">Ages & Stages Experience</h2>
					<ul class="box items-col-3 list-block">
						@foreach ( $stagesExperience as $stageExperience )
							@if($stageExperience != 'other')
								<li>{{ $stageExperience }}</li>
							@endif
						@endforeach							
					</ul>
				</div>
				@endif

				@if(count($activities) > 0)
				<div class="profile-disc-item">
					<h2 class="profile-title">Activities for Kids</h2>
					<ul class="box items-col-3 list-block">
						@foreach ( $activities as $activity )
							@if($activity != 'other')
								<li>{{  $activity }}</li>
							@endif
						@endforeach							
					</ul>
				</div>
				@endif

				@if(count($additionalServices) > 0)
				<div class="profile-disc-item">
					<h2 class="profile-title">Additional Services</h2>
					<ul class="box items-col-3  list-block">
						@foreach ( $additionalServices as $additionalService )
							@if($additionalService != 'other')
								<li>{{ $additionalService }}</li>
							@endif
						@endforeach							
					</ul>
				</div>
				@endif

				@if($sitter->general_text)
				<div class="profile-disc-item">
					<h2 class="profile-title">My Story</h2>
					<p>{!! $sitter->general_text !!}</p>
				</div>
				@endif

				<div class="row">
					<div class="col-md-6">
						@if($sitter->mother_tongue)
						<div class="profile-disc-item">
							<h2 class="profile-title">Mother Tongue</h2>
							<ul>
								<li>{{ $sitter->mother_tongue }}</li>
							</ul>
						</div>
						@endif
					</div>
					<div class="col-md-6">
						@if(count($languages) > 0)
						<div class="profile-disc-item">
							<h2 class="profile-title">Language Skills</h2>
							<ul class="list-block">
								@foreach ( $languages as $key=>$language )
									@if($language != 'other')	
										<li>{{ $language }}</li>
									@endif
								@endforeach	
							</ul>
						</div>
						@endif
					</div>
				</div>
				@if($sitter->city)
				<div class="profile-disc-item mt-3">
					<h2 class="profile-title">Location Map</h2>
					<div class="mapouter">
						<div class="gmap_canvas">
							@php
								$mapSrc = 'https://www.google.com/maps/embed/v1/place?key='.$googleKey.'&zoom=15&q=' . str_replace(' ', '', $sitter->zip_code) . '+' . str_replace(' ', '%20', $sitter->city);
							@endphp

							<iframe width="100%" height="300" id="gmap_canvas" src="{{ $mapSrc }}" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
							Google Maps Generator by <a href="https://www.embedgooglemap.net">embedgooglemap.net</a>
						</div>
					</div>
				</div>
				@endif

				@if(Auth::check() && Auth::user()->role == 'admin')
				<div class="profile-disc-item mt-3">
					<h2 class="profile-title">Work References</h2>
					@foreach ( $references as $reference )	
						<div class="reference-item p-3 mt-3">
							<div><span class="green">Name:</span> {{ $reference->first_name }} {{ $reference->last_name }}</div>
							<div><span class="green">Contact Number:</span> {{ $reference->contact_number }}</div>
							<div><span class="green">Email:</span> {{ $reference->email }}</div>
						</div>
					@endforeach
				</div>
				@endif
			</div>
			<div class="col-md-4">				
				<div class="profile-disc-item">					
					<h2 class="profile-title review-title text-center">Reviews</h2>
					@if(Auth::user()->account_type == 'premium' && Auth::user()->role == 'parent')
					<div id="reviewForm" class="col-md-12 text-center">
						<form method="POST" action='{{ url("nannies/review/{$sitter->user_id}") }}'>
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
		                                            <form method="POST" action='{{url("nannies/review/delete/{$review->id}")}}'>
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
									@if(!empty($review->user->first_name))
									<span class="reviewer-name">{{ $review->user->first_name }}</span>
									@endif
									<span class="review-time">{{ $review->created_at->diffForHumans() }}</span>
								</div>
							</div>
							@endforeach
						@else
							<div class="p-2 text-center">
								<p>No reviews yet for this nanny.</p>
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

				@if(Auth::user()->role == 'admin')
					<a href="/admin/users" class="custom-btn btn-green btn-green-whitebg">< back to list</a>					
				@elseif(Auth::user()->role == 'sitter')
					<a href="/nannies/dashboard" class="custom-btn btn-green btn-green-whitebg">< back to dashboard</a>
				@else
					<a href="/search/nannies" class="custom-btn btn-green btn-green-whitebg">< back to list</a>
				@endif
				
			</div>
		</div>
	</div>
</section>


<!-- Message Modal -->
<div class="modal fade" id="msg-modal" tabindex="-1" role="dialog" aria-labelledby="msg-modalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content login-signup-modal msg-modal">
			<div class="modal-header">
				<div class="container">
					<div class="row align-items-center text-center">
						<div class="col-12">
							<img class="message-modal-img" src="{{ asset('images/TinyStepsLogo.svg') }}">
						</div>
						<div class="col-12 mt-3">
							<p class="modal-title" >Subscribe for premium membership to be able to send first message.</p>							
						</div>
					</div>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<a href="/parents/settings/#payment" class="custom-btn btn-green btn-green-whitebg white">Subscribe</a>
			</div>
		</div>
	</div>
</div>
<!-- END -->
@endsection