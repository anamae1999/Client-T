<footer>
	<div class="container wrapper padTB50">
		<div class="row align-items-center">
			<div class="col-xl-6 col-md-5 footer-left">
				<img src="{{ asset('images/TinyStepsLogo.svg') }}">
				<div class="pt-3">
					<strong>{{$settings->foot_heading}}</strong>
					{!! $settings->foot_content !!}
				</div>
				<div class="footer-contacts mt-4">
					<ul>
						@if($settings->contact_number)
							<li><i class="fas fa-phone"></i><i class="fab fa-whatsapp"></i>{{ $settings->contact_number }}</li>
						@endif
						@if($settings->foot_email)
							<li><a href="mailto:{{$settings->foot_email}}"><i class="fas fa-envelope"></i>{{$settings->foot_email}}</a></li>
						@endif
						@if($settings->foot_commerce)
						<li><i class="far fa-credit-card"></i>{{$settings->foot_commerce}}</li>
						@endif
					</ul>
				</div>
			</div>
			<div class="col-xl-6 col-md-7">
				<div class="row">
					<div class="col-sm-3">
						<h5>About</h5>
						<ul>
							<li><a href="/">Home</a></li>	
							@if(Auth::guest())						
							<li><a data-toggle="modal" data-target="#sign-up-modal" href>Registration</a></li>
							@endif
							<li><a href="/about-us">About Us</a></li>
							<li><a href="/contact">Contact</a></li>
						</ul>
					</div>
					@if((Auth::check() && Auth::user()->role == 'sitter') || (Auth::guest() && !empty($role)  && $role == 'parents'))
					<div class="col-sm-6">
					@else
					<div class="col-sm-5">
					@endif
						<h5>Search</h5>
						<ul>
						@if((Auth::check() && Auth::user()->role == 'sitter') || (Auth::guest() && !empty($role)  && $role == 'parents'))
							<li><a href='{{ url("/search/parents/job?job-desc=Permanent+Nanny") }}'>Looking for a Permanent Nanny</a></li>
							<li><a href='{{ url("/search/parents/job?job-desc=Occasional+Sitter") }}'>Looking for an Occasional Sitter</a></li>
							<li><a href='{{ url("/search/parents/job?job-desc=Afterschool+Sitter") }}'>Looking for an Afterschool Sitter</a></li>
							<li><a href='{{ url("/search/parents/job?job-desc=Night+Sitter") }}'>Looking for a Night Sitter</a></li>
						@else													
							<li><a href='{{ url("/search/nannies/permanent-nanny") }}'>Find a Permanent Nanny</a></li>
							<li><a href='{{ url("/search/nannies/occasional-sitter") }}'>Find an Occasional Sitter</a></li>
							<li><a href='{{ url("/search/nannies/afterschool-sitter") }}'>Find an Afterschool Sitter</a></li>
							<li><a href='{{ url("/search/nannies/night-sitter") }}'>Find a Night Sitter</a></li>						
						@endif
						</ul>
					</div>
					@if((Auth::check() && Auth::user()->role == 'sitter') || (Auth::guest() && !empty($role)  && $role == 'parents'))
					<div class="col-sm-3">
					@else
					<div class="col-sm-4">
					@endif
						<h5>Read More</h5>
						<ul>
							<li><a href="/how-it-works">How it Works</a></li>
							<li><a href="/faq">FAQ</a></li>
							<li><a href="/blog">Blog</a></li>
						</ul>
					</div>
				</div>
				<p>{{$settings->foot_copyright}}</p>
			</div>
		</div>
	</div>
</footer>
<a href="#" id="scroll" style="display: none;"><span></span></a>