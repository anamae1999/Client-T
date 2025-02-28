@extends('admin::layouts.master')
@section('content')
<section class="gray-bg">
	<div class="container-fluid">
		<div class="row no-gutters">
			@include('admin::internals.dashboardtab')
			<div class="dashboard-tab-content padLR60">
			    <div class="tab-content" id="dashboard-tab-content">
					<div class="tab-pane fade show active" id="v-pills-pages">
						<div class="pt-3 pb-3">	
							<a class="green" href='{{ url("/admin/pages") }}'><< Back to pages</a>
						</div>
						<section>
					      	<h2>Edit About Us Page</h2>
					      	<div class="row">
					      		<!-- EDIT CONTENT FORM START -->
					      		<form method="POST" action="{{ url('/admin/update-content/5') }}" enctype="multipart/form-data" class="edit-content-form">
                                	@csrf
					      		<div class="col-xl-9">
					      			@if(Session::has('response'))
						                <div class="alert alert-success">
						                    {{ Session::get('response') }}
						                </div>
						            @endif
					      			<div class="white-box-shadow">
					      				<div class="edit-title brown">
					      					<span>About us</span>
					      				</div>
					      				<div class="edit-body">
					      					<div class="padB10 brown fontS22">Section</div>
						      				<!-- ABOUT US SECTION -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>1</span></div>
						      						<div class="brown pull-left">About us section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
														<input name="about-us-hidden" type="checkbox" class="custom-control-input" id="about-us-hidden"
														@if($showSection['about-us'] == 'hide')
															checked="checked"
														@endif
														>
														<label class="custom-control-label" for="about-us-hidden"></label>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="about-us-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['about-us-title'] }}">
						      							</div>
						      						</div>
						      						<div class="edit-content-container padT10">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="about-us-content" id="content-editor" class="mceEditor">{{ $passedContents['about-us-content'] }}</textarea>
														</div>
													</div>
						      					</div>
						      				</div>
						      				<!-- MISSION SECTION -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>2</span></div>
						      						<div class="brown pull-left">Mission section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
														<input name="mission-hidden" type="checkbox" class="custom-control-input" id="mission-hidden"
														@if($showSection['mission'] == 'hide')
															checked="checked"
														@endif
														>
														<label class="custom-control-label" for="mission-hidden"></label>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="mission-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['mission-title'] }}">
						      							</div>
						      						</div>
						      						<div class="edit-image-container padT10">
							      						<span>Background image</span>
						      							<div class="padT10">
															<img class="photo-frame" src="{{ $passedContents['mission-image'] }}" alt="">
														</div>
							      						<div class="padT10">
							      							<div>
																<label for="edit-mission-img" class="fileBtn">
																    Choose File
																</label>
																<input name="mission-image" class="file-upload hide" id="edit-mission-img" type="file" value="{{ $passedContents['mission-image'] }}" />
																<span class="fileName">{{ $passedContents['mission-image'] }}</span>
															</div>
														</div>
													</div>
						      						<div class="edit-content-container padT10">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="mission-content" id="content-editor" class="mceEditor">{{ $passedContents['mission-content'] }}</textarea>
														</div>
													</div>
						      					</div>
						      				</div>
						      				<!-- VISION SECTION -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>3</span></div>
						      						<div class="brown pull-left">Vision section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
														<input name="vision-hidden" type="checkbox" class="custom-control-input" id="vision-hidden"
														@if($showSection['vision'] == 'hide')
															checked="checked"
														@endif
														>
														<label class="custom-control-label" for="vision-hidden"></label>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="vision-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['vision-title'] }}">
						      							</div>
						      						</div>
						      						<div class="edit-image-container padT10">
							      						<span>Background image</span>
						      							<div class="padT10">
															<img class="photo-frame" src="{{ $passedContents['vision-image'] }}" alt="">
														</div>
							      						<div class="padT10">
							      							<div>
																<label for="edit-vision-img" class="fileBtn">
																    Choose File
																</label>
																<input name="vision-image" class="file-upload hide" id="edit-vision-img" type="file" value="{{ $passedContents['vision-image'] }}" />
																<span class="fileName">{{ $passedContents['vision-image'] }}</span>
															</div>
														</div>
													</div>
						      						<div class="edit-content-container padT10">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="vision-content" id="content-editor" class="mceEditor">{{ $passedContents['vision-content'] }}</textarea>
														</div>
													</div>
						      					</div>
						      				</div>						      				
						      				<!-- AWARDS AND CERT SECTION -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>4</span></div>
						      						<div class="brown pull-left">Awards section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
														<input name="awards-hidden" type="checkbox" class="custom-control-input" id="awards-hidden"
														@if($showSection['awards'] == 'hide')
															checked="checked"
														@endif
														>
														<label class="custom-control-label" for="awards-hidden"></label>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="awards-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['awards-title'] }}">
						      							</div>
						      						</div>
						      					</div>
						      					<div class="pad10 text-right">
													<a class="custom-btn btn-green btn-green-whitebg fontW300 py-2 px-3" href="/admin/pages/manage-awards-and-certifications">Manage Awards and Certification</a>
												</div>
						      				</div>

						      				<!-- ABOUT US TEXT ROW SECTION -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>5</span></div>
						      						<div class="brown pull-left">Text row section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
														<input name="about-us-text-row-hidden" type="checkbox" class="custom-control-input" id="about-us-text-row-hidden"
														@if($showSection['about-us-text-row'] == 'hide')
															checked="checked"
														@endif
														>
														<label class="custom-control-label" for="about-us-text-row-hidden"></label>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="about-us-text-row-heading" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['about-us-text-row-heading'] }}">
						      							</div>
						      						</div>
						      						<div class="edit-content-container padT10">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="about-us-text-row-content" id="content-editor" class="mceEditor">{{ $passedContents['about-us-text-row-content'] }}</textarea>
														</div>
													</div>
						      					</div>
						      				</div>
						      				<!-- OWNER SECTION -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>6</span></div>
						      						<div class="brown pull-left">Team member section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div>
							      						<div class="custom-control custom-checkbox">
															<input name="owners-hidden" type="checkbox" class="custom-control-input" id="owners-hidden"
															@if($showSection['owners'] == 'hide')
																checked="checked"
															@endif
															>
															<label class="custom-control-label" for="owners-hidden"></label>
														</div>
													</div>
						      					</div>
						      					<div class="pad10 text-right">
													<a class="custom-btn btn-green btn-green-whitebg fontW300 py-2 px-3" href="/admin/pages/manage-team-members">Manage Team Members</a>
												</div>						      					
						      				</div>
						      				<!-- BROWN BACKGROUND REGISTER NOW -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>7</span></div>
						      						<div class="brown pull-left">Register now section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div>
							      						<div class="custom-control custom-checkbox">
															<input name="about-us-cta-hidden" type="checkbox" class="custom-control-input" id="edit-hide-brownbg-textCTA"
															@if($showSection['about-us-cta'] == 'hide')
																checked="checked"
															@endif
															>
															<label class="custom-control-label" for="edit-hide-brownbg-textCTA"></label>
														</div>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-content-container">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="about-us-cta-title" id="content-editor" class="mceEditor">{{ $passedContents['about-us-cta-title'] }}</textarea>
														</div>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-button-container">
						      							<span>CTA</span>
							      						<span class="marR10">Button text</span>
						      							<input name="about-us-cta-btn-text" type="text" class="edit-title-input padLR10" value="{{ $passedContents['about-us-cta-btn-text'] }}">
						      						</div>
						      					</div>
						      				</div>
					      				</div>
					      			</div>
					      		</div>
					      		<div class="col-xl-3 pl-auto pt-4 pt-xl-0 pl-xl-0">
					      			<div class="white-box-shadow">
					      				<div class="edit-title brown">
					      					<span>Page Info</span>
					      				</div>
					      				<div class="edit-body p-4">
					      					<div class="brown fontS16">
											  <p class="line-height13"><i class="far fa-calendar marR10"></i>	Last modified <span class="marL15">
					      						@if($page->updated_at)
					      							{{ date_format($page->updated_at, "d/m/y H:i:s") }}
					      						@endif
					      						</span></p>
					      					</div>
					      				</div>
					      				<div class="edit-footer gray-bg text-right p-3">
					      					<button type="submit" class="custom-btn btn-green btn-green-whitebg fontW300 py-2 px-3">Update</button>
					      				</div>
					      			</div>
					      		</form>
					      		<!-- EDIT CONTENT FORM END -->
					      			<div class="white-box-shadow">
					      				<div class="edit-title brown">
					      					<span>Meta Data</span>
					      				</div>
					      				<!-- EDIT META FORM START -->
					      				<form method="POST" action="{{ url('/admin/update-meta/5') }}">
					      				@csrf
						      				<div class="edit-body">
						      					<div class="edit-title-container">
						      						<span class="brown">Meta title</span>
						      						<div class="padT10">
					      								<input name="meta-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $page->meta_titles }}">
					      							</div>
					      						</div>
						      					<div class="edit-title-container padT10">
						      						<span class="brown">Meta description</span>
						      						<div class="padT10">
					      								<textarea class="col-12 padLR10" name="meta-description">{{ $page->meta_descriptions }}</textarea>
					      							</div>
					      						</div>
						      					<div class="edit-title-container padT10">
						      						<span class="brown">Meta keywords</span>
						      						<div class="padT10">
					      								<input name="meta-keywords" type="text" class="edit-title-input col-12 padLR10" placeholder="Insert keywords" value="{{ $page->meta_keywords }}">
					      							</div>
					      						</div>
						      				</div>
						      				<div class="edit-footer gray-bg text-right p-3">
						      					<button type="submit" class="custom-btn btn-green btn-green-whitebg fontW300 py-2 px-3">Update</button>
						      				</div>
				      					</form>
				      					<!-- EDIT META FORM END -->
					      			</div>
					      		</div>
					      	</div>
					    </section>
					</div>
			    </div>
		  	</div>
		</div>
	</div>
</section>
@endsection