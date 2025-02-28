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
					      	<h2>Edit How It Works Page</h2>
					      	<div class="row">
					      		<!-- EDIT CONTENT FORM START -->
					      		<form method="POST" action="{{ url('/admin/update-content/2') }}" enctype="multipart/form-data" class="edit-content-form">
					      		@csrf
					      		<div class="col-xl-9">
					      			@if(Session::has('response'))
						                <div class="alert alert-success">
						                    {{ Session::get('response') }}
						                </div>
						            @endif
					      			<div class="white-box-shadow">
					      				<div class="edit-title brown">
					      					<span>How it works</span>
					      				</div>
					      				<div class="edit-body">
					      					<div class="padB10 brown fontS22">Section</div>
						      				<!-- INTRO SECTION -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>1</span></div>
						      						<div class="brown pull-left">How it works section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
														<input name="how-it-works-main-hidden" type="checkbox" class="custom-control-input" id="edit-hide-intro"
															@if($showSection['how-it-works-main'] == 'hide')
																checked="checked"
															@endif
														>
														<label class="custom-control-label" for="edit-hide-intro"></label>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="how-it-works-main-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['how-it-works-main-title'] }}">
						      							</div>
						      						</div>
						      						<div class="edit-content-container padT10">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="how-it-works-main-content" id="content-editor" class="mceEditor">{{ $passedContents['how-it-works-main-content'] }}</textarea>
														</div>
													</div>
						      					</div>
						      				</div>
						      				<!-- FOR NANNY SECTION -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>2</span></div>
						      						<div class="brown pull-left">For Nanny section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
														<input name="for-nanny-hidden" type="checkbox" class="custom-control-input" id="edit-hide-nanny"
															@if($showSection['for-nanny'] == 'hide')
																checked="checked"
															@endif
														>
														<label class="custom-control-label" for="edit-hide-nanny"></label>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Tab Title</span>
							      						<div class="padT10">
						      								<input name="for-nanny-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['for-nanny-title'] }}">
						      							</div>
						      						</div>
						      					</div>
						      					<div class="edit-body-row row no-gutters p-0">
						      						<div class="edit-body-col col-12 col-lg-6 col-xl-4">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>1</span></div>
							      							<div class="brown pull-left">Step 1</div>
							      						</div>
														<div class="edit-title-container padT10">
								      						<span>Title</span>
								      						<div class="padT10">
							      								<input name="for-nanny-col1-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['for-nanny-col1-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{ $passedContents['for-nanny-col1-image'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							<div>
																	<label for="edit-nanny-step-img1" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="for-nanny-col1-image" class="file-upload hide" id="edit-nanny-step-img1" type="file" value="{{ $passedContents['for-nanny-col1-image'] }}" />
																	<span class="fileName">{{ $passedContents['for-nanny-col1-image'] }}</span>
																</div>
															</div>
														</div>
														<div class="edit-title-container padT10">
								      						<span>Content Title</span>
								      						<div class="padT10">
							      								<input name="for-nanny-col1-content-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['for-nanny-col1-content-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="for-nanny-col1-content" id="content-editor" class="mceEditor">{{ $passedContents['for-nanny-col1-content'] }}</textarea>
															</div>
														</div>
													</div>
						      						<div class="edit-body-col col-12 col-lg-6 col-xl-4">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>2</span></div>
							      							<div class="brown pull-left">Step 2</div>
							      						</div>
														<div class="edit-title-container padT10">
								      						<span>Title</span>
								      						<div class="padT10">
							      								<input name="for-nanny-col2-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['for-nanny-col2-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{ $passedContents['for-nanny-col2-image'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							<div>
																	<label for="edit-nanny-step-img2" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="for-nanny-col2-image" class="file-upload hide" id="edit-nanny-step-img2" type="file" value="{{ $passedContents['for-nanny-col2-image'] }}" />
																	<span class="fileName">{{ $passedContents['for-nanny-col2-image'] }}</span>
																</div>
															</div>
														</div>
														<div class="edit-title-container padT10">
								      						<span>Content Title</span>
								      						<div class="padT10">
							      								<input name="for-nanny-col2-content-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['for-nanny-col2-content-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="for-nanny-col2-content" id="content-editor" class="mceEditor">{{ $passedContents['for-nanny-col2-content'] }}</textarea>
															</div>
														</div>
													</div>
						      						<div class="edit-body-col col-12 col-lg-12 col-xl-4">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>3</span></div>
							      							<div class="brown pull-left">Step 3</div>
							      						</div>
														<div class="edit-title-container padT10">
								      						<span>Title</span>
								      						<div class="padT10">
							      								<input name="for-nanny-col3-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['for-nanny-col3-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{ $passedContents['for-nanny-col3-image'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							<div>
																	<label for="edit-nanny-step-img3" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="for-nanny-col3-image" class="file-upload hide" id="edit-nanny-step-img3" type="file" value="{{ $passedContents['for-nanny-col3-image'] }}" />
																	<span class="fileName">{{ $passedContents['for-nanny-col3-image'] }}</span>
																</div>
															</div>
														</div>
														<div class="edit-title-container padT10">
								      						<span>Content Title</span>
								      						<div class="padT10">
							      								<input name="for-nanny-col3-content-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['for-nanny-col3-content-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="for-nanny-col3-content" id="content-editor" class="mceEditor">{{ $passedContents['for-nanny-col3-content'] }}</textarea>
															</div>
														</div>
													</div>
						      					</div>
						      				</div>
						      				<!-- FOR PARENT SECTION -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>3</span></div>
						      						<div class="brown pull-left">For Parent section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
														<input name="for-parent-hidden" type="checkbox" class="custom-control-input" id="edit-hide-parent"
															@if($showSection['for-parent'] == 'hide')
																checked="checked"
															@endif>
														<label class="custom-control-label" for="edit-hide-parent"></label>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Tab Title</span>
							      						<div class="padT10">
						      								<input name="for-parent-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['for-parent-title'] }}">
						      							</div>
						      						</div>
						      					</div>
						      					<div class="edit-body-row row no-gutters p-0">
						      						<div class="edit-body-col col-12 col-lg-6 col-xl-4">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>1</span></div>
							      							<div class="brown pull-left">Step 1</div>
							      						</div>
														<div class="edit-title-container padT10">
								      						<span>Title</span>
								      						<div class="padT10">
							      								<input name="for-parent-col1-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['for-parent-col1-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{ $passedContents['for-parent-col1-image'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							<div>
																	<label for="edit-parent-step-img1" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="for-parent-col1-image" class="file-upload hide" id="edit-parent-step-img1" type="file" value="{{ $passedContents['for-parent-col1-image'] }}" />
																	<span class="fileName">{{ $passedContents['for-parent-col1-image'] }}</span>
																</div>
															</div>
														</div>
														<div class="edit-title-container padT10">
								      						<span>Content Title</span>
								      						<div class="padT10">
							      								<input name="for-parent-col1-content-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['for-parent-col1-content-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="for-parent-col1-content" id="content-editor" class="mceEditor">{{ $passedContents['for-parent-col1-content'] }}</textarea>
															</div>
														</div>
													</div>
						      						<div class="edit-body-col col-12 col-lg-6 col-xl-4">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>2</span></div>
							      							<div class="brown pull-left">Step 2</div>
							      						</div>
														<div class="edit-title-container padT10">
								      						<span>Title</span>
								      						<div class="padT10">
							      								<input name="for-parent-col2-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['for-parent-col2-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{ $passedContents['for-parent-col2-image'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							<div>
																	<label for="edit-parent-step-img2" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="for-parent-col2-image" class="file-upload hide" id="edit-parent-step-img2" type="file" value="{{ $passedContents['for-parent-col2-image'] }}" />
																	<span class="fileName">{{ $passedContents['for-parent-col2-image'] }}</span>
																</div>
															</div>
														</div>
														<div class="edit-title-container padT10">
								      						<span>Content Title</span>
								      						<div class="padT10">
							      								<input name="for-parent-col2-content-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['for-parent-col2-content-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="for-parent-col2-content" id="content-editor" class="mceEditor">{{ $passedContents['for-parent-col2-content'] }}</textarea>
															</div>
														</div>
													</div>
						      						<div class="edit-body-col col-12 col-lg-12 col-xl-4">
						      							<div class="row no-gutters align-items-center">
							      							<div class="edit-number pull-left"><span>3</span></div>
							      							<div class="brown pull-left">Step 3</div>
							      						</div>
														<div class="edit-title-container padT10">
								      						<span>Title</span>
								      						<div class="padT10">
							      								<input name="for-parent-col3-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['for-parent-col3-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-image-container padT10">
								      						<span>Image</span>
							      							<div class="padT10">
																<img class="photo-frame" src="{{ $passedContents['for-parent-col3-image'] }}" alt="">
															</div>
								      						<div class="padT10">
								      							<div>
																	<label for="edit-parent-step-img3" class="fileBtn">
																	    Choose File
																	</label>
																	<input name="for-parent-col3-image" class="file-upload hide" id="edit-parent-step-img3" type="file" value="{{ $passedContents['for-parent-col3-image'] }}" />
																	<span class="fileName">{{ $passedContents['for-parent-col3-image'] }}</span>
																</div>
															</div>
														</div>
														<div class="edit-title-container padT10">
								      						<span>Content Title</span>
								      						<div class="padT10">
							      								<input name="for-parent-col3-content-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['for-parent-col3-content-title'] }}">
							      							</div>
							      						</div>
							      						<div class="edit-content-container padT10">
								      						<span>Content</span>
							      							<div class="padT10">
															    <textarea name="for-parent-col3-content" id="content-editor" class="mceEditor">{{ $passedContents['for-parent-col3-content'] }}</textarea>
															</div>
														</div>
													</div>
						      					</div>
						      				</div>
						      				<!-- BROWN BACKGROUND REGISTER NOW -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>4</span></div>
						      						<div class="brown pull-left">Register now section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div>
							      						<div class="custom-control custom-checkbox">
															<input name="how-it-works-cta1-hidden" type="checkbox" class="custom-control-input" id="edit-hide-brownbg-textCTA"
																@if($showSection['how-it-works-cta1'] == 'hide')
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
														    <textarea name="how-it-works-cta1-title" id="content-editor" class="mceEditor">{{ $passedContents['how-it-works-cta1-title'] }}</textarea>
														</div>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-button-container">
						      							<span>CTA</span>
						      							<span class="marR10">Button text</span>
					      								<input name="how-it-works-cta1-btn-text" type="text" class="edit-title-input padLR10" value="{{ $passedContents['how-it-works-cta1-btn-text'] }}">
						      						</div>
						      					</div>
						      				</div>
						      				<!-- PROGRAM SECTION -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>5</span></div>
						      						<div class="brown pull-left">Program section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
														<input name="program-hidden" type="checkbox" class="custom-control-input" id="edit-hide-program"
															@if($showSection['program'] == 'hide')
																checked="checked"
															@endif>
														
														<label class="custom-control-label" for="edit-hide-program"></label>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="program-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['program-title'] }}">
						      							</div>
						      						</div>
						      						<div class="edit-content-container padT10">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="program-content" id="content-editor" class="mceEditor">{{ $passedContents['program-content'] }}</textarea>
														</div>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-image-container">
							      						<span>Image</span>
						      							<div class="padT10">
															<img class="photo-frame" src="{{ $passedContents['program-image'] }}" alt="">
														</div>
							      						<div class="padT10">
							      							<div>
																<label for="edit-program" class="fileBtn">
																    Choose File
																</label>
																<input name="program-image" class="file-upload hide" id="edit-program" type="file" value="{{ $passedContents['program-image'] }}" />
																<span class="fileName">{{ $passedContents['program-image'] }}</span>
															</div>
														</div>
													</div>
						      						<div class="edit-content-container padT10">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="program-content2" id="content-editor" class="mceEditor">{{ $passedContents['program-content2'] }}</textarea>
														</div>
													</div>
							      					<div class="edit-body-row">
							      						<div class="edit-title-container d-flex flex-wrap">
															<div class="m-1">
																<span>CTA</span>
																<span class="marR10">Button text</span>
																<input name="program-btn-text" type="text" class="edit-title-input padLR10" value="{{ $passedContents['program-btn-text'] }}">
															</div>
															<div class="m-1">
																<span class="marR10">Button url</span>
																<input name="program-btn-link" type="text" class="edit-title-input padLR10" value="{{ $passedContents['program-btn-link'] }}">
													  		</div>
														</div>
							      					</div>
						      					</div>
						      				</div>
						      				<!-- BENEFITS SECTION -->
					      					<div class="edit-section-body">
						      					<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>6</span></div>
						      						<div class="brown pull-left">Benefits section</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
														<input name="benefits-hidden" type="checkbox" class="custom-control-input" id="edit-hide-benefits"
															@if($showSection['benefits'] == 'hide')
																checked="checked"
															@endif>
														
														<label class="custom-control-label" for="edit-hide-benefits"></label>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="benefits-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['benefits-title'] }}">
						      							</div>
						      						</div>
						      					</div>
						      					<div class="edit-body-row">
							      					<span>Benefits List</span>
					      							<div class="row no-gutters align-items-center padT10">
						      							<div class="edit-number pull-left"><span>1</span></div>
						      							<div class="edit-list brown pull-left">
						      								<input name="benefits-list1" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['benefits-list1'] }}">
						      							</div>
						      						</div>
					      							<div class="row no-gutters align-items-center padT10">
						      							<div class="edit-number pull-left"><span>2</span></div>
						      							<div class="edit-list brown pull-left">
						      								<input name="benefits-list2" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['benefits-list2'] }}">
						      							</div>
						      						</div>
					      							<div class="row no-gutters align-items-center padT10">
						      							<div class="edit-number pull-left"><span>3</span></div>
						      							<div class="edit-list brown pull-left">
						      								<input name="benefits-list3" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['benefits-list3'] }}">
						      							</div>
						      						</div>
					      							<div class="row no-gutters align-items-center padT10">
						      							<div class="edit-number pull-left"><span>4</span></div>
						      							<div class="edit-list brown pull-left">
						      								<input name="benefits-list4" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['benefits-list4'] }}">
						      							</div>
						      						</div>
					      							<div class="row no-gutters align-items-center padT10">
						      							<div class="edit-number pull-left"><span>5</span></div>
						      							<div class="edit-list brown pull-left">
						      								<input name="benefits-list5" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['benefits-list5'] }}">
						      							</div>
						      						</div>
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
															<input name="how-it-works-cta2-hidden" type="checkbox" class="custom-control-input" id="edit-hide-brownbg-textCTA2"
																@if($showSection['how-it-works-cta2'] == 'hide')
																	checked="checked"
																@endif>
															
															<label class="custom-control-label" for="edit-hide-brownbg-textCTA2"></label>
														</div>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-content-container">
							      						<span>Content</span>
						      							<div class="padT10">
														    <textarea name="how-it-works-cta2-title" id="content-editor" class="mceEditor">{{ $passedContents['how-it-works-cta2-title'] }}</textarea>
														</div>
													</div>
						      					</div>
						      					<div class="edit-body-row">
						      						<div class="edit-button-container">
						      							<span>CTA</span>
						      							<span class="marR10">Button text</span>
					      								<input name="how-it-works-cta2-btn-text" type="text" class="edit-title-input padLR10" value="{{ $passedContents['how-it-works-cta2-btn-text'] }}">	
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
					      				<form method="POST" action="{{ url('/admin/update-meta/2') }}">
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