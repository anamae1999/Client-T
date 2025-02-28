@extends('admin::layouts.alternate')
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
					      	<h2>Edit Blog</h2>
					      	<div class="row">
					      		<!-- EDIT CONTENT FORM START -->
					      		<form method="POST" action="{{ url('blog/update',array($post->id)) }}" enctype="multipart/form-data" class="edit-content-form">
                                	@csrf
					      		<div class="col-xl-8">
					      			@if(Session::has('response'))
						                <div class="alert alert-success">
						                    {{ Session::get('response') }}
						                </div>
						            @endif
					      			<div class="white-box-shadow">
					      				<div class="edit-title brown">
					      					<p class="fontS30"><strong><span>{{ $post->post_title }}</span></strong></p>
					      				</div>
					      				<div class="edit-body">					      					
						      				<!-- BLOG SECTION -->
					      					<div class="edit-section-body">	
											  	<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>1</span></div>
						      						<div class="brown pull-left">Blog section</div>
						      					</div>
					      						<div class="edit-body-row category-choice">
					      							<label for="edit-category">
														<strong>Category</strong><span class="required"> *</span>
													</label>
													<select name="category-id" class="custom-select">
														<option disabled="disabled" selected="selected">Select Category</option>
														@if(count($categories)>0)
															@foreach($categories as $category)
																<option value="{{$category->id}}" {{ $post->category_id == $category->id ? 'selected="selected"' : '' }}>{{ucwords($category->category)}}</option>
															@endforeach
														@endif
													</select>
													@if ($errors->has('category-id'))
	                                                    <span class="help-block inlineBlock">
	                                                        {{ str_replace("category-id","category",$errors->first('category-id')) }}
	                                                    </span>
	                                                @endif
				      							</div>
												<div class="edit-body-row">
													<div class="edit-title-container">
							      						<strong><span class="fontS18">Blog Title</span></strong>
							      						<div class="padT10">
						      								<input name="post-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $post->post_title }}">
						      								@if ($errors->has('post-title'))
			                                                    <span class="help-block">
			                                                        {{ str_replace("post-title","blog title",$errors->first('post-title')) }}
			                                                    </span>
			                                                @endif
						      							</div>
						      						</div>
												</div>
												<div class="edit-body-row">
						      						<div class="edit-image-container">
							      						<strong><span class="fontS18">Blog feature image</span></strong>
					      								<div class="padT10">
															<div class="feat-img-wrap">	
																<img id="blog-feat-img" class="feat-photo-frame" src='{{ $post->post_image ? $post->post_image : "/images/image-placeholder.jpg"}}' alt="feature-img">
															</div>	
														</div>
							      						<div class="padT10 padL10">
															<label for="edit-banner-img" class="fileBtn">
															    Choose File
															</label>
															<input name="post-image" class="file-upload hide" id="edit-banner-img" type="file" value="{{ $post->post_image }}" />
															<span class="fileName">{{ $post->post_image }}</span>
														</div>
														@if ($errors->has('post-image'))
		                                                    <span class="help-block">
		                                                        {{ str_replace("post-image","blog image",$errors->first('post-image')) }}
		                                                    </span>
		                                                @endif
													</div>

						      						<div class="edit-content-container padT10">
							      						<strong><span class="fontS18">Blog Content</span></strong>
						      							<div class="padT10">
														    <textarea name="post-body" id="content-editor" class="mceEditorBlog">{{ $post->post_body }}</textarea>
														    @if ($errors->has('post-body'))
			                                                    <span class="help-block">
			                                                        {{ str_replace("post-body","blog content",$errors->first('post-body')) }}
			                                                    </span>
			                                                @endif
														</div>
													</div>
						      					</div>						      					
						      				</div>	
						      				<!-- AUTHOR SECTION -->
					      					<div class="edit-section-body">	
					      						<div class="edit-body-row row no-gutters align-items-center gray-bg">
						      						<div class="edit-number pull-left"><span>2</span></div>
						      						<div class="brown pull-left">Author Details</div>
						      					</div>							      						
						      					<div class="edit-body-row">
						      						<div class="edit-image-container">
							      						<span>Author image</span>
						      							<div class="padT10">																
															<div class="auth-img-wrap">	
																<img id="auth-photo-img" class="auth-photo-frame" src='{{ $post->author_pic ? $post->author_pic : "/images/avatar-placeholder.png"}}' alt="placeholder">
															</div>		
														</div>
							      						<div class="padT10">
															<label for="edit-author-img" class="fileBtn">
															    Choose File
															</label>
															<input name="author_pic" class="file-upload hide" id="edit-author-img" type="file" value="{{ $post->author_pic }}">
															<span class="fileName"></span>
														</div>
														@if ($errors->has('author_pic'))
		                                                    <span class="help-block">
		                                                        {{ $errors->first('author_pic') }}
		                                                    </span>
		                                                @endif
													</div>
						      						<div class="edit-title-container padT10">
							      						<span>Author Name<span class="required"> *</span></span>
							      						<div class="padT10">
						      								<input name="author_name" type="text" class="edit-title-input col-12 padLR10" value="{{ $post->author_name }}">
						      								@if ($errors->has('author_name'))
			                                                    <span class="help-block">
			                                                        {{ $errors->first('author_name') }}
			                                                    </span>
			                                                @endif
						      							</div>
						      						</div>									      					

						      						<div class="edit-content-container padT10">
							      						<span>Author Description<span class="required"> *</span></span>
						      							<div class="padT10">
														    <textarea name="author_desc" id="description-editor" class="mceEditor">{{ $post->author_desc }}</textarea>
														    @if ($errors->has('author_desc'))
			                                                    <span class="help-block">
			                                                    	{{ str_replace("author_desc","author description",$errors->first('author_desc')) }}		                          
			                                                    </span>
			                                                @endif
														</div>
													</div>
						      					</div>						      					
						      				</div>	      				
					      				</div>
					      			</div>
					      		</div>
					      		<div class="col-xl-4 pl-auto pt-4 pt-xl-0 pl-xl-0">
	                                <div class="white-box-shadow">
	                                    <div class="edit-title brown">
	                                        <p class="fontS30 bold">Post Info</p>
	                                    </div>
	                                    <div class="edit-body p-4">
	                                        <div class="brown fontS16">
											<p class="line-height13"><i class="far fa-calendar marR10"></i>Last modified <span class="marL15">
					      						@if($post->updated_at)
					      							{{ date_format($post->updated_at, "d/m/y") }}
					      						@endif
				      						</span></p>
	                                        </div>
	                                    </div>
	                                    <!-- EDIT META START -->	
					      				<div class="edit-body">
					      					<div class="edit-title-container">
					      						<span class="brown">Meta title</span>
					      						<div class="padT10">
				      								<input name="meta-title" type="text" class="edit-title-input col-12 padLR10" value="{{ $post->meta_title }}">
				      							</div>
				      						</div>
					      					<div class="edit-title-container padT10">
					      						<span class="brown">Meta description</span>
					      						<div class="padT10">
				      								<textarea class="col-12 padLR10" name="meta-description">{{ $post->meta_description }}</textarea>
				      							</div>
				      						</div>
					      					<div class="edit-title-container padT10">
					      						<span class="brown">Meta keywords</span>
					      						<div class="padT10">
				      								<input name="meta-keyword" type="text" class="edit-title-input col-12 padLR10" placeholder="Insert keywords" value="{{ $post->meta_keyword }}">
				      							</div>
				      						</div>
				      						<div class="edit-title-container padT10">
					      						<span class="brown">Slug<span class="required"> *</span></span>
					      						<div class="padT10">
				      								<input name="slug" type="text" class="edit-title-input col-12 padLR10" placeholder="Insert URL" value="{{ $post->slug }}">
				      								@if ($errors->has('slug'))
	                                                    <span class="help-block">
	                                                        {{ $errors->first('slug') }}
	                                                    </span>
	                                                @endif
				      							</div>
				      						</div>
				      						<div class="edit-title-container padT20 custom-radio-green">
					      						<div class="custom-control custom-radio">
					      							<div>
					      								<input type="radio" class="custom-control-input" id="publish" name="visibility" value="1" required="required" 
					      								@if($post->published)
												    		checked="checked"
												    	@endif	
					      								>
												    	<label class="custom-control-label" for="publish">Published</label>
					      							</div>
													
											    	<div>
											    		<input type="radio" class="custom-control-input" id="unpublish" name="visibility" value="0" required="required"
											    		@if(!$post->published)
												    		checked="checked"
												    	@endif
											    		>
												    	<label class="custom-control-label" for="unpublish">Unpublished</label>
											    	</div>
											    	
												</div>
				      						</div>
					      				</div>					      									      					
				      					<!-- EDIT META END -->
	                                    <div class="edit-footer gray-bg text-right p-3">
	                                        <button type="submit" class="custom-btn btn-green btn-green-whitebg fontW300 py-2 px-3">Update</button>
	                                    </div>
	                                </div>
                                </div>				      		
					      			
					      		</form>
					      		<!-- EDIT CONTENT FORM END -->					      			
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