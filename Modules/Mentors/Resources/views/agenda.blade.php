@extends('mentors::layouts.master')
@section('content')
<section class="gray-bg">
	<div class="container-fluid">
		<div class="row no-gutters">
			@include('parents::internals.dashboardtab')
			<div class="dashboard-tab-content padLR60">
			    <div class="tab-content loaderParent">
			    	<div id="loadingDiv">
						<div class="loader"></div>
					</div>
					<div class="tab-pane fade show active">

						<section>
							@if(Session::has('response'))
				                <div class="alert alert-success">
				                    {{ Session::get('response') }}
				                </div>
				            @endif
							<div class="row">
								<div class="agenda-tab-col-left">
							        <div class="d-flex flex-row flex-wrap align-items-center px-1 px-sm-3 px-md-4 pb-3 row no-gutters shadow white-bg rounded my-md-3 my-0">
	                                    <div class="col-12 p-3 agenda-header">	                                        
                                            <h3 class="brown m-0 inlineBlock align-middle">Agendas</h3>	
                                            <a class="custom-btn btn-green btn-green-whitebg dashboard-btn" href="manage-agendas">Add Event</a>                                       
	                                    </div>
	                                    <div class="agenda-container col-12">	
									      	<div class="table-container">									      	
												<table class="table dashboard-table table-responsive mb-0">
													<thead>
														<tr>
															<th scope="col"><span class="pr-1">Title</span></th>
															<th scope="col"></th>	
															<th scope="col"><span class="pr-1">Date</span></th>
														</tr>
													</thead>
													<tbody>

														@foreach($agendas as $key1 => $agenda)														
														<tr>
															<td><a href="#agenda{{$key1}}" class="green accordion-toggle collapsed" data-toggle="collapse" data-target="#collapse{{$key1}}" aria-expanded="false" aria-controls="collapse{{$key1}}">{{$agenda->title}}</a></td>
															<td>
																<a class="green btn-action" href="/mentors/edit-agenda/{{ $agenda->id }}">Edit</a>	
																<a class="green btn-action" href="#deleteAgendaModal" data-toggle="modal" data-id="{{ $agenda->id }}" data-agenda-title="{{$agenda->title}}">Delete</a>
															</td>
															<td>Last Modified <span class="pl-3">{{ date_format($agenda->updated_at, "d/m/y H:i:s") }}</span></td>
														</tr>
														@endforeach
															
													</tbody>
												</table>
												<div class="table-container-footer d-flex flex-wrap align-items-center justify-content-between">
													{{ $agendas->appends(Request::except('page'))->links() }}
												</div>
											</div>	
										</div>
	                                </div>
								</div>
								<div class="agenda-tab-col-right shadow white-bg rounded my-3 my-0 agenda-wrapper">
									<div class="col-12 p-3 agenda-header">	                                        
                                        <h3 class="brown m-0 inlineBlock align-middle">Preview Agendas</h3>	
	                                </div>
	                               
									<!-- Agenda Section -->
									<div class="row">
										<div class="col-12">
											<div class="col-8">
												<div class="agenda-wrapper pt-3">
													
													<div class="agenda-accordion-repeater">
													 	<div id="agenda-accordion">
													 		@if(count($agendas)>0)

													 		@foreach($agendas as $key => $agenda)
													 		<!-- Accordion Start Here -->
													 		<div id="agenda{{$key}}" class="card">
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
													 		@endif

													 		
													 	</div> <!-- end of agenda-accordion -->
												 	</div> <!-- end of agenda-accordion-repeater -->
												 	
												</div> <!-- end of agenda wrapper -->
											</div><!-- end of agenda col -->
											
										</div>
									</div> <!-- end of agenda section row -->
									
								</div>
								
							</div>
					    </section>
					</div>
			    </div>
		  	</div>
		</div>
	</div>
</section>

<!-- Delete confirmation modal -->
<div id="deleteAgendaModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Do you really want to delete "<span class="agenda-title"></span>"?</strong></p>                
            </div>
            <div class="modal-body d-flex">
			<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>

            	
			<p> Are you sure you want to do this? this cannot be undone. </p>
			</div>    
            <div class="modal-footer"> 
	            <form method="POST" action='{{ url("mentors/agenda/delete") }}'> 
				@csrf
                @method('DELETE')
					<div>
						<button type="button" class="btn btn-default marL20" data-dismiss="modal">Cancel</button>
	                    <input type="hidden" name="agendaId">	 
	                    <button class="dlt-btn">Delete</button>
					</div>
	            </div> 
            </form> 
            	
            </div>
        </div>
      </div>
</div>
@endsection