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
                            <h2>Edit FAQ Page</h2>
                            <div class="row">
                                <!-- EDIT CONTENT FORM START -->
                                <form method="POST" action="{{ url('/admin/update-content/3') }}" enctype="multipart/form-data" class="edit-content-form">
                                	@csrf
                                    <div class="col-xl-9">
                                    	@if(Session::has('response'))
							                <div class="alert alert-success">
							                    {{ Session::get('response') }}
							                </div>
							            @endif
                                        <div class="white-box-shadow">
                                            <div class="edit-title brown">
                                                <span>FAQ</span>
                                            </div>
                                            <div class="edit-body">
                                            <div class="padB10 brown fontS22">Section</div>
											<!-- INTRO SECTION -->
											<div class="edit-section-body">
												<div class="edit-body-row row no-gutters align-items-center gray-bg">
													<div class="edit-number pull-left"><span>1</span></div>
													<div class="brown pull-left">FAQ Into</div>
												</div>
												<div class="edit-body-row edit-hide">
													<span>Hide Section?</span>
													<div class="custom-control custom-checkbox">
														<input name="faq-cta-hidden" type="checkbox" class="custom-control-input" id="edit-hide-intro"
															@if($showSection['faq-cta'] == 'hide')
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
															<input name="faq-main-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['faq-main-title'] }}">
														</div>
													</div>
													<div class="edit-content-container padT10">
														<span>Content</span>
														<div class="padT10">
															<textarea name="faq-main-content" id="content-editor" class="mceEditor">{{ $passedContents['faq-main-content'] }}</textarea>
														</div>
													</div>
												</div>
											</div>
											<!-- FAQ SECTION -->
											<div class="edit-section-body">
												<div class="edit-body-row row no-gutters align-items-center gray-bg">
													<div class="edit-number pull-left"><span>2</span></div>
													<div class="brown pull-left">FAQ SECTION</div>
												</div>
												<div class="edit-body-row edit-hide">
													<span>Hide Section?</span>
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="edit-hide-question">
														<label class="custom-control-label" for="edit-hide-question"></label>
													</div>
												</div>
												<div class="pad10 text-right">
													<a class="custom-btn btn-green btn-green-whitebg fontW300 py-2 px-3" href="/admin/pages/manage-faq">Manage FAQs</a>
												</div>
											</div>
											
                                            <!-- BROWN BACKGROUND REGISTER NOW -->
                                            <div class="edit-section-body">
                                                <div class="edit-body-row row no-gutters align-items-center gray-bg">
                                                    <div class="edit-number pull-left"><span>3</span></div>
                                                    <div class="brown pull-left">Register now section</div>
                                                </div>
                                                <div class="edit-body-row edit-hide">
                                                    <span>Hide Section?</span>
                                                    <div>
                                                        <div class="custom-control custom-checkbox">
                                                            <input name="faq-main-hidden" type="checkbox" class="custom-control-input" id="edit-hide-brownbg-textCTA"
	                                                            @if($showSection['faq-main'] == 'hide')
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
                                                            <textarea name="faq-cta-title" id="content-editor" class="mceEditor">{{ $passedContents['faq-cta-title'] }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="edit-body-row">
                                                    <div class="edit-button-container">
														<div class="m-1">
                                                        	<span>CTA</span>
                                                            <span class="marR10">Button text</span>
                                                            <input name="faq-cta-btn-text" type="text" class="edit-title-input padLR10" value="{{ $passedContents['faq-cta-btn-text'] }}">
														</div>
														<div class="m-1">	
															<span class="marR10">Button url</span>
                                                            <input name="faq-cta-btn-link" type="text" class="edit-title-input padLR10" value="{{ $passedContents['faq-cta-btn-link'] }}">
                                                        </div>
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
				      				<form method="POST" action="{{ url('/admin/update-meta/3') }}">
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