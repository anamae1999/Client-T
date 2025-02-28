@extends('mentors::layouts.master')
@section('content')
<section class="gray-bg">
	<div class="container-fluid">
		<div class="row no-gutters">
			@include('parents::internals.dashboardtab')
			<div class="dashboard-tab-content padLR60">
			    <div class="tab-content" id="dashboard-tab-content">
			    	@if(Session::has('response'))
		                <div class="alert alert-success">
		                    {{ Session::get('response') }}
		                </div>
		            @endif
					<div class="tab-pane fade show active">
						<section>
							<div class="row no-gutters justify-content-center">
								<div class="col-12 shadow white-bg rounded my-md-3 my-0 p-4 p-sm-5">
									<div class="pb-3">	
										<a class="green" href='{{ url("mentors/agendas") }}'><< Back to Agendas</a>
										<h3 class="brown m-0">Add Agenda</h3>	
									</div>
									<form method="POST" action="{{ url('/mentors/add-agenda') }}">
									    @csrf	
												
										<div class="agenda padT10">	
											<div class="edit-section-body">
												<div class="edit-body-row">
													<div class="pad15">
														<span>Agenda Title<span class="required"> *</span></span>
														<div class="padT10">
															<input name="title" type="text" class="edit-title-input col-12 padLR10" value="{{ old('title') }}" required="required">	
															@if ($errors->has('title'))
				                                                <span class="help-block">
				                                                    {{ $errors->first('title') }}
				                                                </span>
				                                            @endif
														</div>
													</div>
												</div>
												<div class="edit-body-row">
													<div class="pad15">
														<span>Agenda Description</span>
														<div class="padT10 new-profile-form">
															<textarea name="description" rows="3" class="mceDashboard">{{ old('description') }}</textarea>	
															@if ($errors->has('description'))
				                                                <span class="help-block">
				                                                    {{ $errors->first('description') }}
				                                                </span>
				                                            @endif											
														</div>
													</div>
												</div>
												<div class="edit-body-row event-details-wrap">
													<div class="pad15 event-details js-evt-count">
														<span>Event Details</span>
														
															<div class="session-date-wrap py-2">
																<p class="green">Session Date</p>
																<div class="session-date inlineBlock">
																	<div class="session-date-inner mt-2">
																		<select name="sd-day[0][]" class="custom-select new-profile-form" required="required">
																			<option disabled="disabled" value="" selected="selected">DD</option>
																			@for($day=1;$day<=31;$day++)			
																			    <option value='{{ sprintf("%02d",$day) }}' 
																					{{ old('sd-day') == $day ? 'selected="selected"' : '' }}	
																			    >{{ sprintf("%02d",$day) }}</option>
																			@endfor
																		</select>	
																		<span> / </span>	
																		<select name="sd-month[0][]" class="custom-select new-profile-form" required="required">
																			<option disabled="disabled" value="" selected="selected">MM</option>
																			@for($month=1;$month<=12;$month++)				
																			    <option value='{{ sprintf("%02d",$month) }}'	
																					{{ old('sd-month') == $month ? 'selected="selected"' : '' }}								    
																			    >{{ sprintf("%02d",$month) }}</option>		
																			@endfor
																		</select>	
																		<span> / </span>	
																		<select name="sd-year[0][]" class="custom-select new-profile-form" required="required">
																			<option disabled="disabled" value="" selected="selected">YYYY</option>
																			@for($year=date("Y");$year>=2020;$year--)	
																			    <option value='{{ $year }}' 							    
																					{{ old('sd-year') == $year ? 'selected="selected"' : '' }}
																			    >{{ $year }}</option>								
																			@endfor
																		</select>
																		<button type="button" class="brown del-sd-btn new-profile-form"><i class="fas fa-trash"></i></button>	

																	</div>

																</div>	
																<button type="button" class="custom-btn btn-white btn-green-whitebg new-profile-form add-date-btn">+</button>														
															</div>
														
															<div class="session-time-wrap py-2">
																<p class="green">Session Time</p>
																<div class="session-time">
																	<div class="time-picker">	
																		<div class="hour">
																			<div class="hr-up"></div>
																			<input type="number" class="hr" value="00" name="st-start-hr[0]">
																			<div class="hr-down"></div>
																		</div>

																		<div class="separator">:</div>

																		<div class="minute">
																			<div class="min-up"></div>
																			<input type="number" class="min" value="00" name="st-start-min[0]">
																			<div class="min-down"></div>
																		</div>
																	</div>
																	<div>&nbsp;—&nbsp;</div>
																	<div class="time-picker">
																		<div class="hour">
																			<div class="hr-up"></div>
																			<input type="number" class="hr" value="00" name="st-end-hr[0]">
																			<div class="hr-down"></div>
																		</div>

																		<div class="separator">:</div>

																		<div class="minute">
																			<div class="min-up"></div>
																			<input type="number" class="min" value="00" name="st-end-min[0]">
																			<div class="min-down"></div>
																		</div>
																	</div>															
																</div>															
															</div>

															<div class="row">
																<div class="col-12 col-md-6 col-lg-5 col-xl-4 session-venue py-2">
																	<p class="green">Session Venue</p>
																	<input type="text" name="venue[0]">
																</div>
																<div class="col-12 col-md-6 col-lg-7 col-xl-8 session-fee py-2">
																	<p class="green">Fee</p>
																	<span >€ </span><input type="number" name="fee[0]" class="number-input" min="1" max="1000" step=".10" placeholder="0.00" value="">
																</div>	
																<div class="col-12 col-md-6 col-lg-5 col-xl-4 session-language py-2">
																	<p class="green">Language</p>
																	<select name="language[0]" class="custom-select new-profile-form">
																		@foreach($languages as $language)
																			<option value="{{ $language }}">{{ $language }}</option>
																		@endforeach
																	</select>
																	<div class="other mt-2">
																		<p class="green">Other language(s)</p>
																		<input type="text" name="other-lang[0]">
																	</div>	
																</div>
																<div class="col-12 col-md-6 col-lg-7 col-xl-8 session-promo py-2">
																	<p class="green">Promo</p>
																	<input type="text" name="promo[0]">
																</div>	
															</div>
													</div>
												</div>
											</div>
												
										</div>	
										
										<div class="padT10">
											<input type="hidden" name="event-details-count" value="1">
											<button type="submit" class="custom-btn btn-green btn-green-whitebg btn-primary dashboard-btn ml-2 mt-2">Save Event</button>
											<button type="button" class="custom-btn btn-white btn-green-whitebg new-profile-form add-evt-dtl-btn">+<span class="tooltiptext">Add new event details</span></button>
										</div>												
									</form>	
								</div>
							</div>	
						</section>
					</div>
					    
					  
				</div>

			   </div>
		  </div>
	</div>
</section>

<div class="blank-event-dtls hide">
	<div class="event-details pad15 js-evt-count">
		<span>Event Details</span>
		<button type="button" class="brown del-evt-dtls-btn new-profile-form pull-right"><i class="fas fa-trash"></i></button>
		<div class="session-date-wrap py-2">
			<p class="green">Session Date</p>
			<div class="session-date inlineBlock">
				<div class="session-date-inner mt-2">
					<select name="" class="custom-select new-profile-form sd-day" required="required">
						<option disabled="disabled" value="" selected="selected">DD</option>
						@for($day=1;$day<=31;$day++)			
						    <option value='{{ sprintf("%02d",$day) }}' 
								{{ old('sd-day') == $day ? 'selected="selected"' : '' }}	
						    >{{ sprintf("%02d",$day) }}</option>
						@endfor
					</select>	
					<span> / </span>	
					<select name="" class="custom-select new-profile-form sd-month" required="required">
						<option disabled="disabled" value="" selected="selected">MM</option>
						@for($month=1;$month<=12;$month++)				
						    <option value='{{ sprintf("%02d",$month) }}'	
								{{ old('sd-month') == $month ? 'selected="selected"' : '' }}								    
						    >{{ sprintf("%02d",$month) }}</option>		
						@endfor
					</select>	
					<span> / </span>	
					<select name="" class="custom-select new-profile-form sd-year" required="required">
						<option disabled="disabled" value="" selected="selected">YYYY</option>
						@for($year=date("Y");$year>=2020;$year--)	
						    <option value='{{ $year }}' 							    
								{{ old('sd-year') == $year ? 'selected="selected"' : '' }}
						    >{{ $year }}</option>								
						@endfor
					</select>	
					<button type="button" class="brown del-sd-btn new-profile-form"><i class="fas fa-trash"></i></button>																		
				</div>
			</div>	
			<button type="button" class="custom-btn btn-white btn-green-whitebg new-profile-form add-date-btn">+</button>														
		</div>
	
		<div class="session-time-wrap py-2">
			<p class="green">Session Time</p>
			<div class="session-time">
				<div class="time-picker">	
					<div class="hour">
						<div class="hr-up"></div>
						<input type="number" class="hr start-hr" value="00" name="">
						<div class="hr-down"></div>
					</div>

					<div class="separator">:</div>

					<div class="minute">
						<div class="min-up"></div>
						<input type="number" class="min start-min" value="00" name="">
						<div class="min-down"></div>
					</div>
				</div>
				<div>&nbsp;—&nbsp;</div>
				<div class="time-picker">
					<div class="hour">
						<div class="hr-up"></div>
						<input type="number" class="hr end-hr" value="00" name="">
						<div class="hr-down"></div>
					</div>

					<div class="separator">:</div>

					<div class="minute">
						<div class="min-up"></div>
						<input type="number" class="min end-min" value="00" name="">
						<div class="min-down"></div>
					</div>
				</div>															
			</div>		
		</div>
		<div class="row">
			<div class="col-12 col-md-6 col-lg-5 col-xl-4 session-venue py-2">
				<p class="green">Session Venue</p>
				<input type="text" name="" class="venue-input">
			</div>
			<div class="col-12 col-md-6 col-lg-7 col-xl-8 session-fee py-2">				
				<p class="green">Fee</p>
				<span >€ </span><input type="number" name="" class="number-input fee-input" min="1" max="20" step=".10" placeholder="0.00" value="">
			</div>	
			<div class="col-12 col-md-6 col-lg-5 col-xl-4 session-language py-2">
				<p class="green">Language</p>
				<select name="" class="custom-select new-profile-form lang-select">
					@foreach($languages as $language)
						<option>{{ $language }}</option>
					@endforeach
				</select>	
				<div class="other mt-2">
					<p class="green">Other language(s)</p>
					<input class="lang-other" type="text" name="">
				</div>	
			</div>
			<div class="col-12 col-md-6 col-lg-7 col-xl-8 session-promo py-2">
				<p class="green">Promo</p>
				<input type="text" name="" class="promo-input">
			</div>	
		</div>
	</div>	
</div>

@endsection