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
<section class="gray-bg">
	@if($showSection['about-us'] == 'show')
	<div class="container wrapper padT50">
		<div class="row">
			<div class="col-xl-12 section-title-content">
				<h2 class="section-title">{{ $passedContents['about-us-title'] }}</h2>
				{!! $passedContents['about-us-content'] !!}
			</div>
		</div>
	</div>
	@endif

	<div class="container">

		@if($showSection['mission'] == 'show')
		<div class="row section-title-img-text padB50">
			<div class="col-xl-12 section-title-content">
				<h2 class="section-title">{{ $passedContents['mission-title'] }}</h2>
			</div>
			<div class="col-xl-6 col-sm-6">
				<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['mission-image'] }}" alt='{{ str_replace("-", " ", ucfirst(pathinfo($passedContents["mission-image"], PATHINFO_FILENAME))) }}'>
			</div>
			<div class="col-xl-6 col-sm-6">
				{!! $passedContents['mission-content'] !!}
			</div>
		</div>
		@endif

		@if($showSection['vision'] == 'show')
		<div class="row section-title-img-text padB50">
			<div class="col-xl-12 section-title-content">
				<h2 class="section-title">{{ $passedContents['vision-title'] }}</h2>
			</div>
			<div class="col-xl-6 col-sm-6">
				<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['vision-image'] }}" alt='{{ str_replace("-", " ", ucfirst(pathinfo($passedContents["vision-image"], PATHINFO_FILENAME))) }}'>
			</div>
			<div class="col-xl-6 col-sm-6">
				{!! $passedContents['vision-content'] !!}
			</div>
		</div>
		@endif

	</div>
	
</section>


@if($showSection['awards'] == 'show')
<section class="padTB50">
	<div class="container">
		<div class="row text-center">
			<div class="col-xl-12 section-title-content">
				<h2 class="section-title">{{ $passedContents['awards-title'] }}</h2>
			</div>
		</div>
	</div>
	<div class="container header-wrapper">
		<div class="row awards-slider">
			@if(count($awards) > 0)
				@foreach($awards as $award)
					<div class="award-item">
						<div class="slider-container text-center">
							<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $award->award_image }}" alt="{{ $award->award_title }}">
							<p>{{ $award->award_title }}</p>
						</div>
					</div> 		
				@endforeach
			@else
				<div class="award-item text-center">
					<p>No Awards / Certification.</p>
				</div>
			@endif	
		</div>
	</div>
</section>
@endif

@if($showSection['about-us-text-row'] == 'show')
<section class="padT50">
	<div class="container wrapper padT50">
		<div class="row">
			<div class="col-xl-12 section-title-content">
				<h2 class="section-title">{{ $passedContents['about-us-text-row-heading'] }}</h2>
				{!! $passedContents['about-us-text-row-content'] !!}
			</div>
		</div>
	</div>
</section>
@endif

@if($showSection['owners'] == 'show')
<section class="pb-4">
	<div class="container wrapper padTB50">
		<div class="row justify-content-center">

			@if(count($members) > 0)
				@foreach($members as $member)
				<div class="col-sm-6 col-md-4 text-center pb-5">
					<div class="name-border-bot-container owner-container">
						<div class="owner-desc">{{ $member->member_introduction }}</div>
						<div class="member-photo-frame" style='background-image:url("{{ $member->member_pic ? $member->member_pic : asset("/images/avatar-placeholder.png") }}")'>	
						</div>	
						<h3 class="name-border-bot green">{{ $member->member_name }}</h3>
						<div class="vertical-line green-line"></div>
						<p>{{ $member->member_position }}</p>
					</div>
				</div>
				@endforeach
			@endif

		</div>
	</div>
</section>
@endif

@if($showSection['about-us-cta'] == 'show' && Auth::guest())
<section class="brown-bg register-now-section">
	<div class="container wrapper padTB50">
		<div class="row align-items-center text-center">
			<div class="col-md-7">
				{!! $passedContents['about-us-cta-title'] !!}
			</div>
			<div class="col-md-5 register-now-button">
				<a class="custom-btn btn-green" href="#" data-toggle="modal" data-target="#sign-up-modal">{{ $passedContents['about-us-cta-btn-text'] }}</a>
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