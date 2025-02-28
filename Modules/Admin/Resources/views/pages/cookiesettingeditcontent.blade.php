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
							<a class="green" href='{{ url("/admin/pages/manage-cookie-settings") }}'><< Back to Manage Cookie Settings page</a>
						</div>
						
					    <section>
					    	<h2>Edit Cookie Settings Item</h2>
							<div class="border-lg-grey p-4">									
								<form method="POST" action="{{ url('/admin/update-cookie-setting',array($cookieItem->id)) }}">
						      	@csrf											
									
									<div class="cookie-setting padT10">
																							
										<div class="edit-title-container padTB10">
											<span class="fw600">Title<span class="required"> *</span></span>
											<div class="padT10">
												<input name="title" type="text" class="edit-title-input col-12 padLR10" value="{{ $cookieItem->title }}">	
												@if ($errors->has('title'))
	                                                <span class="help-block">
	                                                    {{ $errors->first('title') }}
	                                                </span>
	                                            @endif
											</div>
										</div>
										<div class="edit-content-container padT10">
				      						<span class="fw600">Content<span class="required"> *</span></span>
			      							<div class="padT10">
											    <textarea name="content" id="content-editor" class="mceEditor">{{ $cookieItem->content }}</textarea>
											    @if ($errors->has('content'))
                                                    <span class="help-block">
                                                        {{ $errors->first('content') }}
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


