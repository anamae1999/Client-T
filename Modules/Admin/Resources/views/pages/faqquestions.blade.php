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
							<a class="green" href='{{ url("/admin/pages/edit/faq") }}'><< Back to edit FAQ page</a>
						</div>
						<section>							
					      	<h2>FAQ</h2>
					      	<div class="pages-container">
					      		<ul class="AD-pages-tab nav nav-tabs faqTabs" id="AD-pages-tab" role="tablist">
									<li class="nav-item p-0 col-6 col-md-3 col-xl-auto">
										<a class="nav-link" id="for-nanny-tab" data-toggle="tab" href="#for-nanny" role="tab" aria-controls="for-nanny" aria-selected="true" data-category="For Nanny">For Nanny</a>
									</li>
									<li class="nav-item p-0 col-6 col-md-3 col-xl-auto">
										<a class="nav-link" id="for-parent-tab" data-toggle="tab" href="#for-parent" role="tab" aria-controls="for-parent" aria-selected="false" data-category="For Parent">For Parent</a>
									</li>
									<li class="nav-item p-0 col-6 col-md-3 col-xl-auto">
										<a class="nav-link" id="about-tiny-steps-tab" data-toggle="tab" href="#about-tiny-steps" role="tab" aria-controls="about-tiny-steps" aria-selected="false" data-category="About Tiny Steps">About Tiny Steps</a>
									</li>
									<li class="nav-item p-0 col-6 col-md-3 col-xl-auto">
										<a class="nav-link" id="account-and-privacy-tab" data-toggle="tab" href="#account-and-privacy" role="tab" aria-controls="account-and-privacy" aria-selected="false" data-category="Account and Privacy">Account and Privacy</a>
									</li>									
								</ul>								
					      	</div>
					      	<div class="tab-content" id="AD-pages-tab-content">
					      		<!-- for nanny tab -->
				      			<div class="tab-pane fade show active" id="for-nanny" role="tabpanel" aria-labelledby="for-nanny-tab">
							      	<div class="table-container mb-5 p-4">
							      		<div id="for-nanny-accordion">
							      			@if(count($faqsNanny) > 0)
							                    @foreach($faqsNanny as $faqNanny)
									      			<div class="card">
													    <div class="card-header" id="heading{{ $faqNanny->id }}">
													      <div class="mb-0 d-flex justify-content-between">
													        <button class="btn btn-link fw600 green green-link collapsed" data-toggle="collapse" data-target="#collapse{{ $faqNanny->id }}" aria-expanded="true" aria-controls="collapse{{ $faqNanny->id }}">
													          {{ $faqNanny->question }}
													        </button>
													        <div class="d-flex align-items-center">		
													        	<a class="m-1 green" href='{{ url("/admin/pages/edit/faq/{$faqNanny->id}") }}'>Edit</a>
																<a class="m-1 green" href="#deleteModal" data-toggle="modal" data-id="{{ $faqNanny->id }}" data-question="{{ $faqNanny->question }}">Delete</a>
													        </div>
													        
													      </div>
													    </div>
													    <div id="collapse{{ $faqNanny->id }}" class="collapse" aria-labelledby="heading{{ $faqNanny->id }}" data-parent="#for-nanny-accordion">
													      <div class="card-body">
													        {{ $faqNanny->answer }}
													      </div>
													    </div>
												    </div>	
										    	@endforeach
									    	@else
												<div>
													<p>No questions available</p>
												</div>													
											@endif							    
							      		</div>								

										<div class="table-container-footer clearfix">
											 {{ $faqsNanny->links() }}
										</div>
									</div>
								</div>

								<!-- for parent tab -->
				      			<div class="tab-pane fade" id="for-parent" role="tabpanel" aria-labelledby="for-parent-tab">
							      	<div class="table-container mb-5 p-4">
										<div id="for-parent-accordion">
							      			@if(count($faqsParent) > 0)
							                    @foreach($faqsParent as $faqParent)
									      			<div class="card">
													    <div class="card-header" id="heading{{ $faqParent->id }}">
													      <div class="mb-0 d-flex justify-content-between">
													        <button class="btn btn-link fw600 green green-link collapsed" data-toggle="collapse" data-target="#collapse{{ $faqParent->id }}" aria-expanded="true" aria-controls="collapse{{ $faqParent->id }}">
													          {{ $faqParent->question }}
													        </button>
													        <div class="d-flex align-item-center">
													        	<a class="m-1 green" href='{{ url("/admin/pages/edit/faq/{$faqParent->id}") }}'>Edit</a>
																<a class="m-1 green" href="#deleteModal" data-toggle="modal" data-id="{{ $faqParent->id }}" data-question="{{ $faqParent->question }}">Delete</a>
													        </div>
													        
													      </div>
													    </div>
													    <div id="collapse{{ $faqParent->id }}" class="collapse" aria-labelledby="heading{{ $faqParent->id }}" data-parent="#for-parent-accordion">
													      <div class="card-body">
													        {{ $faqParent->answer }}
													      </div>
													    </div>
												    </div>	
										    	@endforeach
									    	@else
												<div>
													<p>No questions available</p>
												</div>													
											@endif							    
							      		</div>								

										<div class="table-container-footer clearfix">
											 {{ $faqsParent->links() }}
										</div>
									</div>
								</div>

								<!-- about-tiny-steps tab -->
				      			<div class="tab-pane fade" id="about-tiny-steps" role="tabpanel" aria-labelledby="about-tiny-steps-tab">
							      	<div class="table-container mb-5 p-4">
										<div id="about-tiny-steps-accordion">
							      			@if(count($faqsAbout) > 0)
							                    @foreach($faqsAbout as $faqAbout)
									      			<div class="card">
													    <div class="card-header" id="heading{{ $faqAbout->id }}">
													      <div class="mb-0 d-flex justify-content-between">
													        <button class="btn btn-link fw600 green green-link collapsed" data-toggle="collapse" data-target="#collapse{{ $faqAbout->id }}" aria-expanded="true" aria-controls="collapse{{ $faqAbout->id }}">
													          {{ $faqAbout->question }}
													        </button>
													        <div class="d-flex align-item-center">
													        	<a class="m-1 green" href='{{ url("/admin/pages/edit/faq/{$faqAbout->id}") }}'>Edit</a>
																<a class="m-1 green" href="#deleteModal" data-toggle="modal" data-id="{{ $faqAbout->id }}" data-question="{{ $faqAbout->question }}">Delete</a>
													        </div>
													        
													      </div>
													    </div>
													    <div id="collapse{{ $faqAbout->id }}" class="collapse" aria-labelledby="heading{{ $faqAbout->id }}" data-parent="#about-tiny-steps-accordion">
													      <div class="card-body">
													        {{ $faqAbout->answer }}
													      </div>
													    </div>
												    </div>	
										    	@endforeach
									    	@else
												<div>
													<p>No questions available</p>
												</div>													
											@endif							    
							      		</div>								

										<div class="table-container-footer clearfix">
											 {{ $faqsAbout->links() }}
										</div>
									</div>
								</div>

								<!-- account-and-privacy tab -->
				      			<div class="tab-pane fade" id="account-and-privacy" role="tabpanel" aria-labelledby="account-and-privacy-tab">
							      	<div class="table-container mb-5 p-4">
										<div id="about-tiny-steps-accordion">
							      			@if(count($faqsPrivacy) > 0)
							                    @foreach($faqsPrivacy as $faqPrivacy)
									      			<div class="card">
													    <div class="card-header" id="heading{{ $faqPrivacy->id }}">
													      <div class="mb-0 d-flex justify-content-between">
													        <button class="btn btn-link fw600 green green-link collapsed" data-toggle="collapse" data-target="#collapse{{ $faqPrivacy->id }}" aria-expanded="true" aria-controls="collapse{{ $faqPrivacy->id }}">
													          {{ $faqPrivacy->question }}
													        </button>
													        <div class="d-flex align-item-center">
													        	<a class="m-1 green" href='{{ url("/admin/pages/edit/faq/{$faqPrivacy->id}") }}'>Edit</a>
													        	<a class="m-1 green" href="#deleteModal" data-toggle="modal" data-id="{{ $faqPrivacy->id }}" data-question="{{ $faqPrivacy->question }}">Delete</a>
													        </div>
													        
													      </div>
													    </div>
													    <div id="collapse{{ $faqPrivacy->id }}" class="collapse" aria-labelledby="heading{{ $faqPrivacy->id }}" data-parent="#about-tiny-steps-accordion">
													      <div class="card-body">
													        {{ $faqPrivacy->answer }}
													      </div>
													    </div>
												    </div>	
										    	@endforeach
									    	@else
												<div>
													<p>No questions available</p>
												</div>													
											@endif							    
							      		</div>								

										<div class="table-container-footer clearfix">
											 {{ $faqsPrivacy->appends(Request::except('page'))->links() }}
										</div>
									</div>
								</div>
					      	</div>

					    </section>
					    <section>
							<div class="border-lg-grey p-4">									
								<form method="POST" action="{{ url('/admin/add-faq') }}">
						      	@csrf	
						      		<input id="inputCategory" type="hidden" name="category">										
									
									<div class="question padT10">
																							
										<div class="edit-title-container padTB10">
											<span class="fw600">Question<span class="required"> *</span></span>
											<div class="padT10">
												<input name="question" type="text" class="edit-title-input col-12 padLR10" value="{{ old('question') }}">
												@if ($errors->has('question'))
	                                                <span class="help-block">
	                                                    {{ $errors->first('question') }}
	                                                </span>
	                                            @endif
											</div>
										</div>
										<div class="edit-title-container padT10">
											<span class="fw600">Answer<span class="required"> *</span></span>
											<div class="padT10">
												<textarea name="answer" id="content-editor" rows="3">{{ old('answer') }}</textarea>
												@if ($errors->has('answer'))
	                                                <span class="help-block">
	                                                    {{ $errors->first('answer') }}
	                                                </span>
	                                            @endif
											</div>
										</div>
									</div>
									<div class="padT10">
										<button type="submit" class="custom-btn btn-green btn-green-whitebg btn-primary dashboard-btn ml-2 mt-2">Add Question</button>
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

<!-- Delete confirmation modal -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Do you really want to delete "<span class="faq-title"></span>"?</strong></p>                
            </div>
            <div class="modal-body d-flex">
            	
                    
				<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<p> Are you sure you want to do this? this cannot be undone. </p>
			</div>
			<form method="POST" action='{{ url("/admin/faq/delete") }}'>	
            @csrf
            @method('DELETE')
	            <input type="hidden" name="faqId">	
				<div class="modal-footer">   
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button class="dlt-faq dlt-btn">Delete</button>      
				</div>                  
			</form>
        </div>
      </div>
</div>


@endsection


