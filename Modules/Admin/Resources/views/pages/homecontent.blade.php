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
					      	<h2>Edit Home Page</h2>
					      	<div class="row">
					      		<!-- EDIT CONTENT FORM START -->
					      		<form method="POST" action="{{ url('/admin/update-content/1') }}" enctype="multipart/form-data" class="edit-content-form">
					      		@csrf
					      		<div class="col-xl-9">
					      			@if(Session::has('response'))
						                <div class="alert alert-success">
						                    {{ Session::get('response') }}
						                </div>
						            @endif
					      			<div class="white-box-shadow">
					      				<div class="edit-title brown">
					      					<span>{{ $page->page_titles }}</span>
					      				</div>
					      				<div class="edit-body">
					      					<div class="padB10 brown fontS22">Section</div>
					      					<!-- BANNER SECTION -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>1</span></div>
						      						<div class="brown pull-left">Banner section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
															<input name="banner-hidden" type="checkbox" class="custom-control-input" id="edit-hide-banner" @if($showSection['banner'] == 'hide')
																checked="checked"
															@endif
															>
															<label class="custom-control-label" for="edit-hide-banner"></label>
														</div>
							      				</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<textarea name="banner-title" id="content-editor" class="mceEditor">
														    	{{ $passedContents['banner-title'] }}
														    </textarea>
						      							</div>
						      						</div>
					      						</div>
						      					<div class="edit-body-row">
						      						<div class="edit-image-container">
							      						<span>Background image</span>
						      							<div class="padT10">
															<img class="photo-frame" src="{{ $passedContents['banner-bg'] ? $passedContents['banner-bg'] : '/images/image-placeholder.jpg' }}" alt="">
														</div>
							      						<div class="padT10">
															<label for="edit-banner-img" class="fileBtn">
															    Choose File
															</label>
															<input name="banner-bg" class="file-upload hide" id="edit-banner-img" type="file" value="{{ $passedContents['banner-bg'] }}" />
															<span class="fileName">{{ $passedContents['banner-bg'] ? $passedContents['banner-bg'] : 'No file chosen'}}</span>
														</div>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="content-container">
																<span>Sign Up Text</span>
																<div class="padT10">
																<input name="banner-sign-up-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['banner-sign-up-title'] }}">
																</div>
						      							<div class="padT10">
														    <textarea name="banner-content" id="content-editor" class="mceEditor">
														    	{{ $passedContents['banner-content'] }}
														    </textarea>
														</div>
													</div>
						      					</div>
						      				</div>
						      				<!-- NANNIES AND BABYSITTERS -->
						      				<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>2</span></div>
						      						<div class="brown pull-left">Nannies and babysitters section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						
							      						<div class="custom-control custom-checkbox">
															<input name="nannies-and-babysitters-hidden" type="checkbox" class="custom-control-input" id="edit-hide-nannies"
																@if($showSection['nannies-and-babysitters'] == 'hide')
																	checked="checked"
																@endif

															>
															<label class="custom-control-label" for="edit-hide-nannies"></label>
														</div>
													
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="nannies-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['nannies-title'] }}">
						      							</div>
						      						</div>
						      						<div class="edit-content-container padT10">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="nannies-content" id="content-editor" class="mceEditor">{{ $passedContents['nannies-content'] }}</textarea>
														</div>
													</div>
						      					</div>
						      				</div>
						      				<!-- HOW IT WORKS -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>3</span></div>
						      						<div class="brown pull-left">How it works section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
														<input name="how-it-works-hidden" type="checkbox" class="custom-control-input" id="edit-hide-howitworks"
															@if($showSection['how-it-works'] == 'hide')
																checked="checked"
															@endif
														>
														<label class="custom-control-label" for="edit-hide-howitworks"></label>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="how-it-works-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['how-it-works-title'] }}">
						      							</div>
						      						</div>
						      						<div class="edit-content-container padT10">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="how-it-works-content" id="content-editor" class="mceEditor">{{ $passedContents['how-it-works-content'] }}</textarea>
														</div>
													</div>
						      					</div>
						      					<div class="edit-body-row row no-gutters p-0">
						      						<div class="edit-body-col col-12 col-lg-6 col-xl-4">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>1</span></div>
							      							<div class="brown pull-left">Column 1</div>
							      						</div>
														<div class="edit-title-container padT10">
								      						<span>Title</span>
								      						<div class="padT10">
							      								<input name="how-it-works-col1-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['how-it-works-col1-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{ $passedContents['how-it-works-col1-img'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							
																	<label for="edit-howitworks-img1" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="how-it-works-col1-img" class="file-upload hide" id="edit-howitworks-img1" type="file" value="{{ $passedContents['how-it-works-col1-img'] }}" />
																	<span class="fileName">{{ $passedContents['how-it-works-col1-img'] }}</span>
																
															</div>
														</div>
							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="how-it-works-col1-content" id="content-editor" class="mceEditor">{{ $passedContents['how-it-works-col1-content'] }}</textarea>
															</div>
														</div>
													</div>
						      						<div class="edit-body-col col-12 col-lg-6 col-xl-4">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>2</span></div>
							      							<div class="brown pull-left">Column 2</div>
							      						</div>
														<div class="edit-title-container padT10">
								      						<span>Title</span>
								      						<div class="padT10">
							      								<input name="how-it-works-col2-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['how-it-works-col2-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{ $passedContents['how-it-works-col2-img'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							
																	<label for="edit-howitworks-img2" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="how-it-works-col2-img" class="file-upload hide" id="edit-howitworks-img2" type="file" value="{{ $passedContents['how-it-works-col2-img'] }}" />
																	<span class="fileName">{{ $passedContents['how-it-works-col2-img'] }}</span>
																
															</div>
														</div>
							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="how-it-works-col2-content" id="content-editor" class="mceEditor">{{ $passedContents['how-it-works-col2-content'] }}</textarea>
															</div>
														</div>
													</div>
						      						<div class="edit-body-col col-12 col-lg-12 col-xl-4">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>3</span></div>
							      							<div class="brown pull-left">Column 3</div>
							      						</div>
														<div class="edit-title-container padT10">
								      						<span>Title</span>
								      						<div class="padT10">
							      								<input name="how-it-works-col3-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['how-it-works-col3-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{ $passedContents['how-it-works-col3-img'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							
																	<label for="edit-howitworks-img3" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="how-it-works-col3-img" class="file-upload hide" id="edit-howitworks-img3" type="file" value="{{ $passedContents['how-it-works-col3-img'] }}" />
																	<span class="fileName">{{ $passedContents['how-it-works-col3-img'] }}</span>
																
															</div>
														</div>
							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="how-it-works-col3-content" id="content-editor" class="mceEditor">{{ $passedContents['how-it-works-col3-content'] }}</textarea>
															</div>
														</div>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container d-flex flex-wrap">
														<div class="m-1">
															<span>CTA</span>
															<span class="marR10">Button text</span>
															<input name="how-it-works-btn-text" type="text" class="edit-title-input padLR10" value="{{ $passedContents['how-it-works-btn-text'] }}">
														</div> 
														<div class="m-1"> 
															  <span class="marR10">Button url</span>
					      									<input name="how-it-works-btn-link" type="text" class="edit-title-input padLR10" value="{{ $passedContents['how-it-works-btn-link'] }}">
														</div>
													</div>
						      					</div>
						      				</div>
						      				<!-- SCREENING NANNY & BABYSITTER -->
						      			<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>4</span></div>
						      						<div class="brown pull-left">Screening section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						
							      						<div class="custom-control custom-checkbox">
															<input name="screening-hidden" type="checkbox" class="custom-control-input" id="edit-hide-screening"
																@if($showSection['screening'] == 'hide')
																	checked="checked"
																@endif

															>
															<label class="custom-control-label" for="edit-hide-screening"></label>
														</div>
													
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="screening-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['screening-title'] }}">
						      							</div>
						      						</div>

						      						<div class="edit-body-row row no-gutters p-0">
						      						<div class="edit-body-col col-12 col-lg-6 col-xl-4">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>1</span></div>
							      							<div class="brown pull-left">Column 1</div>
							      						</div>

						      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{$passedContents['steps-screens-contentimg1'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							
																	<label for="edit-screens-contentimg1" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="steps-screens-contentimg1" class="file-upload hide" id="edit-screens-contentimg1" type="file" value="{{ $passedContents['steps-screens-contentimg1'] }}" />
																	<span class="fileName">{{ $passedContents['steps-screens-contentimg1'] }}</span>
															</div>
													</div> 
						      						<div class="edit-content-container padT10">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="screening-content" id="content-editor" class="mceEditor">{{ $passedContents['screening-content'] }}</textarea>
														</div>
													</div>
						      					</div>


						      					<!-- // -->

						      					<div class="edit-body-col col-12 col-lg-6 col-xl-4">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>1</span></div>
							      							<div class="brown pull-left">Column 2</div>
							      						</div>

						      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{$passedContents['steps-screens-contentimg2'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							
																	<label for="edit-screens-contentimg2" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="steps-screens-contentimg2" class="file-upload hide" id="edit-screens-contentimg2" type="file" value="{{ $passedContents['steps-screens-contentimg2'] }}" />
																	<span class="fileName">{{ $passedContents['steps-screens-contentimg2'] }}</span>
															</div>
													</div> 
						      						<div class="edit-content-container padT10">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="screening-content1" id="content-editor" class="mceEditor">{{ $passedContents['screening-content1'] }}</textarea>
														</div>
													</div>
						      					</div>
						      					

						      				</div>
						      			</div>


						      				</div><!-- end -->
						      			

						      				<!-- TESTIMONIALS SECTION -->
						      				<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>5</span></div>
						      						<div class="brown pull-left">Testimonials section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						
							      						<div class="custom-control custom-checkbox">
															<input name="testimonials-hidden" type="checkbox" class="custom-control-input" id="edit-hide-testimonials" 						
																@if($showSection['testimonials'] == 'hide')
																	checked="checked"
																@endif
															>
															<label class="custom-control-label" for="edit-hide-testimonials"></label>
														</div>
													
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="testi-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['testi-title'] }}">
						      							</div>
						      						</div>
						      					</div>
						      					<div class="pad10 text-right">
													<a class="custom-btn btn-green btn-green-whitebg fontW300 py-2 px-3" href="/admin/pages/manage-testimonials">Manage Testimonials</a>
												</div>
						      				</div>

						      				<!-- BROWN BACKGROUND REGISTER NOW -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>6</span></div>
						      						<div class="brown pull-left">Register now section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
															<input name="cta-1st-hidden" type="checkbox" class="custom-control-input" id="edit-hide-brownbg-textCTA"
																@if($showSection['cta-1st'] == 'hide')
																	checked="checked"
																@endif

															>
															<label class="custom-control-label" for="edit-hide-brownbg-textCTA"></label>
														</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-content-container">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="cta-1st-title" id="content-editor" class="mceEditor">{{ $passedContents['cta-1st-title'] }}</textarea>
															</div>
														</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-button-container">
						      							<span>CTA</span>
						      							<span class="marR10">Button text</span>
					      								<input name="cta-1st-btn-text" type="text" class="edit-title-input padLR10" value="{{ $passedContents['cta-1st-btn-text'] }}">
						      						</div>
						      					</div>
						      				</div>

						      				<!-- MENTORS -->
						      				<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>7</span></div>
						      						<div class="brown pull-left">Mentors section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						
							      						<div class="custom-control custom-checkbox">
															<input name="mentors-hidden" type="checkbox" class="custom-control-input" id="edit-hide-mentors"
																@if($showSection['mentors'] == 'hide')
																	checked="checked"
																@endif

															>
															<label class="custom-control-label" for="edit-hide-mentors"></label>
														</div>
													
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="mentors-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['mentors-title'] }}">
						      							</div>
						      						</div>
						      						<div class="edit-content-container padT10">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="mentors-content" id="content-editor" class="mceEditor">{{ $passedContents['mentors-content'] }}</textarea>
														</div>
													</div>
													<div class="edit-body-row">
							      						<div class="edit-title-container d-flex flex-wrap">
															<div class="m-1">
																<span>CTA</span>
																<span class="marR10">Button text</span>
																<input name="mentors-btn-text" type="text" class="edit-title-input padLR10" value="{{ $passedContents['mentors-btn-text'] }}">
															</div> 															
														</div>
							      					</div>
						      					</div>
						      				</div>

						      				<!-- SERVICES SECTION -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>8</span></div>
						      						<div class="brown pull-left">Services section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
														<input name="services-hidden" type="checkbox" class="custom-control-input" id="edit-hide-services"
															@if($showSection['services'] == 'hide')
																checked="checked"
															@endif
														>
														<label class="custom-control-label" for="edit-hide-services"></label>
													</div>
						      					</div>
						      					<div class="edit-body-row row no-gutters p-0">
						      						<div class="edit-body-col col-12 col-lg-6 col-xl-4">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>1</span></div>
							      							<div class="brown pull-left">Column 1</div>
							      						</div>
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{ $passedContents['services-image1'] }}" alt="">
															</div>
								      						<div class="padT10">
																<label for="edit-services-img1" class="fileBtn">
																    Choose File
																</label>
																<input name="services-image1" class="file-upload hide" id="edit-services-img1" type="file" value="{{ $passedContents['services-image1'] }}" />
																<span class="fileName">{{ $passedContents['services-image1'] }}</span>
															</div>
														</div>
														<div class="edit-title-container padT10">
								      						<span>Title</span>
								      						<div class="padT10">
							      								<input name="services-title1" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['services-title1'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="services-content1" id="content-editor" class="mceEditor">{{ $passedContents['services-content1'] }}</textarea>
															</div>
														</div>
														<div class="edit-content-container padT10">
								      						<span>Popup Content</span>
							      							<div class="padT10">
															    <textarea name="service-modal1" id="content-editor" class="mceEditor">{{ $passedContents['service-modal1'] }}</textarea>
															</div>
														</div>
													</div>
						      						<div class="edit-body-col col-12 col-lg-6 col-xl-4">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>2</span></div>
							      							<div class="brown pull-left">Column 2</div>
							      						</div>
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{ $passedContents['services-image2'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							
																	<label for="edit-services-img2" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="services-image2" class="file-upload hide" id="edit-services-img2" type="file" value="{{ $passedContents['services-image2'] }}" />
																	<span class="fileName">{{ $passedContents['services-image2'] }}</span>
																
															</div>
														</div>
														<div class="edit-title-container padT10">
								      						<span>Title</span>
								      						<div class="padT10">
							      								<input name="services-title2" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['services-title2'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="services-content2" id="content-editor" class="mceEditor">{{ $passedContents['services-content2'] }}</textarea>
															</div>
														</div>
														<div class="edit-content-container padT10">
								      						<span>Popup Content</span>
							      							<div class="padT10">
															    <textarea name="service-modal2" id="content-editor" class="mceEditor">{{ $passedContents['service-modal2'] }}</textarea>
															</div>
														</div>
													</div>
						      						<div class="edit-body-col col-12 col-lg-12 col-xl-4">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>3</span></div>
							      							<div class="brown pull-left">Column 3</div>
							      						</div>
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{ $passedContents['services-image3'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							
																	<label for="edit-services-img3" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="services-image3" class="file-upload hide" id="edit-services-img3" type="file" value="{{ $passedContents['services-image3'] }}" />
																	<span class="fileName">{{ $passedContents['services-image3'] }}</span>
																
															</div>
														</div>
														<div class="edit-title-container padT10">
								      						<span>Title</span>
								      						<div class="padT10">
							      								<input name="services-title3" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['services-title3'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="services-content3" id="content-editor" class="mceEditor">{{ $passedContents['services-content3'] }}</textarea>
															</div>
														</div>
														<div class="edit-content-container padT10">
								      						<span>Popup Content</span>
							      							<div class="padT10">
															    <textarea name="service-modal3" id="content-editor" class="mceEditor">{{ $passedContents['service-modal3'] }}</textarea>
															</div>
														</div>
													</div>
						      					</div>
						      				</div>

						      				<!-- TYPES OF SITTERS -->
						      				<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>9</span></div>
						      						<div class="brown pull-left">Types of sitter section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
														<input name="sitter-types-hidden" type="checkbox" class="custom-control-input" id="edit-hide-sitter-types"
															@if($showSection['sitter-types'] == 'hide')
																checked="checked"
															@endif
														>
														<label class="custom-control-label" for="edit-hide-sitter-types"></label>
													</div>
						      					</div>
						      					<div class="edit-body-row row no-gutters p-0">
						      						<div class="edit-title-container edit-body-col col-12">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="sitter-types-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['sitter-types-title'] }}">
						      							</div>
						      						</div>
						      						<div class="edit-body-col col-12 col-lg-6">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>1</span></div>
							      							<div class="brown pull-left">Column 1</div>
							      						</div>	
							      							<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{$passedContents['sitter-image-content1'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							
																	<label for="sitter-image-content1" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="sitter-image-content1" class="file-upload hide" id="sitter-image-content1" type="file" value="{{ $passedContents['sitter-image-content1'] }}" />
																	<span class="fileName">{{ $passedContents['sitter-image-content1'] }}</span>
																
															</div>
														</div>

							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="sitter-types-content1" id="content-editor" class="mceEditor">{{ $passedContents['sitter-types-content1'] }}</textarea>
															</div>
														</div>
													</div>
													<div class="edit-body-col col-12 col-lg-6">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>2</span></div>
							      							<div class="brown pull-left">Column 2</div>
							      						</div>							      						
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{$passedContents['sitter-image-content2'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							
																	<label for="edit-howitworks-img1" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="sitter-image-content2" class="file-upload hide" id="sitter-image-content2" type="file" value="{{ $passedContents['sitter-image-content2'] }}" />
																	<span class="fileName">{{ $passedContents['sitter-image-content2'] }}</span>
																
															</div>
														</div>
							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="sitter-types-content2" id="content-editor" class="mceEditor">{{ $passedContents['sitter-types-content2'] }}</textarea>
															</div>
														</div>
													</div>
													<div class="edit-body-col col-12 col-lg-6">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>3</span></div>
							      							<div class="brown pull-left">Column 3</div>
							      						</div>
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{$passedContents['sitter-image-content3'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							
																	<label for="sitter-image-content3" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="sitter-image-content3" class="file-upload hide" id="sitter-image-content3" type="file" value="{{ $passedContents['sitter-image-content3'] }}" />
																	<span class="fileName">{{ $passedContents['sitter-image-content3'] }}</span>
																
															</div>
														</div>

							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="sitter-types-content3" id="content-editor" class="mceEditor">{{ $passedContents['sitter-types-content3'] }}</textarea>
															</div>
														</div>
													</div>
													<div class="edit-body-col col-12 col-lg-6">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>4</span></div>
							      							<div class="brown pull-left">Column 4</div>
							      						</div>
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{$passedContents['sitter-image-content4'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							
																	<label for="edit-howitworks-img1" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="sitter-image-content4" class="file-upload hide" id="sitter-image-content4" type="file" value="{{ $passedContents['sitter-image-content4'] }}" />
																	<span class="fileName">{{ $passedContents['sitter-image-content4'] }}</span>
																
															</div>
														</div>							      						
							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="sitter-types-content4" id="content-editor" class="mceEditor">{{ $passedContents['sitter-types-content4'] }}</textarea>
															</div>
														</div>
													</div>
						      					</div>
						      				</div>		
						      				
						      				<!-- BROWN BACKGROUND REGISTER NOW -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>10</span></div>
						      						<div class="brown pull-left">Register now section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
															<div class="custom-control custom-checkbox">
																<input name="cta-2nd-hidden" type="checkbox" class="custom-control-input" id="edit-hide-brownbg-textCTA2"
																	@if($showSection['cta-2nd'] == 'hide')
																		checked="checked"
																	@endif
																>
																<label class="custom-control-label" for="edit-hide-brownbg-textCTA2"></label>
															</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-content-container">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="cta-2nd-title" id="content-editor" class="mceEditor">{{ $passedContents['cta-2nd-title'] }}</textarea>
														</div>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-button-container">
						      							<span>CTA</span>
							      						
							      							<span class="marR10">Button text</span>
						      								<input name="cta-2nd-btn-text" type="text" class="edit-title-input padLR10" value="{{ $passedContents['cta-2nd-btn-text'] }}">
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
											  <p class="line-height13"><i class="far fa-calendar marR10"></i>Last modified <span class="marL15">
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
					      				<form method="POST" action="{{ url('/admin/update-meta/1') }}">
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