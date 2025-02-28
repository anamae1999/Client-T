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
			    <div class="tab-content loaderParent">
			    	<div id="loadingDiv">
						<div class="loader"></div>
					</div>
			    	<div class="tab-pane fade show active">
						<form method="POST" action="{{ url('/mentors/update') }}" enctype="multipart/form-data" class="edit-profile-form">
		      			@csrf
								<div class="table-container bg-white rounded p-md-5 p-3 my-md-3 my-0">
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-12">
													<div class="row pb-4">
														<div class="col-xl-9">
															<div class="pb-4 col-details">
																@if(empty($mentor->job_description))
																<div id="no-profile" class="alert alert-info">
												                    Please complete your profile so you would be included in the search listing.
												                </div>
												                @endif
												                @if ($errors->any())
																    <div class="alert alert-danger alert-errors">
																        <ul>			        	
																            @foreach ($errors->all() as $error)
																            	<li>{{ str_replace("-", " ",$error) }}</li>	
																            @endforeach				            
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
																				<img class="profile-photo-frame old-profile-form" src="{{ $mentor->profile_pic ? $mentor->profile_pic : '/images/avatar-placeholder.png' }}" alt="{{ $mentor->user->first_name }} {{ $mentor->user->last_name }}">

																				<img id="profile-img" class="profile-photo-frame new-profile-form hide" src="{{ $mentor->profile_pic ? $mentor->profile_pic : '/images/avatar-placeholder.png' }}" alt="{{ $mentor->user->first_name }} {{ $mentor->user->last_name }}">	
																			</div>
																			<p class="new-profile-form hide" style="width:200px;padding: 5px 30px; font-size: 13px; background-color:#28994b; color: #FFFFFF;margin-top:-28px;position:absolute;text-align:center;cursor: pointer;">Edit/Choose Photo</p>
																		</div>
																		<div class="padT5">
																			<!-- <label for="edit-profile-img" class="fileBtn new-profile-form hide">
																				Update Photo
																			</label> -->
																			<input name="profile-pic" value="{{ $mentor->profile_pic }}" class="file-upload hide" id="edit-profile-img" type="file"/>
																			<span class="fileName">
																				@if($mentor->profile_pic)
																				{{ substr(pathinfo($mentor->profile_pic, PATHINFO_BASENAME), 7) }}
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
																	<p class="old-profile-form">{{ $mentor->user->first_name }}</p>
																	<input type="text" name="first-name" class="new-profile-form hide" value="{{ $mentor->user->first_name }}">
																	@if ($errors->has('first-name'))
									                                    <span class="help-block new-profile-form hide">
									                                        {{ str_replace("-"," ",$errors->first('first-name')) }}
									                                    </span>
									                                @endif

																</div>
																<div class="col-12 col-md-6 mt767">
																	<h6 class="green">Last name</h6>
																	<p class="old-profile-form">{{ $mentor->user->last_name }}</p>
																	<input type="text" name="last-name" class="new-profile-form hide" value="{{ $mentor->user->last_name }}">
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
																	<p class="old-profile-form">{{ $mentor->street }}</p>
																	<input type="text" name="street-name" class="new-profile-form hide" value="{{ $mentor->street ? $mentor->street : old('street-name') }}">
																	@if ($errors->has('street-name'))
									                                    <span class="help-block new-profile-form hide">
									                                        {{ str_replace("-"," ",$errors->first('street-name')) }}
									                                    </span>
									                                @endif																	
																</div>
																<div class="col-12 col-md-6 mt767">
																	<h6 class="green">House number<span class="required new-profile-form hide"> *</span></h6>
																	<p class="old-profile-form">{{ $mentor->house_number }}</p>
																	<input type="text" name="house-number" class="new-profile-form hide" value="{{ $mentor->house_number ? $mentor->house_number : old('house-number') }}">
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
																	<p class="old-profile-form">{{ $mentor->zip_code }}</p>
																	<input type="text" name="zip-code" class="new-profile-form hide" value="{{ $mentor->zip_code ? $mentor->zip_code : old('zip-code') }}">
																	@if ($errors->has('zip-code'))
									                                    <span class="help-block new-profile-form hide">
									                                        {{ str_replace("-"," ",$errors->first('zip-code')) }}
									                                    </span>
									                                @endif
																	
																</div>
																<div class="col-12 col-md-6 mt767 help-text-city-container">
																	<h6 class="green">City/town<span class="required new-profile-form hide"> *</span></h6>
																	<p class="old-profile-form">{{ $mentor->city }}</p>
																	<input type="text" name="city" class="new-profile-form hide" value="{{ $mentor->city ? $mentor->city : old('city') }}">
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
														<div class="col-md-12 col-lg-8 col-xl-4">		
															<div class="row pb-3">
																<div class="col-12">
																	<div class="help-text-jd-container">
																		<h6 class="green noMarB">Job description<span class="required new-profile-form hide"> *</span></h6>
																		@if($settings->mentor_tooltip)
											                                <div class="help-text-jd new-profile-form hide">
		                                                                        <div class="question-mark-jd">?</div>
		                                                                        <div class="help-text-jd-content text-left">
		                                                                            <em class="fonts14">{!! $settings->mentor_tooltip !!}</em>
		                                                                            <span class="help-text-close">x</span>
		                                                                        </div>
		                                                                    </div>
		                                                                @endif
		                                                            </div>	
																	
																		<ul class="list-box old-profile-form">
																			@foreach ( $job_descriptions as $key => $job_description )
																				@if($job_description != null)	
																					<li>{{ $job_description }}</li>	
																				@endif
																			@endforeach	
																		</ul>
																		<div class="job-description-wrap">
																			@if($job_descriptions != null)
																				@foreach ( $job_descriptions as $key => $job_description )
																					<div class="add-jd-wrap">	
																						<input type="text" name="job_descriptions[]" class="new-profile-form hide add-jd-ipt" value="{{ $job_description }}">
																					</div>
																				@endforeach	
																			@else
																				<div class="add-jd-wrap">	
																					<input type="text" name="job_descriptions[]" class="new-profile-form hide add-jd-ipt" value="">
																				</div>
																			@endif
																				
																			<button id="add-jd-btn" type="button" class="custom-btn btn-green btn-green-whitebg new-profile-form hide">+</button>
																		</div>	
																	

																</div>
															</div>
															<div class="row pb-3">
																<div class="col-12">
																	<h6 class="green">Trainings or workshop offered:</h6>
																	<ul class="list-box old-profile-form">
																		@foreach ( $trainings as $key => $training )
																			@if($training != null)	
																				<li>{{ $training }}</li>	
																			@endif
																		@endforeach	
																	</ul>
																		<div class="training-wrap">
																			@if($trainings != null)
																				@foreach ( $trainings as $key => $training )
																					<div class="add-trn-wrap">	
																						<input type="text" name="trainings[]" class="new-profile-form hide add-trn-ipt" value="{{ $training }}">
																					</div>
																				@endforeach	
																			@else
																				<div class="add-trn-wrap">	
																					<input type="text" name="trainings[]" class="new-profile-form hide add-trn-ipt" value="">
																				</div>
																			@endif
																				
																			<button id="add-trn-btn" type="button" class="custom-btn btn-green btn-green-whitebg new-profile-form hide">+</button>
																		</div>
																</div>
															</div>
															<div class="row">
																<div class="col-12">
																	<h4>Connect Information Details</h4>
																</div>
															</div>
															<div class="row pb-3">	
																<div class="col-12">
																	<h6 class="green">Email<span class="required new-profile-form hide"> *</span></h6>
																	<p class="old-profile-form">{{ $mentor->email }}</p>
																	<input type="email" name="email" class="new-profile-form hide" value="{{ $mentor->email ? $mentor->email : old('email') }}">
																	@if ($errors->has('email'))
									                                    <span class="help-block new-profile-form hide">
									                                        {{ $errors->first('email') }}
									                                    </span>
									                                @endif
																</div>
															</div>
															<div class="row pb-3">	
																<div class="col-12">
																	<h6 class="green">Contact Number<span class="required new-profile-form hide"> *</span></h6>
																	<p class="old-profile-form">{{ $mentor->number }}</p>
																	<input type="text" name="number" class="new-profile-form hide" value="{{ $mentor->number ? $mentor->number : old('number') }}">
																	@if ($errors->has('number'))
									                                    <span class="help-block new-profile-form hide">
									                                        {{ $errors->first('number') }}
									                                    </span>
									                                @endif
																</div>
															</div>
															<div class="row pb-3">	
																<div class="col-12">
																	<h6 class="green">Website<span class="required new-profile-form hide"> *</span></h6>
																	<p class="old-profile-form">{{ $mentor->website }}</p>
																	<input type="text" name="website" class="new-profile-form hide" value="{{ $mentor->website ? $mentor->website : old('website') }}">
																	@if ($errors->has('website'))
									                                    <span class="help-block new-profile-form hide">
									                                        {{ $errors->first('website') }}
									                                    </span>
									                                @endif
																</div>
															</div>

															<div class="row pb-3">
																<div class="col-12">
																	<h6 class="green">My Intention:</h6>
																	<div class="old-profile-form">
																		<p class="pt-2">{!! $mentor->general_text !!}</p>
																	</div>
																	<div class="new-profile-form hide">	
																		<textarea name="general-text" class="form-control mt-2 mceDashboard">{{ $mentor->general_text ? $mentor->general_text : old('general-text') }}</textarea>
																	</div>
																</div>
															</div>													
														</div>
														<div class="col-md-12 col-xl-6">		
															<div class="row pb-3">
																<div class="col-12">
																	<h6 class="green">Spoken languages</h6>
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
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">																	
													<button type="button" class="custom-btn btn-green btn-green-whitebg profile-btn mr-3 mb-3">Edit Profile</button>																	
													<button type="submit" class="custom-btn btn-green btn-green-whitebg update-btn mr-3 mb-3">Save Changes</button>
													<a href="dashboard" class="custom-btn btn-white btn-green-whitebg new-profile-form hide mr-3 mb-3 cancel-btn">Cancel Editing</a>
													<a href="{{ url('mentors/profile') }}/{{ Auth::user()->id }}/{{ lcfirst(Auth::user()->first_name) }}" class="green view-profile-btn inlineBlock" target="_blank">View my profile</a>
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
<div class="modal fade new-profile-form hide" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header padLR40 photo-ex-header">
				<div class="container">
					<div class="row align-items-center text-center">
						<div class="col-12 mt-3">
							<img class="message-modal-img" src="{{ asset('images/TinyStepsLogo.svg') }}">
							@if($settings->mentor_photo_example_heading)
							<div class="modal-title py-3">{!! $settings->mentor_photo_example_heading !!}</div>
							@endif							
						</div>
					</div>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@if($settings->mentor_photo_example_top_text)
			<div class="modal-body padLR40 pb-0">
				<p>{!! $settings->mentor_photo_example_top_text !!}</p>				
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
			
			

			@if($settings->mentor_photo_example_bottom_text)
			<div class="modal-body padLR40 pt-0">
				<p>{!! $settings->mentor_photo_example_bottom_text !!}</p>				
			</div>
			@endif
			<center><h5 class="new-profile-form hide" >Upload or Update your Photo Here.</h5></center>							
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