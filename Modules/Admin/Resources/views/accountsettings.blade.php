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
					<div class="no-gutters">
						@if(Session::has('response'))
			                <div class="alert alert-success">
			                    {{ Session::get('response') }}
			                </div>
			            @endif
						<div>
							<h2>System Settings</h2>
						</div>						

						<!-- price settings -->
						<div id="price-settings" class="row no-gutters white-bg rounded shadow scroll-x flex-column">
							<div class="section-header col-12 d-flex flex-row flex-wrap align-items-center px-4 pt-4 pb-3 no-gutters">
								<h4 class="brown m-0 mx-3">Subscription Details</h4>
							</div>
							<h5 class="brown mx-4 mt-4">Pricing</h5>
							<div class="ts-tab-container m-3">
								
								<div class="ts-tab-header col-12 d-flex flex-row flex-wrap align-items-center px-4 pt-4 no-gutters">
									<ul class="AD-pages-tab nav nav-tabs" id="AD-pages-tab" role="tablist">
										<li class="nav-item p-0 col-sm-auto col-6 d-flex">
											<a class="nav-link active" id="parents-tab" data-toggle="tab" href="#parentPrices" role="tab" aria-controls="parents-tab" aria-selected="true">For Parent</a>
										</li>
										<li class="nav-item p-0 col-sm-auto col-6 d-flex">
											<a class="nav-link" id="nannies-tab" data-toggle="tab" href="#nannyPrices" role="tab" aria-controls="nannies-tab" aria-selected="false">For Nanny</a>
										</li>
									</ul>
								</div>
								<div class="prices-container">									      		
									<div class="tab-content" id="prices-tab-content">
										<div class="tab-pane fade show active" id="parentPrices" role="tabpanel" aria-labelledby="parent-prices-tab">
												
												<div class="col-md-12 pt-4 px-4 pb-2">
													<table class="table table-bordered admin-table table-responsive">
															<tr height="70">
															<td><p class="bullet-container"><span class="green-bullet">&nbsp;</span>Free</p></td>
																<td>€ 0.00</td>
																<td>(€ 0.00 per month)</td>
															</tr>
															<tr class="ad-pricing">
																<td><p class="bullet-container"><span class="green-bullet">&nbsp;</span>1 month</p></td>
																<td>€ {{ $settings->parent_1mo }}</td>
																<td>(€ {{ $settings->parent_1mo }} per month)</td>
																<form method="POST" action="{{ url('/admin/settings/update-price') }}">
																@csrf
																	<td>
																		<input type="number" name="parent-price-1mo" class="price-input" placeholder="Enter amount" value="{{ $settings->parent_1mo }}" min="0" step=".01">
																	</td>	
																	<td><button type="submit" class="custom-btn btn-green btn-green-whitebg">Change Amount</button></td>
																</form>
															</tr>
															<tr class="ad-pricing">
																<td><p class="bullet-container"><span class="green-bullet">&nbsp;</span>3 month</p></td>
																<td>€ {{ $settings->parent_3mo }}</td>
																<td>(€ {{ round(($settings->parent_3mo / 3), 2) }} per month)</td>
																<form method="POST" action="{{ url('/admin/settings/update-price') }}">
																@csrf
																	<td>
																		<input type="number" name="parent-price-3mo" class="price-input" placeholder="Enter amount" value="{{ $settings->parent_3mo }}" min="0" step=".01">
																	</td>	
																	<td><button type="submit" class="custom-btn btn-green btn-green-whitebg">Change Amount</button></td>
																</form>
															</tr>
													</table>
												</div>								      							
										</div>
										<div class="tab-pane fade" id="nannyPrices" role="tabpanel" aria-labelledby="nanny-prices-tab">
											<div class="col-md-12 pt-4 px-4 pb-2">
												<table class="table table-bordered admin-table table-responsive">
														<tr height="70">
														<td><p class="bullet-container"><span class="green-bullet">&nbsp;</span>Free</p></td>
															<td>€ 0.00</td>
															<td>(€ 0.00 per month)</td>
														</tr>
														<tr class="ad-pricing">
															<td><p class="bullet-container"><span class="green-bullet">&nbsp;</span>1 month</p></td>
															<td>€ {{ $settings->sitter_1mo }}</td>
															<td>(€ {{ $settings->sitter_1mo }} per month)</td>
															<form method="POST" action="{{ url('/admin/settings/update-price') }}">
																@csrf
																<td>
																	<input type="number" name="sitter-price-1mo" class="price-input" placeholder="Enter amount" value="{{ $settings->sitter_1mo }}" min="0" step=".01">
																</td>	
																<td><button type="submit" class="custom-btn btn-green btn-green-whitebg">Change Amount</button></td>
															</form>
														</tr>
														<tr class="ad-pricing">
															<td><p class="bullet-container"><span class="green-bullet">&nbsp;</span>3 month</p></td>
															<td>€ {{ $settings->sitter_3mo }}</td>
															<td>(€ {{ round(($settings->sitter_3mo / 3), 2) }} per month)</td>
															<form method="POST" action="{{ url('/admin/settings/update-price') }}">
																@csrf
																<td>
																	<input type="number" name="sitter-price-3mo" class="price-input" placeholder="Enter amount" value="{{ $settings->sitter_3mo }}" min="0" step=".01">
																</td>	
																<td><button type="submit" class="custom-btn btn-green btn-green-whitebg">Change Amount</button></td>
															</form>
														</tr>
												</table>
											</div>											
										</div>
									</div>
								</div>		
							</div>	
							
							<h5 class="brown mx-4 mt-4">Payment Section Text</h5>
							<div class="col-md-8 px-4 pb-4">
								<form method="POST" action="{{ url('/admin/settings/update-notice') }}">
								@csrf
									<textarea name="payment-notice" class="payment-notice p-3" rows="3">{{$settings->payment_notice}}</textarea>
							    	<button type="submit" class="custom-btn btn-green btn-green-whitebg mt-2">Save Changes</button>
								</form>							    
							</div>						
						</div>

						<!-- account settings -->
						<form id="account-settings" method="post" action="{{ url('/admin/settings/update') }}" enctype="multipart/form-data" class="admin-accset" autocomplete="off">
					    @csrf
					    @method('patch')
						<div class="mt-5 row no-gutters white-bg rounded shadow align-items-center">
							<div class="section-header order-1 col-12 d-flex flex-row flex-wrap align-items-center px-4 pt-4 pb-3 no-gutters">
									<h4 class="brown m-0 mx-3">Account Details</h4>
							</div>
							<div class="col-12 col-xl-9 order-3 order-xl-2">	
								<div class="row no-gutters">
									<div class="col-md-12 p-4 p-xl-5">
										<div class="row align-items-start pb-3">
											<div class="col-lg-6 pb-3 pb-lg-0">
												<label class="green" for="">Current email address</label>
												<p class="account-settings-email">{{ $user->email }}</p>
											</div>
											<div class="col-lg-6">
												<label class="green" for="">New email address</label>
												<input type="email" class="ad-input form-control" name="email">
												@if ($errors->has('email'))
                                                    <span class="help-block">
                                                        {{ $errors->first('email') }}
                                                    </span>
                                                @endif
											</div>
										</div>
										<div class="row align-items-start pb-3">	
											<div class="col-lg-6 pb-3 pb-lg-0">
												<label class="green" for="">New Password <span class="pass-req">(Min. 8 Characters)</span></label>												
												<input id="password-field" type="password" class="form-control" name="password">
												<span toggle="#password-field" class="fa fa-fw fa-eye password-icon toggle-password"></span>
												@if ($errors->has('password'))
                                                    <span class="help-block">
                                                        {{ $errors->first('password') }}
                                                    </span>
                                                @endif
											</div>
											<div class="col-lg-6">
												<label class="green" for="">Confirm New Password</label>
												<input id="password-field-confirmation" type="password" class="form-control" name="password_confirmation">
												<span toggle="#password-field-confirmation" class="fa fa-fw fa-eye password-icon toggle-password-confirmation"></span>
												@if ($errors->has('password_confirmation'))
                                                    <span class="help-block">
                                                        {{ $errors->first('password_confirmation') }}
                                                    </span>
                                                @endif
											</div>
										</div>
										<div class="row align-items-start">	
											<div class="col-lg-6 pb-3 pb-lg-0">
												<label class="green" for="">First Name</label>
												<input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}">	
												@if ($errors->has('first_name'))
                                                    <span class="help-block">
                                                        {{ $errors->first('first_name') }}
                                                    </span>
                                                @endif
											</div>
											<div class="col-lg-6">
												<label class="green" for="">Last Name</label>
												<input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}">
												@if ($errors->has('last_name'))
                                                    <span class="help-block">
                                                        {{ $errors->first('last_name') }}
                                                    </span>
                                                @endif
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-12 col-xl-3 order-2 order-xl-3 d-flex justify-content-center">
								<div class="edit-admin-pic text-center p-3">
									<h5 class="mb-3 mt-1">Update Photo</h5>
									<div>
										<div class="profile-img-wrap">
											<img id="profile-img" class="profile-photo-frame" src="{{ $user->admin->admin_pic ? $user->admin->admin_pic : '/images/avatar-placeholder.png' }}" alt="{{ $user->first_name }} {{ $user->last_name }}">		
										</div>
									</div>
									<div class="py-2">
										<label for="file-upload-profile" class="fileBtn">
											Choose File
										</label>
										<input name="profile-pic" class="file-upload hide" id="file-upload-profile" type="file" value="{{ $user->admin->admin_pic }}" />
										<span class="fileName">{{ $user->admin->admin_pic ? '' : 'No file chosen' }}</span>
									</div>
									@if ($errors->has('profile-pic'))
	                                    <span class="help-block">
	                                        {{ str_replace("profile-pic","profile picture",$errors->first('profile-pic')) }}
	                                    </span>
	                                @endif
								</div>
							</div>

							<div class="col-12 px-5 pb-5 order-4 pt-4 pt-xl-0">																
								<button class="custom-btn btn-green btn-green-whitebg" type="submit">Save Changes</button>
							</div>
						</div>
						</form>

						<!-- Cookie Settings -->
						<div id="cookie-settings" class="mt-5 row no-gutters white-bg rounded shadow">
							<div class="section-header col-12 d-flex flex-row flex-wrap align-items-center px-4 pt-4 pb-3 no-gutters">
								<h4 class="brown m-0 mx-3">Cookie Policy</h4>
							</div>

							<div class="col-12 p-4">
								<div class="col-12 d-flex justify-content-start">
									<h5>Cookie notification is turned {{ $settings->cookie == 1 ? 'on' : 'off' }}.</h5>									
									<form id="cookieForm" method="POST" action="{{ url('/admin/settings/toggle-cookie') }}">
									@csrf
										<label class="switch m-0 mx-3">
											<input type="checkbox" name="cookie-toggle"
											@if($settings->cookie == 1)
												checked="checked"
											@endif
											>
											<span class="slider round"></span>
										</label>
									</form>									
								</div>
								<div class="col-12">
									<p><em>Turn cookie notification on/off.</em></p>
								</div>		
							</div>					
						</div>

						<!-- Vetting Settings -->
						<div id="vetting-settings" class="mt-5 row no-gutters white-bg rounded shadow">
							<div class="section-header col-12 d-flex flex-row flex-wrap align-items-center px-4 pt-4 pb-3 no-gutters">
								<h4 class="brown m-0 mx-3">Vetting Request Feature</h4>
							</div>

							<div class="col-12 p-4">
								<div class="col-12 d-flex justify-content-start">
									<h5>Vetting feature is turned {{ $settings->vetting == 1 ? 'on' : 'off' }}.</h5>									
									<form id="vettingForm" method="POST" action="{{ url('/admin/settings/toggle-vetting') }}">
									@csrf
										<label class="switch m-0 mx-3">
											<input type="checkbox" name="vetting-toggle"
											@if($settings->vetting == 1)
												checked="checked"
											@endif
											>
											<span class="slider round"></span>
										</label>
									</form>							
								</div>
								<div class="col-12">
									<p><em>Turn vetting feature on/off.</em></p>
								</div>			
							</div>					
						</div>

						<!-- Badges -->
						<div id="badges" class="mt-5 row no-gutters white-bg rounded shadow">
							<div class="section-header col-12 d-flex flex-row flex-wrap align-items-center px-4 pt-4 pb-3 no-gutters">
								<h4 class="brown m-0 mx-3">Badges</h4>								
							</div>
							<div class="col-12 p-4">								
								@if(count($badges) > 0)
									<table class="badge-list table table-bordered admin-table table-responsive">
										@foreach($badges as $badge)
										<tr>
											<td><h5 class="green badge-name m-0">{{$badge->badge_name}}</h5></td>
											<td><img class="badge-image" src="{{$badge->badge_pic}}" alt="{{$badge->badge_name}}"></td>
											<td>
											    <form method="POST" action="/admin/delete-badge">
											        @csrf
											        @method('DELETE')
											        <div class="form-group">
											        	<input type="hidden" name="badgeId" value="{{$badge->id}}">											            
											            <button class="brown del-evt-dtls-btn"><i class="fas fa-trash"></i></button>
											        </div>
											    </form>
												
											</td>
										</tr>
								    	@endforeach	
									</table>					                    
						    	@else									
									<p>No badges available</p>																						
								@endif									
							</div>

							<div class="col-12 p-4">
								<div class="col-12 d-flex justify-content-start">
																		
									<form id="badgesForm" method="POST" action="{{ url('/admin/settings/add-badge') }}" enctype="multipart/form-data">
									@csrf
										<div class="badges padT10">				
											<div class="padTB10">												
												<div class="form-group">
													<label class="green mb-0" for="badgeName">Badge Name<span class="required"> *</span></label>
													<input id="badgeName" name="badge-name" type="text" class="form-control" value="{{ old('badge-name') }}">	
													@if ($errors->has('badge-name'))
		                                                <span class="help-block">
		                                                	{{ str_replace("badge-name","badge name",$errors->first('badge-name')) }}	
		                                                </span>
		                                            @endif
												</div>
												<div class="form-group">
													<label class="green mb-0" for="badgeImage">Badge Image<span class="required"> *</span></label>
													<label for="badgeImage" class="fileBtn">
														Choose File
													</label>												
													<input id="badgeImage" name="badge-image" class="file-upload hide" type="file" />
													<span class="fileName">No file chosen</span>
													@if ($errors->has('badge-image'))
		                                                <span class="help-block">
		                                                    {{ str_replace("badge-image","badge image",$errors->first('badge-image')) }}
		                                                </span>
		                                            @endif
												</div>
												<button type="submit" class="custom-btn btn-green btn-green-whitebg btn-primary">Add Badge</button>
											</div>
										</div>										
									</form>							
								</div>
										
							</div>					
						</div>

						<!-- Social Media Links Row -->
						<div id="social-links" class="mt-5 row no-gutters white-bg rounded shadow">
							<div class="section-header col-12 d-flex flex-row flex-wrap align-items-center px-4 pt-4 pb-3 no-gutters">
								<h4 class="brown m-0 mx-3">Social Media Links</h4>
							</div>
							<form class="full-width" method="POST" action="/admin/settings/update-social">
							@csrf
								<div class="col-12 p-4">
									<div class="form-group">
										<label class="green mb-0" for="facebook">Facebook</label>
										<input type="text" class="form-control" id="facebook" name="facebook" value="{{$settings->facebook}}">	
									</div>
									<div class="form-group">
										<label class="green mb-0" for="twitter">Twitter</label>
										<input type="text" class="form-control" id="twitter" name="twitter" value="{{$settings->twitter}}">
									</div>
									<div class="form-group">
										<label class="green mb-0" for="instagram">Instagram</label>
										<input type="text" class="form-control" id="instagram" name="instagram" value="{{$settings->instagram}}">
									</div>
									<div class="form-group">
										<label class="green mb-0" for="linkedin">Linkedin</label>
										<input type="text" class="form-control" id="linkedin" name="linkedin" value="{{$settings->linkedin}}">										
									</div>
									<div class="form-group">
										<label class="green mb-0" for="linkedin">Whatsapp</label>
										<input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{$settings->whatsapp}}">										
									</div>
									<div class="form-group">
										<button class="custom-btn btn-green btn-green-whitebg" type="submit">Save Changes</button>
									</div>
								</div>
							</form>	
						</div>

						<!-- Footer Texts -->
						<div id="footer-text" class="mt-5 row no-gutters white-bg rounded shadow">
							<div class="section-header col-12 d-flex flex-row flex-wrap align-items-center px-4 pt-4 pb-3 no-gutters">
								<h4 class="brown m-0 mx-3">Footer Text</h4>
							</div>
							<form class="full-width" method="POST" action="/admin/settings/update-footer">
							@csrf
								<div class="col-12 p-4">
									<div class="form-group">
										<label class="green mb-0" for="heading">Heading</label>
										<input type="text" class="form-control" id="heading" name="foot_heading" value="{{$settings->foot_heading}}">	
									</div>
									<div class="form-group">
										<label class="green mb-0" for="content">Content</label>
										<textarea name="foot_content" id="content" class="mceEditor">
									    	{{$settings->foot_content}}
									    </textarea>
									</div>
									<div class="form-group">
										<label class="green mb-0" for="copyright">Copyright</label>
										<input type="text" class="form-control" id="copyright" name="foot_copyright" value="{{$settings->foot_copyright}}">
									</div>
									<div class="form-group">
										<label class="green mb-0" for="contact_number">Contact Number</label>
										<input type="text" class="form-control" id="contact_number" name="foot_contact_number" value="{{$settings->contact_number}}">
									</div>
									<div class="form-group">
										<label class="green mb-0" for="email">Email</label>
										<input type="text" class="form-control" id="email" name="foot_email" value="{{$settings->foot_email}}">
									</div>
									<div class="form-group">
										<label class="green mb-0" for="commerce">Chamber of Commerce</label>
										<input type="text" class="form-control" id="commerce" name="foot_commerce" value="{{$settings->foot_commerce}}">	
									</div>
									<div class="form-group">
										<button class="custom-btn btn-green btn-green-whitebg" type="submit">Save Changes</button>
									</div>
								</div>
							</form>	
						</div>

						<!-- Tooltip texts -->
						<div id="tooltip-text" class="mt-5 row no-gutters white-bg rounded shadow">
							<div class="section-header col-12 d-flex flex-row flex-wrap align-items-center px-4 pt-4 pb-3 no-gutters">
								<h4 class="brown m-0 mx-3">Tooltip Text</h4>
							</div>
							<form class="full-width" method="POST" action="/admin/settings/update-tooltip">
							@csrf
								<div class="col-12 p-4">

									<div class="form-group">
										<label class="green mb-0" for="content">Profile Address Tooltip <span class="pass-req">(For All Users)</span></label>
										<textarea name="dashboard_tooltip" id="dashboard_tooltip" class="mceEditor">
									    	{{$settings->dashboard_tooltip}}
									    </textarea>
									</div>	

									<div class="form-group">
										<label class="green mb-0" for="content">Job Description Tooltip <span class="pass-req">(For Nannies)</span></label>
										<textarea name="jd_tooltip" id="jd_tooltip" class="mceEditor">
									    	{{$settings->job_description_tooltip}}
									    </textarea>
									</div>	

									<div class="form-group">
										<label class="green mb-0" for="content">Looking For Tooltip <span class="pass-req">(For Parents)</span></label>
										<textarea name="lf_tooltip" id="lf_tooltip" class="mceEditor">
									    	{{$settings->looking_for_tooltip}}
									    </textarea>
									</div>	

									<div class="form-group">
										<label class="green mb-0" for="content">Mentor's Job Description Tooltip <span class="pass-req">(For Mentors)</span></label>
										<textarea name="mt_tooltip" id="mt_tooltip" class="mceEditor">
									    	{{$settings->mentor_tooltip}}
									    </textarea>
									</div>										

									<div class="form-group">
										<label class="green mb-0" for="content">Payment Tooltip <span class="pass-req">(For Nannies and Parents)</span></label>
										<textarea name="payment_tooltip" id="payment_tooltip" class="mceEditor">
									    	{{$settings->payment_tooltip}}
									    </textarea>
									</div>																							
									
									<div class="form-group">
										<button class="custom-btn btn-green btn-green-whitebg" type="submit">Save Changes</button>
									</div>
								</div>
							</form>	
						</div>

						<!-- Profile Photo texts -->
						<div id="profile-photo-example-text" class="mt-5 row no-gutters white-bg rounded shadow">
							<div class="section-header col-12 d-flex flex-row flex-wrap align-items-center px-4 pt-4 pb-3 no-gutters">
								<h4 class="brown m-0 mx-3">Profile Photo Example Content</h4>
							</div>
							<form class="full-width" method="POST" action="/admin/settings/update-photo-example" enctype="multipart/form-data">
							@csrf
								<div class="col-12 pt-2 px-4">
									<h5 class="brown mt-4">For Sitters</h5>
									<div class="form-group">
										<label class="green mb-0" for="npe-heading">Heading Text</label>
										<textarea name="nanny_photo_example_heading" id="npe-heading" class="mceEditor">
									    	{{$settings->nanny_photo_example_heading}}
									    </textarea>
									</div>	

									<div class="form-group">
										<label class="green mb-0" for="npe-top-text">Text Above Example Photo</label>
										<textarea name="nanny_photo_example_top_text" id="npe-top-text" class="mceEditor">
									    	{{$settings->nanny_photo_example_top_text}}
									    </textarea>
									</div>	

									<div class="form-group">
										<label class="green mb-0" for="npe-bottom-text">Text Below Example Photo</label>
										<textarea name="nanny_photo_example_bottom_text" id="npe-bottom-text" class="mceEditor">
									    	{{$settings->nanny_photo_example_bottom_text}}
									    </textarea>
									</div>
								</div>
								<div class="col-12 pt-2 px-4"">	
									<h5 class="brown mt-4">For Parents</h5>
									<div class="form-group">
										<label class="green mb-0" for="ppe-heading">Heading Text</label>
										<textarea name="parent_photo_example_heading" id="ppe-heading" class="mceEditor">
									    	{{$settings->parent_photo_example_heading}}
									    </textarea>
									</div>	

									<div class="form-group">
										<label class="green mb-0" for="ppe-top-text">Text Above Example Photo</label>
										<textarea name="parent_photo_example_top_text" id="ppe-top-text" class="mceEditor">
									    	{{$settings->parent_photo_example_top_text}}
									    </textarea>
									</div>	

									<div class="form-group">
										<label class="green mb-0" for="ppe-bottom-text">Text Below Example Photo</label>
										<textarea name="parent_photo_example_bottom_text" id="ppe-bottom-text" class="mceEditor">
									    	{{$settings->parent_photo_example_bottom_text}}
									    </textarea>
									</div>	
								</div>
								<div class="col-12 pt-2 px-4"">
									<h5 class="brown mt-4">For Mentors</h5>
									<div class="form-group">
										<label class="green mb-0" for="mpe-heading">Heading Text</label>
										<textarea name="mentor_photo_example_heading" id="mpe-heading" class="mceEditor">
									    	{{$settings->mentor_photo_example_heading}}
									    </textarea>
									</div>	

									<div class="form-group">
										<label class="green mb-0" for="mpe-top-text">Text Above Example Photo</label>
										<textarea name="mentor_photo_example_top_text" id="mpe-top-text" class="mceEditor">
									    	{{$settings->mentor_photo_example_top_text}}
									    </textarea>
									</div>	

									<div class="form-group">
										<label class="green mb-0" for="mpe-bottom-text">Text Below Example Photo</label>
										<textarea name="mentor_photo_example_bottom_text" id="mpe-bottom-text" class="mceEditor">
									    	{{$settings->mentor_photo_example_bottom_text}}
									    </textarea>
									</div>	
								</div>																			
								<div class="col-12 pt-2 px-4"">	
									<div class="form-group">
										<button class="custom-btn btn-green btn-green-whitebg" type="submit">Save Changes</button>
									</div>
								</div>
								
							</form>	
						</div>

						<!-- Photo Examples -->
						<div id="profile-photo-example-images" class="mt-5 row no-gutters white-bg rounded shadow">
							<div class="section-header col-12 d-flex flex-row flex-wrap align-items-center px-4 pt-4 pb-3 no-gutters">
								<h4 class="brown m-0 mx-3">Profile Photo Example Images</h4>								
							</div>
							<div class="col-12 p-4">								
								@if(count($photoSamples) > 0)
									<table class="photoSample-list text-center table table-bordered admin-table table-responsive">
										@foreach($photoSamples as $photoSample)
										<tr>											
											<td>
												<div class="example-photo-frame" style="background-image: url({{$photoSample->photo_example_pic}});">
												</div>
											</td>
											<td>
												@if($photoSample->type == 1)
													Nanny
												@elseif($photoSample->type == 2)
													Parent
												@else
													Mentor
												@endif												
											</td>
											<td>
											    <form method="POST" action="/admin/delete-photoSample">
											        @csrf
											        @method('DELETE')
											        <div class="form-group">
											        	<input type="hidden" name="photoSampleId" value="{{$photoSample->id}}">	
											            <button class="brown del-evt-dtls-btn"><i class="fas fa-trash"></i></button>
											        </div>
											    </form>
												
											</td>
										</tr>
								    	@endforeach	
									</table>					                    
						    	@else									
									<p class="px-3">No photo sample available.</p>																						
								@endif									
							</div>

							<div class="col-12 p-4">
								<div class="col-12 d-flex justify-content-start">
																		
									<form id="photoSamplesForm" method="POST" action="{{ url('/admin/settings/add-sample-photo') }}" enctype="multipart/form-data">
									@csrf
										<div class="sample-photos padT10">				
											<div class="padTB10">
												<div class="form-group">
													<div>
														<label class="green mb-0" for="sample-photoImage">Example Profile Photo Image<span class="required"> *</span></label>
													</div>
													<div class="form-group mt-3">
														<label for="photoType green mb-0">
															Select type of photo
														</label>
														<select id="photoType" name="photo-type" class="form-control">
											        		<option value="1">Nanny</option>
											        		<option value="2">Parent</option>
											        		<option value="3">Mentor</option>
											        	</select>
											        </div>
											        <div class="form-group">
														<label for="sample-photoImage" class="fileBtn">
															Choose File
														</label>
														<input id="sample-photoImage" name="sample-photo-image" class="file-upload hide" type="file" />
														<span class="fileName">No file chosen</span>
													</div>
													@if ($errors->has('sample-photo-image'))
		                                                <span class="help-block">
		                                                    {{ str_replace("sample-photo-image","sample-photo image",$errors->first('sample-photo-image')) }}
		                                                </span>
		                                            @endif
												</div>
												<button type="submit" class="custom-btn btn-green btn-green-whitebg btn-primary">Add sample photo</button>
											</div>
										</div>										
									</form>							
								</div>
										
							</div>					
						</div>

						<!-- site header and footer -->
						<div class="mt-5 row no-gutters white-bg rounded shadow">
							<div class="section-header col-12 d-flex flex-row flex-wrap align-items-center px-4 pt-4 pb-3 no-gutters">
								<h4 class="brown m-0 mx-3">Advanced</h4>
							</div>							
							<form class="full-width" method="POST" action="/admin/settings/savehtml">
							@csrf
								<div class="mt-2 col-12">
									<div class="d-flex flex-column m-3">
										<h5 class="ml-3 mb-1">Header HTML code</h5>
										<p class="ml-3 mb-1">Code inside the area below will be pasted at the near top of the page.</p>
										<!-- name is headhtml -->	
										<div id="head-editor" data-headhtml="{{ $settings->headhtml }}"></div>
																			
									</div>
								</div>
								<div class="mt-2 col-12">
									<div class="d-flex flex-column m-3">
										<h5 class="ml-3 mb-1">Footer HTML code</h5>
										<p class="ml-3 mb-1">Code inside the area below will be pasted at the near end of the page.</p>
										<!-- name is foothtml -->
										<div id="foot-editor" data-foothtml="{{ $settings->foothtml }}"></div>
									</div>
								</div>
								<div class="mt-2 col-12">
									<div class="m-4">
										<button class="custom-btn btn-green btn-green-whitebg" type="submit">Save Changes</button>
									</div>
								</div>
							</form>	
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection