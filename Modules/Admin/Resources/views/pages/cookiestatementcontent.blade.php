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
					      	<h2>Edit Cookie Statement Page</h2>
					      	<div class="row">
					      		<!-- EDIT CONTENT FORM START -->
					      		<form method="POST" action="{{ url('/admin/update-content/9') }}" enctype="multipart/form-data" class="edit-content-form">
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
						      						<div class="brown pull-left">Cookie Statement</div>
						      					</div>
						      					<div class="edit-body-row edit-hide">
						      						<span>Hide Section?</span>
						      						<div class="custom-control custom-checkbox">
														<input name="cookie-statement-hidden" type="checkbox" class="custom-control-input" id="edit-hide-cs" @if($showSection['cookie-statement'] == 'hide')
															checked="checked"
														@endif
														>
														<label class="custom-control-label" for="edit-hide-cs"></label>
													</div>
							      				</div>
						      					<div class="edit-body-row">
						      						<div class="edit-title-container">
							      						<span>Section Title</span>
							      						<div class="padT10">
						      								<input name="cs-heading" type="text" class="edit-title-input col-12 padLR10" value="{{ $passedContents['cs-heading'] }}">
						      							</div>
						      						</div>
					      						</div>
						      					<div class="edit-body-row">
						      						<div class="content-container">
						      							<span>Section Content</span>
						      							<div class="padT10">
														    <textarea name="cs-content" class="mceEditor">
														    	{{ $passedContents['cs-content'] }}
														    </textarea>
														</div>
													</div>
						      					</div>
						      				</div>						      				
					      				</div>
					      			</div>
					      			<!-- Manage Cookies -->
					      			<div class="white-box-shadow">
					      				<div class="edit-body">	
					      					<div class="padB10 brown fontS22">Cookie Settings Pop-up</div>				      					
					      					<div class="edit-section-body">	
					      						<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>2</span></div>
						      						<div class="brown pull-left">Cookie Settings Content</div>
						      					</div>					      					
						      					<div class="pad10 text-right">
													<a class="custom-btn btn-green btn-green-whitebg fontW300 py-2 px-3" href="/admin/pages/manage-cookie-settings">Manage Cookie Settings Content</a>
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
					      				<form method="POST" action="{{ url('/admin/update-meta/9') }}">
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