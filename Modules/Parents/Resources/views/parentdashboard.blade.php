@extends('parents::layouts.master')
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
							<form method="POST" action="{{ url('/parents/update') }}" enctype="multipart/form-data" class="edit-profile-form">
			      			@csrf
								<div class="table-container bg-white rounded p-md-5 p-3 my-md-3 my-0">
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-12">
													<div class="row pb-4">
														<div class="col-xl-9">
															<div class="pb-4 col-details">
																@if(empty($guardian->job_description))
																<div id="no-profile" class="alert alert-info">
												                    Please complete your profile so you would be included in the search listing.
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
																<h4 class="brown m-0">Personal Details</h4>
															</div>	
															<div class="row pl-3 pt-3 p-xl-0">
																<div class="edit-image-container edit-profile-img text-xl-center text-left order-first order-xl-last">
																		<h6 class="green">Profile Picture</h6>
																		<div class="padT5" data-toggle="modal" data-target="#photoModal">
																			<div class="profile-img-wrap">
																				<img class="profile-photo-frame old-profile-form" src="{{ $guardian->profile_pic ? $guardian->profile_pic : '/images/avatar-placeholder.png' }}" alt="{{ $guardian->user->first_name }} {{ $guardian->user->last_name }}">

																				<img id="profile-img" class="profile-photo-frame new-profile-form hide" src="{{ $guardian->profile_pic ? $guardian->profile_pic : '/images/avatar-placeholder.png' }}" alt="{{ $guardian->user->first_name }} {{ $guardian->user->last_name }}">
																			</div>
																			<p class="new-profile-form hide" style="width:200px;padding: 5px 30px; font-size: 13px; background-color:#28994b; color: #FFFFFF;margin-top:-28px;position:absolute;text-align:center;cursor: pointer;">Edit/Choose Photo</p>
																		</div>
																		<div class="padT5">
																			<!-- <label for="edit-profile-img" class="fileBtn new-profile-form hide">
																				Update Photo
																			</label> -->
																			<input name="profile-pic" value="{{ $guardian->profile_pic }}" class="file-upload hide" id="edit-profile-img" type="file"/>							
																			<span class="fileName">
																				@if($guardian->profile_pic)
																				{{ substr(pathinfo($guardian->profile_pic, PATHINFO_BASENAME), 7) }}
																				@else
																					No file chosen
																				@endif
																			</span>
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
																	<p class="old-profile-form">{{ $guardian->user->first_name }}</p>
																	<input type="text" name="first-name" class="new-profile-form hide" value="{{ $guardian->user->first_name }}">
																	@if ($errors->has('first-name'))
									                                    <span class="help-block new-profile-form hide">
									                                        {{ str_replace("-"," ",$errors->first('first-name')) }}
									                                    </span>
									                                @endif
																</div>
																<div class="col-12 col-md-6 mt767">
																	<h6 class="green">Last name</h6>
																	<p class="old-profile-form">{{ $guardian->user->last_name }}</p>
																	<input type="text" name="last-name" class="new-profile-form hide" value="{{ $guardian->user->last_name }}">
																	@if ($errors->has('last-name'))
									                                    <span class="help-block new-profile-form hide">
									                                        {{ str_replace("-"," ",$errors->first('last-name')) }}
									                                    </span>
									                                @endif
																</div>
															</div>
															<div class="row pb-3">
																<div class="col-12 col-md-6">
																	<h6 class="green">Street name<span class="required new-profile-form hide"> *</span></h6>
																	<p class="old-profile-form">{{ $guardian->street }}</p>
																	<input type="text" name="street-name" class="new-profile-form hide" value="{{ $guardian->street ? $guardian->street : old('street-name') }}">
																	@if ($errors->has('street-name'))
									                                    <span class="help-block new-profile-form hide">
									                                        {{ str_replace("-"," ",$errors->first('street-name')) }}
									                                    </span>
									                                @endif																	
																</div>
																<div class="col-12 col-md-6 mt767">
																	<h6 class="green">House number<span class="required new-profile-form hide"> *</span></h6>
																	<p class="old-profile-form">{{ $guardian->house_number }}</p>
																	<input type="text" name="house-number" class="new-profile-form hide" value="{{ $guardian->house_number ? $guardian->house_number : old('house-number') }}">
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
																	<p class="old-profile-form">{{ $guardian->zip_code }}</p>
																	<input type="text" name="zip-code" class="new-profile-form hide" value="{{ $guardian->zip_code ? $guardian->zip_code : old('zip-code') }}">
																	@if ($errors->has('zip-code'))
									                                    <span class="help-block new-profile-form hide">
									                                    	{{ str_replace("-"," ",$errors->first('zip-code')) }}
									                                    </span>
									                                @endif																	
																</div>
																<div class="col-12 col-md-6 mt767 help-text-city-container">
																	<h6 class="green">City/town<span class="required new-profile-form hide"> *</span></h6>
																	<p class="old-profile-form">{{ $guardian->city }}</p>
																	<input type="text" name="city" class="new-profile-form hide" value="{{ $guardian->city ? $guardian->city : old('city') }}">
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
													<div class="row pb-4">
														<div class="col-lg-5">
															<div class="row pb-3">
																<div class="col-12">
																	<h6 class="green">Start date of job<span class="required new-profile-form hide"> *</span></h6>
																	<p class="old-profile-form">
																		@if($guardian->begin_date)
																		{{ date("d/m/Y", strtotime($guardian->begin_date)) }}
																		@endif
																	</p>
																	<select class="custom-select new-profile-form hide" name="bd-day">	
																		<option value="" disabled="disabled" {{ $guardian->begin_date ? 'class=d-none' : 'selected="selected"' }}>DD</option>
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
																		<option value="" disabled="disabled" {{ $guardian->begin_date ? 'class=d-none' : 'selected="selected"' }}>MM</option>

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
																		<option value="" disabled="disabled" {{ $guardian->begin_date ? 'class=d-none' : 'selected="selected"' }}>YYYY</option>
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
																	<h6 class="green">Looking for<span class="required new-profile-form hide"> *</span></h6>
																	<p class="old-profile-form">{{ $guardian->job_description }}</p>
																	<div class="help-text-jd-container">
																		<select name="job-description" class="custom-select new-profile-form hide">
																			<option disabled="disabled" {{ $guardian->job_description ? 'class=d-none' : 'selected="selected"' }}>Select</option>
																			@foreach($jdDropdown as $option)
																			
																			    <option value='{{ $option }}' 
																			    @if($guardian->job_description)
																			    {{ $option == $guardian->job_description ? 'selected="selected"' : '' }}
																			    @else
																				{{ old('job-description') == $option ? 'selected="selected"' : '' }}
																		   		@endif
																		   		>{{ $option }}</option>
																			
																			@endforeach																		
																		</select>
																		@if($settings->looking_for_tooltip)
											                                <div class="help-text-jd new-profile-form hide">
		                                                                        <div class="question-mark-jd">?</div>
		                                                                        <div class="help-text-jd-content text-left">
		                                                                            <em class="fonts14">{!! $settings->looking_for_tooltip !!}</em>
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
																	<h6 class="green">For how many children do you need care?</h6>
																	<p class="old-profile-form">{{ $guardian->num_of_children }} {{ $guardian->num_of_children == 1 ? 'child' : 'children' }}</p>
																	<select id="numOfChildren" name="num-of-children" class="custom-select new-profile-form hide">
																		@for($num=1;$num<=5;$num++)
																		
																			@if($num == 1)
																			    <option value='{{ $num }}' {{ $guardian->num_of_children == $num || old('num-of-children') == $num ? 'selected="selected"' : '' }}>{{ $num }} child</option>
																		    @else
																			    <option value='{{ $num }}' {{ $guardian->num_of_children == $num || old('num-of-children') == $num ? 'selected="selected"' : '' }}>{{ $num }} children</option>
																		    @endif
																		
																		@endfor
																	</select>
																</div>
															</div>
															<div class="row pb-3">
																<div class="col-4 col-sm-3 children-genders">
																	<h6 class="green">Gender</h6>
																	@if(!empty($genders) || is_array(old('gender-of-children')))

																		@if(is_array(old('gender-of-children')))
																			@php
																				$genders = old('gender-of-children');
																			@endphp
																		@endif

																		@foreach ( $genders as $gender )
																			<p class="old-profile-form mb-0">{{ $gender }}</p>	
																			<select name="gender-of-children[]" class="custom-select new-profile-form hide child-gender">
																				<option value="Boy" {{ $gender == 'Boy' ? 'selected="selected"' : '' }}>Boy</option>
																				<option value="Girl" {{ $gender == 'Girl' ? 'selected="selected"' : '' }}>Girl</option>
																			</select>	
																		@endforeach	
																	@else																		
																		<select name="gender-of-children[]" class="custom-select new-profile-form hide child-gender">
																			<option value="Boy">Boy</option>
																			<option value="Girl">Girl</option>
																		</select>
																	@endif																														
																</div>
																<div class="col-8 col-sm-9 children-ages">
																	<h6 class="green">Age</h6>
																	@if(!empty($ages) || is_array(old('age-of-children')))

																		@if(is_array(old('age-of-children')))
																			@php
																				$ages = old('age-of-children');
																			@endphp
																		@endif

																		@foreach ( $ages as $age )
																			<p class="old-profile-form mb-0">{{ $age }}</p>	
																			<select name="age-of-children[]" id="" class="custom-select new-profile-form hide child-age">
																			@for($ageCtr=0;$ageCtr<=16;$ageCtr++)	
																				<option value='{{ $ageCtr }}' {{ $age == $ageCtr ? 'selected="selected"' : '' }}>{{ $ageCtr }}</option>
																			@endfor
																			</select>
																		@endforeach	
																	@else
																			<select name="age-of-children[]" id="" class="custom-select new-profile-form hide child-age">
																			@for($ageCtr=1;$ageCtr<=16;$ageCtr++)	
																				<option value='{{ $ageCtr }}'>{{ $ageCtr }}</option>
																			@endfor
																			</select>
																	@endif
																</div>
															</div>
															<div class="row pb-3">
																<div class="col-12">
																	<h6 class="green">Ages & stages experience needed</h6>
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
																</div>
															</div>
															<div class="row">
																<div class="col-12">
																	<h6 class="green">Activities for kids</h6>
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
																</div>
															</div>
														</div>
														<div class="col-lg-7">
															<div class="row pb-3">
																<div class="col-12">
																	<h6 class="green">Average hourly rate</h6>
																	<p class="old-profile-form">€ {{ $guardian->hourly_rate }}</p>
																	<span class="new-profile-form hide">€ </span><input type="number" name="avg-hourly" class="number-input new-profile-form hide" min="10" max="20" step=".10" placeholder="0.00" value="{{ $guardian->hourly_rate ? $guardian->hourly_rate : old('avg-hourly') }}">	
																</div>
															</div>
															<div class="row pb-3">
																<div class="col-12">
																	<h6 class="green">Mother tongue</h6>
																	<p class="old-profile-form">{{ $guardian->mother_tongue }}</p>
																	<select name="mother-tongue" class="custom-select new-profile-form hide">
																		@foreach($langDropdown as $option)
																		
																		    <option value='{{ $option }}' {{ $option == $guardian->mother_tongue || $option == old('mother-tongue') ? 'selected="selected"' : '' }}>{{ $option }}</option>
																		
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
																	<h6 class="green">Additional services</h6>
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
																</div>
															</div>
															<div class="row pb-3">
																<div class="col-12">
																	<div class="parent-gen-text-wrap">
																		<h6 class="green">Write below your family's specific needs and preferences.<span class="required new-profile-form hide"> *</span></h6>
																		<div class="old-profile-form">
																			<p class="pt-2">{!! $guardian->general_text !!}</p>
																		</div>
																		<div class="new-profile-form hide">
																			<div class="mb-3">
																				<em>Contact details are not allowed for your privacy and safety. You may send it through private message.</em>
																			</div>
																			<textarea name="general-text" class="form-control mt-2 mceDashboard">{{ $guardian->general_text ? $guardian->general_text : old('general-text') }}</textarea>	
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
												</div>
											</div>
										</div>
									</div>									
									<div class="row">
										<div class="col-12">
											<h6 class="green">Days needed</h6>
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
															<td>18:00 - 00:00</td>
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
										</div>
									</div>
									<div class="row align-items-end pt-4">

										<div class="col-12">
											<button type="button" class="custom-btn btn-green btn-green-whitebg profile-btn mr-3 mb-3">Edit Profile</button>
											
											<button type="submit" class="custom-btn btn-green btn-green-whitebg update-btn  mr-3 mb-3">Save Changes</button>
											@if(!empty($guardian->job_description))	
											<a href="dashboard" class="custom-btn btn-white btn-green-whitebg new-profile-form hide mr-3 mb-3 cancel-btn">Cancel Editing</a>
											@endif
											<a href="{{ url('parents/profile') }}/{{ Auth::user()->id }}/{{ lcfirst(Auth::user()->first_name) }}" class="green view-profile-btn inlineBlock" target="_blank">View my profile</a>
											
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
<div class="modal fade new-profile-form hide" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header padLR40 photo-ex-header">
				<div class="container">
					<div class="row align-items-center text-center">
						<div class="col-12 mt-3">
							<img class="message-modal-img" src="{{ asset('images/TinyStepsLogo.svg') }}">
							@if($settings->parent_photo_example_heading)
							<div class="modal-title py-3">{!! $settings->parent_photo_example_heading !!}</div>
							@endif							
						</div>
					</div>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@if($settings->parent_photo_example_top_text)
			<div class="modal-body padLR40 pb-0">
				<p>{!! $settings->parent_photo_example_top_text !!}</p>				
			</div>
			@endif

				@if(!empty($examplePhotos))
			<div class="modal-body text-center py-0">				
				<div class="example-photo-slider">
					@foreach($examplePhotos as $examplePhoto)
					<div class="example-photo-item" style="background-image: url({{$examplePhoto->photo_example_pic}});"></div>	
					@endforeach
				</div>			
			</div>
			@endif

			@if($settings->parent_photo_example_bottom_text)
			<div class="modal-body padLR40 pt-0">
				<p>{!! $settings->parent_photo_example_bottom_text !!}</p>				
			</div>
			@endif
			<center><h5 class="new-profile-form hide">Upload or Update your Photo Here.</h5></center>							
			<div class="padT5" style="text-align:center;padding-bottom:20px;">
				<label onclick="myFunction()" for="edit-profile-img" class="fileBtn new-profile-form hide" id="chosef" style="padding:10px 20px;background-color: #28994b;">
				Update Photo
				</label>
				<input  name="profile-pic" value="{{ $sitter->profile_pic }}" class="file-upload hide" id="edit-profile-img" type="file"/>
				<!-- <span class="fileName">
					@if($sitter->profile_pic)
					{{ substr(pathinfo($sitter->profile_pic, PATHINFO_BASENAME), 7) }}
					@else
					No file chosen
				    @endif
					</span> -->
					<button onclick="myFunctionsbtn()" class="new-profile-form hide" id="subbtn"  type="button" data-dismiss="modal" aria-label="Close" style="padding:8px 20px;border:1px solid #28994b;border-radius:5px;font-size: 12px;">Save</button>
				</div>
		</div>
	</div>
</div>
<script>
  var chosedf = document.getElementById("chosef");
  var elementd = document.getElementById("subbtn");
  chosedf.style.color = "#FFFFFF";
  elementd.style.color = "#28994b";
 
function myFunction() {
  var chosef = document.getElementById("chosef");
  var element = document.getElementById("subbtn");
  element.style.backgroundColor = "#28994b";
  element.style.color = "#FFFFFF";
  chosef.style.backgroundColor = "#FFFFFF";
  chosef.style.color = "#28994b";
}

function myFunctionsbtn() {
  var chosef = document.getElementById("chosef");
  var element = document.getElementById("subbtn");
  element.style.backgroundColor = "#FFFFFF";
  element.style.color = "#28994b";
  chosef.style.backgroundColor = "#28994b";
  chosef.style.color = "#FFFFFF";
}
</script>
@endsection