@extends('layouts.layout')
@section('content')

<section class="gray-bg search-page">
	<div class="container wrapper padTB50">
		<div class="row">
			<div class="col-md-12">
				<form method="GET" action='{{ url("/search/{$role}/location") }}' class="search-loc padT40 padB40">
				@csrf
				<input type="hidden" name="job-desc" value="{{ !empty($jobDesc) ? $jobDesc : '' }}">
				  <div class="form-group justify-content-md-center mb-0 clearfix">
				  	<div class="search-zip-input">
				    	@if(Auth::check() && $showRefresh != 1)
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
			    		<input id="search" type="search" class="form-control" id="search" name="search-location" value="{{ str_replace(' ', '', Auth::user()->$func->zip_code) }}" maxlength="6">
			    		@else
			    		<input id="search" type="search" class="form-control" id="search" name="search-location" placeholder="1012AA" maxlength="6" value="{{ !empty($searchWord) ? $searchWord : '' }}">
			    		@endif
				  	</div>
				  	<div class="search-zip-button">
				  		<button type="submit" class="custom-btn btn-green">Search&nbsp;Nearby</button>
				  	</div>
				  </div>
				</form>
			</div>
		</div> 
		<div class="row align-items-center padT50">
			<div class="col-md-12 search-loc-filter-container">

				@if($role == 'nannies')
					<span class="align-middle">Show me:</span>
				@endif

				@if($role == 'parents')
				<div class="col-12">
					<span class="align-middle">Show Parents looking for:</span>					
				</div>					
				@endif			
				
				@if($role == 'nannies' || $role == 'parents')
				<form id="searchJobDesc" method="GET" action='{{ url("/search/{$role}/job") }}' class="search-job-desc d-inline">
				@csrf
					<input type="hidden" name="search-location" value="{{ !empty($searchWord) ? $searchWord : '' }}">
					<div class="form-group custom-radio-green mb-0 d-inline">
						<div class="custom-control custom-radio custom-control-inline">
					    	<input type="radio" class="custom-control-input" id="nanny" name="job-desc" value="Permanent Nanny"
						    	@if($jobDesc == 'Permanent Nanny')
						    		checked="checked" 
						    	@endif
					    	>
					    	<label class="custom-control-label" for="nanny">Permanent Nanny</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="occasionalSitter" name="job-desc" value="Occasional Sitter"
								@if($jobDesc == 'Occasional Sitter')
						    		checked="checked" 
						    	@endif
							>
							<label class="custom-control-label" for="occasionalSitter">Occasional Sitter</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="afterschoolSitter" name="job-desc" value="Afterschool Sitter"
								@if($jobDesc == 'Afterschool Sitter')
						    		checked="checked" 
						    	@endif
							>
							<label class="custom-control-label" for="afterschoolSitter">Afterschool Sitter</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="nightSitter" name="job-desc" value="Night Sitter"
								@if($jobDesc == 'Night Sitter')
						    		checked="checked" 
						    	@endif
							>
							<label class="custom-control-label" for="nightSitter">Night Sitter</label>
						</div>
						@if(Auth::check()) 
							@if(Auth::user()->account_type == 'premium')
							<div class="custom-control custom-radio custom-control-inline">
								<a class="advance-search">Advanced Search</a>
							</div>
							@endif
						@endif
					</div>
				</form>
				@endif
			</div>
		</div>
	</div>
</section>
<section>
	<div class="container wrapper padTB50">
		@if(count($users) > 0)
		<div class="search-notification pad15">
			<p>{{ $users->total() }} {{ $role }} found. 
				@if($showRefresh == 1)
					@if($role == 'nannies')
						<a class="green ml-2" href="/search/nannies">Clear Search</a>
					@endif

					@if($role == 'parents')
						<a class="green ml-2" href="/search/parents">Clear Search</a>				
					@endif	

					@if($role == 'mentors')
						<a class="green ml-2" href="/search/mentors">Clear Search</a>				
					@endif				
				@endif
			</p>
		</div>
		@endif

		<div class="row search-result">
			
				@if(count($users) > 0)
                    @foreach($users as $user)
                        <div class="col-sm-6 col-lg-4 search-result-item padB50">
							<div class="profile-div">


								@if(Auth::guest())

									@if($user->isOnline())
								   		@php
											$status = '<span class="status online">Online</span>';
										@endphp
									@else
										@php
											$status = '<span class="status offline">Offline</span>';
										@endphp
									@endif

									@if($user->role == 'sitter' || $user->role == 'parent')
								    	@if($user->role == 'sitter')
											@php
											 	$func = 'sitterProfile';
									        @endphp	
									    @elseif($user->role == 'parent')  
									    	@php
											 	$func = 'guardianProfile';
									        @endphp	
									    @endif

									    @if(!is_null($user->$func->date_of_birth))
											@php
											 	$birthDate = explode("/", $user->$func->date_of_birth);
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
								        	$stagesExperience = explode(", ", $user->$func->stages_experience);	
											$activities = explode(", ", $user->$func->activities);
											$addtlServices = explode(", ", $user->$func->additional_services);
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

								        @if($role == 'nannies')
								        @php
								        $img1= $user->screening->bandge_img1;
								        $img2= $user->screening->bandge_img2;
								        $img3= $user->screening->bandge_img3;
								        $img4= $user->screening->bandge_img4;
								        $img5= $user->screening->bandge_img5;
								        @endphp
								        @else 
								        @php
								        $img1= ' ' ;
								        $img2= ' ' ;
								        $img3= ' ' ;
								        $img4= ' ' ;
								        $img5= ' ' ;
								        @endphp
								        @endif		

										<a href="#" data-toggle="modal" data-target="#user-modal"
							    		data-id="{{ $user->id }}"
										data-pic="{{ $user->$func->profile_pic ? $user->$func->profile_pic : asset('images/avatar-placeholder.png') }}" 
										data-gender="{{ ucfirst($user->$func->gender) }}"
										data-exp="{{ $user->$func->years_of_experience }}"
										data-fname="{{ $user->first_name }}"
										data-city="{{ $user->$func->city }}" 
										data-age="{{ $age }}"
										data-job="{{ $user->$func->job_description }}"																
										data-desc="{{ $user->$func->general_text }}"
										data-status="{{ $status }}"
										data-stages="{{ $stagesExperienceList }}"
										data-activities="{{ $activitiesList }}"
										data-services="{{ $addtlServicesList }}"
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
										data-bapic="<img  class='badgeimg' src='{{$img1}}'>"
										data-bbpic="<img  class='badgeimg' src='{{$img2}}'>"	
										data-bcpic="<img  class='badgeimg' src='{{$img3}}'>"	
										data-bdpic="<img  class='badgeimg' src='{{$img4}}'>"	
										data-bepic="<img  class='badgeimg' src='{{$img5}}'>"
										data-hourlyrate="{{ $user->$func->hourly_rate }}"	
										data-qualification="{{ $user->$func->qualifications}}"	
										data-mothert="{{$user->$func->mother_tongue }}"	
										data-lang="{{ $user->$func->languages }}"		
										data-premium="<img class='imgpop' src='{{ asset('images/newpremiumbagde.png') }}'>"		
										data-accounttype= "{{$actype}}" 

										data-link='{{ $func == "sitterProfile" ? "/nannies" : "/parents"}}/profile/{{$user->id}}/{{strtolower($user->first_name)}}'
										>			
									@endif

								    @if($user->role == 'mentor')  
								    	@php
										 	$func = 'mentorProfile';
								        @endphp	

								        @php
								        	$trainings = explode(", ", $user->$func->trainings);	
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
										data-id="{{ $user->id }}"
										data-pic="{{ $user->$func->profile_pic }}" 								
										data-fname="{{ $user->first_name }}" 
										data-city="{{ $user->$func->city }}" 								
										data-job="{{ $user->$func->job_description }}"									
										data-trainings="{{ $trainingsList }}"		
										data-desc="{{ $user->$func->general_text }}"
										data-status="{{ $status }}"								
										data-link="/mentors/profile/{{$user->id}}/{{strtolower($user->first_name)}}"
										>
							        @endif	
							    		

								@else
									@if($user->role == 'sitter')
									<a href="/nannies/profile/{{$user->sitterProfile->user_id}}/{{strtolower($user->first_name)}}">
																		
									@elseif($user->role == 'parent')
									<a href="/parents/profile/{{$user->guardianProfile->user_id}}/{{strtolower($user->first_name)}}">

									@elseif($user->role == 'mentor')
									<a href="/mentors/profile/{{$user->mentorProfile->user_id}}/{{strtolower($user->first_name)}}">
									@endif

								@endif	

								@if($user->role == 'sitter')									
									<div class="image-status js-profile-pic" style='background-image: url({{ $user->sitterProfile->profile_pic ? $user->sitterProfile->profile_pic : asset("images/avatar-placeholder.png") }})'>						
								@elseif($user->role == 'parent')									
									<div class="image-status js-profile-pic" style='background-image: url({{ $user->guardianProfile->profile_pic ? $user->guardianProfile->profile_pic : asset("images/avatar-placeholder.png") }})'>
								@elseif($user->role == 'mentor')									
									<div class="image-status js-profile-pic" style='background-image: url({{ $user->mentorProfile->profile_pic ? $user->mentorProfile->profile_pic : asset("images/avatar-placeholder.png") }})'>
								@endif	
								@if($user->isOnline())
								    <span class="status online">Online</span>
								@else
									<span class="status offline">Offline</span>
								@endif
									
									</div><!-- ./image-status -->
								</a>
						</div> <!-- ./profile-div -->
						@if($user->account_type == 'premium')	
						<img class="imgsearch" src="{{ asset('images/newpremiumbagde.png') }}">	
				        @endif

							<div class="search-details">
								<div class="padTB20">
									@if($user->role == 'sitter')
										@if($user->sitterProfile->date_of_birth)
											@php
											 	$birthDate = explode("/", $user->sitterProfile->date_of_birth);

									            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
									                ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
									        @endphp
								        @else
								        	@php
								        		$age = '';
								        	@endphp
								        @endif
							        @endif
							        <div class="row">
							        	<div class="col-12">
							        		<h5 class="mb-0">{{ $user->first_name }}{{ $user->role == 'sitter' ? ', ' . $age : '' }}</h5>
							        		@if($user->role == 'sitter')
							        			<h5 class="fontS16 fontW600">{{ $user->sitterProfile->city }}</h5>
							        		@elseif ($user->role == 'parent')
							        			<h5 class="fontS16 fontW600">{{ $user->guardianProfile->city }}</h5>
							        		@elseif ($user->role == 'mentor')	
							        			<h5 class="fontS16 fontW600">{{ $user->mentorProfile->city }}</h5>
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
							        		@if((Auth::check() && Auth::user()->lat && Auth::user()->lng && $user->lat && $user->lng) || isset($guestCoords))
												<span class="loc-pin green"><i class="fas fa-map-marker-alt"></i><em>{{ round($user->distance, 1) }} km</em></span>
											@endif
							        	</div>
							        </div>
								</div>

								@if($user->role == 'sitter' || $user->role == 'parent')
									@if($user->role == 'sitter')
										@php						
											$activities = explode(", ", $user->sitterProfile->activities);
										@endphp
										<div class="padB20">
								      		<p class="m-0">{{ $user->sitterProfile->years_of_experience }} Years experience</p>
										</div>
									@elseif($user->role == 'parent')
										@php
											$stagesExperience = explode(", ", $user->guardianProfile->stages_experience);
											$activities = explode(", ", $user->guardianProfile->activities);	
										@endphp


										@if(!empty($stagesExperience[0]))
										<div class="padB20">
											<strong class="green">Ages &amp; Stages:</strong>
											<ul class="list-divider">

												@foreach ( $stagesExperience as $stageExperience )
													@if($stageExperience != 'other')
													<li>{{ str_replace(" |",",",$stageExperience) }}</li>
													@endif
												@endforeach	
												
											</ul>
									    </div>
									    @endif
									@endif								

								    @if(!empty($activities[0]))
									<div class="padB20">
										<strong class="green">Activities for Kids:</strong>
										<ul class="list-divider">
											@foreach ( $activities as $activity )
												@if($activity != 'other')
												<li>{{ str_replace(" |",",",$activity) }}</li>
												@endif
											@endforeach	
										</ul>
								    </div>
								    @endif			
								@endif

								@if($user->role == 'mentor')
									@php
										$trainings = explode(", ", $user->mentorProfile->trainings);
									@endphp


									@if(!empty($trainings[0]))
									<div class="padB20">
										<strong class="green">Trainings & Workshops Offered:</strong>
										<ul class="list-divider">

											@foreach ( $trainings as $training )
												
												<li>{{ str_replace(" |",",",$training) }}</li>
												
											@endforeach	
											
										</ul>
								    </div>
								    @endif
								@endif
														
							</div>
							<br><br>
							<div class="read-more-btn">
								@if(Auth::guest())
										@if($user->account_type == 'premium')	
										@php	
										$actype = 'premium' ;	
										@endphp	
							            @else	
							            @php	
										$actype = 'free' ;	
										@endphp 	
								        @endif	

								        @if($role == 'nannies')
								        @php
								        $img1= $user->screening->bandge_img1;
								        $img2= $user->screening->bandge_img2;
								        $img3= $user->screening->bandge_img3;
								        $img4= $user->screening->bandge_img4;
								        $img5= $user->screening->bandge_img5;
								        @endphp
								        @else 
								        @php
								        $img1= ' ' ;
								        $img2= ' ' ;
								        $img3= ' ' ;
								        $img4= ' ' ;
								        $img5= ' ' ;
								        @endphp
								        @endif																												
									@if($user->role == 'sitter' || $user->role == 'parent') 				
							    		<a class="custom-btn btn-green btn-green-whitebg" href="#" data-toggle="modal" data-target="#user-modal"
							    		data-id="{{ $user->id }}"
										data-pic="{{ $user->$func->profile_pic ? $user->$func->profile_pic : asset('images/avatar-placeholder.png') }}" 
										data-gender="{{ ucfirst($user->$func->gender) }}"
										data-exp="{{ $user->$func->years_of_experience }}"
										data-fname="{{ $user->first_name }}" 
										data-age="{{ $age }}"
										data-city="{{ $user->$func->city }}"
										data-job="{{ $user->$func->job_description }}"																
										data-desc="{{ $user->$func->general_text }}"
										data-status="{{ $status }}"
										data-stages="{{ $stagesExperienceList }}"
										data-activities="{{ $activitiesList }}"
										data-services="{{ $addtlServicesList }}"
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
										data-bapic="<img  class='badgeimg' src='{{$img1}}'>"
										data-bbpic="<img  class='badgeimg' src='{{$img2}}'>"	
										data-bcpic="<img  class='badgeimg' src='{{$img3}}'>"	
										data-bdpic="<img  class='badgeimg' src='{{$img4}}'>"	
										data-bepic="<img  class='badgeimg' src='{{$img5}}'>"
										data-hourlyrate="{{ $user->$func->hourly_rate }}"	
										data-qualification="{{ $user->$func->qualifications}}"	
										data-mothert="{{$user->$func->mother_tongue }}"	
										data-lang="{{ $user->$func->languages }}"		
										data-premium="<img class='imgpop' src='{{ asset('images/newpremiumbagde.png') }}'>"		
										data-accounttype= "{{$actype}}" 

										>Read More</a>
									@endif

									@if($user->role == 'mentor') 

									    <a class="custom-btn btn-green btn-green-whitebg" href="#" data-toggle="modal" data-target="#mentor-modal"
										data-id="{{ $user->id }}"
										data-pic="{{ $user->$func->profile_pic }}" 								
										data-fname="{{ $user->first_name }}" 
										data-city="{{ $user->$func->city }}" 								
										data-job="{{ $user->$func->job_description }}"									
										data-trainings="{{ $trainingsList }}"		
										data-desc="{{ $user->$func->general_text }}"
										data-status="{{ $status }}"								
										data-link="/mentors/profile/{{$user->id}}/{{strtolower($user->first_name)}}"
										>Read More</a>
							        @endif	

							    @else
							    	@if($user->role == 'sitter')
										<a class="custom-btn btn-green btn-green-whitebg" href="/nannies/profile/{{$user->sitterProfile->user_id}}/{{strtolower($user->first_name)}}">Read More</a>
									@elseif($user->role == 'parent')
										<a class="custom-btn btn-green btn-green-whitebg" href="/parents/profile/{{$user->guardianProfile->user_id}}/{{strtolower($user->first_name)}}">Read More</a>			
									@elseif($user->role == 'mentor')
										<a class="custom-btn btn-green btn-green-whitebg" href="/mentors/profile/{{$user->mentorProfile->user_id}}/{{strtolower($user->first_name)}}">Read More</a>
									@endif
							    @endif
							</div>
						</div>                                   
                    @endforeach
                @else
                	<div class="search-notification pad15">

                		@if(isset($invalidZip))
                			<p>Postal code is not recognized.</p>
                		@endif
                    	<p>No {{ $role }} found.
                    		@if($showRefresh == 1)
								@if($role == 'nannies')
									<a class="green ml-2" href="/search/nannies">Clear Search</a>
								@endif

								@if($role == 'parents')
									<a class="green ml-2" href="/search/parents">Clear Search</a>				
								@endif

								@if($role == 'mentors')
									<a class="green ml-2" href="/search/mentors">Clear Search</a>				
								@endif
							@endif
                    	</p>
                    </div>
                @endif 
		</div>

		<div class="row">
			<div class="col-xl-12 text-center">
				<nav aria-label="..." class="d-flex justify-content-center blog-pagination">
				  {{ $users->appends(Request::except('page'))->links() }}
				</nav>
			</div>
		</div>
	</div>
</section>

@if($role == 'nannies' || $role == 'parents')
<!-- Advanced Search Modal -->
<div class="clearfix">
	<div class="full-WH"></div>
	<div class="search-filter-container">
		<div class="filter-header">
			<h5 class="text-center">Advanced Search</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
		<div class="filter-body">
		
		<form method="GET" action='{{ url("/search/{$role}/advanced") }}' class="form-group form">
		@csrf
			<div class="filter-body-row">
				<h5>Filter:</h5>
			</div>
			<div class="filter-body-row">
				<h6>Availability</h6>
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
							<td><input type="checkbox" name="availability[]" value="mon_dawn" class="green-box" ></td>
							<td><input type="checkbox" name="availability[]" value="tue_dawn" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="wed_dawn" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="thu_dawn" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="fri_dawn" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="sat_dawn" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="sun_dawn" class="green-box"></td>
						</tr>
						<tr>
							<td>06:00 - 12:00</td>
							<td><input type="checkbox" name="availability[]" value="mon_morning" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="tue_morning" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="wed_morning" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="thu_morning" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="fri_morning" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="sat_morning" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="sun_morning" class="green-box"></td>
						</tr>
						<tr>
							<td>12:00 - 18:00</td>
							<td><input type="checkbox" name="availability[]" value="mon_afternoon" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="tue_afternoon" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="wed_afternoon" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="thu_afternoon" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="fri_afternoon" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="sat_afternoon" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="sun_afternoon" class="green-box"></td>
						</tr>
						<tr>
							<td>18:00 - 00:00</td>
							<td><input type="checkbox" name="availability[]" value="mon_evening" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="tue_evening" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="wed_evening" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="thu_evening" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="fri_evening" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="sat_evening" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="sun_evening" class="green-box"></td>
						</tr>						
					</tbody>
				</table>
				<!-- availability start for mobile-->
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
							<td><input type="checkbox" name="availability[]" value="mon_dawn" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="mon_morning" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="mon_afternoon" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="mon_evening" class="green-box"></td>
						</tr>
						<tr>
							<td>Tue</td>
							<td><input type="checkbox" name="availability[]" value="tue_dawn" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="tue_morning" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="tue_afternoon" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="tue_evening" class="green-box"></td>
						</tr>
						<tr>
							<td>Wed</td>
							<td><input type="checkbox" name="availability[]" value="wed_dawn" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="wed_morning" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="wed_afternoon" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="wed_evening" class="green-box"></td>
						</tr>
						<tr>
							<td>Thu</td>
							<td><input type="checkbox" name="availability[]" value="thu_dawn" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="thu_morning" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="thu_afternoon" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="thu_evening" class="green-box"></td>
						</tr>
						<tr>
							<td>Fri</td>
							<td><input type="checkbox" name="availability[]" value="fri_dawn" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="fri_morning" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="fri_afternoon" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="fri_evening" class="green-box"></td>
						</tr>
						<tr>
							<td>Sat</td>
							<td><input type="checkbox" name="availability[]" value="sat_dawn" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="sat_morning" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="sat_afternoon" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="sat_evening" class="green-box"></td>
						</tr>
						<tr>
							<td>Sun</td>
							<td><input type="checkbox" name="availability[]" value="sun_dawn" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="sun_morning" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="sun_afternoon" class="green-box"></td>
							<td><input type="checkbox" name="availability[]" value="sun_evening" class="green-box"></td>
						</tr>
					</tbody>
				</table>
				<!-- availability end -->
			</div>
			<div class="filter-body-row">
				<h6>Hourly Rate (€)</h6>
				<div class="filter-range">
						<input type="text" class="range-val1" name="minRate" id="HourlyfirstVal" readonly>
						<input type="text" class="range-val2" name="maxRate" id="HourlysecondVal" readonly>
						<div id="Hourlyslider-range"></div>
				</div>
			</div>
			@if($role == 'parents')
			<div class="filter-body-row">
				<h6>Age of Children</h6>
				<div class="filter-range">
						<input type="text" class="range-val1" name="minAge" id="AgeChildfirstVal" readonly>
						<input type="text" class="range-val2" name="maxAge" id="AgeChildsecondVal" readonly>
						<div id="AgeChildslider-range"></div>
				</div>
			</div>
			<div class="filter-body-row">
				<h6>Number of Children</h6>
				<div class="filter-range">
						<input type="text" class="range-val1" name="minChild" id="NumChildfirstVal" readonly>
						<input type="text" class="range-val2" name="maxChild" id="NumChildsecondVal" readonly>
						<div id="NumChildslider-range"></div>
				</div>
			</div>
			@endif
			<div class="filter-body-row">
				<h6>Distance (km)</h6>
				<div class="filter-range">
						<input type="text" class="range-val1" name="minDistance" id="DistancefirstVal" readonly>
						<input type="text" class="range-val2" name="maxDistance" id="DistancesecondVal" readonly>
						<div id="Distanceslider-range"></div>
				</div>
			</div>
			<div class="filter-body-row text-center">
				<input type="submit" value="Search" class="custom-btn btn-green btn-green-whitebg filter-button">
			</div>
			<input type="hidden" name="search-location" value="{{ !empty($searchWord) ? $searchWord : '' }}">
			<input type="hidden" name="job-desc" value="{{ $jobDesc }}">
		</form>
		</div>
	</div>
</div>
<!-- End Advanced Search Modal -->


<!-- user modal -->
<div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="nanny-modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content profile-modal">
            <div class="modal-header">
                <div class="pic"></div>
                <div class="">	
            		<div class="premium"></div>	
            		<!-- <div class="premiumtxt"></div> -->	
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
                    	@if($role == 'nannies')
                        <p class="m-0"><span class="age"></span>, <span class="gender"></span></p>
                        @endif
                        <span class="status"></span>
                    </div>                    
                </div>
                  @if($role == 'nannies')
                 <div class=" badgespopup row align-items-center padTB15 ">	
                	<div class="bapic"></div>	
                	<div class="bbpic"></div>	
                	<div class="bcpic"></div>	
                	<div class="bdpic"></div>	
                	<div class="bepic"></div>	
                </div>
                @endif
                <div class="row align-items-center padTB15 border-top-bot">
                    <div class="col-md-12">
                        <p class="m-0">@if($role == 'parents')Looking for @else I'm a @endif<span class="job"></span>@if($role == 'nannies'), <span class="exp"></span> years Experience @endif</p>
                    </div>
                </div>
                <div class="row align-items-center padT15">
                    <div class="col-md-12">                    	
                        <div class="profile-modalWlist">
                            <strong class="green">Ages & Stages Experience:</strong>

                            <!-- populated via JS -->
                            <ul class="list-divider stages"></ul>
                        </div>
                        <div class="profile-modalWlist">
                            <strong class="green">Activities for Kids:</strong>

                             <!-- populated via JS -->
                            <ul class="list-divider activities"></ul>
                        </div>                       
                        <div class="profile-modalWlist">
                            <strong class="green">Additional Services:</strong>

                             <!-- populated via JS -->
                            <ul class="list-divider services"></ul>
                        </div>
                    </div>
                </div>
                @if($role == 'nannies' || $role == 'parents')
                   <div class="row align-items-center padT15">	
                	<div class="col-md-12">	
                        <strong class="green">Hourly Rate:</strong>	
                        <p class=" hourlyrate"></p>	
                    </div>	
                </div>
                @if($role == 'nannies')	
                <div class="row align-items-center padT15">	
                	<div class="col-md-12">	
                        <strong class="green">Qualification:</strong>	
                        <p class="qualification"></p>	
                    </div>	
                </div>
                @endif	
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
                @endif
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
                	<a href="" class="custom-btn btn-green btn-green-whitebg signUp">Sign up to View Profile</a>
					<p class="mt-3">Already have an account?</p>
					<a href="" class="green logIn">Log in</a>
				</div>          
            </div>
        </div>
    </div>
</div>
<!-- END -->
@endif

@if($role == 'mentors')
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
@endif
@endsection