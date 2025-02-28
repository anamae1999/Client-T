@extends('layouts.layout')

@section('title', $page->meta_titles)
@section('description', $page->meta_descriptions)
@section('keywords', $page->meta_keywords)

@if(!empty($settings->headhtml))
	@section('headhtml')
		@php
			$dom = new DOMDocument;
			$dom->loadHTML($settings->headhtml);
			$html = $dom->saveHTML();

			echo $html;
		@endphp
	@endsection
@endif

@section('content')
	
	@if($settings->cookie == 1)
		@include('cookieConsent::index')
	@endif

	@if(Session::has('unauthorized'))
        <div class="alert-secondary text-center p-5">
            {{ Session::get('unauthorized') }}
            {{ Session::get('deactivated') }}
        </div>
    @endif

    @if(Session::has('response'))
	    <div class="alert alert-success">
	        {{ Session::get('response') }}
	    </div>
	@endif

	@if($showSection['banner'] == 'show')
		<section class="banner home" @if($passedContents['banner-bg']) style="background-image: url({{ $passedContents['banner-bg'] }});" @endif>
			<div class="container-fluid banner-bg">
				<div class="container wrapper">
					<div class="row align-items-center justify-content-end banner-content">
						<div class="col-xl-6 col-md-6 col-sm-8">

							@if($passedContents['banner-title'])
								<div class="marB40">{!! $passedContents['banner-title'] !!}</div>
							@endif
							<form action='{{ url("/search") }}' method="get" class="search-loc marB40">
							@csrf
																	
								<div class="form-group custom-radio-green">
									<div class="custom-control custom-radio custom-control-inline">

										@if(Auth::check() && Auth::user()->role == 'mentor')
											<input type="radio" class="custom-control-input" id="customRadio" name="role" value="parents" required="required">
									    	<label class="custom-control-label" for="customRadio">Find a parent</label>
										@else
									    	<input type="radio" class="custom-control-input" id="customRadio" name="role" value="parents" required="required" 
									    	@if(Auth::check())
									    		{{Auth::user()->role == 'sitter' ? 'checked' : 'disabled'}}
									    	@endif								    	
									    	>
									    	<label class="custom-control-label" for="customRadio">I'm a nanny</label>
								    	@endif
									</div>
								  	<div class="custom-control custom-radio custom-control-inline">
								  		@if(Auth::check() && Auth::user()->role == 'mentor')
											<input type="radio" class="custom-control-input" id="customRadio2" name="role" value="nannies" required="required">
									    	<label class="custom-control-label" for="customRadio2">Find a nanny</label>
										@else
									    	<input type="radio" class="custom-control-input" id="customRadio2" name="role" value="nannies" required="required" 
									    	@if(Auth::check())
									    		{{Auth::user()->role == 'parent' ? 'checked' : 'disabled'}}
									    	@endif
									    	>
									    	<label class="custom-control-label" for="customRadio2">I'm a parent</label>
								    	@endif
								    	
								  	</div>								  	
								</div>
								
							  	<div class="form-group btn-group full justify-content-md-center mb-0 blkOn420">
									<div class="home-loc-input">
										@if(Auth::check() && Auth::user()->role != 'admin')
											@if(Auth::user()->role == 'sitter')
												@php
												 	$func = 'sitterProfile';
										        @endphp	
										    @elseif(Auth::user()->role == 'parent')  
										    	@php
												 	$func = 'guardianProfile';
										        @endphp	
										    @elseif(Auth::user()->role == 'mentor')  
										    	@php
												 	$func = 'mentorProfile';
										        @endphp
										    @endif
							    		<input type="search" class="form-control" id="search" name="search-location" value="{{ str_replace(' ', '', Auth::user()->$func->zip_code) }}" maxlength="6">
							    		@else
							    		<input type="search" class="form-control" id="search" name="search-location" placeholder="1012AA" maxlength="6">
							    		@endif
									</div>
									<div class="home-loc-button">
							  			<button type="submit" class="custom-btn btn-green">Search&nbsp;Nearby</button>
									</div>
								</div>
							</form>

							@if(Auth::guest())
								@if($passedContents['banner-sign-up-title'])
									<h3>
										<a class="white" href="" data-toggle="modal" data-target="#sign-up-modal" id="sign-up">{{ $passedContents['banner-sign-up-title'] }}</a>
									</h3>
								@endif

								@if($passedContents['banner-content'])
									{!! $passedContents['banner-content'] !!}
								@endif
							@endif
						</div>
					</div>
				</div>
			</div>
		</section>
	@endif

	@if($showSection['nannies-and-babysitters'] == 'show')
		<section class="padTB50">
			<div class="container">
				<div class="row text-center">
					<div class="col-xl-12 section-title-content">
						@if($passedContents['nannies-title'])
							<h2 class="section-title">{{ $passedContents['nannies-title'] }}</h2>
						@endif

						@if($passedContents['nannies-content'])
							{!! $passedContents['nannies-content'] !!}
						@endif
					</div>
				</div>
			</div>
			<div class="container header-wrapper ">
				<div class="row featured-nanny-slider">	
					@foreach($users as $user)
					<div class="">
						<div class="slider-container">
							<div class="nanny-img">
								@if(!is_null($user->sitterProfile->date_of_birth))
									@php
									 	$birthDate = explode("/", $user->sitterProfile->date_of_birth);
							        @endphp
						        @else
							    	@php
									 	$birthDate = '';
							        @endphp	
						        @endif

						        @if($birthDate)
							        @php
							            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
							        @endphp
							    @else
								    @php
										$age = '';
								    @endphp	
						        @endif

						        @php
						        	$stagesExperience = explode(", ", $user->sitterProfile->stages_experience);	
									$activities = explode(", ", $user->sitterProfile->activities);
									$addtlServices = explode(", ", $user->sitterProfile->additional_services);
						        @endphp

						        @if(count($stagesExperience) > 0)
									@php
										$stagesExperienceList = '';
									@endphp
										@foreach ( $stagesExperience as $stageExperience )
											@if($stageExperience != 'other')
												@php
												$stagesExperienceList = $stagesExperienceList . '<li>' . str_replace(" |",",",$stageExperience) . '</li>';
												@endphp
											@endif
										@endforeach		
							    @endif

							    @if(count($activities) > 0)
									@php
										$activitiesList = '';
									@endphp
										@foreach ( $activities as $activity )
											@if($activity != 'other')
												@php
												$activitiesList = $activitiesList . '<li>' . str_replace(" |",",",$activity) . '</li>';
												@endphp
											@endif
										@endforeach		
							    @endif

							    @if(count($addtlServices) > 0)
									@php
										$addtlServicesList = '';
									@endphp
										@foreach ( $addtlServices as $addtlService )
											@if($addtlService != 'other')
												@php
												$addtlServicesList = $addtlServicesList . '<li>' . str_replace(" |",",",$addtlService) . '</li>';
												@endphp
											@endif
										@endforeach		
							    @endif

							    @if($user->isOnline())
							   		@php
										$status = '<span class="status online">Online</span>';
									@endphp
								@else
									@php
										$status = '<span class="status offline">Offline</span>';
									@endphp
								@endif

								@php
									$time = ['dawn','morning','afternoon','evening','mon','tue','wed','thu','fri','sat','sun'];

									$dawn = '<td>00:00 - 06:00</td>';
									$morning = '<td>06:00 - 12:00</td>';
									$afternoon = '<td>12:00 - 18:00</td>';
									$evening = '<td>18:00 - 00:00</td>';
									$mon = '<td>Mon</td>';
									$tue = '<td>Tue</td>';
									$wed = '<td>Wed</td>';
									$thu = '<td>Thu</td>';
									$fri = '<td>Fri</td>';
									$sat = '<td>Sat</td>';
									$sun = '<td>Sun</td>';
								@endphp

								@foreach($schedColumns as $schedColumn)	

									@if(strpos($schedColumn, 'dawn') !== false)	
									
										@if($user->schedule[$schedColumn] == 1)
											@php
												$schedColumn = $schedColumn . ' active';
											@endphp
										@endif										
										@php								
											$dawn = $dawn . '<td><span class="green-box '. $schedColumn .'"></span></td>';
										@endphp
									@endif

									@if(strpos($schedColumn, 'morning') !== false)

										@if($user->schedule[$schedColumn] == 1)
											@php
												$schedColumn = $schedColumn . ' active';
											@endphp
										@endif										
										@php								
											$morning = $morning . '<td><span class="green-box '. $schedColumn .'"></span></td>';
										@endphp

									@endif

									@if(strpos($schedColumn, 'afternoon') !== false)

										@if($user->schedule[$schedColumn] == 1)
											@php
												$schedColumn = $schedColumn . ' active';
											@endphp
										@endif										
										@php								
											$afternoon = $afternoon . '<td><span class="green-box '. $schedColumn .'"></span></td>';
										@endphp
									@endif

									@if(strpos($schedColumn, 'evening') !== false)

										@if($user->schedule[$schedColumn] == 1)
											@php
												$schedColumn = $schedColumn . ' active';
											@endphp
										@endif	

										@php								
											$evening = $evening . '<td><span class="green-box '. $schedColumn .'"></span></td>';
										@endphp

									@endif

									@if(strpos($schedColumn, 'mon') !== false)	
										@if($user->schedule[$schedColumn] == 1)
											@php
												$schedColumn = $schedColumn . ' active';
											@endphp
										@endif

										@php								
											$mon = $mon . '<td><span class="green-box '. $schedColumn .'"></span></td>';
										@endphp										
									@endif

									@if(strpos($schedColumn, 'tue') !== false)	
										@if($user->schedule[$schedColumn] == 1)
											@php
												$schedColumn = $schedColumn . ' active';
											@endphp
										@endif

										@php								
											$tue = $tue . '<td><span class="green-box '. $schedColumn .'"></span></td>';
										@endphp										
									@endif

									@if(strpos($schedColumn, 'wed') !== false)	
										@if($user->schedule[$schedColumn] == 1)
											@php
												$schedColumn = $schedColumn . ' active';
											@endphp
										@endif

										@php								
											$wed = $wed . '<td><span class="green-box '. $schedColumn .'"></span></td>';
										@endphp										
									@endif


									@if(strpos($schedColumn, 'thu') !== false)	
										@if($user->schedule[$schedColumn] == 1)
											@php
												$schedColumn = $schedColumn . ' active';
											@endphp
										@endif

										@php								
											$thu = $thu . '<td><span class="green-box '. $schedColumn .'"></span></td>';
										@endphp										
									@endif


									@if(strpos($schedColumn, 'fri') !== false)	
										@if($user->schedule[$schedColumn] == 1)
											@php
												$schedColumn = $schedColumn . ' active';
											@endphp
										@endif

										@php								
											$fri = $fri . '<td><span class="green-box '. $schedColumn .'"></span></td>';
										@endphp										
									@endif

									@if(strpos($schedColumn, 'sat') !== false)	
										@if($user->schedule[$schedColumn] == 1)
											@php
												$schedColumn = $schedColumn . ' active';
											@endphp
										@endif

										@php								
											$sat = $sat . '<td><span class="green-box '. $schedColumn .'"></span></td>';
										@endphp										
									@endif

									@if(strpos($schedColumn, 'sun') !== false)	
										@if($user->schedule[$schedColumn] == 1)
											@php
												$schedColumn = $schedColumn . ' active';
											@endphp
										@endif

										@php								
											$sun = $sun . '<td><span class="green-box '. $schedColumn .'"></span></td>';
										@endphp										
									@endif


								@endforeach	
							

								@if($user->account_type == 'premium')
										@php

										$actype = 'premium' ;

										@endphp
							    @else
							            @php

										$actype = 'free' ;

										@endphp 
								@endif

								

								<a href="#" data-toggle="modal" data-target="#user-modal"
								data-id="{{ $user->id }}"
								data-pic="{{ $user->sitterProfile->profile_pic ? $user->sitterProfile->profile_pic : asset('images/avatar-placeholder.png') }}" 
								data-gender="{{ $user->sitterProfile->gender }}"
								data-exp="{{ $user->sitterProfile->years_of_experience }}"
								data-fname="{{ $user->first_name }}" 
								data-city="{{ $user->sitterProfile->city }}" 
								data-age="{{ $age }}"
								data-job="{{ $user->sitterProfile->job_description }}"	
								data-stages="{{ $stagesExperienceList }}"
								data-activities="{{ $activitiesList }}"
								data-services="{{ $addtlServicesList }}"
								data-desc="{{ $user->sitterProfile->general_text }}"
								data-status="{{ $status }}"
								data-dawn="{{ $dawn }}"
								data-morning="{{ $morning }}"
								data-afternoon="{{ $afternoon }}"
								data-evening="{{ $evening }}"	
								data-mon="{{ $mon }}"
								data-tue="{{ $tue }}"
								data-wed="{{ $wed }}"
								data-thu="{{ $thu }}"
								data-fri="{{ $fri }}"
								data-sat="{{ $sat }}"
								data-sun="{{ $sun }}"
								data-link="/nannies/profile/{{$user->id}}/{{strtolower($user->first_name)}}"
								data-hourlyrate="{{ $user->sitterProfile->hourly_rate }}"
								data-qualification="{{ $user->sitterProfile->qualifications}}"
								data-mothert="{{$user->sitterProfile->mother_tongue }}"
								data-lang="{{ $user->sitterProfile->languages }}"
								data-bapic="<img  class='badgeimg' src='{{$user->screening->bandge_img1}}'>"
								data-bbpic="<img  class='badgeimg' src='{{$user->screening->bandge_img2}}'>"
								data-bcpic="<img  class='badgeimg' src='{{$user->screening->bandge_img3}}'>"
								data-bdpic="<img  class='badgeimg' src='{{$user->screening->bandge_img4}}'>"
								data-bepic="<img  class='badgeimg' src='{{$user->screening->bandge_img5}}'>"
								data-premium="<img class='imgpop' src='https://tinysteps.nl/uploads/Super Nanny Badge-TinySteps_SuperNannyBadge_Desktop.png'>"
								data-premiumtxt="<p class='premiumpop'>Premium Badge</p>"
								data-accounttype= "{{$actype}}"  
								>
									<div class="overlay"></div>
									<div class="featured-nanny-slider-img" style='background-image: url({{$user->sitterProfile->profile_pic ? $user->sitterProfile->profile_pic : asset("images/avatar-placeholder.png") }});'>
										
									</div>
									<ul>
										<li>{{$user->first_name}}</li>
										@if($user->sitterProfile->city)
										<li><span class="loc-pin"><i class="fas fa-map-marker-alt"></i>{{ucwords($user->sitterProfile->city)}}</span></li>
										@endif
										<li>
											@if($user->isOnline())
										   		<span class="status online">Online</span>
											@else
												<span class="status offline">Offline</span>
											@endif
											
										</li>
									</ul>
								</a>
							</div>
						@if($user->account_type == 'premium')
						<img style="max-width: 50px;margin-top: -55px;position: absolute; margin-left: 155px;" class="imgsearch" src="{{ asset('images/newpremiumbagde.png') }}">
						@else
						<p></p>
				        @endif
							@if($user->role == 'sitter')
											
											
							        		<div id="badgediv" class="row align-items-center padTB15" style="padding-bottom:10px;justify-content: center;">
							        			@if(empty($user->screening->bandge_img1))
							        			@else
							        			<img class="listimg" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $user->screening->bandge_img1}}">
							        			@endif
							        			@if(empty($user->screening->bandge_img2))
							        			@else
							        			<img id="img2" class="listimg" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $user->screening->bandge_img2}}">
							        			@endif
							        			@if(empty($user->screening->bandge_img3))
							        			@else
							        			<img class="listimg" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $user->screening->bandge_img3}}">
							        			@endif
							        			@if(empty($user->screening->bandge_img4))
							        			@else
							        			<img class="listimg" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $user->screening->bandge_img4}}">
							        			@endif
							        			@if(empty($user->screening->bandge_img5))
							        			@else
							        			<img class="listimg" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $user->screening->bandge_img5}}">
							        			@endif
							                </div>
							@endif

							<div class="intro">
								@if($user->sitterProfile->job_description)
									<strong>{{$user->sitterProfile->job_description}}</strong>
								@endif

								@if(!is_null($user->sitterProfile->activities)) 
									@php
										$activities = explode(", ", $user->sitterProfile->activities);
									@endphp
								@else
									@php
										$activities = [];
									@endphp
								@endif								

								@if(count($activities) > 0)
								<p class="mt-2 green"><strong>Activities for kids:</strong></p>
									<ul class="list-divider">
										@foreach ( $activities as $activity )
											@if($activity != 'other')
												<li>{{  $activity }}</li>
											@endif
										@endforeach							
									</ul>
								@endif


							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</section>
	@endif

	@if($showSection['how-it-works'] == 'show')
		<section class="how-it-works gray-bg">
			<div class="container wrapper padTB50">

				@if($passedContents['how-it-works-title'] || $passedContents['how-it-works-content'])
				<div class="row text-center">
					<div class="col-xl-12 section-title-content">
						@if($passedContents['how-it-works-title'])
							<h2 class="section-title">{{ $passedContents['how-it-works-title'] }}</h2>
						@endif

						@if($passedContents['how-it-works-content'])
							{!! $passedContents['how-it-works-content'] !!}
						@endif
					</div>
				</div>
				@endif

				<div class="row row-eq-height">

					@if($passedContents['how-it-works-col1-title'] || $passedContents['how-it-works-col1-img'] || $passedContents['how-it-works-col1-content'])
					<div class="col-xl-4 col-md-4 col-sm-12 text-center how-it-works-item">

						@if($passedContents['how-it-works-col1-title'])
							<h2 class="steps-item-title">{{ $passedContents['how-it-works-col1-title'] }}</h2>
							<div class="vertical-line orange-line"></div>
						@endif

						@if($passedContents['how-it-works-col1-img'])												
							<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['how-it-works-col1-img'] }}">
						@endif

						@if($passedContents['how-it-works-col1-content'])
							<span class="how-it-works-item-disc">{!! $passedContents['how-it-works-col1-content'] !!}</span>
						@endif
					</div>
					@endif

					@if($passedContents['how-it-works-col2-title'] || $passedContents['how-it-works-col2-img'] || $passedContents['how-it-works-col2-content'])
					<div class="col-xl-4 col-md-4 col-sm-12 text-center how-it-works-item">

						@if($passedContents['how-it-works-col2-title'])
							<h2 class="steps-item-title">{{ $passedContents['how-it-works-col2-title'] }}</h2>
							<div class="vertical-line orange-line"></div>
						@endif

						@if($passedContents['how-it-works-col2-img'])												
							<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['how-it-works-col2-img'] }}">
						@endif

						@if($passedContents['how-it-works-col2-content'])
							<span class="how-it-works-item-disc">{!! $passedContents['how-it-works-col2-content'] !!}</span>
						@endif
					</div>
					@endif

					@if($passedContents['how-it-works-col3-title'] || $passedContents['how-it-works-col3-img'] || $passedContents['how-it-works-col3-content'])
					<div class="col-xl-4 col-md-4 col-sm-12 text-center how-it-works-item">

						@if($passedContents['how-it-works-col3-title'])
							<h2 class="steps-item-title">{{ $passedContents['how-it-works-col3-title'] }}</h2>
							<div class="vertical-line orange-line"></div>
						@endif

						@if($passedContents['how-it-works-col3-img'])												
							<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['how-it-works-col3-img'] }}">
						@endif

						@if($passedContents['how-it-works-col3-content'])
							<span class="how-it-works-item-disc">{!! $passedContents['how-it-works-col3-content'] !!}</span>
						@endif
					</div>
					@endif
				</div>

				@if($passedContents['how-it-works-btn-text'])
				<div class="row text-center">
					<div class="col-xl-12 how-it-works-link-div">
						<a class="how-it-works-link" href="{{ $passedContents['how-it-works-btn-link'] }}">{{ $passedContents['how-it-works-btn-text'] }}</a>
					</div>
				</div>
				@endif
			</div>
		</section>
	@endif

	<!--NAMZ AMARO ADDED -->
	@if($showSection['screening'] == 'show')
		<section class="how-it-works">
			<div class="container screenwrapper padTB50">
				<div class="text-center">
					<div class="col-xl-12 section-title-content">
						@if($passedContents['screening-title'])
						<h2 class="section-title">{{ $passedContents['screening-title'] }}</h2>
						@endif
					</div>
				</div>

				<div class="row">
					<div class="screen-auth col-sm-12 col-md-6">
						<div class="auth">
				        <div class="screen"><img class="screenimg" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['steps-screens-contentimg1'] }}"></div>
				        @if($passedContents['screening-content'])
						<div class="screentext">
							{!! $passedContents['screening-content'] !!}
                        </div>
                        @endif
						</div>
					</div>

					<div class="screen-auth col-sm-12 col-md-6">
						<div class="auth">
				        <div class="screen"><img  class="screenimg" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['steps-screens-contentimg2'] }}"></div>
				        @if($passedContents['screening-content1'])
						<div class="screentext">
							{!! $passedContents['screening-content1'] !!}
                        </div>
                        @endif
						</div>
					</div>
				</div>

			</div>
		</section>
	@endif
<!-- 	END -->


	<!-- @if($showSection['screening'] == 'show')
		<section class="screening">
			<div class="container wrapper padTB50">

				@if($passedContents['screening-title'] || $passedContents['screening-content'])
				<div class="row text-center">
					<div class="col-xl-12 section-title-content">
						@if($passedContents['screening-title'])
							<h2 class="section-title">{{ $passedContents['screening-title'] }}</h2>
						@endif

						@if($passedContents['screening-content'])
							{!! $passedContents['screening-content'] !!}
						@endif
					</div>
				</div>
				@endif
			</div>
		</section>
	@endif -->

	@if($showSection['testimonials'] == 'show')

		@if(count($testimonials) > 0 || Auth::check() && Auth::user()->account_type == 'premium')
		<section class="padTB50 gray-bg">

			@if($passedContents['testi-title'])
			<div class="container">
				<div class="row text-center">
					<div class="col-xl-12 section-title-content">
						<h2 class="section-title">{{ $passedContents['testi-title'] }}</h2>
					</div>
				</div>
			</div>
			@endif

			<div class="container header-wrapper">
				<div class="row testimonial-slider">

					@if(count($testimonials) > 0)
					    @foreach($testimonials as $testimonial)
						<div class='testi-item {{count($testimonials) <= 2 ? "bor-left" : ""}}'>

							<div class="slider-container">
								<div class="testi-content">
									<em><p>{{ $testimonial->testi_content }}</p></em>
								</div>
								<div class="testi-author text-right">
									<em><p>{{ $testimonial->testi_author }}</p></em>
								</div>
								<div class="testi-rating">
									@for($x = 1; $x <= 5; $x++)
									    @if($x <= $testimonial->testi_rating)
									    	
											<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ asset('images/star-rate.png') }}" alt="rating-star">
											
									    @else
									    	
											<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ asset('images/star-rate-1.png') }}" alt="rating-star">
											
									    @endif
									@endfor
								</div>
							</div>

						</div>
						@endforeach
			    	@else
						<div class="testi-item text-center">
							<p>Be the first one to send us a testimonial!</p>
						</div>													
					@endif	


				</div>
				@if(Auth::check() && Auth::user()->account_type == 'premium')
				<div id="testiWrap" class="add-testi-wrap mt-5">
					<div id="testiForm" class="col-12 col-md-6 text-center mx-auto mt-5 p-3 white-bg">
						<form method="POST" action='{{ url("/add/testimonial") }}'>
						@csrf							
							<div class="form-group">								
						    	<textarea rows="4" name="content" class="form-control" required="required"></textarea>
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
						  	<div class="form-group btn-div text-center">
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
					<div class="btn-div testi-btn text-center">						
						<a href="#" class="submit-testi-btn custom-btn btn-green btn-green-whitebg">Submit a testimonial</a>
					</div>					
				</div>
				@endif
			</div>		
		</section>
		@endif
	@endif

	@if($showSection['cta-1st'] == 'show' && Auth::guest())
		<section class="brown-bg register-now-section">
			<div class="container wrapper padTB50">
				<div class="row align-items-center">
					<div class="col-xl-8 col-md-7 text-center">
					{!! $passedContents['cta-1st-title'] !!}
					</div>
					<div class="col-xl-4 col-md-5 register-now-button text-center">

						@if($passedContents['cta-1st-btn-text'])
							<a class="custom-btn btn-green" href="" data-toggle="modal" data-target="#sign-up-modal" id="sign-up">{{ $passedContents['cta-1st-btn-text'] }}</a>
						@endif
						
					</div>
				</div>
			</div>
		</section>
	@endif

	<!-- mentors -->
	@if($showSection['mentors'] == 'show')
		<section class='padTB50 {{count($testimonials) > 0 ? "" : "gray-bg"}}'>
			<div class="container">
				<div class="row text-center">
					<div class="col-xl-12 section-title-content">
						@if($passedContents['mentors-title'])
							<h2 class="section-title">{{ $passedContents['mentors-title'] }}</h2>
						@endif

						@if($passedContents['mentors-content'])
							{!! $passedContents['mentors-content'] !!}
						@endif
					</div>
				</div>
			</div>
			<div class="container header-wrapper ">
				<div class="row featured-nanny-slider">
					@foreach($mentors as $mentor)
					<div class="">
						<div class="slider-container">
							<div class="nanny-img">
							    @if($mentor->isOnline())
							   		@php
										$status = '<span class="status online">Online</span>';
									@endphp
								@else
									@php
										$status = '<span class="status offline">Offline</span>';
									@endphp
								@endif

								@php
						        	$trainings = explode(", ", $mentor->mentorProfile->trainings);	
						        @endphp

								@if(count($trainings) > 0)
									@php
										$trainingsList = '';
									@endphp
										@foreach ( $trainings as $training )
											
												@php
												$trainingsList = $trainingsList . '<li>' . str_replace(" |",",",$training) . '</li>';
												@endphp
											
										@endforeach		
							    @endif

								<a href="#" data-toggle="modal" data-target="#mentor-modal"
								data-id="{{ $mentor->id }}"
								data-pic="{{ $mentor->mentorProfile->profile_pic }}" 								
								data-fname="{{ $mentor->first_name }}" 
								data-city="{{ $mentor->mentorProfile->city }}" 								
								data-job="{{ $mentor->mentorProfile->job_description }}"									
								data-trainings="{{ $trainingsList }}"		
								data-desc="{{ $mentor->mentorProfile->general_text }}"
								data-status="{{ $status }}"								
								data-link="/mentors/profile/{{$mentor->id}}/{{strtolower($mentor->first_name)}}"
								>
									<div class="overlay"></div>
									<div class="featured-nanny-slider-img" style='background-image: url({{ $mentor->mentorProfile->profile_pic ? $mentor->mentorProfile->profile_pic : asset("images/avatar-placeholder.png") }});'>
										
									</div>
									<ul>
										<li>{{$mentor->first_name}}</li>
										@if($mentor->mentorProfile->city)
										<li><span class="loc-pin"><i class="fas fa-map-marker-alt"></i>{{ucwords($mentor->mentorProfile->city)}}</span></li>
										@endif
										<li>
											@if($mentor->isOnline())
										   		<span class="status online">Online</span>
											@else
												<span class="status offline">Offline</span>
											@endif
											
										</li>
									</ul>
								</a>
							</div>
							<div class="intro">
								@if($mentor->mentorProfile->job_description)
									<strong>{{$mentor->mentorProfile->job_description}}</strong>
								@endif

								@if(!is_null($mentor->mentorProfile->trainings)) 
									@php
										$trainings = explode(", ", $mentor->mentorProfile->trainings);
									@endphp
								@else
									@php
										$trainings = [];
									@endphp
								@endif								

								@if(count($trainings) > 0)
								<p class="mt-2 green"><strong>Trainings & workshops offered:</strong></p>
									<ul class="list-divider">
										@foreach ( $trainings as $training )
											<li>{{  $training }}</li>
										@endforeach							
									</ul>
								@endif	
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>

			@if($passedContents['mentors-btn-text'])
			<div class="container">
				<div class="row text-center">
					<div class="col-xl-12 how-it-works-link-div">
						<a class="how-it-works-link" href="/search/mentors">{{ $passedContents['mentors-btn-text'] }}</a>
					</div>
				</div>
			</div>
			@endif
		</section>
	@endif

	@if($showSection['services'] == 'show')
		<section class='services {{count($testimonials) > 0 ? "gray-bg" : ""}}'>
			<div class="container wrapper padTB50">
				<div class="row">

					@if($passedContents['services-title1'] || $passedContents['services-image1'] || $passedContents['services-content1'])
					<div class="col-md-4 text-center">
						<div class="name-border-bot-container">
							<a href="#" class="service-modal-link" data-toggle="modal" data-target="#service-nanny-modal">
								<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['services-image1'] }}" alt='{{ str_replace("-", " ", ucfirst(pathinfo($passedContents["services-image1"], PATHINFO_FILENAME))) }}'>
							</a>
							<h2 class="name-border-bot green">
								<a href="#" class="service-modal-link green" data-toggle="modal" data-target="#service-nanny-modal">{{ $passedContents['services-title1'] }}</a>
							</h2>
							<div class="vertical-line green-line"></div>
							{!! $passedContents['services-content1'] !!}
						</div>
					</div>
					@endif

					@if($passedContents['services-title2'] || $passedContents['services-image2'] || $passedContents['services-content2'])
					<div class="col-md-4 text-center">
						<div class="name-border-bot-container">
							<a href="#" class="service-modal-link" data-toggle="modal" data-target="#service-parent-modal">
								<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['services-image2'] }}" alt='{{ str_replace("-", " ", ucfirst(pathinfo($passedContents["services-image2"], PATHINFO_FILENAME))) }}'>
							</a>
							<h2 class="name-border-bot green">
								<a href="#" class="service-modal-link green" data-toggle="modal" data-target="#service-parent-modal">{{ $passedContents['services-title2'] }}</a>
							</h2>
							<div class="vertical-line green-line"></div>
							{!! $passedContents['services-content2'] !!}
						</div>
					</div>
					@endif

					@if($passedContents['services-title3'] || $passedContents['services-image3'] || $passedContents['services-content3'])
					<div class="col-md-4 text-center">
						<div class="name-border-bot-container">
							<a href="#" class="service-modal-link" data-toggle="modal" data-target="#service-mentor-modal">
								<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['services-image3'] }}" alt='{{ str_replace("-", " ", ucfirst(pathinfo($passedContents["services-image3"], PATHINFO_FILENAME))) }}'>
							</a>
							<h2 class="name-border-bot green">
								<a href="#" class="service-modal-link green" data-toggle="modal" data-target="#service-mentor-modal">{{ $passedContents['services-title3'] }}</a>
							</h2>
							<div class="vertical-line green-line"></div>
							{!! $passedContents['services-content3'] !!}
						</div>
					</div>
					@endif
				</div>
			</div>
		</section>
	@endif

	@if($showSection['sitter-types'] == 'show')
		<section class='sitter-types {{count($testimonials) > 0 ? "" : "gray-bg"}}'>
			<div class="container wrapper padTB50">

				@if($passedContents['sitter-types-title'])
				<div class="row text-center">
					<div class="col-xl-12 padB20">
						@if($passedContents['sitter-types-title'])
							<h2 class="section-title">{{ $passedContents['sitter-types-title'] }}</h2>
						@endif
					</div>
				</div>
				@endif

				<div class="row row-eq-height">
					@if($passedContents['sitter-types-content1'])
					<div class="sitter-type-item col-sm-12 col-md-6 col-xl-3">
						<div>
							<center><img class="sitters" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['sitter-image-content1'] }}"></center>
							{!! $passedContents['sitter-types-content1'] !!}							
						</div>
					</div>
					@endif
					@if($passedContents['sitter-types-content2'])
					<div class="sitter-type-item col-sm-12 col-md-6 col-xl-3">
						<div>
							<center><img class="sitters" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['sitter-image-content2'] }}"></center>
							{!! $passedContents['sitter-types-content2'] !!}
						</div>
					</div>
					@endif
					@if($passedContents['sitter-types-content3'])
					<div class="sitter-type-item col-sm-12 col-md-6 col-xl-3">
						<div>
							<center><img class="sitters" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['sitter-image-content3'] }}"></center>
							{!! $passedContents['sitter-types-content3'] !!}
						</div>
					</div>
					@endif
					@if($passedContents['sitter-types-content4'])
					<div class="sitter-type-item col-sm-12 col-md-6 col-xl-3">
						<div>
							<center><img class="sitters" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['sitter-image-content4'] }}"></center>
							{!! $passedContents['sitter-types-content4'] !!}
						</div>
					</div>
					@endif


				
				</div>
			</div>
		</section>
	@endif

	@if(!empty($post))
	<section class='home-blog {{count($testimonials) > 0 ? "gray-bg" : ""}}'>
		<div class="container wrapper padTB50">
			<div class="row align-items-center">
				<div class="col-xl-5 col-md-5 home-blog-img">
					<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $post->post_image ? $post->post_image : asset('/images/image-placeholder.jpg') }}" alt='{{ str_replace("-", " ", ucfirst(pathinfo($post->post_image ? $post->post_image : asset("/images/image-placeholder.jpg"), PATHINFO_FILENAME))) }}'>
				</div>
				<div class="col-xl-7 col-md-7 home-blog-contents">
					<div class="home-blog-title">
						<h4><a href="/blog/inner/{{$post->slug}}" class="green">{{$post->post_title}}</a></h4>
					</div>
					<div class="home-blog-details">
						<p>{{$post->author_name}}</p>
						<p>{{date('d/m/Y', strtotime($post->created_at))}}</p>
					</div>
					<div class="home-blog-content">		
						@php
							$start = strpos($post->post_body, '<p>');
							$end = strpos($post->post_body, '</p>', $start);
							$paragraph = substr($post->post_body, $start, $end-$start+4);	
						@endphp

						{!! strip_tags($paragraph,"<p>") !!}

						@if(strlen($post->post_body) > strlen($paragraph))	
							<span>...</span>							
						@endif							
					</div>
					<div class="home-blog-cta">
						<a class="custom-btn btn-green btn-green-whitebg" href='{{ url("blog/inner/{$post->slug}") }}'>Read More</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	@endif

	<!-- 2nd cta -->
	@if($showSection['cta-2nd'] == 'show' && Auth::guest())
		<section class="brown-bg register-now-section">
			<div class="container wrapper padTB50">
				<div class="row align-items-center">
					<div class="col-xl-8 col-md-7 text-center">
						{!! $passedContents['cta-2nd-title'] !!}
					</div>
					<div class="col-xl-4 col-md-5 register-now-button text-center">
						@if($passedContents['cta-2nd-btn-text'])
							<a class="custom-btn btn-green" href="#" data-toggle="modal" data-target="#sign-up-modal" id="sign-up">{{ $passedContents['cta-2nd-btn-text'] }}</a>
						@endif
					</div>
				</div>
			</div>
		</section>
	@endif

<!-- Service Modal Nanny -->
<div class="modal fade service-modal" id="service-nanny-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body">
            	<button type="button" class="close service-modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="row align-items-end pad20">
                    <div class="col-12">
                        {!! $passedContents['service-modal1'] !!}       					
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- END -->

<!-- Service Modal Parent -->
<div class="modal fade service-modal" id="service-parent-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body">
            	<button type="button" class="close service-modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="row align-items-end pad20">
                    <div class="col-12">
                        {!! $passedContents['service-modal2'] !!}                   
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- END -->

<!-- Service Modal Mentor -->
<div class="modal fade service-modal" id="service-mentor-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body">
            	<button type="button" class="close service-modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="row align-items-end pad20">
                    <div class="col-12">
                        {!! $passedContents['service-modal3'] !!}                   
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- END -->

<!-- Nanny Modal -->
<div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="nanny-modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content profile-modal">
            <div class="modal-header">	
            
            	<div class="pic">	
            	</div>
            	<div class="">
            		<div class="premium"></div>
            		<div class="accounttype" style="visibility:hidden;"></div>
            	</div>              
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row align-items-end padB15">
                    <div class="col-12 col-sm-6 profile-modal-top">
                        <h4 class="m-0"><span class="fname"></span></h4>     
                        <p class="city"></p>                   
                    </div>
                    <div class="col-12 col-sm-6 profile-modal-top">
                        <p class="m-0"><span class="age"></span>, <span class="gender"></span></p>                        
                        <span class="status"></span>
                    </div> 
                </div>

                <div class=" badgespopup row align-items-center padTB15  ">
                	<div class="bapic"></div>
                	<div class="bbpic"></div>
                	<div class="bcpic"></div>
                	<div class="bdpic"></div>
                	<div class="bepic"></div>
                </div>
 
                <div class="row align-items-center padTB15 border-top-bot">
                    <div class="col-md-12">
                        <p class="m-0"><span class="job"></span>, <span class="exp"></span> years Experience</p>
                    </div>
                </div>
                <div class="row align-items-center padT15">
                    <div class="col-md-12">
                        <div class="profile-modalWlist">
                            <strong class="green">Ages & Stages Experience:</strong>
                            <ul class="list-divider stages"></ul>
                        </div>
                        <div class="profile-modalWlist">
                            <strong class="green">Activities for kids:</strong>
                            <ul class="list-divider activities"></ul>
                        </div>
                        <div class="profile-modalWlist">
                            <strong class="green">Additional Services:</strong>
                            <ul class="list-divider services"></ul>
                        </div>
                    </div>
                </div>
                 <div class="row align-items-center padT15">
                	<div class="col-md-12">
                        <strong class="green">Hourly Rate:</strong>
                        <p class=" hourlyrate"></p>
                    </div>
                </div>
                <div class="row align-items-center padT15">
                	<div class="col-md-12">
                        <strong class="green">Qualification:</strong>
                        <p class="qualification"></p>
                    </div>
                </div>
                <div class="row align-items-center padT15">
                	<div class="col-md-12">
                        <strong class="green">Mother Tongue:</strong>
                        <p class="mothert"></p>
                    </div>
                </div>
                  <div class="row align-items-center padT15">
                	<div class="col-md-12">
                        <strong class="green">Other Languages:</strong>
                        <ul class="list-divider lang"></ul>
                    </div>
                </div>
                <br>
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <strong class="green">Available on:</strong>
                    </div>
                    <div class="profile-modal-dates">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="desktop-sched-cal">
                            <tbody>
                                <tr>
                                    <td>Time</td>
                                    <td class="text-center">Mon</td>
                                    <td class="text-center">Tue</td>
                                    <td class="text-center">Wed</td>
                                    <td class="text-center">Thu</td>
                                    <td class="text-center">Fri</td>
                                    <td class="text-center">Sat</td>
                                    <td class="text-center">Sun</td>
                                </tr>
                                <tr class="dawn"></tr>
                                <tr class="morning"></tr>
                                <tr class="afternoon"></tr>
                                <tr class="evening"></tr>
                            </tbody>
                        </table>
                        <!-- SCHEDULE FOR MOBILE START-->
                        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="mobile-sched-cal">
                            <tbody>
                                <tr>
                                    <td>Day</td>
                                    <td class="sched">00:00
                                        <br>06:00</td>
                                    <td class="sched">06:00
                                        <br>12:00</td>
                                    <td class="sched">12:00
                                        <br>18:00</td>
                                    <td class="sched">18:00
                                        <br>00:00</td>                                    
                                </tr>
                                <tr class="mon"></tr>
                                <tr class="tue"></tr>
                                <tr class="wed"></tr>
                                <tr class="thu"></tr>
                                <tr class="fri"></tr>
                                <tr class="sat"></tr>
                                <tr class="sun"></tr>
                                
                            </tbody>
                        </table>
                        <!-- SCHEDULE FOR MOBILE END -->
                    </div>
                </div>
                <div class="row align-items-center padT25 padB10">
                    <div class="col-md-12">
                        <p class="m-0 desc"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
            	<div class="form-group text-center">
            	@if(Auth::guest())
                <a  href="" class="custom-btn btn-green btn-green-whitebg signUp">Sign up to View Profile</a>
                <p class="mt-3">Already have an account?</p>
				<a href="" class="green logIn">Log in</a>
                @else
                	@if(Auth::user()->role != 'sitter')
                	<a href="" class="custom-btn btn-green btn-green-whitebg viewProfile" target="_blank">View Profile</a>
                	@endif
                @endif                
			</div>
            </div>
        </div>
    </div>
</div>
<!-- END -->

<!-- Mentor Modal -->
<div class="modal fade" id="mentor-modal" tabindex="-1" role="dialog" aria-labelledby="mentor-modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content profile-modal">
            <div class="modal-header">
            	<div class="pic">	
            	</div>                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row align-items-end padB15">
                    <div class="col-12 col-sm-6 profile-modal-top">
                        <h4 class="m-0"><span class="fname"></span></h4>     
                        <p class="city"></p>                   
                    </div>
                    <div class="col-12 col-sm-6 profile-modal-top">
                        <span class="status"></span>
                    </div> 
                </div>
                <div class="row align-items-center padTB15 border-top-bot">
                    <div class="col-md-12">
                        <p class="m-0"><span class="job"></span></p>
                    </div>
                </div>
                <div class="row align-items-center padT15">
                    <div class="col-md-12">
                        <div class="profile-modalWlist">
                            <strong class="green">Trainings & workshops offered:</strong>
                            <ul class="list-divider trainings"></ul>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center padT25 padB10">
                    <div class="col-md-12">
                    	<strong class="green">About Me:</strong>
                        <p class="m-0 desc"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
            	<div class="form-group text-center">
            	@if(Auth::guest())
                <a  href="" class="custom-btn btn-green btn-green-whitebg signUp">Sign up to View Profile</a>
                <p class="mt-3">Already have an account?</p>
				<a href="" class="green logIn">Log in</a>
                @else
                <a href="" class="custom-btn btn-green btn-green-whitebg viewProfile" target="_blank">View Profile</a>
                @endif                
			</div>
            </div>
        </div>
    </div>
</div>
<!-- END -->
@endsection

@if(!empty($settings->foothtml))
	@section('foothtml')
		@php
			$dom = new DOMDocument;
			$dom->loadHTML($settings->foothtml);
			$html = $dom->saveHTML();

			echo $html;
		@endphp
	@endsection
@endif