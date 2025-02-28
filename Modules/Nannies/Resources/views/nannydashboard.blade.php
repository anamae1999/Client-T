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
			    <div class="tab-content loaderParent">
			    	<div id="loadingDiv">
						<div class="loader"></div>
					</div>
			    	<div class="tab-pane fade show active">
						<form method="POST" action="{{ url('/nannies/update') }}" class="edit-profile-form" enctype="multipart/form-data">
		      			@csrf
							<div class="table-container bg-white rounded p-md-5 p-3 my-md-3 my-0">
								<div class="row">
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-12">
												<div class="row pb-4">
													<div class="col-xl-9">
														<div class="pb-4 col-details">
															@if(empty($sitter->job_description))
															<div id="no-profile" class="alert alert-info">
											                    Please complete your Profile and submit for screening.
											                </div>
											                @endif

											                @if ($errors->any())
															    <div class="alert alert-danger alert-errors">
															        <ul>			        	
															            @foreach ($errors->all() as $error)
															            	@if(!strpos($error,'bd-month') && !strpos($error,'bd-day') && !strpos($error,'bd-year'))
																            	<li>{{ str_replace("-", " ",$error) }}</li>
															            	@endif				                
															            @endforeach
															            @if ($errors->has('bd-month') || $errors->has('bd-day') || $errors->has('bd-year'))
																            <li>The begin date field is required.</li>
															        	@endif
															        </ul>
															    </div>
															@endif

															@if(!empty($user->screening) && $user->screening->status != 'verified')
															<div class="screening-notice">
																<h5 class="brown">You have requested for screening.</h5>
																<p class="brown">The information that you have submitted will be screened by Tiny Steps.</p>
																<p class="brown">You will receive a notification email for the progress of your application.</p>
			                                                    <div>Your Application Status: <strong>{{ ucfirst($user->screening->application_status) }}</strong></div>
			                                                    <div>Your Screening Status: <strong>{{ ucfirst($user->screening->status) }}</strong></div>
			                                                    @if($user->screening->remarks)	
			                                                    <div class="mt-2"><strong class="brown">Admin Remarks: </strong> {{$user->screening->remarks}}</div>
			                                                    @endif
															</div>		                                                    	       
		                                                    @endif 
															<h4 class="brown m-0">Personal Details</h4>																
														</div>															
														<div class="row pl-3 pt-3 p-xl-0">
															<div class="edit-image-container edit-profile-img text-xl-center text-left order-first order-xl-last">
																	<h6 class="green">Profile Picture</h6>
																	<div class="padT5" id="profile-out">
																		<div class="profile-img-wrap">
																			<img class="profile-photo-frame old-profile-form" src="{{ $sitter->profile_pic ? $sitter->profile_pic : '/images/avatar-placeholder.png' }}" alt="{{ $sitter->user->first_name }} {{ $sitter->user->last_name }}">

																			<img id="profile-img" class="profile-photo-frame new-profile-form hide" src="{{ $sitter->profile_pic ? $sitter->profile_pic : '/images/avatar-placeholder.png' }}" alt="{{ $sitter->user->first_name }} {{ $sitter->user->last_name }}">	
																		</div>
																		
																	</div>
																	<div class="padT5 new-profile-form hide" >
																		<div class="profile-img-wrap">
																			<img class="profile-photo-frame old-profile-form" src="{{ $sitter->profile_pic ? $sitter->profile_pic : '/images/avatar-placeholder.png' }}" alt="{{ $sitter->user->first_name }} {{ $sitter->user->last_name }}">

																			<img id="profile-img-new" class="profile-photo-frame new-profile-form hide" src="{{ $sitter->profile_pic ? $sitter->profile_pic : '/images/avatar-placeholder.png' }}" alt="{{ $sitter->user->first_name }} {{ $sitter->user->last_name }}">	
																		</div>
																		<p data-toggle="modal" data-target="#photoModal" id="btn-one" class="new-profile-form hide new-text"  id="newbtn" style="width:200px;padding: 5px 30px; font-size: 13px; background-color:#28994b; color: #FFFFFF;margin-top:-28px;position:absolute;text-align:center;cursor: pointer;">Edit/Choose Photo
																		</p>
																	</div>
																	<div class="padT5">
																		<!-- <label for="edit-profile-img" class="fileBtn new-profile-form hide">
																			Update Photo
																		</label> -->
																		<!-- <input name="profile-pic" value="{{ $sitter->profile_pic }}" class="file-upload hide" id="edit-profile-img" type="file"/>
																		<span class="fileName">
																			@if($sitter->profile_pic)
																			{{ substr(pathinfo($sitter->profile_pic, PATHINFO_BASENAME), 7) }}
																			@else
																				No file chosen
																			@endif
																		</span> -->
																	</div>
																	
																	
																	<!-- <div class="padT10">
																		<a href="" class="see-ex-btn fileBtn new-profile-form green hide" data-toggle="modal" data-target="#photoModal">See Photo Requirement</a>
																	</div> -->
																	

																	@if ($errors->has('profile-pic'))
									                                    <span class="help-block new-profile-form hide">
									                                        {{ str_replace("profile-pic","profile picture",$errors->first('profile-pic')) }}
									                                    </span>
									                                @endif


															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-xl-8 col-12 user-details">
														<div class="row pb-3">
															<div class="col-12 col-md-6">
																<h6 class="green">First name</h6>
																<p class="old-profile-form">{{ $sitter->user->first_name }}</p>
																<input type="text" name="first-name" class="new-profile-form hide" value="{{ $sitter->user->first_name }}">
																@if ($errors->has('first-name'))
								                                    <span class="help-block new-profile-form hide">
								                                        {{ str_replace("-"," ",$errors->first('first-name')) }}
								                                    </span>
								                                @endif

															</div>
															<div class="col-12 col-md-6 mt767">
																<h6 class="green">Last name</h6>
																<p class="old-profile-form">{{ $sitter->user->last_name }}</p>
																<input type="text" name="last-name" class="new-profile-form hide" value="{{ $sitter->user->last_name }}">
																@if ($errors->has('last-name'))
								                                    <span class="help-block new-profile-form hide">
								                                        {{ str_replace("-"," ",$errors->first('last-name')) }}
								                                    </span>
								                                @endif
															</div>
														</div>
														<div class="row pb-3">
															<div class="col-12 col-md-6">
																<h6 class="green">Email Address</h6>
																<p class="old-profile-form">{{ $sitter->user->email }}</p>
																<input type="email" name="email" class="new-profile-form hide" value="{{ $sitter->user->email }}" disabled>												
															</div>
															<div class="col-12 col-md-6 mt767">
																<h6 class="green">Contact number<span class="required new-profile-form hide"> *</span></h6>
																<p class="old-profile-form">{{ $sitter->contact_number }}</p>
																<input type="text" name="contact-number" class="new-profile-form hide" value="{{ $sitter->contact_number ? $sitter->contact_number : old('contact-number') }}">
																@if ($errors->has('contact-number'))
								                                    <span class="help-block new-profile-form hide">
								                                        {{ str_replace("-"," ",$errors->first('contact-number')) }}
								                                    </span>
								                                @endif																	
															</div>
														</div>
														<div class="row pb-3">
															<div class="col-12 col-md-6">
																<h6 class="green">Street name<span class="required new-profile-form hide"> *</span></h6>
																<p class="old-profile-form">{{ $sitter->street }}</p>
																<input type="text" name="street-name" class="new-profile-form hide" value="{{ $sitter->street ? $sitter->street : old('street-name') }}">
																@if ($errors->has('street-name'))
								                                    <span class="help-block new-profile-form hide">
								                                        {{ str_replace("-"," ",$errors->first('street-name')) }}
								                                    </span>
								                                @endif																	
															</div>
															<div class="col-12 col-md-6 mt767">
																<h6 class="green">House number<span class="required new-profile-form hide"> *</span></h6>
																<p class="old-profile-form">{{ $sitter->house_number }}</p>
																<input type="text" name="house-number" class="new-profile-form hide" value="{{ $sitter->house_number ? $sitter->house_number : old('house-number') }}">
																@if ($errors->has('house-number'))
								                                    <span class="help-block new-profile-form hide">
								                                        {{ str_replace("-"," ",$errors->first('house-number')) }}
								                                    </span>
								                                @endif																	
															</div>
														</div>
														<div class="row pb-3">
															<div class="col-12 col-md-6">
																<h6 class="green">Zip code<span class="required new-profile-form hide"> *</span></h6>
																<p class="old-profile-form">{{ $sitter->zip_code }}</p>
																<input type="text" name="zip-code" class="new-profile-form hide" value="{{ $sitter->zip_code ? $sitter->zip_code : old('zip-code') }}">
																@if ($errors->has('zip-code'))
								                                    <span class="help-block new-profile-form hide">
								                                        {{ str_replace("-"," ",$errors->first('zip-code')) }}
								                                    </span>
								                                @endif
																
															</div>
															<div class="col-12 col-md-6 mt767 help-text-city-container">
																<h6 class="green">City/town<span class="required new-profile-form hide"> *</span></h6>
																<p class="old-profile-form">{{ $sitter->city }}</p>
																<input type="text" name="city" class="new-profile-form hide" value="{{ $sitter->city ? $sitter->city : old('city') }}">
																@if ($errors->has('city'))
								                                    <span class="help-block new-profile-form hide">
								                                        {{ $errors->first('city') }}
								                                    </span>
								                                @endif	

								                                @if($settings->dashboard_tooltip)
								                                <div class="help-text-city new-profile-form hide">
                                                                    <div class="question-mark">?</div>
                                                                    <div class="help-text-city-content text-left">
                                                                        <em class="fonts14">{!! $settings->dashboard_tooltip !!}</em>
                                                                        <span class="help-text-close">x</span>
                                                                    </div>
                                                                </div>
                                                                @endif
															</div>																
														</div>	
													</div>
												</div>
												<div class="row">
													<div class="col-lg-6">
														<div class="row pb-3">
															<div class="col-12">
																<h6 class="green">Date of birth<span class="required new-profile-form hide"> *</span></h6>
																<p class="old-profile-form">{{ date("d/m/Y", strtotime($sitter->date_of_birth)) }}</p>
																
																<select class="custom-select new-profile-form hide" name="dob-day">	
																	<option value="" disabled="disabled" {{ $sitter->date_of_birth ? 'class=d-none' : 'selected="selected"' }}>DD</option>
																  	@for($day=1;$day<=31;$day++)
																	
																	    <option value='{{ sprintf("%02d",$day) }}' 
																	    @if(!empty($birthDate[1]))
																		    {{ $birthDate[1] == $day ? 'selected="selected"' : '' }}
																		@else
																			{{ old('dob-day') == $day ? 'selected="selected"' : '' }}
																	    @endif																		    
																	    >{{ sprintf("%02d",$day) }}</option>
																	
																	@endfor
																</select> 
																<span class="new-profile-form hide"> / </span>
																<select class="custom-select new-profile-form hide" name="dob-month">
																	<option value="" disabled="disabled" {{ $sitter->date_of_birth ? 'class=d-none' : 'selected="selected"' }}>MM</option>
																 	@for($month=1;$month<=12;$month++)
																																				
																	    <option value='{{ sprintf("%02d",$month) }}' 
																	    @if(!empty($birthDate[0]))
																		    {{ $birthDate[0] == $month ? 'selected="selected"' : '' }}
																		@else
																			{{ old('dob-month') == $month ? 'selected="selected"' : '' }}
																	    @endif
																	    >{{ sprintf("%02d",$month) }}</option>
																	
																	@endfor
																</select>
																<span class="new-profile-form hide"> / </span>
																<select class="custom-select new-profile-form hide" name="dob-year">
																	<option value="" disabled="disabled" {{ $sitter->date_of_birth ? 'class=d-none' : 'selected="selected"' }}>YYYY</option>
																	@for($year=date("Y");$year>=1901;$year--)
																	
																	    <option value='{{ $year }}' 
																	    @if(!empty($birthDate[2]))
																		    {{ $birthDate[2] == $year ? 'selected="selected"' : '' }}
																		@else
																			{{ old('dob-year') == $year ? 'selected="selected"' : '' }}
																	    @endif	
																	    >{{ $year }}</option>
																	
																	@endfor
																</select>
															</div>	
															@if ($errors->has('dob-month') || $errors->has('dob-day') || $errors->has('dob-year'))
															<div class="col-12">
																<span class="help-block new-profile-form hide">
							                                        The date of birth field is required.
							                                    </span>
															</div>							                                    
							                                @endif
							                                @if($errors->has('age'))
															<div class="col-12">
																<span class="help-block new-profile-form hide" role="alert">									
																	{{ $errors->first('age') }}                              					
																</span>	
															</div>														
															@endif																
														</div>
														<div class="row pb-3">
															<div class="col-12">
																<h6 class="green">Start date of job<span class="required new-profile-form hide"> *</span></h6>
																	<p class="old-profile-form">
																		@if($sitter->begin_date)
																			{{ date("d/m/Y", strtotime($sitter->begin_date)) }}
																		@endif
																	</p>
																<select class="custom-select new-profile-form hide" name="bd-day">	
																	<option value="" disabled="disabled" {{ $sitter->begin_date ? 'class=d-none' : 'selected="selected"' }}>DD</option>
																  	@for($day=1;$day<=31;$day++)
																	
																	    <option value='{{ sprintf("%02d",$day) }}' 
																	    @if(!empty($beginDate[1]))
																		    {{ $beginDate[1] == $day ? 'selected="selected"' : '' }}
																		@else
																			{{ old('bd-day') == $day ? 'selected="selected"' : '' }}
																	    @endif																		    
																	    >{{ sprintf("%02d",$day) }}</option>
																	
																	@endfor
																</select>
																<span class="new-profile-form hide"> / </span>
																<select class="custom-select new-profile-form hide" name="bd-month">
																	<option value="" disabled="disabled" {{ $sitter->begin_date ? 'class=d-none' : 'selected="selected"' }}>MM</option>
																 	@for($month=1;$month<=12;$month++)
																																			
																	    <option value='{{ sprintf("%02d",$month) }}' 
																	    @if(!empty($beginDate[0]))
																		    {{ $beginDate[0] == $month ? 'selected="selected"' : '' }}
																		@else
																			{{ old('bd-month') == $month ? 'selected="selected"' : '' }}
																	    @endif
																	    >{{ sprintf("%02d",$month) }}</option>
																	
																	@endfor
																</select>																	 
																<span class="new-profile-form hide"> / </span>
																<select class="custom-select new-profile-form hide" name="bd-year">	
																	<option value="" disabled="disabled" {{ $sitter->begin_date ? 'class=d-none' : 'selected="selected"' }}>YYYY</option>	
																	@for($year=date("Y");$year>=2020;$year--)
																	
																	    <option value='{{ $year }}' 
																	    @if(!empty($beginDate[2]))
																		    {{ $beginDate[2] == $year ? 'selected="selected"' : '' }}
																		@else
																			{{ old('bd-year') == $year ? 'selected="selected"' : '' }}
																	    @endif	
																	    >{{ $year }}</option>
																	
																	@endfor
																</select>
															</div>
															@if ($errors->has('bd-month') || $errors->has('bd-day') || $errors->has('bd-year'))
															<div class="col-12">
																<span class="help-block new-profile-form hide">
							                                        The begin date field is required.
							                                    </span>
															</div>							                                    
							                                @endif
														</div>
														<div class="row pb-3">
															<div class="col-12">
																<h6 class="green">Job description<span class="required new-profile-form hide"> *</span></h6>
																<p class="old-profile-form">{{ $sitter->job_description }}</p>
																																	
																	<div class="help-text-jd-container">
																		<select name="job-description" class="custom-select new-profile-form hide">
																			<option disabled="disabled" {{ $sitter->job_description ? 'class=d-none' : 'selected="selected"' }}>Select</option>
																			@foreach($jdDropdown as $option)
																			
																			    <option value='{{ $option }}' 
																			    @if($sitter->job_description)
																			    {{ $option == $sitter->job_description ? 'selected="selected"' : '' }}
																			    @else
																				{{ old('job-description') == $option ? 'selected="selected"' : '' }}
																		   		@endif
																			    >{{ $option }}</option>
																			
																			@endforeach	

																		</select>
																		@if($settings->job_description_tooltip)
											                                <div class="help-text-jd new-profile-form hide">
		                                                                        <div class="question-mark-jd">?</div>
		                                                                        <div class="help-text-jd-content text-left">
		                                                                            <em class="fonts14">{!! $settings->job_description_tooltip !!}</em>
		                                                                            <span class="help-text-close">x</span>
		                                                                        </div>
		                                                                    </div>
		                                                                @endif
		                                                            </div>																		

																@if ($errors->has('job-description'))
																<div>
																	<span class="help-block new-profile-form hide">
								                                        {{ str_replace("job-description","job description",$errors->first('job-description')) }}
								                                    </span>
																</div>							                                    
								                                @endif
								                                
															</div>
														</div>
														<div class="row pb-3">
															<div class="col-12">
																<h6 class="green">How many years of experience do you have?</h6>
																<p class="old-profile-form">{{ $sitter->years_of_experience ? $sitter->years_of_experience  . ' years' : '' }}</p>
																<select name="years-of-experience" id="" class="custom-select new-profile-form hide">
																	@for($exp=0;$exp<=20;$exp++)
																	
																	    <option value='{{ $exp }}' 
																	    @if($sitter->years_of_experience)
																	    {{ $sitter->years_of_experience == $exp ? 'selected="selected"' : '' }}
																	    @else
																		{{ old('years-of-experience') == $exp ? 'selected="selected"' : '' }}
																   		@endif
																	    >{{ $exp }} years</option>
																	
																	@endfor
																</select>
															</div>
														</div>															
														<div class="row pb-3">
															<div class="col-12">
																<h6 class="green">Ages & stages experience<span class="required new-profile-form hide"> *</span></h6>
																<ul class="list-box old-profile-form">
																	@foreach ( $stagesExperience as $stageExperience )
																		@if($stageExperience != 'other')
																		<li>{{ $stageExperience }}</li>
																		@endif
																	@endforeach	
																</ul>
																<ul class="list-box-checked new-profile-form hide">
																	@foreach($stgsCheckbox as $key=>$choice)							
																	    <li>
																			<input name="stages-experience[]" type="checkbox" class="custom-control-input" id="{{ strtolower($choice) }}" value="{{ $choice }}"	
																				{{ in_array($choice, $stagesExperience) || (is_array(old('stages-experience')) && in_array($choice, old('stages-experience'))) ? 'checked="checked"' : '' }}
																			>
																			<label class="custom-control-label" for="{{ strtolower($choice) }}">{{ $choice }}</label>
																		</li>
																	@endforeach																			
																	<li>
																		<input name="stages-experience[]" type="checkbox" class="custom-control-input other-clicked" id="ageOther" value="other"
																			{{ in_array("other", $stagesExperience) || (is_array(old('stages-experience')) && in_array("other", old('stages-experience'))) ? 'checked="checked"' : '' }}
																		>
																		<label class="custom-control-label" for="ageOther">Other:</label>
																		<input name="stages-experience[]" class="list-box-other {{ in_array("other", $stagesExperience) || (is_array(old('stages-experience')) && in_array("other", old('stages-experience'))) ? '' : 'hide' }}" type="text"

																		@php
																			$foundIndex = array_search('other',$stagesExperience);
																			$afterFound = array_slice($stagesExperience,$foundIndex + 1);
																			$value = implode(", ", $afterFound);
																		@endphp
																		
																		@if(in_array("other", $stagesExperience))				
																			value="{{ $value }}"
																		@elseif(is_array(old('stages-experience')) && in_array("other", old('stages-experience')))
																			@php 
																				$stagesArray = old('stages-experience');
																				$stagesFoundIndex = array_search('other',$stagesArray);
																				$stagesAfterFound = array_slice($stagesArray,$stagesFoundIndex + 1);
																				$stagesValue = implode(", ", $stagesAfterFound);
																			@endphp	
																			value="{{ $stagesValue }}"
																		@else
																			value=""
																		@endif
																		>
																	</li>
																</ul>
																@if ($errors->has('stages-experience'))
								                                    <span class="help-block new-profile-form hide">
								                                        {{ $errors->first('stages-experience') }}
								                                    </span>
								                                @endif
															</div>
														</div>
														<div class="row pb-3">
															<div class="col-12">
																<h6 class="green">Activities for kids<span class="required new-profile-form hide"> *</span></h6>
																<ul class="list-box old-profile-form">
																	@foreach ( $activities as $activity )

																		@if($activity != 'other')
																			<li>{{ $activity }}</li>
																		@endif

																	@endforeach	
																</ul>
																<ul class="list-box-checked new-profile-form hide">	
																	@foreach($actCheckbox as $key=>$choice)							
																	    <li>
																			<input name="kids-activities[]" type="checkbox" class="custom-control-input" id="{{ strtolower($choice) }}" value="{{ $choice }}"	
																				{{ in_array($choice, $activities) || (is_array(old('kids-activities')) && in_array($choice, old('kids-activities'))) ? 'checked="checked"' : '' }}
																			>
																			<label class="custom-control-label" for="{{ strtolower($choice) }}">{{ $choice }}</label>
																		</li>
																	@endforeach		
																	
																	<li>
																		<input name="kids-activities[]" type="checkbox" class="custom-control-input other-clicked" id="activitiesOther" value="other"
																			{{ in_array("other", $activities) || (is_array(old('kids-activities')) && in_array("other", old('kids-activities'))) ? 'checked="checked"' : '' }}
																		>
																		<label class="custom-control-label" for="activitiesOther">Other:</label>
																		<input name="kids-activities[]" class="list-box-other {{ in_array("other", $activities) || (is_array(old('kids-activities')) && in_array("other", old('kids-activities'))) ? '' : 'hide' }}" type="text" 
																		@php
																			$foundIndex1 = array_search('other',$activities);
																			$afterFound1 = array_slice($activities,$foundIndex1 + 1);
																			$value1 = implode(", ", $afterFound1);
																		@endphp
																		
																		@if(in_array("other", $activities))				
																			value="{{ $value1 }}"	
																		@elseif(is_array(old('kids-activities')) && in_array("other", old('kids-activities')))
																			@php 
																				$actArray = old('kids-activities');
																				$actFoundIndex = array_search('other',$actArray);
																				$actAfterFound = array_slice($actArray,$actFoundIndex + 1);
																				$actValue = implode(", ", $actAfterFound);
																			@endphp	
																			value="{{ $actValue }}"
																		@else
																			value=""
																		@endif
																		>
																	</li>
																</ul>
																@if ($errors->has('kids-activities'))
								                                    <span class="help-block new-profile-form hide">
								                                        {{ $errors->first('kids-activities') }}
								                                    </span>
								                                @endif
															</div>
														</div>		
														<div class="row pb-3">
															<div class="col-12">
																<h6 class="green">Additional services<span class="required new-profile-form hide"> *</span></h6>
																<ul class="list-box old-profile-form">
																	@foreach ( $additionalServices as $additionalService )

																		@if($additionalService != 'other')
																			<li>{{ $additionalService }}</li>
																		@endif

																	@endforeach
																</ul>
																<ul class="list-box-checked new-profile-form hide">
																	@foreach($servCheckbox as $key=>$choice)							
																	    <li>
																			<input name="additional-services[]" type="checkbox" class="custom-control-input" id="{{ strtolower($choice) }}" value="{{ $choice }}"	
																				{{ in_array($choice, $additionalServices) || (is_array(old('additional-services')) && in_array($choice, old('additional-services'))) ? 'checked="checked"' : '' }}
																			>
																			<label class="custom-control-label" for="{{ strtolower($choice) }}">{{ $choice }}</label>
																		</li>
																	@endforeach																			
																	
																	<li>
																		<input name="additional-services[]" type="checkbox" class="custom-control-input other-clicked" id="addServicesOther" value="other"
																			{{ in_array("other", $additionalServices) || (is_array(old('additional-services')) && in_array("other", old('additional-services'))) ? 'checked="checked"' : '' }}
																		>
																		<label class="custom-control-label" for="addServicesOther">Other:</label>
																		<input name="additional-services[]" class="list-box-other {{ in_array("other", $additionalServices) || (is_array(old('additional-services')) && in_array("other", old('additional-services'))) ? '' : 'hide' }}" type="text" 
																			@php
																				$foundIndex4 = array_search('other',$additionalServices);
																				$afterFound4 = array_slice($additionalServices,$foundIndex4 + 1);
																				$value4 = implode(", ", $afterFound4);
																			@endphp
																			
																			@if(in_array("other", $additionalServices))				
																				value="{{ $value4 }}"
																		@elseif(is_array(old('additional-services')) && in_array("other", old('additional-services')))
																			@php 
																				$addlArray = old('additional-services');
																				$addlFoundIndex = array_search('other',$addlArray);
																				$addlAfterFound = array_slice($addlArray,$addlFoundIndex + 1);
																				$addlValue = implode(", ", $addlAfterFound);
																			@endphp	
																			value="{{ $addlValue }}"
																		@else
																			value=""
																		@endif
																		>
																	</li>
																</ul>
																@if ($errors->has('additional-services'))
								                                    <span class="help-block new-profile-form hide">
								                                        {{ $errors->first('additional-services') }}
								                                    </span>
								                                @endif

															</div>
														</div>													
													</div>
													<div class="col-lg-6">
														<div class="row pb-3">
															<div class="col-md-12">
																<h6 class="green">Gender<span class="required new-profile-form hide"> *</span></h6>
																<p class="old-profile-form">{{ $sitter->gender }}</p>
																<div class="new-profile-form hide">
																	<div class="custom-control custom-radio-green custom-control-inline">
																		<input type="radio" id="male" name="gender" class="custom-control-input" value="Male" {{ $sitter->gender == 'Male' || old('gender') == 'Male' ? 'checked="checked"' : '' }}>
																		<label class="custom-control-label" for="male">Male</label>
																	</div>
																	<div class="custom-control custom-radio-green custom-control-inline">
																		<input type="radio" id="female" name="gender" class="custom-control-input" value="Female" {{ $sitter->gender == 'Female' || old('gender') == 'Female' ? 'checked="checked"' : '' }}>
																		<label class="custom-control-label" for="female">Female</label>
																	</div>
																</div>
																@if ($errors->has('gender'))
								                                    <span class="help-block new-profile-form hide">
								                                        {{ $errors->first('gender') }}
								                                    </span>
								                                @endif
															</div>
														</div>
														<div class="row pb-3">
															<div class="col-12">
																<h6 class="green">Average hourly rate<span class="required new-profile-form hide"> *</span></h6>
																<p class="old-profile-form">€ {{ $sitter->hourly_rate }}</p>
																<span class="new-profile-form hide">€ </span><input type="number" name="avg-hourly" class="number-input new-profile-form hide" min="10" max="20" step=".10" placeholder="0.00" value="{{ $sitter->hourly_rate ? $sitter->hourly_rate : old('avg-hourly') }}">	
															</div>	
															<div class="col-12">	
															@if ($errors->has('avg-hourly'))
							                                    <span class="help-block new-profile-form hide">
							                                        {{ $errors->first('avg-hourly') }}
							                                    </span>
							                                @endif	
							                                </div>												
														</div>
														<div class="row pb-3">
															<div class="col-12">
																<h6 class="green">Mother tongue</h6>
																<p class="old-profile-form">{{ $sitter->mother_tongue }}</p>
																<select name="mother-tongue" class="custom-select new-profile-form hide">
																	@foreach($langDropdown as $option)
																	
																	    <option value='{{ $option }}' {{ $option == $sitter->mother_tongue || $option == old('mother-tongue') ? 'selected="selected"' : '' }}>{{ $option }}</option>
																	
																	@endforeach	
																</select>
															</div>
														</div>
														<div class="row pb-3">
															<div class="col-12">
																<h6 class="green">Other languages you speak</h6>
																<ul class="list-box old-profile-form">
																	@foreach ( $languages as $key=>$language )
																		@if($language != 'other')
																			<li>{{ $language }}</li>
																		@endif
																	@endforeach	
																</ul>
																<ul class="list-box-checked new-profile-form hide">
																	
																		@foreach($langCheckbox as $key=>$choice)							
																		    <li>
																				<input name="languages[]" type="checkbox" class="custom-control-input" id="{{ strtolower($choice) }}" value="{{ $choice }}"	
																					{{ in_array($choice, $languages) || (is_array(old('languages')) && in_array($choice, old('languages'))) ? 'checked="checked"' : '' }}
																				>
																				<label class="custom-control-label" for="{{ strtolower($choice) }}">{{ $choice }}</label>
																			</li>
																		@endforeach	

																		<li>
																			<input name="languages[]" type="checkbox" class="custom-control-input other-clicked" id="languageOther" value="other"
																				{{ in_array("other", $languages) || (is_array(old('languages')) && in_array("other", old('languages'))) ? 'checked="checked"' : '' }}
																			>
																			<label class="custom-control-label mb-1" for="languageOther">Other:</label>
																			<input name="languages[]" class="list-box-other {{ in_array("other", $languages) || (is_array(old('languages')) && in_array("other", old('languages'))) ? '' : 'hide' }}" type="text"
																			@php
																				$foundIndex2 = array_search('other',$languages);
																				$afterFound2 = array_slice($languages,$foundIndex2 + 1);
																				$value2 = implode(", ", $afterFound2);
																			@endphp
																			
																			@if(in_array("other", $languages))				
																				value="{{ $value2 }}"
																			@elseif(is_array(old('languages')) && in_array("other", old('languages')))
																				@php 
																					$langArray = old('languages');
																					$langFoundIndex = array_search('other',$langArray);
																					$langAfterFound = array_slice($langArray,$langFoundIndex + 1);
																					$langValue = implode(", ", $langAfterFound);
																				@endphp	
																				value="{{ $langValue }}"
																			@else
																				value=""
																			@endif
																			>
																		</li>
																		
																	
																</ul>
															</div>
														</div>
														<div class="row pb-3">
															<div class="col-12">
																<h6 class="green">Qualifications: (Diploma, Certification) <span class="required new-profile-form hide"> *</span></h6>
																<ul class="list-box old-profile-form">
																	@foreach ( $qualifications as $qualification )

																		@if($qualification != 'other')
																			<li>{{ $qualification }}</li>
																		@endif

																	@endforeach
																</ul>
																<ul class="list-box-checked new-profile-form hide">

																	@foreach($qualCheckbox as $key=>$choice)
						
																	    <li>
																			<input name="qualifications[]" type="checkbox" class="custom-control-input" id="{{ strtolower($choice) }}" value="{{ $choice }}"	
																			{{ in_array($choice, $qualifications) || (is_array(old('qualifications')) && in_array($choice, old('qualifications'))) ? 'checked="checked"' : '' }}
																			>
																			<label class="custom-control-label" for="{{ strtolower($choice) }}">{{ $choice }}</label>
																		</li>
																	@endforeach	
																	
																	<li>
																		<input name="qualifications[]" type="checkbox" class="custom-control-input other-clicked" id="qualificationOther" value="other" 
																			{{ in_array("other", $qualifications) || (is_array(old('qualifications')) && in_array("other", old('qualifications'))) ? 'checked="checked"' : '' }}
																		>
																		<label class="custom-control-label" for="qualificationOther">Other:</label>
																		<input name="qualifications[]" class="list-box-other {{ in_array("other", $qualifications) || (is_array(old('qualifications')) && in_array("other", old('qualifications'))) ? '' : 'hide' }}" type="text"
																			@php
																				$foundIndex3 = array_search('other',$qualifications);
																				$afterFound3 = array_slice($qualifications,$foundIndex3 + 1);
																				$value3 = implode(", ", $afterFound3);
																			@endphp
																			
																			@if(in_array("other", $qualifications))				
																				value="{{ $value3 }}"
																		@elseif(is_array(old('qualifications')) && in_array("other", old('qualifications')))
																			@php 
																				$qualArray = old('qualifications');
																				$qualFoundIndex = array_search('other',$qualArray);
																				$qualAfterFound = array_slice($qualArray,$qualFoundIndex + 1);
																				$qualValue = implode(", ", $qualAfterFound);
																			@endphp	
																			value="{{ $qualValue }}"																		
																		@else
																			value=""
																		@endif
																		>
																	</li>
																</ul>
																@if ($errors->has('qualifications'))
								                                    <span class="help-block new-profile-form hide">
								                                        {{ $errors->first('qualifications') }}
								                                    </span>
								                                @endif
															</div>
														</div>
														
														<div class="row pb-3">
															<div class="col-md-12">
																<h6 class="green">Write below about yourself (experiences, interests and skills).<span class="required new-profile-form hide"> *</span></h6>
																<div class="col-12 pb-3 px-0 nanny-gen-text-wrap">
																	<div class="old-profile-form">
																		<p class="pt-2">{!! $sitter->general_text !!}</p>
																	</div>
																	<div class="new-profile-form hide">
																		<div class="mb-3">
																			<em>Contact details are not allowed for your privacy and safety. You may send it through private message.</em>	
																		</div>
																		<textarea name="general-text" class="form-control mt-2" style="height:130px;">{{ $sitter->general_text ? $sitter->general_text : old('general-text') }}</textarea>
																		@if ($errors->has('general-text'))
										                                    <span class="help-block new-profile-form hide">
										                                        {{ str_replace("The general-text","This",$errors->first('general-text')) }}
										                                    </span>
										                                @endif	
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="row pb-3 pb-lg-0">
													<div class="col-12">
														<h6 class="green">Availability<span class="required new-profile-form hide"> *</span></h6>
														<div class="old-profile-form scroll-x">
															<table cellpadding="0" cellspacing="0" border="0" width="100%" class="desktop-sched-cal desktop-sched-cal-profile">
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
																		<td>00:00&nbsp;-&nbsp;06:00</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'dawn') !== false)	
																				<td>
																					<span class='green-box green-box-edit {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>06:00 - 12:00</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'morning') !== false)	
																				<td>
																					<span class='green-box green-box-edit {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>12:00 - 18:00</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'afternoon') !== false)	
																				<td>
																					<span class='green-box green-box-edit {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>18:00 - 00:00</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'evening') !== false)	
																				<td>
																					<span class='green-box green-box-edit {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																</tbody>
															</table>
															<!-- SCHEDULE FOR MOBILE START-->
															<table cellpadding="0" cellspacing="0" border="0" width="100%" class="mobile-sched-cal mobile-sched-cal-profile">
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
																					<span class='green-box green-box-edit {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>Tue</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'tue') !== false)	
																				<td>
																					<span class='green-box green-box-edit {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
																				</td>
																			@endif
																		@endforeach	
																	<tr>
																		<td>Wed</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'wed') !== false)	
																				<td>
																					<span class='green-box green-box-edit {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>Thu</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'thu') !== false)	
																				<td>
																					<span class='green-box green-box-edit {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>Fri</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'fri') !== false)	
																				<td>
																					<span class='green-box green-box-edit {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>Sat</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'sat') !== false)	
																				<td>
																					<span class='green-box green-box-edit {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>Sun</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'sun') !== false)	
																				<td>
																					<span class='green-box green-box-edit {{ $schedColumn }} {{ $scheds[$schedColumn] == 1 ? "active" : "" }}'></span>
																				</td>
																			@endif
																		@endforeach
																	</tr>
																</tbody>
															</table>
															<!-- SCHEDULE FOR MOBILE END -->															
														</div>
														<div class="list-box-checked new-profile-form hide scroll-x">
															<table cellpadding="0" cellspacing="0" border="0" width="100%" class="desktop-sched-cal desktop-sched-cal-profile">
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
																		<td>00:00&nbsp;-&nbsp;06:00</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'dawn') !== false)
																				<td>
																					<input type="checkbox" name="{{ $schedColumn }}" class="green-box green-box-edit" 
																					@if($scheds[$schedColumn] == 1 || old($schedColumn))
																						checked="checked"			
																					@endif
																					>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>06:00 - 12:00</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'morning') !== false)
																				<td>
																					<input type="checkbox" name="{{ $schedColumn }}" class="green-box green-box-edit"
																					@if($scheds[$schedColumn] == 1 || old($schedColumn))
																						checked="checked"
																					@endif
																					>
																				</td>
																			@endif
																		@endforeach	

																	</tr>
																	<tr>
																		<td>12:00 - 18:00</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'afternoon') !== false)
																				<td>
																					<input type="checkbox" name="{{ $schedColumn }}" class="green-box green-box-edit"
																					@if($scheds[$schedColumn] == 1 || old($schedColumn))
																						checked="checked"
																					@endif
																					>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>18:00 - 24:00</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'evening') !== false)
																				<td>
																					<input type="checkbox" name="{{ $schedColumn }}" class="green-box green-box-edit"
																					@if($scheds[$schedColumn] == 1 || old($schedColumn))
																						checked="checked"
																					@endif
																					>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																</tbody>
															</table>
															<!-- SCHEDULE FOR MOBILE START-->
															<table cellpadding="0" cellspacing="0" border="0" width="100%" class="mobile-sched-cal mobile-sched-cal-profile">
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
																					<input type="checkbox" name="{{ $schedColumn }}" class="green-box green-box-edit"
																					@if($scheds[$schedColumn] == 1 || old($schedColumn))
																						checked="checked"
																					@endif
																					>
																				</td>
																			@endif
																		@endforeach			
																	</tr>
																	<tr>
																		<td>Tue</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'tue') !== false)
																				<td>
																					<input type="checkbox" name="{{ $schedColumn }}" class="green-box green-box-edit"
																					@if($scheds[$schedColumn] == 1 || old($schedColumn))
																						checked="checked"
																					@endif
																					>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>Wed</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'wed') !== false)
																				<td>
																					<input type="checkbox" name="{{ $schedColumn }}" class="green-box green-box-edit"
																					@if($scheds[$schedColumn] == 1 || old($schedColumn))
																						checked="checked"
																					@endif
																					>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>Thu</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'thu') !== false)
																				<td>
																					<input type="checkbox" name="{{ $schedColumn }}" class="green-box green-box-edit"
																					@if($scheds[$schedColumn] == 1 || old($schedColumn))
																						checked="checked"
																					@endif
																					>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>Fri</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'fri') !== false)
																				<td>
																					<input type="checkbox" name="{{ $schedColumn }}" class="green-box green-box-edit"
																					@if($scheds[$schedColumn] == 1 || old($schedColumn))
																						checked="checked"
																					@endif
																					>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>Sat</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'sat') !== false)
																				<td>
																					<input type="checkbox" name="{{ $schedColumn }}" class="green-box green-box-edit"
																					@if($scheds[$schedColumn] == 1 || old($schedColumn))
																						checked="checked"
																					@endif
																					>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																	<tr>
																		<td>Sun</td>
																		@foreach($schedColumns as $schedColumn)
																			@if(strpos($schedColumn, 'sun') !== false)
																				<td>
																					<input type="checkbox" name="{{ $schedColumn }}" class="green-box green-box-edit"
																					@if($scheds[$schedColumn] == 1 || old($schedColumn))
																						checked="checked"
																					@endif
																					>
																				</td>
																			@endif
																		@endforeach	
																	</tr>
																</tbody>
															</table>
															<!-- SCHEDULE FOR MOBILE END -->
														</div>
														@if ($errors->has('availability'))
						                                    <span class="help-block new-profile-form hide">
						                                        {{ $errors->first('availability') }}
						                                    </span>
						                                @endif	
													</div>
												</div>
												<div class="row pb-3 pb-lg-0 mt-4">													
													<div class="col-md-12">	
														<div class="references-wrap py-3">														
															<h6 class="green"> Work References</h6>
															<div class="col-12 pb-3 px-0">
																<div class="refs-parent maxWidth600L">
																	<div class="old-profile-form">
																		@if(count($references)>0)
																			@foreach ( $references as $reference )	
																				<div class="reference-item p-3 mt-3">
																					<div><span class="green">Name:</span> {{ $reference->first_name }} {{ $reference->last_name }}</div>
																					<div><span class="green">Contact Number:</span> {{ $reference->contact_number }}</div>
																					<div><span class="green">Email:</span> {{ $reference->email }}</div>
																				</div>
																			@endforeach
																		@else
																			<p>No references.</p>
																		@endif
																	</div>

																	@if(count($references)>0 || is_array(old('ref-fname')))

																		@if(is_array(old('ref-fname')))
																			@php
																				$refFnames = old('ref-fname'); 		
																				$refLnames = old('ref-lname');
																				$refContactNumbers = old('ref-contact-num');
																				$refEmails = old('ref-email');
																				$references = [];
																			@endphp

																			@foreach($refFnames as $key => $refFname)
																				@php
																					$references[$key]['first_name'] = $refFname;
																				@endphp
																			@endforeach	

																			@foreach($refLnames as $key => $refLname)
																				@php
																					$references[$key]['last_name'] = $refLname;
																				@endphp
																			@endforeach

																			@foreach($refContactNumbers as $key => $refContactNumber)
																				@php
																					$references[$key]['contact_number'] = $refContactNumber;
																				@endphp
																			@endforeach

																			@foreach($refEmails as $key => $refEmail)
																				@php
																					$references[$key]['email'] = $refEmail;
																				@endphp
																			@endforeach	

																			
																		@endif																		

																		@foreach ( $references as $key => $reference )
																			
																			<div class="refs-item-wrap px-3 mt-3 new-profile-form hide relative">
																				<div class="row pb-3">
																					<div class="col-12 col-md-6">
																						<h6 class="green mt-3">First Name<span class="required new-profile-form hide"> *</span></h6>
																						<input type="text" name="ref-fname[]" class="new-profile-form hide" required="required" value="{{is_array(old('ref-fname')) ? $reference['first_name'] : $reference->first_name }}">
																					</div>
																					<div class="col-12 col-md-6">
																						<h6 class="green mt-3">Last Name<span class="required new-profile-form hide"> *</span></h6>
																						<input type="text" name="ref-lname[]" class="new-profile-form hide" required="required" value="{{is_array(old('ref-lname')) ? $reference['last_name'] : $reference->last_name }}">
																					</div>
																					<div class="col-12 col-md-6">
																						<h6 class="green mt-3">Contact Number<span class="required new-profile-form hide"> *</span></h6>
																						<input type="text" name="ref-contact-num[]" class="new-profile-form hide" required="required" value="{{is_array(old('ref-contact-num')) ? $reference['contact_number'] : $reference->contact_number }}">
																					</div>
																					<div class="col-12 col-md-6">
																						<h6 class="green mt-3">Email<span class="required new-profile-form hide"> *</span></h6>
																						<input type="email" name="ref-email[]" class="new-profile-form hide" required="required" value="{{is_array(old('ref-email')) ? $reference['email'] : $reference->email }}">
																					</div>
																				</div>
																			</div>
																		@endforeach

																	@else
																	<div class="refs-item-wrap px-3 mt-3 new-profile-form hide relative">
																		<div class="row pb-3">
																			<div class="col-12 col-md-6">
																				<h6 class="green mt-3">First Name<span class="required new-profile-form hide"> *</span></h6>
																				<input type="text" name="ref-fname[]" class="new-profile-form hide" required="required">
																			</div>
																			<div class="col-12 col-md-6">
																				<h6 class="green mt-3">Last Name<span class="required new-profile-form hide"> *</span></h6>
																				<input type="text" name="ref-lname[]" class="new-profile-form hide" required="required">
																			</div>
																			<div class="col-12 col-md-6">
																				<h6 class="green mt-3">Contact Number<span class="required new-profile-form hide"> *</span></h6>
																				<input type="text" name="ref-contact-num[]" class="new-profile-form hide" required="required">
																			</div>
																			<div class="col-12 col-md-6">
																				<h6 class="green mt-3">Email<span class="required new-profile-form hide"> *</span></h6>
																				<input type="email" name="ref-email[]" class="new-profile-form hide" required="required">
																			</div>
																		</div>
																	</div>
																	@endif

																</div>
																<div class="row pb-3 mt-3 new-profile-form hide">
																	<div class="col-12">
																		<button type="button" class="custom-btn btn-white btn-green-whitebg new-profile-form hide add-ref-btn">Add a reference</button>
																	</div>
																</div>
															</div>
														</div>
													</div>													
												</div>
												<div class="row align-items-end pt-4">
													<div class="col-12">
														<button type="button" id="edit-profile" class="custom-btn btn-green btn-green-whitebg profile-btn mr-3 mb-3">Edit Profile</button>
														@if(!empty($sitter->profile_pic))
														<button type="submit" class="custom-btn btn-green btn-green-whitebg update-btn mr-3 mb-3">{{ empty($screening) ? 'Submit for Screening' : 'Save Changes' }}</button>
														@else
														<button type="submit" disabled class="custom-btn btn-green btn-green-whitebg update-btn mr-3 mb-3">Upload photo first to enable save button</button>
														@endif

														@if(!empty($sitter->job_description))
														<a href="dashboard" class="custom-btn btn-white btn-green-whitebg new-profile-form hide mr-3 mb-3 cancel-btn">Cancel Editing</a>
														@endif
														<a href="{{ url('nannies/profile') }}/{{ Auth::user()->id }}/{{ lcfirst(Auth::user()->first_name) }}" class="green view-profile-btn inlineBlock" target="_blank">View my profile</a>
													</div>
												</div>
											</div>
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
</section>

<div class="modal fade new-profile-form hide photoModal" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header padLR40 photo-ex-header">
				<div class="container">
					<div class="row align-items-center text-center">
						<div class="col-12 mt-3">
							<img class="message-modal-img" src="{{ asset('images/TinyStepsLogo.svg') }}">
							@if($settings->nanny_photo_example_heading)
							<div class="modal-title py-3">{!! $settings->nanny_photo_example_heading !!}</div>
							@endif							
						</div>
					</div>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@if($settings->nanny_photo_example_top_text)
			<div class="modal-body padLR40 pb-0">
				<p>{!! $settings->nanny_photo_example_top_text !!}</p>				
			</div>
			@endif

			@if(!empty($examplePhotos))
			<div class="modal-body text-center nimg">				
				<div class="example-photo-slider">
					@foreach($examplePhotos as $examplePhoto)
					<center><div class="example-photo-item" style="background-image: url({{$examplePhoto->photo_example_pic}});"></div>	</center>
					@endforeach
				</div>			
			</div>
			@endif

			@if($settings->nanny_photo_example_bottom_text)
			<div class="modal-body padLR40 pt-0">
				<p>{!! $settings->nanny_photo_example_bottom_text !!}</p>				
			</div>
			@endif	
			<center><h5 class="new-profile-form hide">Update your photo here and don't forget to review the requirements.</h5></center>							
			<div class="padT5" style="text-align:center;padding-bottom:20px;">
				<form method="POST" action="{{ url('/nannies/profile') }}" class="edit-profile-form" enctype="multipart/form-data">
					@csrf
					<center>
					<div class="padT5 new-profile-form hide" style="padding-bottom:20px;">
					<div class="profile-img-wrap">
							<img class="profile-photo-frame old-profile-form" src="{{ $sitter->profile_pic ? $sitter->profile_pic : '/images/avatar-placeholder.png' }}" alt="{{ $sitter->user->first_name }} {{ $sitter->user->last_name }}">

							<img id="profile-img" class="profile-photo-frame new-profile-form hide" src="{{ $sitter->profile_pic ? $sitter->profile_pic : '/images/avatar-placeholder.png' }}" alt="{{ $sitter->user->first_name }} {{ $sitter->user->last_name }}">	
					</div>
					<div id="cropPos" class="mt-2 hide">
							<p class="pp-select-title new-profile-form green hide">Cropping position</p>
							<select id="cropPosSelect" name="crop_pos" class="custom-select new-profile-form pp-select mt-1 hide" disabled>
									<option class="crop-pos-center" value="center">Center</option>
									<option class="crop-pos-top" value="top">Top</option>	
									<option class="crop-pos-bottom" value="bottom">Bottom</option>
									<option class="crop-pos-right" value="right">Right</option>
									<option class="crop-pos-left" value="left">Left</option>	
									</select>
									</div>
							</div></center>
				<label  for="edit-profile-img" class="fileBtn new-profile-form hide" id="chosef" style="padding:10px 20px;background-color: #28994b;color: #FFFFFF;">
				Choose Photo
				</label>
					<input name="profile-pic" value="{{ $sitter->profile_pic }}" class="file-upload hide" id="edit-profile-img" type="file"/>
		
					<button type="submit" class="fileBtn new-profile-form hide" id="choseg" style="padding:10px 50px;background-color: #FFFFFF;color: #28994b;">Save</button>
				</div>
		</div>
	</div>
</div>
<script type="text/javascript">document.getElementById("photoModal2").style.display = "none";</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
   $("#edit-profile").click(function(){
   $("#profile-out").remove();
  });

   $("#edit-profile-img").change(function(){
   $("#chosef").css("color", "#28994b");
   $("#chosef").css("background-color", "white");
   $("#choseg").css("color", "white");
   $("#choseg").css("background-color", "#28994b");

   });

});

</script>
@endsection


