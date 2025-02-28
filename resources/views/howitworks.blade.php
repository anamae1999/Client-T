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
	<section class="how-it-works gray-bg padTB50">
		@if($showSection['how-it-works-main'] == 'show')
		<div class="container">
			<div class="row text-center">
				<div class="col-xl-12 section-title-content">
					<h2 class="section-title">{{ $passedContents['how-it-works-main-title'] }}</h2>
					{!! $passedContents['how-it-works-main-content'] !!}
				</div>
			</div>
		</div>
		@endif

		<div class="container pb-3">
			<div class="row">
				<ul class="how-it-works-tab-title full nav nav-tabs" id="myTab" role="tablist">
					@if($showSection['for-nanny'] == 'show')
					  <li class="nav-item half text-center">
					    <a class="nav-link p-3 active" id="nanny-tab" data-toggle="tab" href="#nanny" role="tab" aria-controls="nanny" aria-selected="true">{{ $passedContents['for-nanny-title'] }}</a>
					  </li>
					@endif

					@if($showSection['for-parent'] == 'show')
					  <li class="nav-item half text-center">
					    <a class="nav-link p-3" id="parent-tab" data-toggle="tab" href="#parent" role="tab" aria-controls="parent" aria-selected="false">{{ $passedContents['for-parent-title'] }}</a>
					  </li>
					@endif
				</ul>
			</div>
			<div class="row">
				<div class="full how-it-works-tab tab-content" id="myTabContent">

				@if($showSection['for-nanny'] == 'show')
				  <div class="tab-pane fade show active" id="nanny" role="tabpanel" aria-labelledby="nanny-tab">
				  	<div class="how-it-works-item pad50">
				  		<div class="row padB50">
					  		<div class="col-md-3 text-center">
						  		<h2 class="steps-item-title">{{ $passedContents['for-nanny-col1-title'] }}</h2>
									<div class="vertical-line orange-line"></div>
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['for-nanny-col1-image'] }}">
								</div>
								<div class="col-md-9 steps-item-content">
									<h4>{{ $passedContents['for-nanny-col1-content-title'] }}</h4>
									{!! $passedContents['for-nanny-col1-content'] !!}	
								</div>
							</div>
				  		<div class="row padB50">
					  		<div class="col-md-3 text-center">
						  		<h2 class="steps-item-title">{{ $passedContents['for-nanny-col2-title'] }}</h2>
									<div class="vertical-line orange-line"></div>
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['for-nanny-col2-image'] }}">
								</div>
								<div class="col-md-9 steps-item-content">
									<h4>{{ $passedContents['for-nanny-col2-content-title'] }}</h4>
									{!! $passedContents['for-nanny-col2-content'] !!}	
								</div>
							</div>
				  		<div class="row">
					  		<div class="col-md-3 text-center">
						  		<h2 class="steps-item-title">{{ $passedContents['for-nanny-col3-title'] }}</h2>
									<div class="vertical-line orange-line"></div>
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['for-nanny-col3-image'] }}">
								</div>
								<div class="col-md-9 steps-item-content">
									<h4>{{ $passedContents['for-nanny-col3-content-title'] }}</h4>
									{!! $passedContents['for-nanny-col3-content'] !!}	
								</div>
							</div>
						</div>
				  </div>
				  @endif

				  @if($showSection['for-parent'] == 'show')
				  <div class="tab-pane fade" id="parent" role="tabpanel" aria-labelledby="parent-tab">
				  	<div class="how-it-works-item pad50">
				  		<div class="row padB50">
					  		<div class="col-md-3 text-center">
						  		<h2 class="steps-item-title">{{ $passedContents['for-parent-col1-title'] }}</h2>
									<div class="vertical-line orange-line"></div>
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['for-parent-col1-image'] }}">
								</div>
								<div class="col-md-9 steps-item-content">
									<h4>{{ $passedContents['for-parent-col1-content-title'] }}</h4>
									{!! $passedContents['for-parent-col1-content'] !!}
								</div>
							</div>
				  		<div class="row padB50">
					  		<div class="col-md-3 text-center">
						  		<h2 class="steps-item-title">{{ $passedContents['for-parent-col2-title'] }}</h2>
									<div class="vertical-line orange-line"></div>
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['for-parent-col2-image'] }}">
								</div>
								<div class="col-md-9 steps-item-content">
									<h4>{{ $passedContents['for-parent-col2-content-title'] }}</h4>
									{!! $passedContents['for-parent-col2-content'] !!}
								</div>
							</div>
				  		<div class="row">
					  		<div class="col-md-3 text-center">
						  		<h2 class="steps-item-title">{{ $passedContents['for-parent-col3-title'] }}</h2>
									<div class="vertical-line orange-line"></div>
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['for-parent-col3-image'] }}">
								</div>
								<div class="col-md-9 steps-item-content">
									<h4>{{ $passedContents['for-parent-col3-content-title'] }}</h4>
									{!! $passedContents['for-parent-col3-content'] !!}
								</div>
							</div>
						</div>
				  </div>
				  @endif
				</div>
			</div>
		</div>
	</section>

	@if($showSection['how-it-works-cta1'] == 'show' && Auth::guest())
	<section class="brown-bg register-now-section">
		<div class="container padTB50">
			<div class="row align-items-center">
				<div class="col-xl-8 col-md-7 text-center">
					{!! $passedContents['how-it-works-cta1-title'] !!}
				</div>
				<div class="col-xl-4 col-md-5 register-now-button text-center">
					<a href="" class="signUp custom-btn btn-green" data-toggle="modal" data-dismiss="modal" data-target="#sign-up-modal" id="sign-up-footer">{{ $passedContents['how-it-works-cta1-btn-text'] }}</a>
				</div>
			</div>
		</div>
	</section>
	@endif

	@if($showSection['program'] == 'show')
	<section class="how-it-works padTB50">
		<div class="container">
			<div class="row text-center">
				<div class="col-xl-12 section-title-content">
					<h2 class="section-title">{{ $passedContents['program-title'] }}</h2>
					{!! $passedContents['program-content'] !!}
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row align-items-center program-item">
				<div class="col-xl-4 col-md-4 text-center pb-3">
					<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="{{ $passedContents['program-image'] }}">
				</div>
				<div class="col-xl-8 col-md-8">
					{!! $passedContents['program-content2'] !!}
					<a class="custom-btn btn-green btn-green-whitebg marT40" href="{{ $passedContents['program-btn-link'] }}">{{ $passedContents['program-btn-text'] }}</a>
				</div>
			</div>
		</div>
	</section>
	@endif

	@if($showSection['benefits'] == 'show')
	<section class="how-it-works gray-bg padTB50">
		<div class="container">
			<div class="row text-center">
				<div class="col-xl-12">
					<h2 class="section-title">{{ $passedContents['benefits-title'] }}</h2>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-xl-8 col-md-8 benefits-list">
					<ul>
						<li>{{ $passedContents['benefits-list1'] }}</li>
						<li>{{ $passedContents['benefits-list2'] }}</li>
						<li>{{ $passedContents['benefits-list3'] }}</li>
						<li>{{ $passedContents['benefits-list4'] }}</li>
						<li>{{ $passedContents['benefits-list5'] }}</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	@endif

	@if($showSection['how-it-works-cta2'] == 'show' && Auth::guest())
	<section class="brown-bg register-now-section">
		<div class="container padTB50">
			<div class="row align-items-center">
				<div class="col-xl-8 col-md-7 text-center">
					{!! $passedContents['how-it-works-cta2-title'] !!}
				</div>
				<div class="col-xl-4 col-md-5 register-now-button text-center">
					<a href="" class="signUp custom-btn btn-green" data-toggle="modal" data-dismiss="modal" data-target="#sign-up-modal" id="sign-up-footer">{{ $passedContents['how-it-works-cta2-btn-text'] }}</a>
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