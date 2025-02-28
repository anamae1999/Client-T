<header class="container-fluid">
  	<div class="container header-wrapper">
 			<div class="row align-items-center">
	    	<nav class="navbar navbar-expand-lg navbar-light col-xl-12">
					<a class="navbar-brand" href="/"><img src="{{ asset('images/TinyStepsLogo.svg') }}" alt="Tinysteps Logo"></a>
					<div class="button-wrapper">
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						    <span class="navbar-toggler-icon"></span>
						</button>
						<div class="for-mobile">
						@if(Auth::check()) 
                			<div class="admin-dd dropdown show ml-auto ">
								<a class="btn dropdown-toggle user-name" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									{{ Auth::user()->first_name }}
								</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<div class="dropdown-item">
										<a href="/">
											<div class="row align-items-center no-gutters">
												<div class="admin-dd-icon text-center">
													<img src="{{ asset('images/home.png') }}">
												</div>
												<div>
													Home
												</div>
											</div>
										</a>
									</div>
									@if(Auth::user()->role == 'sitter' || Auth::user()->role == 'parent' || Auth::user()->role == 'mentor')
									<div class="dropdown-item">
										@if(Auth::user()->role == 'sitter')
											<a href="/search/parents">
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/search.png') }}">
													</div>
													<div>
														Search Parents
													</div>
												</div>
											</a>
											<a href="/search/mentors">	
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/search.png') }}">
													</div>
													<div>
														Search Mentors
													</div>
												</div>
											</a>
										@elseif(Auth::user()->role == 'parent')
											<a href="/search/nannies">	
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/search.png') }}">
													</div>
													<div>
														Search Nannies
													</div>
												</div>
											</a>	
											<a href="/search/mentors">	
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/search.png') }}">
													</div>
													<div>
														Search Mentors
													</div>
												</div>
											</a>
										@elseif(Auth::user()->role == 'mentor')			
											<a href="/search/nannies">	
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/search.png') }}">
													</div>
													<div>
														Search Nannies
													</div>
												</div>
											</a>	
											<a href="/search/parents">	
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/search.png') }}">
													</div>
													<div>
														Search Parents
													</div>
												</div>
											</a>					
										@endif							
									</div>
									@endif
									@if(Auth::user()->role == 'admin')									
										<div class="dropdown-item">
											<a href="/admin/dashboard">
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/dashboard.png') }}">
													</div>
													<div>
														Dashboard
													</div>
												</div>
											</a>
										</div>
									@else
										<div class="dropdown-item">
											@if(Auth::user()->role == "sitter")
												<a href='{{ url("/nannies/dashboard") }}'>
											@elseif(Auth::user()->role == "parent")
												<a href='{{ url("/parents/dashboard") }}'>
											@elseif(Auth::user()->role == "mentor")
												<a href='{{ url("/mentors/dashboard") }}'>
											@endif			
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/dashboard.png') }}">
													</div>
													<div>
														Profile
													</div>
												</div>
											</a>
										</div>
										<div class="dropdown-item">
											@if(Auth::user()->role == "sitter")
												<a href='{{ url("/nannies/messages") }}'>
											@elseif(Auth::user()->role == "parent")
												<a href='{{ url("/parents/messages") }}'>
											@elseif(Auth::user()->role == "mentor")
												<a href='{{ url("/mentors/messages") }}'>
											@endif	
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/messages.png') }}">
													</div>
													<div>
														Messages
													</div>
												</div>
											</a>
										</div>

									@endif

									<div class="dropdown-item">
										@if(Auth::user()->role == 'parent')	
										<a href="/parents/settings">
										@elseif(Auth::user()->role == 'sitter')	
										<a href="/nannies/settings">
										@elseif(Auth::user()->role == 'mentor')	
										<a href="/mentors/settings">
										@else
										<a href="/admin/settings">
										@endif		
											<div class="row align-items-center no-gutters">
												<div class="admin-dd-icon text-center">
													<img src="{{ asset('images/gear.png') }}">
												</div>
												<div>
													@if(Auth::user()->role == 'admin')
														System Settings
													@else
														Account Settings													
													@endif
												</div>
											</div>
										</a>
									</div>
									<div class="dropdown-item">
										<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-first').submit();">
											<div class="row align-items-center no-gutters">
												<div class="admin-dd-icon text-center">
													<img src="{{ asset('images/logout.png') }}">
												</div>
												<div>												
													Logout                             																	
												</div>
											</div>
										</a>
										<form id="logout-form-first" action="{{ route('logout') }}" method="POST" style="display: none;">
			                                @csrf
			                            </form>	
									</div>
								</div>
								<a class="btn dropdown-toggle img-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									@if(Auth::user()->role == 'parent')	
									<div class="admin-img" style='background-image:url("{{ !empty(Auth::user()->guardianProfile->profile_pic) ? Auth::user()->guardianProfile->profile_pic : asset("/images/avatar-placeholder.png") }}")'>								
									</div>
									@elseif(Auth::user()->role == 'sitter')	
									<div class="admin-img" style='background-image:url("{{ !empty(Auth::user()->sitterProfile->profile_pic) ? Auth::user()->sitterProfile->profile_pic : asset("/images/avatar-placeholder.png") }}")'>								
									</div>
									@elseif(Auth::user()->role == 'mentor')	
									<div class="admin-img" style='background-image:url("{{ !empty(Auth::user()->mentorProfile->profile_pic) ? Auth::user()->mentorProfile->profile_pic : asset("/images/avatar-placeholder.png") }}")'>								
									</div>
									@elseif(Auth::user()->role == 'admin')	
									<div class="admin-img" style='background-image:url("{{ !empty(Auth::user()->admin->admin_pic) ? Auth::user()->admin->admin_pic : asset("/images/avatar-placeholder.png") }}")'>								
									</div>
									@endif
								</a>
								<div class="inlineBlock position-relative">
									<div class="refresh">
										<div class="reload">
											@if(Auth::user()->has_message == 1)	
												@if(Auth::user()->role == 'parent')
													<a class="message-notif" href='{{ url("/parents/messages") }}'>
												@elseif(Auth::user()->role == 'sitter')	
													<a class="message-notif" href='{{ url("/nannies/messages") }}'>	
												@elseif(Auth::user()->role == 'mentor')	
													<a class="message-notif" href='{{ url("/mentors/messages") }}'>	
												@endif
													<div class="message-notif-icon-wrap">
														<i class="message-notif-icon far fa-envelope white" data-toggle="tooltip" data-placement="top" title="You have unread message(s)"></i>
													</div>										
												</a>
											@endif
										</div>										
									</div>																		
								</div>										
							</div>
                        
                        @endif
					</div>
						
					</div>
				  	

				  <div class="collapse navbar-collapse text-right" id="navbarSupportedContent">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item"><a href="/">Home</a></li>
							<li class="nav-item"><a href="/how-it-works">How it Works</a></li>
							<li class="nav-item"><a href="/faq">FAQ</a></li>
							<li class="nav-item"><a href="/blog">Blog</a></li>
							<li class="nav-item"><a href="/about-us">About Us</a></li>
							<li class="nav-item"><a href="/contact">Contact</a></li>
						</ul>

                		@if(Auth::check()) 
                			<div class="admin-dd dropdown show ml-auto for-desktop">
								<a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									{{ Auth::user()->first_name }}
								</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<div class="dropdown-item">
										<a href="/">
											<div class="row align-items-center no-gutters">
												<div class="admin-dd-icon text-center">
													<img src="{{ asset('images/home.png') }}">
												</div>
												<div>
													Home
												</div>
											</div>
										</a>
									</div>
									@if(Auth::user()->role == 'sitter' || Auth::user()->role == 'parent' || Auth::user()->role == 'mentor')
									<div class="dropdown-item">
										@if(Auth::user()->role == 'sitter')
											<a href="/search/parents">
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/search.png') }}">
													</div>
													<div>
														Search Parents
													</div>
												</div>
											</a>
											<a href="/search/mentors">	
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/search.png') }}">
													</div>
													<div>
														Search Mentors
													</div>
												</div>
											</a>
										@elseif(Auth::user()->role == 'parent')
											<a href="/search/nannies">	
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/search.png') }}">
													</div>
													<div>
														Search Nannies
													</div>
												</div>
											</a>	
											<a href="/search/mentors">	
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/search.png') }}">
													</div>
													<div>
														Search Mentors
													</div>
												</div>
											</a>
										@elseif(Auth::user()->role == 'mentor')			
											<a href="/search/nannies">	
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/search.png') }}">
													</div>
													<div>
														Search Nannies
													</div>
												</div>
											</a>	
											<a href="/search/parents">	
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/search.png') }}">
													</div>
													<div>
														Search Parents
													</div>
												</div>
											</a>					
										@endif							
									</div>
									@endif
									@if(Auth::user()->role == 'admin')									
										<div class="dropdown-item">
											<a href="/admin/dashboard">
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/dashboard.png') }}">
													</div>
													<div>
														Dashboard
													</div>
												</div>
											</a>
										</div>
									@else
										<div class="dropdown-item">
											@if(Auth::user()->role == "sitter")
												<a href='{{ url("/nannies/dashboard") }}'>
											@elseif(Auth::user()->role == "parent")
												<a href='{{ url("/parents/dashboard") }}'>
											@elseif(Auth::user()->role == "mentor")
												<a href='{{ url("/mentors/dashboard") }}'>
											@endif		
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/dashboard.png') }}">
													</div>
													<div>
														Profile
													</div>
												</div>
											</a>
										</div>
										<div class="dropdown-item">
											@if(Auth::user()->role == "sitter")
												<a href='{{ url("/nannies/messages") }}'>
											@elseif(Auth::user()->role == "parent")
												<a href='{{ url("/parents/messages") }}'>
											@elseif(Auth::user()->role == "mentor")
												<a href='{{ url("/mentors/messages") }}'>
											@endif	
												<div class="row align-items-center no-gutters">
													<div class="admin-dd-icon text-center">
														<img src="{{ asset('images/messages.png') }}">
													</div>
													<div>
														Messages
													</div>
												</div>
											</a>
										</div>

									@endif

									<div class="dropdown-item">
										@if(Auth::user()->role == 'parent')	
										<a href="/parents/settings">
										@elseif(Auth::user()->role == 'sitter')	
										<a href="/nannies/settings">
										@elseif(Auth::user()->role == 'mentor')	
										<a href="/mentors/settings">
										@else
										<a href="/admin/settings">
										@endif		
											<div class="row align-items-center no-gutters">
												<div class="admin-dd-icon text-center">
													<img src="{{ asset('images/gear.png') }}">
												</div>
												<div>
													@if(Auth::user()->role == 'admin')
														System Settings
													@else
														Account Settings													
													@endif
												</div>
											</div>
										</a>
									</div>
									<div class="dropdown-item">
										<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
											<div class="row align-items-center no-gutters">
												<div class="admin-dd-icon text-center">
													<img src="{{ asset('images/logout.png') }}">
												</div>
												<div>												
													Logout                             																	
												</div>
											</div>
										</a>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			                                @csrf
			                            </form>	
									</div>
								</div>
								<a class="btn dropdown-toggle img-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									@if(Auth::user()->role == 'parent')	
									<div class="admin-img" style='background-image:url("{{ !empty(Auth::user()->guardianProfile->profile_pic) ? Auth::user()->guardianProfile->profile_pic : asset("/images/avatar-placeholder.png") }}")'>								
									</div>
									@elseif(Auth::user()->role == 'sitter')	
									<div class="admin-img" style='background-image:url("{{ !empty(Auth::user()->sitterProfile->profile_pic) ? Auth::user()->sitterProfile->profile_pic : asset("/images/avatar-placeholder.png") }}")'>								
									</div>
									@elseif(Auth::user()->role == 'mentor')	
									<div class="admin-img" style='background-image:url("{{ !empty(Auth::user()->mentorProfile->profile_pic) ? Auth::user()->mentorProfile->profile_pic : asset("/images/avatar-placeholder.png") }}")'>								
									</div>
									@elseif(Auth::user()->role == 'admin')	
									<div class="admin-img" style='background-image:url("{{ !empty(Auth::user()->admin->admin_pic) ? Auth::user()->admin->admin_pic : asset("/images/avatar-placeholder.png") }}")'>								
									</div>
									@endif
								</a>
								<div class="inlineBlock position-relative">
									<div class="refresh">
										<div class="reload">
											@if(Auth::user()->has_message == 1)	
												@if(Auth::user()->role == 'parent')
														<a class="message-notif" href='{{ url("/parents/messages") }}'>
													@elseif(Auth::user()->role == 'sitter')	
														<a class="message-notif" href='{{ url("/nannies/messages") }}'>	
													@elseif(Auth::user()->role == 'mentor')	
														<a class="message-notif" href='{{ url("/mentors/messages") }}'>	
													@endif		
													<div class="message-notif-icon-wrap">
														<i class="message-notif-icon far fa-envelope white" data-toggle="tooltip" data-placement="top" title="You have unread message(s)"></i>
													</div>										
												</a>
											@endif
										</div>										
									</div>																		
								</div>										
							</div>
                        @else
	                        <div class="header-button clearfix">
								<!-- Button trigger modal -->
								
								<div class="btn-container">
									<a class="custom-btn btn-brown" href="" data-toggle="modal" data-target="#log-in-modal" id="log-in">Log in</a>
								</div>
								<div class="btn-container">
									<a class="custom-btn btn-brown" href="" data-toggle="modal" data-target="#sign-up-modal" id="sign-up">Sign up</a>
								</div>
							</div>
                        @endif
					</div> 
				</nav>
				
			</div>
		</div>
	</div>
</header>
<div class="login-signup-modal-container">
	<!-- Log in Modal -->
	<div class="modal fade auth-modal {{ !empty(Session::get('url')['intended']) && strpos(Session::get('url')['intended'],'verify') ? 'show' : '' }}" id="log-in-modal" tabindex="-1" role="dialog" aria-labelledby="log-in-modalTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content login-signup-modal">
				<div class="modal-header">
					<div class="container">
						<div class="row align-items-center">
							<div class="modal-header-left">
								<img src="{{ asset('images/TinyStepsLogo.svg') }}">
							</div>
							<div class="modal-header-right">
								<h4 class="modal-title" id="">
									@if(!empty(Session::get('url')['intended']) && strpos(Session::get('url')['intended'],'verify'))
										Verification
									@else
										Not a member yet?
									@endif
								</h4>
								<p class="m-0">
									@if(!empty(Session::get('url')['intended']) && strpos(Session::get('url')['intended'],'verify'))
										Login to verify your account
									@else
										Sign up with Tiny Steps for free
									@endif
								</p>
							</div>
						</div>
					</div>
					@if(empty(Session::get('url')['intended']))
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					@endif
				</div>
				<div class="modal-body text-center">
					<form method="POST" action="{{ route('login') }}">
						@csrf
						<input type="hidden" name="loginform" value="1">
						<div class="form-group email-wrap">							
							<input type="email" class="form-control @if($errors->has('email') && old('loginform')) is-invalid @endif" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email*" required="required">
							@if($errors->has('email') && old('loginform'))
								<span class="clear-field"></span>
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
						</div>
						<div class="form-group">
							<input id="password-box" type="password" class="form-control @if($errors->has('password') && old('loginform')) is-invalid @endif" name="password" required autocomplete="current-password" placeholder="Password*" required="required">

                            @if($errors->has('password') && old('loginform'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
						</div> 
						<div class="form-group clearfix"> 
							<div class="checkbox">
								<div class="custom-control custom-checkbox float-left">									
									<input class="form-check-input custom-control-input" type="checkbox" name="remember" id="customCheck" name="rememberme" {{ old('remember') ? 'checked' : '' }}>
									<label class="custom-control-label" for="customCheck">Remember Me</label>
								</div>
								<a class="float-right show-password" href="#">Show password</a>
							</div>
						</div>  
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-block"> Login </button>

							@if(empty(Session::get('url')['intended']))						
								@if (Route::has('password.request'))
	                                <a href="{{ route('password.request') }}">
	                                    Forgot password?
	                                </a>
	                            @endif
	                        @endif
						</div>

						@if(empty(Session::get('url')['intended']))
						<div class="form-group">
							<p>Don’t have an account?</p>
							<a href="" class="signUp" id="sign-up-footer">Sign up for FREE</a>
						</div>                                                           
						@endif
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- END -->
	<!-- Sign up Modal -->
	<div class="modal fade auth-modal" id="sign-up-modal" tabindex="-1" role="dialog" aria-labelledby="sign-up-modalTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content login-signup-modal signup-modal">
				<div class="modal-header">
					<div class="container">
						<div class="row align-items-center">
							<div class="modal-header-left">
								<img src="{{ asset('images/TinyStepsLogo.svg') }}">
							</div>
							<div class="modal-header-right">
								<h4 class="modal-title" id="">Sign up for free</h4>
								<p class="m-0">Registration does not imply any commitments</p>
							</div>
						</div>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<form method="POST" action="{{ route('register') }}">
						@csrf
						<input type="hidden" name="registerForm" value="1">
						<div class="sign-up-radio">
							<span>I’m signing up as:</span>	        		
							<div class="custom-control custom-radio-green custom-control-inline">
								<input type="radio" id="customRadioNanny" name="role" class="custom-control-input" value="sitter" required="required" {{ old('role') == 'sitter' ? 'checked' : ''}}>
								<label class="custom-control-label" for="customRadioNanny">Nanny</label>
							</div>
							<div class="custom-control custom-radio-green custom-control-inline">
								<input type="radio" id="customRadioParent" name="role" class="custom-control-input" value="parent" required="required"{{ old('role') == 'parent' ? 'checked' : ''}}>
								<label class="custom-control-label" for="customRadioParent">Parent</label>
							</div>
						</div>							
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
						<div class="form-group email-wrap">					    
							<input type="email" class="form-control @if($errors->has('email') && !old('loginform')) is-invalid @endif" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

							@if($errors->has('email') && old('registerForm'))
							<span class="clear-field"></span>
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
							@endif
						</div>	
						<div class="form-group sign-up-bdate hide">
							<div class="birth-date-wrap text-left">									
								<p>Birthdate <span class="bdate-req">(Required age is 18 & above.)</span></p>
								<div class="birth-date-wrap-inner">
									<select class="custom-select" name="dob-day">
										<option disabled="disabled" value="" selected="selected">DD</option>
										@for($day=1;$day<=31;$day++)																		
										    <option value='{{ sprintf("%02d",$day) }}' 								    
												{{ old('dob-day') == $day ? 'selected="selected"' : '' }}	
										    >{{ sprintf("%02d",$day) }}</option>								
										@endfor
									</select>
									<select class="custom-select" name="dob-month">
										<option disabled="disabled" value="" selected="selected">MM</option>
										@for($month=1;$month<=12;$month++)					
										    <option value='{{ sprintf("%02d",$month) }}' 								    
												{{ old('dob-month') == $month ? 'selected="selected"' : '' }}								    
										    >{{ sprintf("%02d",$month) }}</option>								
										@endfor
									</select>									
									<select class="custom-select" name="dob-year">
										<option disabled="disabled" value="" selected="selected">YYYY</option>
										@for($year=date("Y");$year>=1901;$year--)																		
										    <option value='{{ $year }}' 								    
												{{ old('dob-year') == $year ? 'selected="selected"' : '' }}								   
										    >{{ $year }}</option>								
										@endfor
									</select>
								</div>	
								@if ($errors->has('dob-month') || $errors->has('dob-day') || $errors->has('dob-year'))
									
									<div class="text-center">
										<span class="help-block error" role="alert">
	                                        The date of birth field is required.
	                                    </span>
									</div>							                                    
	                            @endif
								@if($errors->has('age'))
								<div class="text-center">
									<span class="help-block error" role="alert">									
										<strong>{{ $errors->first('age') }}</strong>                                					
									</span>	
								</div>														
								@endif							
							</div>							
							
						</div>						
						<div class="form-group">	
							<p class="pass-req">Password must contain at least 8 characters.</p>														
							<input id="password" type="password" class="password-box-reg form-control @if($errors->has('password') && !old('loginform')) is-invalid @endif" name="password" required autocomplete="new-password" placeholder="Password">
							@if($errors->has('password') && old('registerForm'))
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
							@if(old('registerForm'))
								@error('g-recaptcha-response')
								<span class="help-block error" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							@endif
							@if(config('services.google.captcha_key'))
							    <div class="g-recaptcha"
							        data-sitekey="{{config('services.google.captcha_key')}}">	
							    </div>
							@endif

							<button type="submit" class="btn btn-primary btn-block"> Register </button>
							<div class="terms-agreement-wrap position-relative">
								<label class="text-left" for="terms-agreement">By registering you are agreeing with the <a href="/terms-of-service" target="_blank">Terms of Service</a> and the <a href="/privacy-policy" target="_blank">Privacy Policy</a>.</label>	
								<input id="terms-agreement" type="checkbox" name="terms_agreement" class="green-box green-box-edit inlineBlock" required="required">		
							</div>
						</div>                                                         
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- END -->


	<!-- Message Modal -->
	@if(Session::has('unauthorized'))
	<div id="unauthorizedModal" class="modal fade" id="msg-modal" role="dialog" aria-labelledby="msg-modalTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content login-signup-modal msg-modal">
				<div class="modal-header">
					<div class="container">
						<div class="row align-items-center text-center">
							<div class="col-12">
								<img class="message-modal-img" src="{{ asset('images/TinyStepsLogo.svg') }}">
							</div>							
						</div>
					</div>
					<button type="button" class="close close-msg-modal" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<div class="col-12">
						<p class="modal-title">{{ Session::get('unauthorized') }}</p>	
						<a class="custom-btn btn-green btn-green-whitebg mt-4" href="/contact">Contact Us</a>						
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
	<!-- END -->
</div>