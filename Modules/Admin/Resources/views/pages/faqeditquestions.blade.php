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
							<a class="green" href='{{ url("/admin/pages/manage-faq") }}'><< Back to Manage FAQs page</a>
						</div>
						
					    <section>
					    	<h2>Edit FAQ Item</h2>
							<div class="border-lg-grey p-4">									
								<form method="POST" action="{{ url('/admin/update-faq',array($faqItem->id)) }}">
						      	@csrf											
									
									<div class="faq-setting padT10">
																							
										<div class="edit-title-container padTB10">
											<span class="fw600">Title<span class="required"> *</span></span>
											<div class="padT10">
												<input name="question" type="text" class="edit-title-input col-12 padLR10" value="{{ $faqItem->question }}">	
												@if ($errors->has('question'))
	                                                <span class="help-block">
	                                                    {{ $errors->first('question') }}
	                                                </span>
	                                            @endif
											</div>
										</div>
										<div class="edit-content-container padT10">
				      						<span class="fw600">Content<span class="required"> *</span></span>
			      							<div class="padT10">
											    <textarea name="answer" id="content-editor" class="mceEditor">{{ $faqItem->answer }}</textarea>
											    @if ($errors->has('answer'))
                                                    <span class="help-block">
                                                        {{ $errors->first('answer') }}
                                                    </span>
                                                @endif
											</div>
										</div>
									</div>
									<div class="padT10">
										<button type="submit" class="custom-btn btn-green btn-green-whitebg btn-primary dashboard-btn ml-2 mt-2">Update</button>
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

@endsection


