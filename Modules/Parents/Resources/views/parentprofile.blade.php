@extends('layouts.layout')

@section('title')
	{{ $guardian->user->first_name }}
@endsection

@section('content')
<section class="gray-bg">
	<div class="container wrapper padTB50">
		<div class="row nanny-profile-div">
			<div class="col-md-4 col-sm-12 profile-img">
				<div class="profile-div">
					<div class="image-status">
						<div class="js-profile-pic" style='background-image: url({{ $guardian->profile_pic ? $guardian->profile_pic : asset("images/avatar-placeholder.png") }})'></div>
						
						@if($guardian->user->isOnline())
						    <span class="status online">Online</span>
						@else
							<span class="status offline">Offline</span>
						@endif
						
						
						@if($guardian->user->account_type == 'premium')
						<div class="premium-status">
							<img src="{{ asset('images/premium-badge.png') }}">
							<h4>Premium Member</h4>
						</div>
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="main-details">
					<h2 class="profile-title">{{ $guardian->user->first_name }},<span> {{ $guardian->city }}{{ isset($distance) && Auth::user()->role != 'admin' ? ', ' . $distance . 'km' : '' }}</span></h2>	
					@if($guardian->job_description)
						<p class="profile-disc mb-0">Looking for {{ $guardian->job_description }}</p>					
					@endif	

					@if($guardian->hourly_rate)
					<p class="profile-hourly-rate m-0">€ {{ $guardian->hourly_rate }} hourly rate</p>
					@endif	

					@if($guardian->begin_date)
					<p class="begin-date">Start date of job: {{ date("d/m/Y", strtotime($guardian->begin_date)) }}</p>
					@endif	
												
				</div>
				<div class="profile-dates pb-3">
					<h4 class="mb-2">Days Needed</h4>
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
				@if(Auth::user()->role == 'sitter' || Auth::user()->role == 'mentor')	
					<div class="btn-div">
						@if(Auth::user()->account_type == 'premium' || !empty($userIsMyContact) || Auth::user()->role == 'mentor')
							<form id="msgParent" action='{{ url("contact/add/{$guardian->user->id}") }}' method="post">
							@csrf
								<input type="hidden" name="role" value="parent">
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
<section>
	<div class="container wrapper padTB50">
		<div class="row">
			<div class="col-md-12">
				@if(count($stagesExperience) > 0)
				<div class="profile-disc-item">
					<h2 class="profile-title">Ages & Stages Experience Needed</h2>
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
				<div class="profile-disc-item mb30">
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
			</div>
			<div class="col-md-7">
				@if(count($additionalServices) > 0)
				<div class="profile-disc-item">
					<h2 class="profile-title">Additional Services</h2>
					<ul class="box items-col-3 list-block">
						@foreach ( $additionalServices as $additionalService )

							@if($additionalService != 'other')
								<li>{{ $additionalService }}</li>
							@endif

						@endforeach							
					</ul>
				</div>
				@endif
				
				@if($guardian->general_text)
				<div class="profile-disc-item">
					<h2 class="profile-title">Our Story</h2>
					<p>{!! $guardian->general_text !!}</p>
				</div>
				@endif
				

				@if($guardian->city)
				<div class="profile-disc-item">
					<h2 class="profile-title">Location Map</h2>
					<div class="mapouter">
						<div class="gmap_canvas">

							@php
								$mapSrc = 'https://www.google.com/maps/embed/v1/place?key='.$googleKey.'&zoom=15&q=' . str_replace(' ', '', $guardian->zip_code) . '+' . str_replace(' ', '%20', $guardian->city);
							@endphp

							<iframe width="100%" height="300" id="gmap_canvas" src="{{ $mapSrc }}" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
							Google Maps Generator by <a href="https://www.embedgooglemap.net">embedgooglemap.net</a>
						</div>
					</div>
				</div>
				@endif
			</div>
			<div class="col-md-5">

				<div class="profile-disc-item">
					<h2 class="profile-title">Children Info</h2>

					@if(!empty($genderAges))
						@for( $i=0; $i < count($genderAges[0]); $i++ )
							<ul>
								<li>{{ $genderAges[1][$i] }} yr old</li>
								<li>{{ ucfirst($genderAges[0][$i]) }}</li>
							</ul>
						@endfor
					@endif			
							
				</div>

				@if($guardian->mother_tongue)
				<div class="profile-disc-item">
					<h2 class="profile-title">Mother Tongue</h2>
					<ul>
						<li>{{ $guardian->mother_tongue }}</li>
					</ul>
				</div>
				@endif

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
		<div class="row padT30">
			<div class="container wrapper">
				@if(Auth::user()->role == 'admin')
					<a href="/admin/users" class="custom-btn btn-green btn-green-whitebg">< back to list</a>			
				@elseif(Auth::user()->role == 'parent')
					<a href="/parents/dashboard" class="custom-btn btn-green btn-green-whitebg">< back to dashboard</a>
				@else
					<a href="/search/parents" class="custom-btn btn-green btn-green-whitebg">< back to list</a>
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
				<a href="/nannies/settings/#payment" class="custom-btn btn-green btn-green-whitebg white">Subscribe</a>
			</div>
		</div>
	</div>
</div>
<!-- END -->
@endsection