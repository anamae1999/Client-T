@extends('admin::layouts.master')
@section('content')
<section class="gray-bg">
	<div class="container-fluid">
		<div class="row no-gutters">
			@include('admin::internals.dashboardtab')
			<div class="dashboard-tab-content padLR60">
				
			    <div class="tab-content loaderParent" id="dashboard-tab-content">
			    	<div id="loadingDiv">
						<div class="loader"></div>
					</div>
					<div class="tab-pane fade show active" id="v-pills-pages">
						<section>
					      	<h2>Pages</h2>
					      	<div class="pages-container">
					      		@if(Session::has('response'))
					                <div class="alert alert-success">
					                    {{ Session::get('response') }}
					                </div>
					            @endif
					      		<ul class="AD-pages-tab nav nav-tabs" id="AD-pages-tab" role="tablist">
									<li class="nav-item p-0 col-sm-auto col-6">
										<a class="nav-link active" id="posts data-pages-tab" data-toggle="tab" href="#data-pages" role="tab" aria-controls="data-pages" aria-selected="true">Website Pages</a>
									</li>
									<li class="nav-item p-0 col-sm-auto col-6">
										<a class="nav-link" id="blog-pages-tab" data-toggle="tab" href="#blog-pages" role="tab" aria-controls="blog-pages" aria-selected="false">Blog Pages</a>
									</li>
								</ul>
								<div class="tab-content" id="AD-pages-tab-content">
									<div class="tab-pane fade show active" id="data-pages" role="tabpanel" aria-labelledby="data-pages-tab">
								      	<div class="table-container marB50">									      	
											<table class="table dashboard-table table-responsive mb-0">
												<thead>
													<tr>
														<th scope="col"><span class="pr-1">Title</span></th>
														<th scope="col"></th>
														<th scope="col"><span class="pr-1">Modified By</span></th>
														<th scope="col"><span class="pr-1">Date</span></th>
													</tr>
												</thead>
												<tbody>
													@if(count($pages) > 0)
									                    @foreach($pages as $page)
															<tr>
																<td><a class="green" href="/admin/pages/edit/{{ $page->slugs }}">{{ $page->page_titles }}</a></td>
																<td>
																	<a class="green btn-action" href="/admin/pages/edit/{{ $page->slugs }}">Edit</a>
																	<a class="green btn-action" href="/{{ $page->slugs }}" target="_blank">View</a>
																</td>
																<td><p class="green">{{ is_null($page->user_id) ? 'no user' : $page->user->first_name }}</p></td>
																<td>Last Modified <span class="pl-3">{{ date_format($page->updated_at, "d/m/y") }}</span></td>
															</tr>
														@endforeach
													@endif
												</tbody>
											</table>
											<div class="table-container-footer d-flex flex-wrap align-items-center justify-content-between">
												{{ $pages->links() }}
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="blog-pages" role="tabpanel" aria-labelledby="blog-pages-tab">
										<div class="table-container marB50">	
											<form method="GET" action='{{ url("/blog/search") }}' class="form-inline">
											@csrf
												<div class="ml-2 mt-2">
													<input name="search-posts" type="text" class="form-control">
												</div>
												<button type="submit" class="custom-btn btn-green btn-green-whitebg btn-primary dashboard-btn ml-2 mt-2">Search Blog</button>
											</form>
											<table class="table dashboard-table table-responsive mb-0">
												<thead>
													<tr>
														<th scope="col"><span class="pr-1">Title</span></th>
														<th scope="col"></th>
														<th scope="col"><span class="pr-1">Author</span></th>
														<th scope="col"><span class="pr-1">Date</span></th>
													</tr>
												</thead>
												<tbody>

													@if(count($posts) > 0)
									                    @foreach($posts as $post)
														<tr>
															<td><a class="{{ $post->published ? 'green' : 'brown'}}" href='{{ url("/blog/pages/edit/post/{$post->id}") }}'>{{$post->post_title}}</a></td>
															<td>
																<a class="green btn-action" href='{{ url("/blog/pages/edit/post/{$post->id}") }}'>Edit</a>
																<a class="green btn-action" href='{{ url("/blog/inner/{$post->slug}") }}'>View</a>
																<a class="green btn-action" href="#deleteBlogModal" data-toggle="modal" data-id="{{ $post->id }}" data-post-title="{{$post->post_title}}">Delete</a>
															</td>
															<td><a class="green" href="#">{{$post->user->first_name}} {{$post->user->last_name}}</a></td>
															<td>Last Modified <span class="pl-3">{{ date_format($post->updated_at, "d/m/y H:i:s") }}</span></td>
														</tr>
														@endforeach
													@else
													<tr>
														<td colspan="4">No posts available</td>
													</tr>
													@endif
												</tbody>
											</table>
											<div class="table-container-footer d-flex flex-wrap align-items-center justify-content-between">
												<div>	
													<a class="custom-btn btn-green btn-green-whitebg dashboard-btn" href="pages/new-blog">Add new</a>
													<a class="custom-btn btn-white btn-green-whitebg dashboard-btn" href="pages/manage-categories">Manage Categories</a>
												</div>
												
												{{ $posts->appends(Request::except('page'))->links() }}
												
											</div>
										</div>
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

<!-- Delete confirmation modal -->
<div id="deleteBlogModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Do you really want to delete "<span class="post-title"></span>"?</strong></p>                
            </div>
            <div class="modal-body d-flex">
			<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>

            	
			<p> Are you sure you want to do this? this cannot be undone. </p>
			</div>    
            <div class="modal-footer"> 
	            <form method="POST" action='{{ url("/blog/post/delete") }}'> 
				@csrf
                @method('DELETE')
					<div>
						<button type="button" class="btn btn-default marL20" data-dismiss="modal">Cancel</button>
	                    <input type="hidden" name="postId">	 
	                    <button class="dlt-blog dlt-btn">Delete</button>
					</div>
	            </div> 
            </form> 
            	
            </div>
        </div>
      </div>
</div>
@endsection