@extends('admin::layouts.master')
@section('content')
<section class="gray-bg">
	<div class="container-fluid">
		<div class="row no-gutters">
			@include('admin::internals.dashboardtab')
			<div class="dashboard-tab-content padLR60">
			    <div class="tab-content" id="dashboard-tab-content">
			    	@if(Session::has('response'))
		                <div class="alert alert-success">
		                    {{ Session::get('response') }}
		                </div>
		            @endif
					<div class="tab-pane fade show active" id="v-pills-pages">
						<div class="pt-3 pb-3">	
							<a class="green" href='{{ url("/admin/pages/edit/home") }}'><< Back to edit Home page</a>
						</div>
						<section>							
					      	<h2>Testimonials</h2>
					      	<div class="table-container mb-5 p-4">
					      		<div id="for-nanny-accordion">
									@if(count($testimonials) > 0)
					                    @foreach($testimonials as $testimonial)
							      			<div class="card">
											    <div class="card-header" id="heading{{ $testimonial->id }}">
											      <div class="mb-0 d-flex justify-content-between">
											        <button class="btn btn-link fw600 green green-link collapsed" data-toggle="collapse" data-target="#collapse{{ $testimonial->id }}" aria-expanded="true" aria-controls="collapse{{ $testimonial->id }}">
											          {{ $testimonial->testi_author }}
											        </button>
											        <div class="d-flex align-items-center">
											        	<a class="m-1 green" href="#editTestiModal" data-toggle="modal" data-id="{{ $testimonial->id }}" data-author="{{ $testimonial->testi_author }}" data-content="{{ $testimonial->testi_content }}" data-rating="{{ $testimonial->testi_rating }}" data-hidden="{{ $testimonial->hidden }}">Edit</a>
														<a class="m-1 green" href="#deleteTestiModal" data-toggle="modal" data-id="{{ $testimonial->id }}" data-author="{{ $testimonial->testi_author }}">Delete</a>
											        </div>
											        
											      </div>
											    </div>
											    <div id="collapse{{ $testimonial->id }}" class="collapse" aria-labelledby="heading{{ $testimonial->id }}" data-parent="#for-nanny-accordion">
											      <div class="card-body">
											      	<div class="testimonial-item">
												      	<div class="stars">
													      	<ul>
													      		@for($x = 1; $x <= 5; $x++)
																    @if($x <= $testimonial->testi_rating)
																    	<li>
																			<img src="{{ asset('images/star-rate.png') }}" alt="rating-star">
																		</li>
																    @else
																    	<li>
																			<img src="{{ asset('images/star-rate-1.png') }}" alt="rating-star">
																		</li>
																    @endif
																@endfor
													      	</ul>	
												      	</div>		
											      	</div>								      	
											        {{ $testimonial->testi_content }}
											      </div>
											    </div>
										    </div>	
								    	@endforeach
							    	@else
										<div>
											<p>No testimonials available</p>
										</div>													
									@endif	
								</div>
								<div class="table-container-footer clearfix">
									 {{ $testimonials->appends(Request::except('page'))->links() }}
								</div>
							      		
							</div>				      	

					    </section>
					    <section>
							<div class="border-lg-grey p-4">									
								<form method="POST" action="{{ url('/admin/add-testimonial') }}">
						      	@csrf												
									<div class="edit-title-container padT10">
										<span class="fw600">Select Rating<span class="required"> *</span></span>
										<div class="padT10">
											<select class="custom-select select-rating" name="rating">
												<option disabled="disabled" selected="selected">Select Rating</option>
												<option value="1" @if(old('rating') == 1) selected="selected" @endif>1 Star</option>
												<option value="2" @if(old('rating') == 2) selected="selected" @endif>2 Stars</option>
												<option value="3" @if(old('rating') == 3) selected="selected" @endif>3 Stars</option>
												<option value="4" @if(old('rating') == 4) selected="selected" @endif>4 Stars</option>
												<option value="5" @if(old('rating') == 5) selected="selected" @endif>5 Stars</option>
											</select>
											@if ($errors->has('rating'))
                                                <span class="help-block">
                                                    {{ $errors->first('rating') }}
                                                </span>
                                            @endif											
										</div>
									</div>	
									<div class="testimonial padT10">
																							
										<div class="edit-title-container padTB10">
											<span class="fw600">Author<span class="required"> *</span></span>
											<div class="padT10">
												<input name="author" type="text" class="edit-title-input col-12 padLR10" value="{{ old('author') }}">	
												@if ($errors->has('author'))
	                                                <span class="help-block">
	                                                    {{ $errors->first('author') }}
	                                                </span>
	                                            @endif
											</div>
										</div>
										<div class="edit-title-container padT10">
											<span class="fw600">Content<span class="required"> *</span></span>
											<div class="padT10">
												<textarea name="content" rows="3">{{ old('content') }}</textarea>	
												@if ($errors->has('content'))
	                                                <span class="help-block">
	                                                    {{ $errors->first('content') }}
	                                                </span>
	                                            @endif											
											</div>
										</div>
									</div>
									<div class="padT10">
										<button type="submit" class="custom-btn btn-green btn-green-whitebg btn-primary dashboard-btn ml-2 mt-2">Add Testimonial</button>
									</div>												
								</form>	
							</div>
						</section>
					</div>

			    </div>
		  	</div>
		</div>
	</div>
</section>



<!-- Edit testimonial modal -->
<div id="editTestiModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form method="POST" action="{{ url('/admin/testimonial/update') }}">
      	@csrf
        <div class="modal-content p-2 f8f8f8-bg">
            <div class="modal-header">
            	<p class="fontS18"><strong>Edit Testimonial Item</strong></p>
            </div>
            <div class="modal-body">
            					
		      		<input type="hidden" name="testiId">	
		      		<div class="edit-title-container padT10">
		      			<div class="padT10">
		      				<input id="hideTesti" type="checkbox" name="hidden">
		      				<label for="hideTesti">Hide</label>		      				
		      			</div>
						<span class="fw600">Select Rating</span>
						<div class="padT10">
							<select class="select-rating" name="rating">
								<option disabled="disabled" selected="selected">Select Rating</option>
								<option id="1" value="1">1 Star</option>
								<option id="2" value="2">2 Stars</option>
								<option id="3" value="3">3 Stars</option>
								<option id="4" value="4">4 Stars</option>
								<option id="5" value="5">5 Stars</option>
							</select>											
						</div>
					</div>								
					<div class="testimonial mt-3">
																			
						<div class="edit-title-container mt-1">
							<span class="fw600">Author</span>
							<div class="mt-2">
								<input name="author" type="text" class="edit-title-input col-12 padLR10">
							</div>
						</div>
						<div class="edit-title-container mt-3">
							<span class="fw600">Content</span>
							<div class="mt-2">
								<textarea name="content" rows="3"></textarea>
							</div>
						</div>
					</div>									
				
			</div>
            <div class="modal-footer align-items-center">                    
                <button type="button" class="btn btn-default mr-3" data-dismiss="modal">Close</button>
				<button type="submit" class="custom-btn btn-green btn-green-whitebg btn-primary dashboard-btn">Update</button>
            </div>  
        </form>    
        </div>
    </div>
</div>

<!-- Delete testimonial confirmation modal -->
<div id="deleteTestiModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Do you really want to delete testimonial from "<span class="author"></span>"?</strong></p>                
            </div>
            <div class="modal-body d-flex">
            	
                    
				<svg class="text-warning mr-3" width="45" height="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<p> Are you sure you want to do this? This cannot be undone. </p>
			</div>
			<form method="POST" action='{{ url("/admin/testimonial/delete") }}'>	
            @csrf
            @method('DELETE')
	            <input type="hidden" name="testiId">	
				<div class="modal-footer">   
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button class="dlt-faq dlt-btn">Delete</button>      
				</div>                  
			</form>
        </div>
      </div>
</div>

@endsection


