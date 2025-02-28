@extends('admin::layouts.master')
@section('content') 
<section class="gray-bg vetting-screening">
<div class="container-fluid">
	<div class="row no-gutters">
		@include('admin::internals.dashboardtab')
		<div class="dashboard-tab-content padLR60">
			
			<div class="tab-content loaderParent">
				<div id="loadingDiv">
					<div class="loader"></div>
				</div>
				@if(Session::has('response'))
					<div class="alert alert-success">
						{{ Session::get('response') }}
					</div>
				@endif

				<div class="tab-pane fade show active" id="v-pills-vetting">
					<h2>Vetting / Screening Requests</h2>
					<div class="row no-gutters">
						<ul class="AD-pages-tab nav nav-tabs" id="AD-pages-tab" role="tablist">
							<li class="nav-item p-0 col-sm-auto col-6">
								<a class="nav-link active" id="vettings-tab-nav" data-toggle="tab" href="#vettings-tab" role="tab" aria-controls="vettings-tab" aria-selected="true">Vetting</a>
							</li>
							<li class="nav-item p-0 col-sm-auto col-6">
								<a class="nav-link" id="screenings-tab-nav" data-toggle="tab" href="#screenings-tab" role="tab" aria-controls="screenings-tab" aria-selected="false">Screening</a>
							</li>
						</ul>
						<div class="col-12 table-container rounded p-0">							
							<div class="tab-content col-12 p-0">
								<!-- Vetting -->								
								<div class="tab-pane fade show active" id="vettings-tab" role="tabpanel" aria-labelledby="data-vettings-tab">									
									<table class="table table-responsive table-uservetting table-vetting m-0">											
										<thead>
											<tr>
												<td colspan="30" style="padding:0;margin:0;border:0;">
													<div class="white-bg d-flex flex-row flex-wrap align-items-center p-4 row no-gutters">
														<div class="col-lg-8">
															<h5 class="brown m-0 mb-3 mb-sm-0 text-left">Vetting Request Table</h5>
														</div>									
														<div class="col-lg-4 d-flex flex-column align-items-stretch">
															<form method="GET" action='{{ url("/admin/vetting/search") }}'>
															@csrf
																<input type="hidden" name="type" value="vetting">
																<input type="text" name="keyword" placeholder="Search here..." class="search" value="{{ !empty($keyword) ? $keyword : '' }}">
																<button type="submit" class="fas fa-search search-button"></button>
															</form>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<th scope="col">
													<span class="pr-1">Requested By</span>
												</th>
												<th scope="col">
													<span class="pr-1">Date of request</span>
												</th>
												<th scope="col">
													<span class="pr-1">Application Status</span>
												</th>
												<th scope="col">
													<span class="pr-1">Remarks</span>
												</th>
												<th scope="col">
													<span class="pr-1">Status</span>
												</th>
												<th scope="col">
													<span class="pr-1">Action</span>
												</th>										
											</tr>
										</thead>
										<tbody>
											@if(count($usersVetting) > 0)
												@foreach($usersVetting as $userVetting)
												<tr>
													<td>{{ $userVetting->first_name }} {{ $userVetting->last_name }}</td>
													<td>{{ $userVetting->vetting->created_at }}</td>
													<td>{{ ucfirst($userVetting->vetting->application_status) }}</td>
													<td>{{ $userVetting->vetting->remarks }}</td>
													<td><span class="green">{{ ucfirst($userVetting->vetting->status) }}</span></td>
													<td>
														<a class="m-1 green" href='{{ url("/nannies/profile") }}/{{$userVetting->id}}/{{ strtolower($userVetting->first_name) }}-{{ strtolower($userVetting->last_name) }}'><i class="far fa-eye px-2 mx-1" data-toggle="tooltip" data-placement="top" title="View Profile"></i></a>

														<a class="m-1 green" href="#" data-toggle="modal" data-target="#remarksModal" data-remarks="{{ $userVetting->vetting->remarks }}" data-id="{{ $userVetting->id }}"><i class="far fa-edit px-2 mx-1" data-toggle="tooltip" data-placement="top" title="Edit Remarks"></i></a>

														<div class="ad-dropdown-wrap pos-relative text-center">
															<a href="#" class="ut-dropbutton selected green"><i class="fas fa-list px-2 mx-1" data-toggle="tooltip" data-placement="top" title="Change Status"></i></a>
															<div class="ut-dropdown-vetting vs-dropdown">

																@if($userVetting->vetting->application_status != 'pending')
																<a class="m-1 ut-dropdown-item" href="#pendVetModal" data-toggle="modal" data-id="{{ $userVetting->id }}" data-name="{{ $userVetting->first_name }} {{ $userVetting->last_name }}">Pend</a>
																@endif

																@if($userVetting->vetting->application_status != 'processing')
																<a class="m-1 ut-dropdown-item" href="#processVetModal" data-toggle="modal" data-id="{{ $userVetting->id }}" data-name="{{ $userVetting->first_name }} {{ $userVetting->last_name }}">Process</a>
																@endif

																@if($userVetting->vetting->application_status != 'passed')
																<a class="m-1 ut-dropdown-item" href="#passVetModal" data-toggle="modal" data-id="{{ $userVetting->id }}" data-name="{{ $userVetting->first_name }} {{ $userVetting->last_name }}">Mark as Passed</a>
																@endif

																@if($userVetting->vetting->application_status != 'failed')
																<a class="m-1 ut-dropdown-item" href="#failVetModal" data-toggle="modal" data-id="{{ $userVetting->id }}" data-name="{{ $userVetting->first_name }} {{ $userVetting->last_name }}">Mark as Failed</a>
																@endif
															</div>
														</div>
													</td>										
												</tr>
												@endforeach	
											@else
												<tr>
													<td colspan="6">No users found.</td>
												</tr>	
											@endif								
										</tbody>
									</table>
									<div class="table-container-footer clearfix">
										{{ $usersVetting->appends(Request::except('page'))->links() }}
									</div>
								</div>

								<!-- Screening -->
								<div class="tab-pane fade" id="screenings-tab" role="tabpanel" aria-labelledby="data-screenings-tab">
									<table class="table table-responsive table-uservetting table-vetting m-0">											
										<thead>
											<tr>
												<td colspan="30" style="padding:0;margin:0;border:0;">
													<div class="white-bg d-flex flex-row flex-wrap align-items-center p-4 row no-gutters">
														<div class="col-lg-8">
															<h5 class="brown m-0 mb-3 mb-sm-0 text-left">Screening Request Table</h5>
														</div>									
														<div class="col-lg-4 d-flex flex-column align-items-stretch">
															<form method="GET" action='{{ url("/admin/screening/search") }}'>
															@csrf
																<input type="hidden" name="type" value="screening">
																<input type="text" name="keyword" placeholder="Search here..." class="search" value="{{ !empty($keyword) ? $keyword : '' }}">
																<button type="submit" class="fas fa-search search-button"></button>
															</form>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<th scope="col">
													<span class="pr-1">Requested By</span>
												</th>
												<th scope="col">
													<span class="pr-1">Date of request</span>
												</th>
												<th scope="col">
													<span class="pr-1">Application Status</span>
												</th>
												<th scope="col">
													<span class="pr-1">Remarks</span>
												</th>
												<th scope="col">
													<span class="pr-1">Contact Number</span>
												</th>
												<th scope="col">
													<span class="pr-1">Status</span>
												</th>
												<th scope="col">
													<span class="pr-1">Badges</span>
												</th>
												<th scope="col">
													<span class="pr-1">Action</span>
												</th>										
											</tr>
										</thead>
										<tbody>
											@if(count($usersScreening) > 0)
												@foreach($usersScreening as $userScreening)
												<tr>
													<td>{{ $userScreening->first_name }} {{ $userScreening->last_name }}</td>
													<td>{{ $userScreening->screening->created_at }}</td>
													<td>{{ ucfirst($userScreening->screening->application_status) }}</td>
													<td>{{ $userScreening->screening->remarks }}</td>
													<td>{{$userScreening->sitterProfile->contact_number}}<td>
													<td><span class="green">{{ ucfirst($userScreening->screening->status) }}</span></td>
													<td><span class="green">{{ ucfirst($userScreening->screening->badge_name) }}, {{ ucfirst($userScreening->screening->badge_name2) }},{{ ucfirst($userScreening->screening->badge_name3) }},{{ ucfirst($userScreening->screening->badge_name4)}},{{ ucfirst($userScreening->screening->badge_name5)}}</span></td>

													<td>	
														<a class="m-1 green" href="#" data-toggle="modal" data-target="#badgeScrModal" data-id="{{ $userScreening->id }}"><i class="fas fa-award px-2 mx-1" data-toggle="tooltip" data-placement="top" title="Add Badge and Update Badge"></i></a>

														<a class="m-1 green" href='{{ url("/nannies/profile") }}/{{$userScreening->id}}/{{ strtolower($userScreening->first_name) }}-{{ strtolower($userScreening->last_name) }}'><i class="far fa-eye px-2 mx-1" data-toggle="tooltip" data-placement="top" title="View Profile"></i></a>

														<a class="m-1 green" href="#" data-toggle="modal" data-target="#remarksScrModal" data-remarks="{{ $userScreening->screening->remarks }}" data-id="{{ $userScreening->id }}"><i class="far fa-edit px-2 mx-1" data-toggle="tooltip" data-placement="top" title="Edit Remarks"></i></a>

														<div class="ad-dropdown-wrap pos-relative text-center">
															<a href="#" class="ut-dropbutton selected green"><i class="fas fa-list px-2 mx-1" data-toggle="tooltip" data-placement="top" title="Change Status"></i></a>
															<div class="ut-dropdown-screening vs-dropdown">

																@if($userScreening->screening->application_status != 'pending')
																<a class="m-1 ut-dropdown-item" href="#pendScrModal" data-toggle="modal" data-id="{{ $userScreening->id }}" data-name="{{ $userScreening->first_name }} {{ $userScreening->last_name }}">Pend</a>
																@endif

																@if($userScreening->screening->application_status != 'processing')
																<a class="m-1 ut-dropdown-item" href="#processScrModal" data-toggle="modal" data-id="{{ $userScreening->id }}" data-name="{{ $userScreening->first_name }} {{ $userScreening->last_name }}">Process</a>
																@endif

																@if($userScreening->screening->application_status != 'passed')
																<a class="m-1 ut-dropdown-item" href="#passScrModal" data-toggle="modal" data-id="{{ $userScreening->id }}" data-name="{{ $userScreening->first_name }} {{ $userScreening->last_name }}">Mark as Passed</a>
																@endif

																@if($userScreening->screening->application_status != 'failed')
																<a class="m-1 ut-dropdown-item" href="#failScrModal" data-toggle="modal" data-id="{{ $userScreening->id }}" data-name="{{ $userScreening->first_name }} {{ $userScreening->last_name }}">Mark as Failed</a>
																@endif
															</div>
														</div>
													</td>										
												</tr>
												@endforeach	
											@else
												<tr>
													<td colspan="6">No users found.</td>
												</tr>	
											@endif								
										</tbody>
									</table>
									<div class="table-container-footer clearfix">
										{{ $usersScreening->appends(Request::except('page'))->links() }}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
</section>

<!-- Vetting - Edit remarks modal -->
<div id="remarksModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form method="POST" action="{{ url('/admin/vetting/update-remarks') }}">
		@csrf
		<div class="modal-content p-2 f8f8f8-bg">
			<div class="modal-header">
				<p class="fontS18"><strong>Edit Remarks</strong></p>
			</div>
			<div class="modal-body">
								
				<input type="hidden" name="userId">	
				<input type="hidden" name="type" value="vetting">							
				<div class="remarks">	
					<div class="edit-title-container mt-3">
						<span class="fw600">Remarks</span>
						<div class="mt-2">
							<textarea name="remarks" id="content-editor" rows="3"></textarea>
						</div>
					</div>
				</div>									
				
			</div>
			<div class="modal-footer align-items-center">                    
				<button type="button" class="btn btn-default mr-3" data-dismiss="modal">Close</button>
				<button type="submit" class="custom-btn btn-green btn-green-whitebg btn-primary dashboard-btn">Update</button>
			</div>  
		</form>    
		</div>
	</div>
</div>

<!-- Vetting - Processing Status Confirm modal -->
<div id="processVetModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content p-2">
			<div class="modal-header">
				<p class="fontS18"><strong>Do you really want to mark <span class="user-name"></span>'s application as "Processing"?</strong></p>
			</div>
			<div class="modal-body d-flex">
				<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<div>
					<p>Confirm update of <span class="user-name"></span>'s vetting request application to processing.</p>
					<p>This will update vetting status to "Unverified".</p>
				</div>
			</div>
			<form method="POST" action='{{ url("/admin/vetting/process") }}'>	
			@csrf            
				<input type="hidden" name="userId">	
				<input type="hidden" name="type" value="vetting">
				<div class="modal-footer">   
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button class="act-btn">Confirm</button>      
				</div>                  
			</form>
		</div>
	</div>
</div>

<!-- Vetting - Pending Status Confirm modal -->
<div id="pendVetModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content p-2">
			<div class="modal-header">
				<p class="fontS18"><strong>Do you really want to mark <span class="user-name"></span>'s application as "Pending"?</strong></p>
			</div>
			<div class="modal-body d-flex">
				<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<div>
					<p>Confirm update of <span class="user-name"></span>'s vetting request application to pending.</p>
					<p>This will update vetting status to "Unverified".</p>
				</div>	
			</div>
			<form method="POST" action='{{ url("/admin/vetting/pend") }}'>	
			@csrf            
				<input type="hidden" name="userId">	
				<input type="hidden" name="type" value="vetting">
				<div class="modal-footer">   
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button class="act-btn">Confirm</button>      
				</div>                  
			</form>
		</div>
	</div>
</div>

<!-- Vetting - Pass Status Confirm modal -->
<div id="passVetModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content p-2">
			<div class="modal-header">
				<p class="fontS18"><strong>Do you really want to mark <span class="user-name"></span>'s application as "Passed"?</strong></p>
			</div>
			<div class="modal-body d-flex">
				<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<div>
					<p>Confirm update of <span class="user-name"></span>'s vetting request application to passed.</p>
					<p>This will update vetting status to "Verified".</p>
				</div>	
			</div>

			<form method="POST" action='{{ url("/admin/vetting/passed") }}'>	
			@csrf            
				<input type="hidden" name="userId">	
				<input type="hidden" name="type" value="vetting">
				<div class="modal-footer">   
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button class="act-btn">Confirm</button>      
				</div>                  
			</form>
		</div>
	</div>
</div>

<!-- Vetting - Fail Status Confirm modal -->
<div id="failVetModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content p-2">
			<div class="modal-header">
				<p class="fontS18"><strong>Do you really want to mark <span class="user-name"></span>'s application as "Failed"?</strong></p>
			</div>
			<div class="modal-body d-flex">
				<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<div>
					<p>Confirm update of <span class="user-name"></span>'s vetting request application to failed.</p>
					<p>This will update vetting status to "Unverified".</p>
				</div>	
			</div>

			<form method="POST" action='{{ url("/admin/vetting/failed") }}'>	
			@csrf            
				<input type="hidden" name="userId">	
				<input type="hidden" name="type" value="vetting">
				<div class="modal-footer">   
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button class="dlt-btn">Confirm</button>      
				</div>                  
			</form>
		</div>
	</div>
</div>


<!-- Screening - Add Badge modal -->
<div id="badge1ScrModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form method="POST" action="{{ url('/admin/screening/update-badge') }}">
		@csrf
		<div class="modal-content p-2 f8f8f8-bg">
			<div class="modal-header">
				<p class="fontS18"><strong>Select Badge</strong></p>
			</div>
			<div class="modal-body">								
				<input type="hidden" name="userId">
				<div class="badge-select">	
					<div class="edit-title-container mt-3">
						<span class="fw600">Badges</span>
						<div class="mt-2">
							<select class="form-control" name="badge-type">
								<option value="none">None</option>
								@if(count($badges)>0)
									@foreach($badges as $badge)
										<option value="{{$badge->badge_name}}">{{$badge->badge_name}}</option>
									@endforeach
								@endif
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer align-items-center">                    
				<button type="button" class="btn btn-default mr-3" data-dismiss="modal">Close</button>
				<button type="submit" class="custom-btn btn-green btn-green-whitebg btn-primary dashboard-btn">Update</button>
			</div>  
		</form>    
		</div>
	</div>
</div>


<div id="badgeScrModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form method="POST" action="{{ url('/admin/screening/update-badge') }}">
		@csrf
		<div class="modal-content p-2 f8f8f8-bg">
			<div class="modal-header">
				<p class="fontS18"><strong>BADGE</strong></p>
			</div>
			<div class="modal-body">								
				<input type="hidden" name="userId">
				<div class="badge-select">	
					<div class="edit-title-container mt-3">
						<div class="mt-2">
							<label>Select Badge Number:</label>
							<select class="form-control" name="badge-num">
							<option value="none">None</option>
								<option value="1">Badge 1</option>
								<option value="2">Badge 2</option>
								<option value="3">Badge 3</option>
								<option value="4">Badge 4</option>
								<option value="5">Badge 5</option>
							</select>
							<br>
							<label>Select Badge Type:</label>
							<select class="form-control" name="badge-type">
							<option value="none">None</option>
								@if(count($badges)>0)
									@foreach($badges as $badge)
										<option value="{{$badge->badge_name}}">{{$badge->badge_name}}</option>
									@endforeach
								@endif
							</select>
							<br>
								@if(!empty($nannyBadge))
										<p>Badge 1: <strong>{{$nannyBadge}}</strong></p>
								@endif
								@if(!empty($nannyBadge2))
										<p>Badge 2: <strong>{{$nannyBadge2}}</strong></p>
								@endif
								@if(!empty($nannyBadge3))
										<p>Badge 3: <strong>{{$nannyBadge3}}</strong></p>
								@endif
								@if(!empty($nannyBadge4))
										<p>Badge 4: <strong>{{$nannyBadge4}}</strong></p>
								@endif
								@if(!empty($nannyBadge5))
										<p>Badge 4: <strong>{{$nannyBadge5}}</strong></p>
								@endif
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer align-items-center">                    
				<button type="button" class="btn btn-default mr-3" data-dismiss="modal">Close</button>
				<button type="submit" class="custom-btn btn-green btn-green-whitebg btn-primary dashboard-btn">Update</button>
			</div>  
		</form>    
		</div>
	</div>
</div>


<!-- Screening - Edit remarks modal -->
<div id="remarksScrModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form method="POST" action="{{ url('/admin/screening/update-remarks') }}">
		@csrf
		<div class="modal-content p-2 f8f8f8-bg">
			<div class="modal-header">
				<p class="fontS18"><strong>Edit Remarks</strong></p>
			</div>
			<div class="modal-body">
								
				<input type="hidden" name="userId">		
				<input type="hidden" name="type" value="screening">						
				<div class="remarks">	
					<div class="edit-title-container mt-3">
						<span class="fw600">Remarks</span>
						<div class="mt-2">
							<textarea name="remarks" id="content-editor" rows="3"></textarea>
						</div>
					</div>
				</div>									
				
			</div>
			<div class="modal-footer align-items-center">                    
				<button type="button" class="btn btn-default mr-3" data-dismiss="modal">Close</button>
				<button type="submit" class="custom-btn btn-green btn-green-whitebg btn-primary dashboard-btn">Update</button>
			</div>  
		</form>    
		</div>
	</div>
</div>

<!-- Screening - Processing Status Confirm modal -->
<div id="processScrModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content p-2">
			<div class="modal-header">
				<p class="fontS18"><strong>Do you really want to mark <span class="user-name"></span>'s application as "Processing"?</strong></p>
			</div>
			<div class="modal-body d-flex">
				<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<div>
					<p>Confirm update of <span class="user-name"></span>'s screening request application to processing.</p>
					<p>This will update screening status to "Unverified".</p>
				</div>
			</div>
			<form method="POST" action='{{ url("/admin/screening/process") }}'>	
			@csrf            
				<input type="hidden" name="userId">	
				<input type="hidden" name="type" value="screening">
				<div class="modal-footer">   
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button class="act-btn">Confirm</button>      
				</div>                  
			</form>
		</div>
	</div>
</div>

<!-- Screening - Pending Status Confirm modal -->
<div id="pendScrModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content p-2">
			<div class="modal-header">
				<p class="fontS18"><strong>Do you really want to mark <span class="user-name"></span>'s application as "Pending"?</strong></p>
			</div>
			<div class="modal-body d-flex">
				<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<div>
					<p>Confirm update of <span class="user-name"></span>'s screening request application to pending.</p>
					<p>This will update screening status to "Unverified".</p>
				</div>	
			</div>
			<form method="POST" action='{{ url("/admin/screening/pend") }}'>	
			@csrf            
				<input type="hidden" name="userId">	
				<input type="hidden" name="type" value="screening">
				<div class="modal-footer">   
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button class="act-btn">Confirm</button>      
				</div>                  
			</form>
		</div>
	</div>
</div>

<!-- Screening - Pass Status Confirm modal -->
<div id="passScrModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content p-2">
			<div class="modal-header">
				<p class="fontS18"><strong>Do you really want to mark <span class="user-name"></span>'s application as "Passed"?</strong></p>
			</div>
			<div class="modal-body d-flex">
				<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<div>
					<p>Confirm update of <span class="user-name"></span>'s screening request application to passed.</p>
					<p>This will update screening status to "Verified".</p>
				</div>	
			</div>

			<form method="POST" action='{{ url("/admin/screening/passed") }}'>	
			@csrf            
				<input type="hidden" name="userId">	
				<input type="hidden" name="type" value="screening">
				<div class="modal-footer">   
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button class="act-btn">Confirm</button>      
				</div>                  
			</form>
		</div>
	</div>
</div>

<!-- Screening - Fail Status Confirm modal -->
<div id="failScrModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content p-2">
			<div class="modal-header">
				<p class="fontS18"><strong>Do you really want to mark <span class="user-name"></span>'s application as "Failed"?</strong></p>
			</div>
			<div class="modal-body d-flex">
				<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<div>
					<p>Confirm update of <span class="user-name"></span>'s screening request application to failed.</p>
					<p>This will hard delete the user from the system.</p>
				</div>	
			</div>

			<form method="POST" action='{{ url("/admin/screening/failed") }}'>	
			@csrf            
				<input type="hidden" name="userId">	
				<input type="hidden" name="type" value="screening">
				<div class="modal-footer">   
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button class="dlt-btn">Confirm</button>      
				</div>                  
			</form>
		</div>
	</div>
</div>
@endsection