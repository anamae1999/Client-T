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
			    	@if(Session::has('response'))
		                <div class="alert alert-success">
		                    {{ Session::get('response') }}
		                </div>
		            @endif
					<div class="tab-pane fade show active" id="v-pills-users">
						<h2>Users</h2>
						<div class="row no-gutters">
							<ul class="AD-pages-tab nav nav-tabs" id="AD-pages-tab" role="tablist">
								<li class="nav-item p-0 col-sm-auto col-6">
									<a class="nav-link active" id="users-tab-nav" data-toggle="tab" href="#users-tab" role="tab" aria-controls="users-tab" aria-selected="true">Users</a>
								</li>
								<li class="nav-item p-0 col-sm-auto col-6">
									<a class="nav-link" id="mentors-tab-nav" data-toggle="tab" href="#mentors-tab" role="tab" aria-controls="mentors-tab" aria-selected="false">Mentors</a>
								</li>
							</ul>
							<div class="tab-content col-12">

								<!-- USERS TAB -->
								<div class="tab-pane fade show active" id="users-tab" role="tabpanel" aria-labelledby="data-pages-tab">
									<div class="col-12 table-container rounded tl-not-rounded p-0">
										<div class="white-bg tl-not-rounded d-flex flex-row flex-wrap align-items-center p-3 row no-gutters">
											<div class="col-12">
												<div class="row">
													<div class="col-6">
														<h5 class="brown m-0">SUBSCRIBERS TABLE</h5>
													</div>
													<div class="col-6 text-right">
														<p>{{ $users->total() }} users found</p>
													</div>
												</div>
												
											</div>
										</div>
										<div>
											<table class="table table-responsive table-uservetting table-user m-0">
												<thead>
														<form method="GET" action='{{ url("/admin/users/search") }}'>
														@csrf
														<td>
															<div class="brown">Advanced Filter:</div>
															<div class="green mt-1">

																<div class="custom-control custom-radio-green custom-control-inline">
																	<input id="searchAll" class="custom-control-input" type="radio" name="user-role" value="all" {{ !empty($role) && $role == 'all' ? 'checked="checked"' : '' }}>
																	<label class="custom-control-label" for="searchAll">All</label>
																</div>

																<div class="custom-control custom-radio-green custom-control-inline">
																	<input id="searchParent" class="custom-control-input" type="radio" name="user-role" value="parent" {{ !empty($role) && $role == 'parent' ? 'checked="checked"' : '' }}>
																	<label class="custom-control-label" for="searchParent">Parent</label>
																</div>

																<div class="custom-control custom-radio-green custom-control-inline">
																	<input id="searchNanny" class="custom-control-input" type="radio" name="user-role" value="sitter" {{ !empty($role) && $role == 'sitter' ? 'checked="checked"' : '' }}>
																	<label class="custom-control-label" for="searchNanny">Nanny</label>
																</div>														 
															</div>	
														</td>
														<td colspan="7">													
															<div class="user-filter-form col-xl-12 col-lg-7 col-md-5 col-sm-5 col-5 p-0">
																<div class="row no-gutters mb-0 mb-xl-2">						
																	<div class="col-xl-3 mb-2 mb-xl-0">
																		<div class="row no-gutters align-items-center pr-xl-1 pr-lg-0">
																			<div class="col-xl-4 col-lg-3">
																				<label class="green mb-0" for="user-filter-fname">First Name</label>
																			</div>
																			<div class="col-xl-8 col-lg-9">
																				<input class="form-control" type="text" name="user-fname" id="user-filter-fname" placeholder="Enter First Name" value="{{ !empty($fname) ? $fname : '' }}">
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-2 mb-xl-0">
																		<div class="row no-gutters align-items-center px-xl-1 px-lg-0">
																			<div class="col-xl-4 col-lg-3">
																				<label class="green mb-0" for="user-filter-lname">Last Name</label>
																			</div>
																			<div class="col-xl-8 col-lg-9">
																				<input class="form-control" type="text" name="user-lname" id="user-filter-lname" placeholder="Enter Last Name" value="{{ !empty($lname) ? $lname : '' }}">
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-2 mb-xl-0">
																		<div class="row no-gutters align-items-center pl-xl-1 pl-lg-0">
																			<div class="col-xl-5 col-lg-3">
																				<label class="green mb-0" for="user-filter-email">Email Address</label>
																			</div>
																			<div class="col-xl-7 col-lg-9">
																				<input class="form-control" type="text" name="user-email" id="user-filter-email" placeholder="" value="{{ !empty($email) ? $email : '' }}">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="row no-gutters">
																	<div class="col-xl-3 mb-2 mb-xl-0">
																		<div class="row no-gutters align-items-center pr-xl-1 pr-lg-0">
																			<div class="col-xl-4 col-lg-3">
																				<label class="green mb-0">Location</label>
																			</div>
																			<div class="col-xl-8 col-lg-9">
																				<input class="form-control" type="text" name="user-location" id="user-filter-location" placeholder="Enter City or Zip Code" value="{{ !empty($location) ? $location : '' }}">	
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-2 mb-xl-0">
																		<div class="row no-gutters align-items-center px-xl-1 px-lg-0">
																			<div class="col-xl-4 col-lg-3">
																				<label class="green mb-0" for="user-filter-status">Status</label>
																			</div>
																			<div class="col-xl-8 col-lg-9">
																				<select name="user-status" class="form-control">
																					<option value="any" {{ !empty($status) && $status == 'any' ? 'selected="selected"' : '' }}>Any Status</option>
																					<option value="activated" {{ !empty($status) && $status == 'activated' ? 'selected="selected"' : '' }}>Activated</option>
																					<option value="suspended" {{ !empty($status) && $status == 'suspended' ? 'selected="selected"' : '' }}>Suspended</option>
																					<option value="blocked" {{ !empty($status) && $status == 'blocked' ? 'selected="selected"' : '' }}>Blocked</option>							
																				</select>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-2 mb-xl-0">
																		<div class="row no-gutters align-items-center pl-xl-1 pl-lg-0">
																			<div class="col-xl-5 col-lg-3">
																				<label class="green mb-0" for="user-filter-email">Account Type</label>
																			</div>
																			<div class="col-xl-7 col-lg-9">
																				<select name="user-account-type" class="form-control">
																					<option value="any" {{ !empty($accountType) && $accountType == 'any' ? 'selected="selected"' : '' }}>Any Account Type</option>
																					<option value="free" {{ !empty($accountType) && $accountType == 'free' ? 'selected="selected"' : '' }}>Free</option>
																					<option value="premium" {{ !empty($accountType) && $accountType == 'premium' ? 'selected="selected"' : '' }}>Premium</option>
																				</select>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-xl-0">
																		<button type="submit" class="custom-btn btn-green btn-green-whitebg dashboard-btn ml-0 ml-xl-3">Search User</button>

																		@if($showRefresh == 1)
																		<a class="green ml-2" href="/admin/users"><i class="fas fa-redo-alt" data-toggle="tooltip" data-placement="top" title="Refresh Search"></i></a>
																		@endif
																	</div>
																</div>
															</div>
														</form>
														</td>
														<td class="border-right-none"></td>
													</tr>
													<tr>
														<th scope="col">
															<span class="pr-1">User ID</span>
														</th>
														<th scope="col">
															<span class="pr-1">First Name</span>
														</th>
														<th scope="col">
															<span class="pr-1">Last Name</span>
														</th>
														<th scope="col">
															<span class="pr-1">Location</span>
														</th>
														<th scope="col">
															<span class="pr-1">Email Address</span>
														</th>
														<th scope="col">
															<span class="pr-1">Role</span>
														</th>
														<th scope="col">
															<span class="pr-1">Account Type</span>
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
													@if(count($users) > 0)
														@foreach($users as $user)
														<tr>
															<td>{{ sprintf("%06d", $user->id) }}</td>
															<td>{{ ucfirst($user->first_name) }}</td>
															<td>{{ ucfirst($user->last_name) }}</td>
															@if($user->role == 'sitter')
															<td>{{ ucfirst($user->sitterProfile->city) }}</td>
															@endif
															@if($user->role == 'parent')
															<td>{{ ucfirst($user->guardianProfile->city) }}</td>
															@endif
															<td>{{ $user->email }}</td>
															<td>{{ $user->role == 'sitter' ? 'Nanny' : ucfirst($user->role) }}</td>
															<td>
																@if($user->account_type == 'free')
																	{{ ucfirst($user->account_type) }}
																@else
																	@if($user->role == 'sitter')
																		@if($user->subscribed('Nannies Premium Plans'))

																			@php
																				$planType = $user->subscription('Nannies Premium Plans')->stripe_plan;
																				$paymentMode = 'Card';
																			@endphp

														                    @if($planType == 'tsnp-monthly')
														                    	@php
															                        $plan = 'Monthly Nannies Premium Plan';
														                        @endphp
														                    @endif

														                    @if($planType == 'tsnp-3months')
															                    @php
															                        $plan = '3 Months Nannies Premium Plan';
														                        @endphp
														                    @endif

														                    <a class="m-1 green" href="#" data-toggle="modal" data-target="#userSubsModalCard" 
																			data-id="{{ $user->id }}"
																			data-plan="{{ $plan }}"
																			data-payment-mode="{{ $paymentMode }}"
																			data-card-brand="{{ ucfirst($user->card_brand) }}"
																			data-card-last-four="{{ $user->card_last_four }}"
																			>{{ ucfirst($user->account_type) }}</a>
																		@else

																			@if($user->idealSubscription->name == 'Nanny 3mos Premium Membership')
																				@php
															                        $plan = '3 Months Nannies Premium Plan';
														                        @endphp
														                    @endif

														                    @if($user->idealSubscription->name == 'Nanny 1mo Premium Membership')
														                        @php
															                        $plan = 'Monthly Nannies Premium Plan';
														                        @endphp
														                    @endif  

														                    @php
														                    	$paymentMode = 'Ideal';
															                    $subsEnd = date('M d, Y',strtotime($user->idealSubscription->ends_at));
														                    @endphp
														                    <a class="m-1 green" href="#" data-toggle="modal" data-target="#userSubsModalIdeal" 
																			data-id="{{ $user->id }}"
																			data-plan="{{ $plan }}"
																			data-payment-mode="{{ $paymentMode }}"
																			data-subs-end="{{ $subsEnd }}"	
																			>{{ ucfirst($user->account_type) }}</a>
																		@endif
																		
																	@endif

																	@if($user->role == 'parent')
																		@if($user->subscribed('Parents Premium Plans'))

																			@php
																				$planType = $user->subscription('Parents Premium Plans')->stripe_plan;
																				$paymentMode = 'Card';
																			@endphp

														                    @if($planType == 'tspp-monthly')
														                    	@php
															                        $plan = 'Monthly Parents Premium Plan';
														                        @endphp
														                    @endif

														                    @if($planType == 'tspp-3months')
															                    @php
															                        $plan = '3 Months Parents Premium Plan';
														                        @endphp
														                    @endif

														                    <a class="m-1 green" href="#" data-toggle="modal" data-target="#userSubsModalCard" 
																			data-id="{{ $user->id }}"
																			data-plan="{{ $plan }}"
																			data-payment-mode="{{ $paymentMode }}"
																			data-card-brand="{{ ucfirst($user->card_brand) }}"
																			data-card-last-four="{{ $user->card_last_four }}"
																			>{{ ucfirst($user->account_type) }}</a>
																		@else

																			@if($user->idealSubscription->name == 'Parent 3mos Premium Membership')
																				@php
															                        $plan = '3 Months Parents Premium Plan';
														                        @endphp
														                    @endif

														                    @if($user->idealSubscription->name == 'Parent 1mo Premium Membership')
														                        @php
															                        $plan = 'Monthly Parents Premium Plan';
														                        @endphp
														                    @endif  

														                    @php
														                    	$paymentMode = 'Ideal';
															                    $subsEnd = date('M d, Y',strtotime($user->idealSubscription->ends_at));
														                    @endphp
														                    <a class="m-1 green" href="#" data-toggle="modal" data-target="#userSubsModalIdeal" 
																			data-id="{{ $user->id }}"
																			data-plan="{{ $plan }}"
																			data-payment-mode="{{ $paymentMode }}"
																			data-subs-end="{{ $subsEnd }}"	
																			>{{ ucfirst($user->account_type) }}</a>
																		@endif
																	@endif
																@endif
																</td>
															<td>{{ ucfirst($user->account_status) }}</td>
															<td>
																
																<a class="m-1 green" href='{{ $user->role == "sitter" ? url("/nannies/profile") : url("/parents/profile") }}/{{$user->id}}/{{ strtolower($user->first_name) }}' target="_blank"><i class="far fa-eye px-2 mx-1" data-toggle="tooltip" data-placement="top" title="View Profile"></i></a>

																@if($user->role == 'sitter')
																	@php
																	 	$func = 'sitterProfile';
															        @endphp	
															    @elseif($user->role == 'parent')  
															    	@php
																	 	$func = 'guardianProfile';
															        @endphp
														        @endif

														        @if(!is_null($user->$func->date_of_birth))
																	@php
																	 	$birthDate = explode("/", $user->$func->date_of_birth);
															        @endphp
														        @else
															    	@php
																	 	$birthDate = '';
															        @endphp	
														        @endif

														        @if($birthDate)
															        @php
															            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
															        @endphp
															    @else
																    @php
																		$age = '';
																    @endphp	
														        @endif
														        

															    @if($user->isOnline())
															   		@php
																		$status = '<span class="status online">Online</span>';
																	@endphp
																@else
																	@php
																		$status = '<span class="status offline">Offline</span>';
																	@endphp
																@endif
																														
																<a class="m-1 green" href="#" data-toggle="modal" data-target="#admin-user-modal" 
																data-id="{{ $user->id }}"
																data-pic="{{ $user->$func->profile_pic ? $user->$func->profile_pic : asset('images/avatar-placeholder.png') }}" 
																data-gender="{{ $user->$func->gender }}"
																data-city="{{ $user->$func->city }}"
																data-exp="{{ $user->$func->years_of_experience }}"
																data-fname="{{ $user->first_name }}" 
																data-age="{{ $age }}"
																data-job="{{ $user->$func->job_description }}"																
																data-desc="{{ $user->$func->general_text }}"
																data-status="{{ $status }}"
																><i class="far fa-edit px-2 mx-1" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>

																
																<div class="ad-dropdown-wrap pos-relative text-center">
																	<a href="#" class="ut-dropbutton selected green"><i class="fas fa-list px-2 mx-1" data-toggle="tooltip" data-placement="top" title="Change Status"></i></a>
																	<div class="ut-dropdown">

																		@if($user->account_status != 'activated')
																		<a class="m-1 ut-dropdown-item" href="#activateUserModal" data-toggle="modal" data-id="{{ $user->id }}" data-name="{{ $user->first_name }} {{ $user->last_name }}">Activate</a>
																		@endif

																		@if($user->account_status != 'suspended')
																		<a class="m-1 ut-dropdown-item" href="#suspendUserModal" data-toggle="modal" data-id="{{ $user->id }}" data-name="{{ $user->first_name }} {{ $user->last_name }}">Suspend</a>
																		@endif

																		@if($user->account_status != 'blocked')
																		<a class="m-1 ut-dropdown-item" href="#blockUserModal" data-toggle="modal" data-id="{{ $user->id }}" data-name="{{ $user->first_name }} {{ $user->last_name }}">Block</a>
																		@endif																		
																		<a class="m-1 ut-dropdown-item" href="#deleteUserModal" data-toggle="modal" data-id="{{ $user->id }}" data-name="{{ $user->first_name }} {{ $user->last_name }}">Delete</a>
																		
																	</div>
																</div>
																
																
															</td>
														</tr>
														@endforeach
													@else
													<tr>
														<td colspan="9">No users found.</td>
													</tr>
													@endif
												</tbody>
											</table>
											<div class="table-container-footer clearfix">
												{{ $users->appends(Request::except('page'))->links() }}
											</div>
										</div>
									</div>	
								</div>

								<!-- MENTORS TAB -->
								<div class="tab-pane fade" id="mentors-tab" role="tabpanel" aria-labelledby="data-pages-tab">
									<div class="col-12 table-container rounded tl-not-rounded p-0">
										<div class="white-bg tl-not-rounded d-flex flex-row flex-wrap align-items-center p-3 row no-gutters">
											<div class="col-12">
												<div class="row">
													<div class="col-6">
														<h5 class="brown m-0 inlineBlock align-middle mr-3">MENTORS TABLE</h5>
														<button class="custom-btn btn-green btn-green-whitebg add-mentor-btn inlineBlock align-middle" data-toggle="modal" data-target="#add-mentor-modal" id="sign-up">Add Mentor</button>	
													</div>
													<div class="col-6 text-right">
														<p>{{ $mentors->total() }} users found</p>
													</div>
												</div>
												
											</div>
										</div>
										<div>
											<table class="table table-responsive table-uservetting table-user m-0">
												<thead>
														<form method="GET" action='{{ url("/admin/mentors/search") }}'>
														@csrf														
														<td colspan="6">													
															<div class="user-filter-form col-xl-12 col-lg-7 col-md-5 col-sm-5 col-5 p-0">
																<div class="row no-gutters mb-0 mb-xl-2">						
																	<div class="col-xl-4 mb-2 mb-xl-0">
																		<div class="row no-gutters align-items-center pr-xl-1 pr-lg-0">
																			<div class="col-lg-4 col-xl-3">
																				<label class="green mb-0" for="mentor-filter-fname">First Name</label>
																			</div>
																			<div class="col-lg-8 col-xl-9">
																				<input class="form-control" type="text" name="mentor-fname" id="mentor-filter-fname" placeholder="Enter First Name" value="{{ !empty($fnameM) ? $fnameM : '' }}">
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-4 mb-2 mb-xl-0">
																		<div class="row no-gutters align-items-center px-xl-1 px-lg-0">
																			<div class="col-lg-4 col-xl-3">
																				<label class="green mb-0" for="mentor-filter-lname">Last Name</label>
																			</div>
																			<div class="col-lg-8 col-xl-9">
																				<input class="form-control" type="text" name="mentor-lname" id="mentor-filter-lname" placeholder="Enter Last Name" value="{{ !empty($lnameM) ? $lnameM : '' }}">
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-4 mb-2 mb-xl-0">
																		<div class="row no-gutters align-items-center pl-xl-1 pl-lg-0">
																			<div class="col-lg-4 col-xl-3">
																				<label class="green mb-0" for="mentor-filter-email">Email Address</label>
																			</div>
																			<div class="col-lg-8 col-xl-9">
																				<input class="form-control" type="text" name="mentor-email" id="mentor-filter-email" placeholder="" value="{{ !empty($emailM) ? $emailM : '' }}">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="row no-gutters">
																	<div class="col-xl-4 mb-2 mb-xl-0">
																		<div class="row no-gutters align-items-center pr-xl-1 pr-lg-0">
																			<div class="col-lg-4 col-xl-3">
																				<label class="green mb-0">Location</label>
																			</div>
																			<div class="col-lg-8 col-xl-9">
																				<input class="form-control" type="text" name="mentor-location" id="mentor-filter-location" placeholder="Enter City or Zip Code" value="{{ !empty($locationM) ? $locationM : '' }}">	
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-4 mb-2 mb-xl-0">
																		<div class="row no-gutters align-items-center px-xl-1 px-lg-0">
																			<div class="col-lg-4 col-xl-3">
																				<label class="green mb-0" for="mentor-filter-status">Status</label>
																			</div>
																			<div class="col-lg-8 col-xl-9">
																				<select name="mentor-status" class="form-control">
																					<option value="any" {{ !empty($statusM) && $statusM == 'any' ? 'selected="selected"' : '' }}>Any Status</option>
																					<option value="activated" {{ !empty($statusM) && $statusM == 'activated' ? 'selected="selected"' : '' }}>Activated</option>
																					<option value="suspended" {{ !empty($statusM) && $statusM == 'suspended' ? 'selected="selected"' : '' }}>Suspended</option>
																					<option value="blocked" {{ !empty($statusM) && $status == 'blocked' ? 'selected="selected"' : '' }}>Blocked</option>
																				</select>
																			</div>
																		</div>
																	</div>				
																	<div class="col-xl-4 mb-xl-0">
																		<button type="submit" class="custom-btn btn-green btn-green-whitebg dashboard-btn ml-0 ml-xl-1">Search User</button>

																		@if($showRefreshM == 1)
																		<a class="green ml-2" href="/admin/users"><i class="fas fa-redo-alt" data-toggle="tooltip" data-placement="top" title="Refresh Search"></i></a>
																		@endif
																	</div>
																</div>
															</div>
														</form>
														</td>
														<td class="border-right-none">
															
														</td>
													</tr>
													<tr>
														<th scope="col">
															<span class="pr-1">User ID</span>
														</th>
														<th scope="col">
															<span class="pr-1">First Name</span>
														</th>
														<th scope="col">
															<span class="pr-1">Last Name</span>
														</th>
														<th scope="col">
															<span class="pr-1">Location</span>
														</th>
														<th scope="col">
															<span class="pr-1">Email Address</span>
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
													@if(count($mentors) > 0)
														@foreach($mentors as $mentor)
														<tr>
															<td>{{ sprintf("%06d", $mentor->id) }}</td>
															<td>{{ ucfirst($mentor->first_name) }}</td>
															<td>{{ ucfirst($mentor->last_name) }}</td>	
															<td>{{ ucfirst($mentor->mentorProfile->city) }}</td>
															<td>{{ $mentor->email }}</td>	
															<td>{{ ucfirst($mentor->account_status) }}</td>
															<td>
																
																<a class="m-1 green" href='{{ url("/mentors/profile")  }}/{{$mentor->id}}/{{ strtolower($mentor->first_name) }}' target="_blank"><i class="far fa-eye px-2 mx-1" data-toggle="tooltip" data-placement="top" title="View Profile"></i></a>												        

															    @if($mentor->isOnline())
															   		@php
																		$status = '<span class="status online">Online</span>';
																	@endphp
																@else
																	@php
																		$status = '<span class="status offline">Offline</span>';
																	@endphp
																@endif
																														
																<a class="m-1 green" href="#" data-toggle="modal" data-target="#admin-user-modal" 
																data-id="{{ $mentor->id }}"
																data-pic="{{ $mentor->mentorProfile->profile_pic ? $mentor->mentorProfile->profile_pic : asset('images/avatar-placeholder.png') }}" 
																data-gender="{{ $mentor->mentorProfile->gender }}"
																data-city="{{ $mentor->mentorProfile->city }}"
																data-fname="{{ $mentor->first_name }}" 
																data-job="{{ $mentor->mentorProfile->job_description }}"	
																data-desc="{{ $mentor->mentorProfile->general_text }}"
																data-status="{{ $status }}"
																><i class="far fa-edit px-2 mx-1" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>

																
																<div class="ad-dropdown-wrap pos-relative text-center">
																	<a href="#" class="ut-dropbutton selected green"><i class="fas fa-list px-2 mx-1" data-toggle="tooltip" data-placement="top" title="Change Status"></i></a>
																	<div class="ut-dropdown">

																		@if($mentor->account_status != 'activated')
																		<a class="m-1 ut-dropdown-item" href="#activateUserModal" data-toggle="modal" data-id="{{ $mentor->id }}" data-name="{{ $mentor->first_name }} {{ $mentor->last_name }}">Activate</a>
																		@endif

																		@if($mentor->account_status != 'suspended')
																		<a class="m-1 ut-dropdown-item" href="#suspendUserModal" data-toggle="modal" data-id="{{ $mentor->id }}" data-name="{{ $mentor->first_name }} {{ $mentor->last_name }}">Suspend</a>
																		@endif

																		@if($mentor->account_status != 'blocked')
																		<a class="m-1 ut-dropdown-item" href="#blockUserModal" data-toggle="modal" data-id="{{ $mentor->id }}" data-name="{{ $mentor->first_name }} {{ $mentor->last_name }}">Block</a>
																		@endif
																		
																		<a class="m-1 ut-dropdown-item" href="#deleteUserModal" data-toggle="modal" data-id="{{ $mentor->id }}" data-name="{{ $mentor->first_name }} {{ $mentor->last_name }}">Delete</a>			
																	</div>
																</div>
																
																
															</td>
														</tr>
														@endforeach
													@else
													<tr>
														<td colspan="9">No users found.</td>
													</tr>
													@endif
												</tbody>
											</table>
											<div class="table-container-footer clearfix">
												{{ $mentors->appends(Request::except('page'))->links() }}
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
	</div>
</section>

<!-- User Modal -->
<div class="modal fade" id="admin-user-modal" tabindex="-1" role="dialog" aria-labelledby="user-modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content profile-modal">
            <div class="modal-header">                
                <div class="pic"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row align-items-end padB15">
                    <div class="col-12 col-sm-6 profile-modal-top">
                        <h4 class="m-0"><span class="fname"></span></h4>     
                        <p class="city"></p>                   
                    </div>
                    <div class="col-12 col-sm-6 profile-modal-top"> 
                        <span class="status"></span>
                    </div>   
                </div>
                <div class="row align-items-center padTB15 border-top-bot">
                    <div class="col-md-12">
                        <p class="m-0"><span class="job"></span>, <span class="exp"></span> years Experience</p>
                    </div>
                </div>
                
            <form method="POST" action='{{ url("/admin/user/update") }}'>
            @csrf
	                <div class="row align-items-center padT25 padB10">
	                	<div class="col-md-12">
		                	<div class="profile-modalWlist">
	                            <strong class="green">User Description Text</strong>
	                        </div>
                        </div>
	                    <div class="col-md-12">
	                        <div class="old-profile-form">
								<p class="m-0 desc"></p>
							</div>
							<div class="new-profile-form hide">	
								<input type="hidden" name="userId">							
								<textarea name="general-text" class="desc-form form-control"></textarea>
							</div>
	                    </div>
	                </div>                	
                               
            </div>
            <div class="modal-footer text-center">
            	<button type="button" class="custom-btn btn-green btn-green-whitebg profile-btn">Edit Description as Admin</button>
				<button type="submit" class="custom-btn btn-green btn-green-whitebg update-btn">Update Description as Admin</button>
            </div>
            </form> 
        </div>
    </div>
</div>
<!-- END -->

<!-- Subscription modal card -->
<div id="userSubsModalCard" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Subscription Details</strong></p>
            </div>
            <div class="modal-body">
				<p><span class="green">Payment Mode:</span> <strong class="payment-mode"></strong></p>
				<p><span class="green">Card Brand:</span> <strong class="card-brand"></strong></p>		
				<p><span class="green">Card Last Four:</span> <strong class="card-last-four"></strong></p>		
				<p><span class="green">Plan:</span> <strong class="plan"></strong></p>
			</div>			
        </div>
    </div>
</div>

<!-- Subscription modal ideal -->
<div id="userSubsModalIdeal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Subscription Details</strong></p>
            </div>
            <div class="modal-body">
				<p><span class="green">Payment Mode:</span> <strong class="payment-mode"></strong></p>
				<p><span class="green">Plan:</span> <strong class="plan"></strong></p>
				<p><span class="green">Subscription End Date:</span> <strong class="subs-end"></strong></p>				
			</div>			
        </div>
    </div>
</div>

<!-- Delete confirmation modal -->
<div id="deleteUserModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Do you really want to delete "<span class="user-name"></span>"?</strong></p>
            </div>
            <div class="modal-body d-flex">
				<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<p> Are you sure you want to delete <span class="user-name"></span>'s account?</p>
			</div>
			<form method="POST" action='{{ url("/admin/user/delete") }}'>	
            @csrf        
            @method('delete')    
	            <input type="hidden" name="userId">	
				<div class="modal-footer">   
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button class="dlt-user dlt-btn">Delete</button>      
				</div>                  
			</form>
        </div>
    </div>
</div>

<!-- Suspend confirmation modal -->
<div id="suspendUserModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Do you really want to suspend "<span class="user-name"></span>"?</strong></p>
            </div>
            <div class="modal-body d-flex">
				<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<p>Proceeding will suspend <span class="user-name"></span>'s account from using the system's features.</p>
			</div>
			<form method="POST" action='{{ url("/admin/user/suspend") }}'>	
            @csrf            
	            <input type="hidden" name="userId">	
				<div class="modal-footer">   
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button class="spd-btn">Suspend</button>      
				</div>                  
			</form>
        </div>
    </div>
</div>

<!-- Block confirmation modal -->
<div id="blockUserModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Do you really want to block "<span class="user-name"></span>"?</strong></p>
            </div>
            <div class="modal-body d-flex">
				<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<p>Proceeding will block <span class="user-name"></span> from logging in on the system.</p>
			</div>
			<form method="POST" action='{{ url("/admin/user/block") }}'>	
            @csrf         
	            <input type="hidden" name="userId">	
				<div class="modal-footer">   
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button class="blk-btn">Block</button>      
				</div>                  
			</form>
        </div>
      </div>
</div>

<!-- Activate confirmation modal -->
<div id="activateUserModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content p-2">
            <div class="modal-header">
            	<p class="fontS18"><strong>Do you really want to activate "<span class="user-name"></span>"?</strong></p>
            </div>
            <div class="modal-body d-flex">
				<svg class="text-warning mr-3" width="45" length="auto" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" class=""></path></svg>
				<p>Proceeding will activate <span class="user-name"></span>'s account.</p>
			</div>
			<form method="POST" action='{{ url("/admin/user/activate") }}'>	
            @csrf            
	            <input type="hidden" name="userId">	
				<div class="modal-footer">   
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button class="act-btn">Activate</button>      
				</div>                  
			</form>
        </div>
      </div>
</div>

<!-- Add Mentor Modal -->
<div class="modal fade auth-modal" id="add-mentor-modal" tabindex="-1" role="dialog" aria-labelledby="add-mentor-modalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content login-signup-modal signup-modal">
			<div class="modal-header">
				<div class="container">
					<div class="row align-items-center">
						<div class="modal-header-left">
							<img src="{{ asset('images/TinyStepsLogo.svg') }}">
						</div>
						<div class="modal-header-right">
							<h4 class="modal-title">Add a Mentor Account</h4>							
						</div>
					</div>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<form method="POST" action='{{ url("/admin/mentor/create") }}'>
					@csrf								
					<div class="form-group half-input clearfix">
						<input id="FirstName" type="text" class="form-control @error('first-name') is-invalid @enderror" name="first-name" value="{{ old('first-name') }}" required autocomplete="first-name" autofocus placeholder="First Name">

						@error('first-name')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror

						<input id="LastName" type="text" class="form-control @error('last-name') is-invalid @enderror" name="last-name" value="{{ old('last-name') }}" required autocomplete="last-name" autofocus placeholder="Last Name">

						@error('last-name')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror					    
					</div>						
					<div class="form-group">					    
						<input type="email" class="form-control @if($errors->has('email') && !old('loginform')) is-invalid @endif" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

						@if($errors->has('email'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
						@endif
					</div>							
					<div class="form-group">	
						<p class="pass-req">Password must contain at least 8 characters.</p>														
						<input id="password" type="password" class="password-box-reg form-control @if($errors->has('password') && !old('loginform')) is-invalid @endif" name="password" required autocomplete="new-password" placeholder="Password">
						@if($errors->has('password'))
						<span class="invalid-feedback" role="alert">									
							<strong>{{ $errors->first('password') }}</strong> 	
						</span>							
						@endif
					</div> 
					<div class="form-group">
						<input id="password-confirm" type="password" class="password-box-reg form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
						<div class="p-2">
							<a class="green float-right show-password-reg" href="#">Show password</a>
						</div>							
					</div> 								 
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block"> Create Account </button>	
					</div>                                                         
				</form>
			</div>
		</div>
	</div>
</div>
<!-- END -->
@endsection

