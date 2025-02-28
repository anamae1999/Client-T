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
					
						<div class="pt-3 pb-3">	
							<a class="green" href='{{ url("/admin/pages/edit/about-us") }}'><< Back to edit About Us page</a>
						</div>
						<section>							
					      	<h2>Team Members</h2>
					      	<div class="table-container row mb-5 p-2">
					      		@foreach($members as $key => $member)
					      		
								<div class="team-member-wrap col-12 col-md-6 col-lg-4">
									<div class="team-member-inner-wrap">
										<div class="edit-body-row row no-gutters align-items-center gray-bg">
				      						<div class="edit-number pull-left"><span>{{ $key + 1 }}</span></div>	
				      					</div>				      				
										<form method="POST" action="{{ url('/admin/member/update',array($member->id)) }}" enctype="multipart/form-data">
									    @csrf
									    	<div class="edit-body col-12">
												<div class="edit-image-container">											
														<span class="fw600 green">Image</span>
														<div class="padT10">

														<div class="photo-frame" style='background-image:url("{{ $member->member_pic ? $member->member_pic : asset("/images/avatar-placeholder.png") }}")'>	
														</div>													
													</div>
														<div class="padT10">
															<div>
															<label for="edit-member_pic{{ $member->id }}" class="fileBtn">
															    Choose File
															</label>
															<input name="member_pic" class="file-upload hide" id="edit-member_pic{{ $member->id }}" type="file" value='{{ $member->member_pic ? $member->member_pic : asset("/images/avatar-placeholder.png") }}' />
															<span class="fileName"></span>
														</div>
													</div>
												</div>
												<div class="edit-title-container padT10">
													<span class="fw600 green">Name</span>
													<div class="padT10">
														<input name="member_name" type="text" class="edit-title-input col-12 padLR10" value="{{ $member->member_name }}">
													</div>
												</div>
												<div class="edit-title-container padT10">
													<span class="fw600 green">Position</span>
													<div class="padT10">
														<input name="member_position" type="text" class="edit-title-input col-12 padLR10" value="{{ $member->member_position }}">
													</div>
												</div>
												<div class="edit-content-container padT10">
													<span class="fw600 green">Introduction</span>
													<div class="padT10">
													    <textarea name="member_intro" id="content-editor" class="owners-desc padLR10" rows="3">{{ $member->member_introduction }}</textarea>
													</div>
												</div>
												<div class="padT10">
													<button type="submit" class="custom-btn btn-green btn-green-whitebg">Update</button>
													<a class="custom-btn btn-white" href="#deleteMemberModal" data-toggle="modal" data-id="{{ $member->id }}" data-name="{{ $member->member_name }}">Delete</a>
												</div>												
											</div>											
										</form>										
									</div>
								</div>
								@endforeach
								<div class="team-member-wrap col-12 col-md-6 col-lg-4">
									<div class="team-member-inner-wrap">
										<div class="edit-body-row row no-gutters align-items-center gray-bg add-member-title-wrap">	
				      						<div class="brown pull-left add-member-title">Add Member</div>
				      					</div>
										<form method="POST" action="{{ url('/admin/add-member') }}" enctype="multipart/form-data">
								      	@csrf												
											<div class="edit-body col-12">										
												<div class="edit-image-container">
													<span class="fw600 brown">Image<span class="required"> *</span></span>
													<div class="padT10">
														<div class="photo-frame" style='background-image:url("/images/avatar-placeholder.png")'>	
														</div>	
													</div>
													<div class="padT10">
														<div>
															<label for="edit-member-pic" class="fileBtn">
															    Choose File
															</label>
															<input name="member_pic" class="file-upload hide" id="edit-member-pic" type="file" />
															<span class="fileName"></span>
														</div>
														@if ($errors->has('member_pic'))
		                                                    <span class="help-block">
		                                                        {{ $errors->first('member_pic') }}
		                                                    </span>
		                                                @endif
													</div>
												</div>
												<div class="edit-title-container padT10">
													<span class="fw600 brown">Name<span class="required"> *</span></span>
													<div class="padT10">
														<input name="member_name" type="text" class="edit-title-input col-12 padLR10" value="{{ old('member_name') }}">
														@if ($errors->has('member_name'))
		                                                    <span class="help-block">
		                                                        {{ $errors->first('member_name') }}
		                                                    </span>
		                                                @endif
													</div>
												</div>
												<div class="edit-title-container padT10">
													<span class="fw600 brown">Position<span class="required"> *</span></span>
													<div class="padT10">
														<input name="member_position" type="text" class="edit-title-input col-12 padLR10" value="{{ old('member_position') }}">
														@if ($errors->has('member_position'))
		                                                    <span class="help-block">
		                                                        {{ $errors->first('member_position') }}
		                                                    </span>
		                                                @endif
													</div>
												</div>
												<div class="edit-content-container padT10">
													<span class="fw600 brown">Introduction<span class="required"> *</span></span>
													<div class="padT10">
													    <textarea name="member_intro" id="content-editor" class="owners-desc padLR10" rows="3">{{ old('member_intro') }}</textarea>
													    @if ($errors->has('member_intro'))
		                                                    <span class="help-block">
		                                                        {{ $errors->first('member_intro') }}
		                                                    </span>
		                                                @endif
													</div>
												</div>
												<div class="padT10">
													<button type="submit" class="custom-btn btn-green btn-green-whitebg btn-primary dashboard-btn">Add Team Member</button>
												</div>	
											</div>
																						
										</form>	
										
									</div>
								</div>
					      		
							      		
							</div>	
					    </section>				

			    </div>
		  	</div>
		</div>
	</div>
</section>

<!-- Delete Member confirmation modal -->
<div id="deleteMemberModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Do you really want to delete "<span class="name"></span>"?</strong></p>                
            </div>
            <div class="modal-body d-flex">
            	
                    
				<svg class="text-warning mr-3" width="45" height="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<p> Confirm deletion of team member. This cannot be undone. </p>
			</div>
			<form method="POST" action='{{ url("/admin/member/delete") }}'>	
            @csrf
            @method('DELETE')
	            <input type="hidden" name="memberId">	
				<div class="modal-footer">   
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button class="dlt-faq dlt-btn">Delete</button>      
				</div>                  
			</form>
        </div>
      </div>
</div>

@endsection


