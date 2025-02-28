@extends('layouts.layout')

@section('title', $page->meta_titles)
@section('description', $page->meta_descriptions)
@section('keywords', $page->meta_keywords)

@if(!empty($settings->headhtml))
	@section('headhtml')
		@php
			$dom = new DOMDocument;
			$dom->loadHTML($settings->headhtml);
			$html = $dom->saveHTML();

			echo $html;
		@endphp
	@endsection
@endif

@section('content')

@if($settings->cookie == 1)
	@include('cookieConsent::index')
@endif
	
	<section class="padTB50">
		@if($showSection['contact-us-main'] == 'show')
			<div class="container wrapper">
				<div class="row text-center">
					<div class="col-xl-12 section-title-content">
						<h2 class="section-title">{{ $passedContents['contact-us-main-title'] }}</h2>
						{!! $passedContents['contact-us-main-content'] !!}
					</div>
				</div>
			</div>
		@endif

		@if($showSection['form-and-image'] == 'show')
			<div class="container wrapper">
				<div class="row align-items-start">
					<div class="col-xl-6 col-md-6">
						<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="full" data-src="{{ $passedContents['form-and-image-image'] }}" alt='{{ str_replace("-", " ", ucfirst(pathinfo($passedContents["form-and-image-image"], PATHINFO_FILENAME))) }}'>
						<div class="footer-contacts py-3">
							<ul>
								
							<li><i class="fas fa-phone"></i><i class="fab fa-whatsapp"></i>{{ $passedContents['form-and-image-contact-num'] }}</li>
						
								<li><a href="mailto:{{ $passedContents['form-and-image-email'] }}"><i class="fas fa-envelope"></i>{{ $passedContents['form-and-image-email'] }}</a></li>
								<li><a href="#"><i class="far fa-credit-card"></i>{{ $passedContents['form-and-image-coc-num'] }}</a></li>
							</ul>
						</div>
						@if($settings->facebook || $settings->twitter || $settings->instagram || $settings->linkedin)
						<div class="follow-us">
							<h3>{{ $passedContents['form-and-image-social-title'] }}</h3>
							<ul>
								@if($settings->facebook)
									<li><a href="{{ url($settings->facebook) }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
								@endif
								@if($settings->twitter)
									<li><a href="{{ url($settings->twitter) }}" target="_blank"><i class="fab fa-twitter"></i></i></a></li>
								@endif
								@if($settings->instagram)
									<li><a href="{{ url($settings->instagram) }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
								@endif
								@if($settings->linkedin)
									<li><a href="{{ url($settings->linkedin) }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
								@endif
							</ul>
						</div>
						@endif
					</div>
					<div class="col-xl-6 col-md-6">
						<form action='{{ url("/form-send") }}' method="post" class="get-in-touch text-center">
							@csrf
							<h2>{{ $passedContents['form-and-image-form-title'] }}</h2>
							{!! $passedContents['form-and-image-form-intro'] !!}
							<div class="form-group">
						    <input type="text" class="form-control" id="FirstName" placeholder="First Name" name="fname" required="required" value="{{ old('fname') }}">
						    <input type="text" class="form-control" id="LastName" placeholder="Last Name" name="lname" required="required" value="{{ old('lname') }}">
							</div>
							<div class="form-group">
						    <input type="email" class="form-control" id="EmailAdd" placeholder="Email Address" name="email" required="required" value="{{ old('email') }}">
							</div>
							<div class="form-group">
						    <input type="text" class="form-control" id="Subject" placeholder="Subject (e.g. feedback, inquiry, etc.)" name="subject" required="required" value="{{ old('subject') }}">
							</div>
							<div class="form-group">
							  <textarea class="form-control" rows="5" id="comment" placeholder="Your question or feedback" name="message" required="required">{{ old('message') }}</textarea>
							</div>
							<div class="form-group">
								@if(!old('registerForm')) 
									@error('g-recaptcha-response')
		                        	<span class="help-block error" role="alert">
										<strong>{{ $message }}</strong>
									</span> 
									@enderror 
								@endif
								@if(config('services.google.captcha_key'))
		                        	<div class="g-recaptcha" data-sitekey="{{config('services.google.captcha_key')}}"></div>
		                        @endif
							</div>
							<div class="form-group btn-group full pt-3">								
							  	<button type="submit" class="custom-btn btn-green">Send message</button>
							</div>
						  	@if(Session::has('response'))
				                <div class="form-success white">
				                    {{ Session::get('response') }}
				                </div>
				            @endif					            	
						</form>
					</div>
				</div>
			</div>
		@endif
	</section>
	

	@if($showSection['contact-us-cta'] == 'show' && Auth::guest())
		<section class="brown-bg register-now-section">
			<div class="container wrapper padTB50">
				<div class="row align-items-center text-center">
					<div class="col-xl-8 col-md-7">
						{!! $passedContents['contact-us-cta-title'] !!}
					</div>
					<div class="col-xl-4 col-md-5 register-now-button">
						<a class="custom-btn btn-green" href="#" data-toggle="modal" data-target="#sign-up-modal">{{ $passedContents['contact-us-cta-btn-text'] }}</a>
					</div>
				</div>
			</div>
		</section>
	@endif
@endsection

@if(!empty($settings->foothtml))
	@section('foothtml')
		@php
			$dom = new DOMDocument;
			$dom->loadHTML($settings->foothtml);
			$html = $dom->saveHTML();

			echo $html;
		@endphp
	@endsection
@endif