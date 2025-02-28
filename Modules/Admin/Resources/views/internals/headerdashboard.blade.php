<header class="container-fluid">
  	<div class="container header-wrapper">
 			<div class="row align-items-center">
	    	<nav class="navbar navbar-expand-lg navbar-light col-xl-12">
				<a class="navbar-brand mr-auto" href="/"><img src="{{ asset('images/TinyStepsLogo.svg') }}"></a>
                		@if(Auth::check()) 
                			<div class="admin-dd dropdown show ml-auto">
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
							
                        @endif
			</nav>
			</div>
		</div>
	</div>
</header>
<div class="login-signup-modal-container">
	<!-- Log in Modal -->
	<div class="modal fade" id="log-in-modal" tabindex="-1" role="dialog" aria-labelledby="log-in-modalTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content login-signup-modal">
				<div class="modal-header">
					<div class="container">
						<div class="row align-items-center">
							<div class="modal-header-left">
								<img src="{{ asset('images/TinyStepsLogo.svg') }}">
							</div>
							<div class="modal-header-right">
								<h4 class="modal-title" id="">Not a member yet?</h4>
								<p class="m-0">Sign up with Happy Steps for free</p>
							</div>
						</div>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<form method="POST" action="{{ route('login') }}">
						@csrf
						
						<div class="form-group">							
							<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
							@error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
						</div>
						<div class="form-group">
							<input id="password-box" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
							@if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    Forgot password?
                                </a>
                            @endif
						</div>
						<div class="form-group">
							<p>Don’t have an account?</p>
							<a href="" class="signUp" id="sign-up-footer">Sign up for FREE</a>
						</div>                                                           
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- END -->
	<!-- Sign up Modal -->
	<div class="modal fade" id="sign-up-modal" tabindex="-1" role="dialog" aria-labelledby="sign-up-modalTitle" aria-hidden="true">
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
						<div class="sign-up-radio">
							<span>I’m signing up as:</span>	        		
							<div class="custom-control custom-radio-green custom-control-inline">
								<input type="radio" id="customRadioNanny" name="role" class="custom-control-input" value="sitter">
								<label class="custom-control-label" for="customRadioNanny">Nanny</label>
							</div>
							<div class="custom-control custom-radio-green custom-control-inline">
								<input type="radio" id="customRadioParent" name="role" class="custom-control-input" value="parent">
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
						<div class="form-group">					    
							<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

							@error('email')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
						<div class="form-group">			      

							<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

							@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div> 
						<div class="form-group">
							<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
						</div> 
						<div class="form-group clearfix">
						</div>  
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-block"> Register </button>
							<p>By registering you are agreeing with the <a href="">Terms of Service</a> and the <a href="">Privacy Policy</a>.</p>
						</div>                                                         
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- END -->
</div>