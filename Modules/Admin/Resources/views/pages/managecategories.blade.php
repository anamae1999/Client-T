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
							@if(Session::has('response'))
				                <div class="alert alert-success">
				                    {{ Session::get('response') }}
				                </div>
				            @endif
				            @if(Session::has('failed'))
				                <div class="alert alert-danger">
				                    {{ Session::get('failed') }}
				                </div>
				            @endif
				      		<div class="row no-gutters white-bg rounded shadow">
				      			<div class="section-header col-12 d-flex flex-row flex-wrap align-items-center px-4 pt-4 pb-3 no-gutters">
									<h2 class="brown m-0 mx-3">Blog Categories</h2>
								</div>
								<div class="col-12 p-4">
									<div class="col-12 d-flex justify-content-start">																		
										<div class="table-container category-container">									      	
											<table class="table dashboard-table table-responsive mb-0">
												<thead>
													<tr>
														<th scope="col" colspan="2"><span class="pr-1">Category Name</span></th>
													</tr>
												</thead>
												<tbody>

													@if(count($categories)>0)
														@foreach($categories as $category)
														<tr>
															<td>{{ ucwords($category->category) }}</td>
															<td class="text-right">
																<a class="green btn-action" href="#updCatModal" data-toggle="modal" data-id="{{ $category->id }}" data-category="{{$category->category}}">Edit</a>
																<a class="green btn-action" href="#delCatModal" data-toggle="modal" data-id="{{ $category->id }}" data-category="{{$category->category}}">Delete</a>
															</td>
														</tr>
														@endforeach
													@endif
														
												</tbody>
											</table>
											<div class="table-container-footer d-flex flex-wrap align-items-center justify-content-between">
												<a href="#addCatModal" data-toggle="modal" class="custom-btn btn-green btn-green-whitebg dashboard-btn" href="pages/new-blog">Add new</a>												
												{{ $categories->appends(Request::except('page'))->links() }}	
												
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

<!-- Add category modal -->
<div id="addCatModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Add new blog post category.</strong></p>                
            </div>
            <form method="POST" action='{{ url("/admin/add-category") }}'> 
			@csrf
	            <div class="modal-body d-flex">            	
					<input type="text" name="category" class="form-control">
				</div>    
           		<div class="modal-footer"> 
					<div>
						<button type="button" class="btn btn-default marL20" data-dismiss="modal">Cancel</button> 
	                    <button class="dlt-btn">Add Category</button>
					</div>
	            </div> 
            
            </form> 
        </div>
    </div>
</div>

<!-- Edit category modal -->
<div id="updCatModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Edit "<span class="category"></span>" category.</p></strong>             
            </div>
            <form method="POST" action='{{ url("/admin/update-category") }}'> 
			@csrf
	            <div class="modal-body d-flex">            	
					<input type="text" name="category" class="form-control">
					<input type="hidden" name="catId">
				</div>    
           		<div class="modal-footer"> 
					<div>
						<button type="button" class="btn btn-default marL20" data-dismiss="modal">Cancel</button> 
	                    <button class="dlt-btn">Update Category</button>
					</div>
	            </div> 
            
            </form> 
        </div>
    </div>
</div>

<!-- Delete confirmation modal -->
<div id="delCatModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Do you really want to delete "<span class="category"></span>"?</strong></p>                
            </div>
            <div class="modal-body d-flex">
			<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
			<p>Are you sure you want to do this? This cannot be undone.</p>
			</div>    
            <div class="modal-footer"> 
	            <form method="POST" action='{{ url("/admin/delete-category") }}'> 
				@csrf
                @method('DELETE')
					<div>
						<button type="button" class="btn btn-default marL20" data-dismiss="modal">Cancel</button>
	                    <input type="hidden" name="catId">	 
	                    <button class="dlt-blog dlt-btn">Delete</button>
					</div>
	            </div> 
            </form> 
            	
            </div>
        </div>
      </div>
</div>
@endsection